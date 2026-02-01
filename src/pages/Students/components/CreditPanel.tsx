import React, { useEffect, useMemo, useState } from "react";
import {
  CalendarDays,
  CreditCard,
  ChevronUp,
  Save,
  Info,
  Lock,
  Calculator,
  CheckCircle,
  FileText,
  Printer,
  X,
} from "lucide-react";

import type { Enrollment, Charge, PaymentMethod } from "../../../services/enrollments";
import { listInstallments, payInstallment, saveEnrollmentCredit } from "../../../services/enrollments";
import { getApiErrorMessage } from "../../../services/api";

import { buildCreditSchedule } from "../utils/creditSchedule";
import { todayYmd, toYmd } from "../utils/dates";
import { clamp } from "../utils/helpers";
import { moneyPENFromCents } from "../utils/money";

type CreditForm = {
  total_soles: string;
  pay_day_date: string;
  cuotas: number;
};

function safeYmdWithDay(day: number) {
  const base = todayYmd(); // YYYY-MM-DD
  const y = base.slice(0, 4);
  const m = base.slice(5, 7);
  const safeDay = clamp(Number(day) || 5, 1, 28);
  return `${y}-${m}-${String(safeDay).padStart(2, "0")}`;
}

function methodLabel(m?: PaymentMethod | null) {
  if (m === "cash") return "Efectivo";
  if (m === "card") return "Tarjeta";
  if (m === "yape") return "Yape";
  if (m === "plin") return "Plin";
  if (m === "transfer") return "Transferencia";
  return "—";
}

function pad(n: number, len = 6) {
  return String(n).padStart(len, "0");
}

function formatDateTimeExact(iso?: string | null) {
  if (!iso) return "—";
  const d = new Date(iso);
  if (Number.isNaN(d.getTime())) return String(iso);
  const dd = String(d.getDate()).padStart(2, "0");
  const mm = String(d.getMonth() + 1).padStart(2, "0");
  const yyyy = d.getFullYear();
  const hh = String(d.getHours()).padStart(2, "0");
  const mi = String(d.getMinutes()).padStart(2, "0");
  const ss = String(d.getSeconds()).padStart(2, "0");
  return `${dd}/${mm}/${yyyy} ${hh}:${mi}:${ss}`;
}

function printHtml(title: string, html: string) {
  const w = window.open("", "_blank", "width=900,height=900");
  if (!w) return;

  w.document.open();
  w.document.write(`<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>${title}</title>
<style>
  body{font-family:Arial,Helvetica,sans-serif;margin:24px;color:#111827}
  .paper{max-width:760px;margin:0 auto;border:1px solid #e5e7eb;border-radius:14px;padding:18px}
  .row{display:flex;justify-content:space-between;gap:12px}
  .muted{color:#6b7280;font-size:12px}
  .title{font-size:18px;font-weight:900;margin:0}
  .tag{display:inline-block;padding:6px 10px;border-radius:999px;font-size:11px;font-weight:900;background:#111827;color:#fff}
  .hr{height:1px;background:#e5e7eb;margin:14px 0}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  .box{border:1px solid #e5e7eb;border-radius:12px;padding:12px}
  .k{font-size:11px;font-weight:900;color:#6b7280;letter-spacing:.4px;text-transform:uppercase}
  .v{font-size:13px;font-weight:800;color:#111827;margin-top:6px}
  .total{font-size:22px;font-weight:900}
  table{width:100%;border-collapse:collapse;font-size:12px}
  th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:left}
  th{font-size:10px;color:#6b7280;font-weight:900;letter-spacing:.4px;text-transform:uppercase}
  @media print{ body{margin:0} .paper{border:none;border-radius:0} }
</style>
</head>
<body>
${html}
<script>
  window.focus();
  window.print();
  window.onafterprint = () => window.close();
</script>
</body>
</html>`);
  w.document.close();
}

function InstallmentReceiptModal(props: {
  open: boolean;
  onClose: () => void;
  charge: Charge | null;
  enrollment: Enrollment;
  installmentNumber: number | null;
  monthlyFeeCents: number;
}) {
  const { open, onClose, charge, enrollment, installmentNumber, monthlyFeeCents } = props;
  if (!open || !charge) return null;

  const receiptNo = `NV-CUOTA-${pad(charge.id)}`;
  const studentName =
    enrollment.student
      ? `${enrollment.student.first_name} ${enrollment.student.last_name}`.trim()
      : `Alumno #${enrollment.student_id}`;

  // Para exactitud: usamos updated_at como “momento real del pago”
  const paidAtExact = formatDateTimeExact((charge as any).updated_at);

  function doPrint() {
    const html = `
      <div class="paper">
        <div class="row">
          <div>
            <p class="title">NOTA DE VENTA — CUOTA</p>
            <div class="muted">Comprobante de pago</div>
            <div class="muted" style="margin-top:6px;">Pago exacto: <b>${paidAtExact}</b></div>
          </div>
          <div style="text-align:right;">
            <div class="tag">${receiptNo}</div>
            <div class="muted" style="margin-top:8px;">Estado: PAGADO</div>
          </div>
        </div>

        <div class="hr"></div>

        <div class="grid">
          <div class="box">
            <div class="k">Alumno</div>
            <div class="v">${studentName}</div>
            <div class="muted" style="margin-top:6px;">Matrícula ID: ${enrollment.id}</div>
          </div>

          <div class="box">
            <div class="k">Detalle</div>
            <div class="v">Cuota #${installmentNumber ?? "—"}</div>
            <div class="muted" style="margin-top:6px;">Vence: ${String(charge.due_on).slice(0,10)}</div>
          </div>

          <div class="box">
            <div class="k">Método</div>
            <div class="v">${methodLabel((charge as any).method)}</div>
            <div class="muted" style="margin-top:6px;">Fecha (paid_on): ${(charge as any).paid_on ?? "—"}</div>
          </div>

          <div class="box">
            <div class="k">Monto</div>
            <div class="v total">${moneyPENFromCents(charge.amount_cents)}</div>
            <div class="muted" style="margin-top:6px;">Moneda: PEN</div>
          </div>
        </div>

        <div class="hr"></div>

        <div class="muted">
          * Registro con fecha y hora exacta para control interno. 
        </div>
      </div>
    `;

    printHtml(`Nota de venta ${receiptNo}`, html);
  }

  return (
    <div style={receiptOverlay} onMouseDown={onClose}>
      <div style={receiptCard} onMouseDown={(e) => e.stopPropagation()}>
        <div style={{ display: "flex", alignItems: "center", gap: 10 }}>
          <div style={{ fontWeight: 900, fontSize: 14 }}>Nota de venta — Cuota</div>
          <button style={receiptCloseBtn} onClick={onClose} type="button">
            <X size={16} />
          </button>
        </div>

        <div style={receiptBody}>
          <div style={receiptHeaderRow}>
            <div>
              <div style={receiptK}>N°</div>
              <div style={{ fontWeight: 900, fontSize: 16 }}>{receiptNo}</div>
              <div style={receiptM}>Pago exacto: <b>{paidAtExact}</b></div>
            </div>
            <div style={{ textAlign: "right" }}>
              <div style={receiptK}>Total</div>
              <div style={{ fontWeight: 900, fontSize: 18 }}>{moneyPENFromCents(charge.amount_cents)}</div>
            </div>
          </div>

          <div style={receiptGrid}>
            <div style={receiptBox}>
              <div style={receiptK}>Alumno</div>
              <div style={receiptV}>{studentName}</div>
              <div style={receiptM}>Matrícula ID: {enrollment.id}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Detalle</div>
              <div style={receiptV}>Cuota #{installmentNumber ?? "—"}</div>
              <div style={receiptM}>Vence: {String(charge.due_on).slice(0, 10)}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Método</div>
              <div style={receiptV}>{methodLabel((charge as any).method)}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Fecha</div>
              <div style={receiptV}>{(charge as any).paid_on ?? "—"}</div>
              <div style={receiptM}>Hora exacta: {paidAtExact}</div>
            </div>
          </div>

          <div style={receiptFootNote}>
            * Comprobante interno con fecha/hora exacta (seguridad).
          </div>
        </div>

        <div style={receiptActions}>
          <button style={receiptBtnPrimary} onClick={doPrint} type="button">
            <Printer size={16} /> Imprimir / Guardar PDF
          </button>
          <button style={receiptBtnSecondary} onClick={onClose} type="button">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  );
}

export function CreditPanel(props: {
  enrollment: Enrollment;
  monthlyFeeCents: number;
  enabled: boolean;
  loading: boolean;
  setLoading: (v: boolean) => void;
  setErr: (v: string | null) => void;
  onRefresh: () => Promise<void>;
}) {
  const { enrollment, monthlyFeeCents, enabled, loading, setLoading, setErr, onRefresh } = props;

  const [open, setOpen] = useState(false);
  const [savedOk, setSavedOk] = useState(false);

  // ✅ Backend: cuotas reales (charges)
  const [installments, setInstallments] = useState<Charge[] | null>(null);
  const [installmentsLoading, setInstallmentsLoading] = useState(false);

  // Método usado para pagar cuotas (global)
  const [payMethod, setPayMethod] = useState<PaymentMethod>("cash");

  // ✅ Nota de venta por cuota
  const [receiptOpen, setReceiptOpen] = useState(false);
  const [receiptCharge, setReceiptCharge] = useState<Charge | null>(null);
  const [receiptIdx, setReceiptIdx] = useState<number | null>(null);

  const [creditForm, setCreditForm] = useState<CreditForm>({
    total_soles: "",
    pay_day_date: "",
    cuotas: 3,
  });

  const planTotalCents = Number((enrollment as any).plan_total_cents ?? 0) || 0;
  const planCuotas = Number((enrollment as any).installments_count ?? 0) || 0;
  const planBillingDay = Number((enrollment as any).billing_day ?? 0) || 0;
  const hasPlan = planTotalCents > 0;

  async function refreshInstallments() {
    if (!enabled || !hasPlan) return;

    setInstallmentsLoading(true);
    try {
      const data = await listInstallments(enrollment.id);
      const sorted = [...data].sort((a, b) => String(a.due_on).localeCompare(String(b.due_on)));
      setInstallments(sorted);
    } catch {
      setInstallments(null);
    } finally {
      setInstallmentsLoading(false);
    }
  }

  useEffect(() => {
    if (!enabled || !hasPlan) return;
    if (open) return;
    refreshInstallments();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [enabled, hasPlan, open, enrollment.id, planTotalCents, planCuotas, planBillingDay]);

  const creditPayDay = useMemo(() => {
    if (creditForm.pay_day_date) return Number(creditForm.pay_day_date.slice(8, 10)) || 5;
    if (planBillingDay) return planBillingDay;
    return 5;
  }, [creditForm.pay_day_date, planBillingDay]);

  const suggested = useMemo(() => {
    const s = toYmd((enrollment as any).starts_on) || todayYmd();
    const m = (enrollment as any).ends_on
      ? (() => {
          const ss = new Date(s + "T00:00:00");
          const ee = new Date(toYmd((enrollment as any).ends_on) + "T00:00:00");
          const months = (ee.getFullYear() - ss.getFullYear()) * 12 + (ee.getMonth() - ss.getMonth()) + 1;
          return Math.max(1, months);
        })()
      : 3;

    return { totalCents: monthlyFeeCents * m, cuotas: m, startYmd: s };
  }, [(enrollment as any).starts_on, (enrollment as any).ends_on, monthlyFeeCents]);

  const totalCents = Math.round((Number(creditForm.total_soles || "0") || 0) * 100);
  const cuotas = clamp(Number(creditForm.cuotas) || 1, 1, 36);

  const schedulePreview = useMemo(() => {
    if (!open) return [];
    if (totalCents <= 0) return [];
    return buildCreditSchedule(suggested.startYmd, creditPayDay, cuotas, totalCents);
  }, [open, totalCents, creditPayDay, cuotas, suggested.startYmd]);

  const cuotaCentsPreview = schedulePreview.length ? schedulePreview[0].amount_cents : 0;

  const schedulePlanFallback = useMemo(() => {
    if (!hasPlan) return [];
    const startYmd = toYmd((enrollment as any).starts_on) || todayYmd();
    const billing = planBillingDay || 5;
    const n = clamp(planCuotas || 1, 1, 36);
    return buildCreditSchedule(startYmd, billing, n, planTotalCents) as Array<{ idx: number; due_on: string; amount_cents: number }>;
  }, [hasPlan, planTotalCents, planCuotas, planBillingDay, (enrollment as any).starts_on]);

  const rows = useMemo(() => {
    if (installments && installments.length) {
      return installments.map((c, i) => ({
        key: c.id,
        idx: i + 1,
        charge: c,
        due_on: c.due_on,
        amount_cents: c.amount_cents,
        paid_cents: c.paid_cents,
        status: c.status,
        method: (c as any).method as PaymentMethod | null | undefined,
        paid_on: (c as any).paid_on as string | null | undefined,
        updated_at: (c as any).updated_at as string | undefined,
      }));
    }
    return schedulePlanFallback.map((r) => ({
      key: `fallback-${r.idx}`,
      idx: r.idx,
      charge: null as any,
      due_on: r.due_on,
      amount_cents: r.amount_cents,
      paid_cents: 0,
      status: "unpaid" as any,
      method: null,
      paid_on: null,
      updated_at: undefined,
    }));
  }, [installments, schedulePlanFallback]);

  const paidCount = useMemo(() => rows.reduce((acc, r) => acc + (r.status === "paid" ? 1 : 0), 0), [rows]);
  const pendingCount = useMemo(() => Math.max(0, rows.length - paidCount), [rows.length, paidCount]);

  function openEditor() {
    setSavedOk(false);
    setOpen(true);

    setCreditForm((f) => {
      const total = f.total_soles ? f.total_soles : (hasPlan ? planTotalCents : suggested.totalCents) / 100;
      const cuotasNext = f.cuotas ? f.cuotas : (hasPlan ? planCuotas : suggested.cuotas) || 3;

      const payDate = f.pay_day_date
        ? f.pay_day_date
        : planBillingDay
        ? safeYmdWithDay(planBillingDay)
        : todayYmd();

      return {
        total_soles: String(total).includes(".") ? String(total) : Number(total).toFixed(2),
        cuotas: cuotasNext,
        pay_day_date: payDate,
      };
    });
  }

  function closeEditor() {
    setOpen(false);
    setSavedOk(false);
  }

  async function handlePayCharge(charge: Charge, idx: number) {
    try {
      setErr(null);
      setLoading(true);

      const updated = await payInstallment(charge.id, {
        method: payMethod,
        paid_on: todayYmd(),
      });

      await refreshInstallments();

      // ✅ abre nota de venta automática
      setReceiptCharge(updated ?? charge);
      setReceiptIdx(idx);
      setReceiptOpen(true);
    } catch (e: any) {
      setErr(getApiErrorMessage(e));
    } finally {
      setLoading(false);
    }
  }

  function openReceiptForPaid(charge: Charge, idx: number) {
    setReceiptCharge(charge);
    setReceiptIdx(idx);
    setReceiptOpen(true);
  }

  function downloadHistoryPdf() {
    if (!installments || !installments.length) return;

    const paid = installments
      .map((c, i) => ({ c, idx: i + 1 }))
      .filter((x) => x.c.status === "paid" || x.c.status === "partial");

    const studentName =
      enrollment.student
        ? `${enrollment.student.first_name} ${enrollment.student.last_name}`.trim()
        : `Alumno #${enrollment.student_id}`;

    const html = `
      <div class="paper">
        <div class="row">
          <div>
            <p class="title">HISTORIAL DE PAGOS — CUOTAS</p>
            <div class="muted">Alumno: <b>${studentName}</b></div>
            <div class="muted">Matrícula ID: ${enrollment.id} • Categoría ID: ${enrollment.category_id}</div>
          </div>
          <div style="text-align:right;">
            <div class="tag">EXPORT</div>
            <div class="muted" style="margin-top:8px;">Generado: ${formatDateTimeExact(new Date().toISOString())}</div>
          </div>
        </div>

        <div class="hr"></div>

        <table>
          <thead>
            <tr>
              <th>Cuota</th>
              <th>Vence</th>
              <th>Método</th>
              <th>paid_on</th>
              <th>Hora exacta (updated_at)</th>
              <th style="text-align:right;">Monto</th>
              <th style="text-align:right;">Pagado</th>
              <th>Estado</th>
              <th>Comprobante</th>
            </tr>
          </thead>
          <tbody>
            ${
              paid.length
                ? paid.map(({ c, idx }) => `
                  <tr>
                    <td>#${idx}</td>
                    <td>${String(c.due_on).slice(0,10)}</td>
                    <td>${methodLabel((c as any).method)}</td>
                    <td>${(c as any).paid_on ?? "—"}</td>
                    <td>${formatDateTimeExact((c as any).updated_at)}</td>
                    <td style="text-align:right;">${moneyPENFromCents(c.amount_cents)}</td>
                    <td style="text-align:right;">${moneyPENFromCents(c.paid_cents)}</td>
                    <td>${c.status}</td>
                    <td>NV-CUOTA-${pad(c.id)}</td>
                  </tr>
                `).join("")
                : `<tr><td colspan="9" class="muted">No hay pagos registrados.</td></tr>`
            }
          </tbody>
        </table>

        <div class="hr"></div>
        <div class="muted">
          * Incluye fecha/hora exacta del comprobante (updated_at) por seguridad.
        </div>
      </div>
    `;

    printHtml(`Historial pagos matricula ${enrollment.id}`, html);
  }

  return (
    <>
      <InstallmentReceiptModal
        open={receiptOpen}
        onClose={() => setReceiptOpen(false)}
        charge={receiptCharge}
        enrollment={enrollment}
        installmentNumber={receiptIdx}
        monthlyFeeCents={monthlyFeeCents}
      />

      <div style={containerStyle}>
        <div style={headerSection}>
          <div style={titleGroup}>
            <Calculator size={16} color="#ff5722" />
            <span style={titleText}>PLAN DE CUOTAS</span>
          </div>
          {hasPlan && !open && <span style={activeBadge}>PROGRAMADO</span>}
        </div>

        {!enabled ? (
          <div style={lockedState}>
            <Lock size={14} />
            <span>Habilite el pago inicial para programar crédito</span>
          </div>
        ) : (
          <div style={{ display: "flex", flexDirection: "column", gap: "12px" }}>
            {hasPlan && !open && (
              <>
                <div style={summaryCard}>
                  <div style={summaryItem}>
                    <span style={summaryLabel}>CRÉDITO TOTAL</span>
                    <span style={summaryValue}>{moneyPENFromCents(planTotalCents)}</span>
                  </div>
                  <div style={summaryDivider} />
                  <div style={summaryItem}>
                    <span style={summaryLabel}>CUOTAS</span>
                    <span style={summaryValue}>
                      {planCuotas || "—"}{" "}
                      {planCuotas ? `de ${moneyPENFromCents(planTotalCents / Math.max(1, planCuotas))}` : ""}
                    </span>
                  </div>
                </div>

                <div style={payStatsRow}>
                  <div style={payStatBox}>
                    <span style={payStatLabel}>PAGADAS</span>
                    <span style={payStatValueGreen}>{paidCount}</span>
                  </div>
                  <div style={payStatBox}>
                    <span style={payStatLabel}>PENDIENTES</span>
                    <span style={payStatValueOrange}>{pendingCount}</span>
                  </div>
                  <div style={payStatBox}>
                    <span style={payStatLabel}>DÍA COBRO</span>
                    <span style={payStatValueDark}>{planBillingDay || 5}</span>
                  </div>
                </div>

                <div style={methodRow}>
                  <span style={methodLabelStyle}>Método para pagar cuotas:</span>
                  <select
                    style={methodSelect}
                    value={payMethod}
                    onChange={(e) => setPayMethod(e.target.value as PaymentMethod)}
                  >
                    <option value="cash">Efectivo</option>
                    <option value="card">Tarjeta</option>
                    <option value="yape">Yape</option>
                    <option value="plin">Plin</option>
                    <option value="transfer">Transferencia</option>
                  </select>
                </div>

                <div style={installmentsCard}>
                  <div style={installmentsHeader}>
                    <Info size={14} />
                    <span style={{ fontWeight: 900, fontSize: 11, color: "#475569" }}>
                      CUOTAS PROGRAMADAS (PAGAR)
                    </span>

                    <button
                      type="button"
                      style={historyBtn}
                      onClick={downloadHistoryPdf}
                      disabled={!installments || !installments.length}
                      title={!installments ? "Aún no hay cuotas reales en backend" : "Imprimir/Guardar PDF"}
                    >
                      <Printer size={14} /> Historial (PDF)
                    </button>

                    <span style={{ marginLeft: "auto", fontSize: 11, color: "#94a3b8", fontWeight: 900 }}>
                      {installmentsLoading ? "Cargando..." : ""}
                    </span>
                  </div>

                  <div style={installmentsBody}>
                    {rows.map((row) => {
                      const paid = row.status === "paid";
                      const partial = row.status === "partial";
                      const remaining = Math.max(0, row.amount_cents - (row.paid_cents || 0));

                      return (
                        <div key={row.key} style={installmentRow}>
                          <div style={{ display: "flex", flexDirection: "column" }}>
                            <div style={installmentTop}>
                              <span style={installmentIdx}>#{row.idx}</span>
                              <span style={installmentDue}>{String(row.due_on).slice(0, 10)}</span>
                            </div>

                            <div style={installmentAmount}>{moneyPENFromCents(row.amount_cents)}</div>

                            {partial ? (
                              <div style={partialNote}>
                                Parcial: {moneyPENFromCents(row.paid_cents)} • Falta:{" "}
                                <b>{moneyPENFromCents(remaining)}</b>
                              </div>
                            ) : null}
                          </div>

                          {/* acciones derecha */}
                          <div style={{ display: "flex", alignItems: "center", gap: 8 }}>
                            {paid && row.charge ? (
                              <>
                                <div style={paidPill}>
                                  <CheckCircle size={14} />
                                  Pagada
                                </div>
                                <button
                                  type="button"
                                  style={receiptMiniBtn}
                                  onClick={() => openReceiptForPaid(row.charge, row.idx)}
                                  title="Ver / imprimir nota de venta"
                                >
                                  <FileText size={14} />
                                </button>
                              </>
                            ) : row.charge ? (
                              <button
                                style={payBtn}
                                type="button"
                                disabled={loading}
                                onClick={() => handlePayCharge(row.charge, row.idx)}
                              >
                                PAGAR CUOTA
                              </button>
                            ) : (
                              <div style={noBackendPill} title="Aún no hay cuotas reales en backend">
                                Sin backend
                              </div>
                            )}
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </>
            )}

            <button
              style={open ? toggleBtnActive : toggleBtn}
              onClick={() => {
                if (open) return closeEditor();
                openEditor();
              }}
            >
              {open ? <ChevronUp size={16} /> : <CreditCard size={16} />}
              {open ? "CANCELAR EDICIÓN" : hasPlan ? "RE-PROGRAMAR CUOTAS" : "CONFIGURAR CRÉDITO"}
            </button>

            {open && (
              <div style={editorPanel}>
                <div style={formGrid}>
                  <div style={inputWrapper}>
                    <label style={labelStyle}>MONTO TOTAL (S/)</label>
                    <input
                      style={modernInput}
                      value={creditForm.total_soles}
                      onChange={(e) =>
                        setCreditForm((f) => ({ ...f, total_soles: e.target.value.replace(/[^\d.]/g, "") }))
                      }
                      inputMode="decimal"
                      placeholder="Ej: 600.00"
                    />
                  </div>

                  <div style={inputWrapper}>
                    <label style={labelStyle}>N° CUOTAS</label>
                    <input
                      style={modernInput}
                      value={creditForm.cuotas}
                      onChange={(e) =>
                        setCreditForm((f) => ({ ...f, cuotas: Number(e.target.value.replace(/[^\d]/g, "")) || 1 }))
                      }
                      inputMode="numeric"
                    />
                  </div>

                  <div style={{ ...inputWrapper, gridColumn: "span 2" }}>
                    <label style={labelStyle}>PRIMER VENCIMIENTO (DETERMINA EL DÍA DE PAGO)</label>
                    <div style={{ position: "relative" }}>
                      <input
                        style={{ ...modernInput, width: "100%", paddingLeft: "35px", paddingRight: "16px" }}
                        type="date"
                        value={creditForm.pay_day_date}
                        onChange={(e) => setCreditForm((f) => ({ ...f, pay_day_date: e.target.value }))}
                      />
                      <CalendarDays size={14} style={inputIcon} />
                    </div>
                  </div>
                </div>

                <div style={previewBox}>
                  <div style={previewHeader}>
                    <Info size={14} />
                    <span>
                      Vista previa: {cuotas} cuotas de <b>{moneyPENFromCents(cuotaCentsPreview)}</b>{" "}
                      <span style={{ opacity: 0.7 }}>
                        • Día cobro: <b>{creditPayDay}</b>
                      </span>
                    </span>
                  </div>

                  <div style={tableContainer}>
                    {schedulePreview.length === 0 ? (
                      <div style={{ padding: 12, fontSize: 12, color: "#64748b" }}>
                        Ingresa un monto mayor a 0 para ver el cronograma.
                      </div>
                    ) : (
                      <table style={miniTable}>
                        <thead>
                          <tr>
                            <th style={thStyle}>#</th>
                            <th style={thStyle}>VENCIMIENTO</th>
                            <th style={{ ...thStyle, textAlign: "right" }}>MONTO</th>
                          </tr>
                        </thead>
                        <tbody>
                          {schedulePreview.map((row) => (
                            <tr key={row.idx}>
                              <td style={tdStyle}>{row.idx}</td>
                              <td style={tdStyle}>{row.due_on}</td>
                              <td style={{ ...tdStyle, textAlign: "right", fontWeight: 700 }}>
                                {moneyPENFromCents(row.amount_cents)}
                              </td>
                            </tr>
                          ))}
                        </tbody>
                      </table>
                    )}
                  </div>
                </div>

                {savedOk ? (
                  <div style={savedOkStyle}>
                    <CheckCircle size={16} /> Programación guardada
                  </div>
                ) : null}

                <button
                  style={saveBtn}
                  disabled={totalCents <= 0 || loading}
                  onClick={async () => {
                    try {
                      setErr(null);
                      setSavedOk(false);
                      setLoading(true);

                      await saveEnrollmentCredit(enrollment.id, {
                        plan_total_cents: totalCents,
                        installments_count: cuotas,
                        billing_day: creditPayDay,
                      });

                      await onRefresh();
                      setSavedOk(true);

                      await refreshInstallments();
                      setTimeout(() => setOpen(false), 600);
                    } catch (e: any) {
                      setErr(getApiErrorMessage(e));
                    } finally {
                      setLoading(false);
                    }
                  }}
                >
                  {loading ? "PROCESANDO..." : (
                    <>
                      <Save size={16} /> GUARDAR PROGRAMACIÓN
                    </>
                  )}
                </button>
              </div>
            )}
          </div>
        )}
      </div>
    </>
  );
}

/* ====== ESTILOS ====== */
const containerStyle: React.CSSProperties = { marginTop: "20px", padding: "20px", background: "#f8fafc", borderRadius: "24px", border: "1px solid #e2e8f0" };
const headerSection: React.CSSProperties = { display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "15px" };
const titleGroup: React.CSSProperties = { display: "flex", alignItems: "center", gap: "8px" };
const titleText: React.CSSProperties = { fontSize: "11px", fontWeight: 900, color: "#64748b", letterSpacing: "1px" };
const activeBadge: React.CSSProperties = { background: "#dcfce7", color: "#166534", fontSize: "9px", fontWeight: 900, padding: "4px 8px", borderRadius: "8px" };

const lockedState: React.CSSProperties = { display: "flex", alignItems: "center", gap: "10px", color: "#94a3b8", fontSize: "12px", fontWeight: 600, padding: "10px", background: "#fff", borderRadius: "12px", border: "1px dashed #cbd5e1" };

const summaryCard: React.CSSProperties = { display: "flex", background: "#fff", padding: "15px", borderRadius: "16px", border: "1px solid #e2e8f0", boxShadow: "0 2px 4px rgba(0,0,0,0.02)" };
const summaryItem: React.CSSProperties = { flex: 1, display: "flex", flexDirection: "column", gap: "2px" };
const summaryLabel: React.CSSProperties = { fontSize: "9px", fontWeight: 800, color: "#94a3b8" };
const summaryValue: React.CSSProperties = { fontSize: "14px", fontWeight: 800, color: "#0f172a" };
const summaryDivider: React.CSSProperties = { width: "1px", background: "#e2e8f0", margin: "0 15px" };

const toggleBtn: React.CSSProperties = { width: "100%", padding: "12px", borderRadius: "14px", border: "1px solid #cbd5e1", background: "#fff", color: "#334155", fontWeight: 800, fontSize: "12px", cursor: "pointer", display: "flex", alignItems: "center", justifyContent: "center", gap: "8px" };
const toggleBtnActive: React.CSSProperties = { ...toggleBtn, background: "#f1f5f9", color: "#ef4444", border: "1px solid #fee2e2" };

const editorPanel: React.CSSProperties = { display: "flex", flexDirection: "column", gap: "15px" };
const formGrid: React.CSSProperties = { display: "grid", gridTemplateColumns: "1fr 1fr", gap: "12px" };
const inputWrapper: React.CSSProperties = { display: "flex", flexDirection: "column", gap: "6px" };
const labelStyle: React.CSSProperties = { fontSize: "10px", fontWeight: 800, color: "#64748b" };
const modernInput: React.CSSProperties = { padding: "10px 12px", borderRadius: "10px", border: "1px solid #e2e8f0", fontSize: "13px", fontWeight: 700, outline: "none" };
const inputIcon: React.CSSProperties = { position: "absolute", left: "12px", top: "50%", transform: "translateY(-50%)", color: "#94a3b8" };

const previewBox: React.CSSProperties = { background: "#fff", borderRadius: "16px", border: "1px solid #e2e8f0", overflow: "hidden" };
const previewHeader: React.CSSProperties = { padding: "10px 15px", background: "#f1f5f9", fontSize: "11px", color: "#475569", display: "flex", alignItems: "center", gap: "8px" };
const tableContainer: React.CSSProperties = { maxHeight: "150px", overflowY: "auto" };
const miniTable: React.CSSProperties = { width: "100%", borderCollapse: "collapse", fontSize: "12px" };
const thStyle: React.CSSProperties = { padding: "10px 12px", color: "#64748b", fontSize: 10, fontWeight: 900, textAlign: "left", borderBottom: "1px solid #e2e8f0" };
const tdStyle: React.CSSProperties = { padding: "10px 12px", borderBottom: "1px solid #f1f5f9", color: "#0f172a" };

const savedOkStyle: React.CSSProperties = { display: "flex", alignItems: "center", gap: 8, padding: "10px 12px", borderRadius: 12, background: "#f0fdf4", border: "1px solid #dcfce7", color: "#166534", fontWeight: 900, fontSize: 12 };

const saveBtn: React.CSSProperties = { width: "100%", padding: "14px", borderRadius: "16px", background: "#0f172a", color: "#fff", border: "none", fontWeight: 800, fontSize: "12px", cursor: "pointer", display: "flex", alignItems: "center", justifyContent: "center", gap: "10px", boxShadow: "0 10px 15px -3px rgba(15, 23, 42, 0.2)" };

const payStatsRow: React.CSSProperties = { display: "grid", gridTemplateColumns: "1fr 1fr 1fr", gap: 10 };
const payStatBox: React.CSSProperties = { background: "#fff", border: "1px solid #e2e8f0", borderRadius: 14, padding: "10px 12px", display: "flex", justifyContent: "space-between", alignItems: "center" };
const payStatLabel: React.CSSProperties = { fontSize: 9, fontWeight: 900, color: "#94a3b8" };
const payStatValueGreen: React.CSSProperties = { fontSize: 14, fontWeight: 900, color: "#166534" };
const payStatValueOrange: React.CSSProperties = { fontSize: 14, fontWeight: 900, color: "#b45309" };
const payStatValueDark: React.CSSProperties = { fontSize: 14, fontWeight: 900, color: "#0f172a" };

const methodRow: React.CSSProperties = { display: "flex", alignItems: "center", justifyContent: "space-between", gap: 10, padding: "10px 12px", borderRadius: 14, border: "1px solid #e2e8f0", background: "#fff" };
const methodLabelStyle: React.CSSProperties = { fontSize: 10, fontWeight: 900, color: "#64748b" };
const methodSelect: React.CSSProperties = { padding: "10px 12px", borderRadius: 12, border: "1px solid #e2e8f0", fontSize: 12, fontWeight: 800, color: "#0f172a", background: "#fff" };

const installmentsCard: React.CSSProperties = { background: "#fff", borderRadius: 16, border: "1px solid #e2e8f0", overflow: "hidden" };
const installmentsHeader: React.CSSProperties = { padding: "10px 15px", background: "#f1f5f9", display: "flex", alignItems: "center", gap: 8 };
const installmentsBody: React.CSSProperties = { display: "grid", gap: 8, padding: 12, maxHeight: 240, overflowY: "auto" };

const installmentRow: React.CSSProperties = { display: "flex", alignItems: "center", justifyContent: "space-between", gap: 12, padding: "12px 12px", borderRadius: 14, border: "1px solid #e2e8f0", background: "#fff" };
const installmentTop: React.CSSProperties = { display: "flex", alignItems: "center", gap: 8 };
const installmentIdx: React.CSSProperties = { fontSize: 11, fontWeight: 900, color: "#0f172a", background: "#f1f5f9", padding: "4px 8px", borderRadius: 10 };
const installmentDue: React.CSSProperties = { fontSize: 12, fontWeight: 800, color: "#475569" };
const installmentAmount: React.CSSProperties = { marginTop: 6, fontSize: 14, fontWeight: 900, color: "#0f172a" };

const partialNote: React.CSSProperties = { marginTop: 6, fontSize: 11, color: "#b45309", fontWeight: 800 };

const payBtn: React.CSSProperties = { padding: "10px 12px", borderRadius: 12, border: "none", background: "#ff5722", color: "#fff", fontWeight: 900, fontSize: 11, cursor: "pointer", whiteSpace: "nowrap" };
const paidPill: React.CSSProperties = { display: "inline-flex", alignItems: "center", gap: 6, padding: "8px 10px", borderRadius: 999, border: "1px solid #dcfce7", background: "#f0fdf4", color: "#166534", fontWeight: 900, fontSize: 11, whiteSpace: "nowrap" };

const noBackendPill: React.CSSProperties = { display: "inline-flex", alignItems: "center", padding: "8px 10px", borderRadius: 999, border: "1px solid #e2e8f0", background: "#f8fafc", color: "#64748b", fontWeight: 900, fontSize: 11, whiteSpace: "nowrap" };

const receiptMiniBtn: React.CSSProperties = {
  border: "1px solid rgba(0,0,0,.10)",
  background: "#fff",
  borderRadius: 12,
  padding: "9px 10px",
  cursor: "pointer",
  display: "inline-flex",
  alignItems: "center",
  justifyContent: "center",
};

const historyBtn: React.CSSProperties = {
  marginLeft: 10,
  border: "1px solid rgba(0,0,0,.12)",
  background: "#fff",
  borderRadius: 12,
  padding: "8px 10px",
  cursor: "pointer",
  display: "inline-flex",
  alignItems: "center",
  gap: 8,
  fontWeight: 900,
  fontSize: 11,
  color: "#0f172a",
};

/* ====== Modal Nota de Venta ====== */
const receiptOverlay: React.CSSProperties = {
  position: "fixed",
  inset: 0,
  background: "rgba(15, 23, 42, 0.65)",
  backdropFilter: "blur(10px)",
  display: "grid",
  placeItems: "center",
  padding: 16,
  zIndex: 220,
};

const receiptCard: React.CSSProperties = {
  width: "min(740px, 100%)",
  background: "#fff",
  borderRadius: 24,
  padding: 16,
  boxShadow: "0 30px 80px rgba(0,0,0,0.35)",
};

const receiptCloseBtn: React.CSSProperties = {
  marginLeft: "auto",
  border: "1px solid rgba(0,0,0,.10)",
  background: "#fff",
  borderRadius: 12,
  padding: "8px 10px",
  cursor: "pointer",
};

const receiptBody: React.CSSProperties = {
  marginTop: 12,
  border: "1px solid #e5e7eb",
  borderRadius: 18,
  padding: 14,
  background: "#f8fafc",
};

const receiptHeaderRow: React.CSSProperties = {
  display: "flex",
  justifyContent: "space-between",
  alignItems: "flex-start",
  gap: 12,
  paddingBottom: 10,
  borderBottom: "1px solid #e5e7eb",
};

const receiptGrid: React.CSSProperties = {
  marginTop: 12,
  display: "grid",
  gridTemplateColumns: "1fr 1fr",
  gap: 10,
};

const receiptBox: React.CSSProperties = {
  background: "#fff",
  border: "1px solid #e5e7eb",
  borderRadius: 14,
  padding: 12,
};

const receiptK: React.CSSProperties = {
  fontSize: 10,
  fontWeight: 900,
  color: "#6b7280",
  letterSpacing: 0.3,
  textTransform: "uppercase",
};

const receiptV: React.CSSProperties = {
  marginTop: 6,
  fontSize: 13,
  fontWeight: 900,
  color: "#0f172a",
};

const receiptM: React.CSSProperties = {
  marginTop: 6,
  fontSize: 12,
  fontWeight: 700,
  color: "#64748b",
};

const receiptFootNote: React.CSSProperties = {
  marginTop: 12,
  fontSize: 12,
  color: "#64748b",
};

const receiptActions: React.CSSProperties = {
  marginTop: 12,
  display: "flex",
  justifyContent: "flex-end",
  gap: 10,
  flexWrap: "wrap",
};

const receiptBtnPrimary: React.CSSProperties = {
  background: "#0f172a",
  color: "#fff",
  border: "none",
  padding: "12px 14px",
  borderRadius: 14,
  fontWeight: 900,
  cursor: "pointer",
  display: "inline-flex",
  alignItems: "center",
  gap: 8,
};

const receiptBtnSecondary: React.CSSProperties = {
  background: "#fff",
  color: "#0f172a",
  border: "1px solid rgba(0,0,0,.12)",
  padding: "12px 14px",
  borderRadius: 14,
  fontWeight: 900,
  cursor: "pointer",
};
