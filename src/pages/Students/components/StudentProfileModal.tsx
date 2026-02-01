import React, { useEffect, useMemo, useState } from "react";
import { useNavigate } from "react-router-dom";
import {
  AlertCircle,
  Ban,
  CheckCircle2,
  CreditCard,
  Edit3,
  FileText,
  Fingerprint,
  GraduationCap,
  HeartPulse,
  Mail,
  Phone,
  Printer,
  Settings,
  ShieldCheck,
  User,
  X,
  Zap,
  Award,
  Calendar,
  Trash2,
} from "lucide-react";

import type { Student } from "../../../services/students";
import type { Category } from "../../../services/categories";
import { listActiveCategories } from "../../../services/categories";
import type { Enrollment, PaymentMethod } from "../../../services/enrollments";
import { listEnrollments, getInitialPayment, saveInitialPayment } from "../../../services/enrollments";
import { getApiErrorMessage } from "../../../services/api";

import { EnrollmentManager } from "./EnrollmentManager";
import { CreditPanel } from "./CreditPanel";

import { calcAge, todayYmd } from "../utils/dates";
import { moneyPENFromCents } from "../utils/money";
import { categoryLabel, formatName, getCurrentEnrollment, getMonthlyFeeCents } from "../utils/helpers";

type InitialPayment = {
  paid: boolean;
  paid_on: string;
  method: PaymentMethod;
};

type InitialReceipt = {
  id: number;
  enrollment_id: number;
  student_id: number;
  category_id: number | null;
  concept: string;
  amount_cents: number;
  paid_cents: number;
  status: string;
  paid_on: string | null;
  method: PaymentMethod | null;
  created_at?: string;
};

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

function printHtml(title: string, html: string) {
  const w = window.open("", "_blank", "width=860,height=900");
  if (!w) return;

  w.document.open();
  w.document.write(`<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>${title}</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color: #111827; }
    .paper { max-width: 720px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 14px; padding: 20px; }
    .row { display:flex; justify-content:space-between; align-items:flex-start; gap: 12px; }
    .muted { color:#6b7280; font-size: 12px; }
    .title { font-size: 18px; font-weight: 800; margin: 0; }
    .subtitle { font-size: 12px; font-weight: 700; color:#374151; margin-top: 4px; }
    .tag { display:inline-block; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 800; background:#111827; color:#fff; }
    .hr { height:1px; background:#e5e7eb; margin: 14px 0; }
    .grid { display:grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .box { border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; }
    .k { font-size: 11px; font-weight: 800; color:#6b7280; letter-spacing: .4px; }
    .v { font-size: 13px; font-weight: 700; color:#111827; margin-top: 4px; }
    .total { font-size: 22px; font-weight: 900; }
    @media print {
      body { margin: 0; }
      .paper { border: none; border-radius: 0; }
    }
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

function ReceiptModal(props: {
  open: boolean;
  onClose: () => void;
  receipt: InitialReceipt | null;
  student: Student;
  enrollment: Enrollment | null;
  amountCents: number;
}) {
  const { open, onClose, receipt, student, enrollment, amountCents } = props;
  if (!open) return null;

  const receiptNo = receipt?.id ? `NV-${pad(receipt.id)}` : `NV-${pad(student.id)}-${Date.now()}`;
  const paidOn = receipt?.paid_on || todayYmd();
  const method = receipt?.method || "cash";
  const category = enrollment?.category ? categoryLabel(enrollment.category as any) : "—";

  function handlePrint() {
    const html = `
      <div class="paper">
        <div class="row">
          <div>
            <p class="title">NOTA DE VENTA</p>
            <div class="subtitle">Comprobante de pago - Matrícula</div>
            <div class="muted" style="margin-top:6px;">Emitido: ${paidOn}</div>
          </div>
          <div style="text-align:right;">
            <div class="tag">${receiptNo}</div>
            <div class="muted" style="margin-top:8px;">Estado: PAGADO</div>
          </div>
        </div>

        <div class="hr"></div>

        <div class="grid">
          <div class="box">
            <div class="k">ALUMNO</div>
            <div class="v">${formatName(student)}</div>
            <div class="muted" style="margin-top:4px;">DNI: ${(student as any).document_number ?? "—"}</div>
          </div>

          <div class="box">
            <div class="k">DETALLE</div>
            <div class="v">Pago inicial (Matrícula)</div>
            <div class="muted" style="margin-top:4px;">Categoría: ${category}</div>
          </div>

          <div class="box">
            <div class="k">MÉTODO</div>
            <div class="v">${methodLabel(method)}</div>
            <div class="muted" style="margin-top:4px;">Fecha: ${paidOn}</div>
          </div>

          <div class="box">
            <div class="k">TOTAL</div>
            <div class="v total">${moneyPENFromCents(amountCents)}</div>
            <div class="muted" style="margin-top:4px;">Moneda: PEN</div>
          </div>
        </div>

        <div class="hr"></div>

        <div class="muted">
          * Este comprobante es generado por el sistema. Conservar para control interno.
        </div>
      </div>
    `;

    printHtml(`Nota de venta ${receiptNo}`, html);
  }

  return (
    <div style={receiptOverlay} onMouseDown={onClose}>
      <div style={receiptCard} onMouseDown={(e) => e.stopPropagation()}>
        <div style={{ display: "flex", alignItems: "center", gap: 10 }}>
          <div style={{ fontWeight: 900, fontSize: 14 }}>Nota de venta — Matrícula</div>
          <div style={{ marginLeft: "auto" }}>
            <button style={receiptCloseBtn} onClick={onClose} type="button">
              <X size={16} />
            </button>
          </div>
        </div>

        <div style={receiptBody}>
          <div style={receiptHeaderRow}>
            <div>
              <div style={{ fontWeight: 900, fontSize: 12, color: "#6b7280" }}>N°</div>
              <div style={{ fontWeight: 900, fontSize: 16 }}>{receiptNo}</div>
            </div>

            <div style={{ textAlign: "right" }}>
              <div style={{ fontWeight: 900, fontSize: 12, color: "#6b7280" }}>Total</div>
              <div style={{ fontWeight: 900, fontSize: 18 }}>{moneyPENFromCents(amountCents)}</div>
            </div>
          </div>

          <div style={receiptGrid}>
            <div style={receiptBox}>
              <div style={receiptK}>Alumno</div>
              <div style={receiptV}>{formatName(student)}</div>
              <div style={receiptM}>DNI: {(student as any).document_number ?? "—"}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Detalle</div>
              <div style={receiptV}>Pago inicial (Matrícula)</div>
              <div style={receiptM}>Categoría: {category}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Método</div>
              <div style={receiptV}>{methodLabel(method)}</div>
            </div>

            <div style={receiptBox}>
              <div style={receiptK}>Fecha</div>
              <div style={receiptV}>{paidOn}</div>
            </div>
          </div>

          <div style={receiptFootNote}>
            * Este comprobante es generado por el sistema. Conservar para control interno.
          </div>
        </div>

        <div style={receiptActions}>
          <button style={receiptBtnPrimary} onClick={handlePrint} type="button">
            <Printer size={16} /> Imprimir nota de venta
          </button>
          <button style={receiptBtnSecondary} onClick={onClose} type="button">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  );
}

export function StudentProfileModal(props: {
  open: boolean;
  student: Student | null;
  onClose: () => void;
  onEdit: (s: Student) => void;
  onToggleActive: (s: Student) => Promise<void>;
  onDeleteStudent: (s: Student) => Promise<void>;
}) {
  const { open, student, onClose, onEdit, onToggleActive, onDeleteStudent } = props;

  // ✅ NUEVO: navegación
  const navigate = useNavigate();

  const [categories, setCategories] = useState<Category[]>([]);
  const [enrollments, setEnrollments] = useState<Enrollment[]>([]);
  const [loading, setLoading] = useState(false);
  const [paymentLoading, setPaymentLoading] = useState(false);
  const [err, setErr] = useState<string | null>(null);
  const [manageOpen, setManageOpen] = useState(false);

  const [initialPaymentByEnrollment, setInitialPaymentByEnrollment] = useState<Record<number, InitialPayment>>({});
  const [receiptByEnrollment, setReceiptByEnrollment] = useState<Record<number, InitialReceipt | null>>({});

  const [receiptOpen, setReceiptOpen] = useState(false);

  const refreshEnrollments = async () => {
    if (!student) return;
    const enr = await listEnrollments({ studentId: student.id, perPage: 50 });
    setEnrollments(enr.data);
  };

  useEffect(() => {
    if (!open || !student) return;
    setErr(null);
    setManageOpen(false);
    setLoading(true);

    (async () => {
      try {
        const [cats, enr] = await Promise.all([
          listActiveCategories(),
          listEnrollments({ studentId: student.id, perPage: 50 }),
        ]);
        setCategories(cats);
        setEnrollments(enr.data);
      } catch (e) {
        setErr(getApiErrorMessage(e));
      } finally {
        setLoading(false);
      }
    })();
  }, [open, student?.id]);

  const currentEnrollment = useMemo(
    () => getCurrentEnrollment(enrollments as any) as any as Enrollment | null,
    [enrollments]
  );

  const currentFeeCents = useMemo(
    () => (currentEnrollment ? getMonthlyFeeCents(currentEnrollment as any, categories as any) : 0),
    [currentEnrollment, categories]
  );

  const isActive = useMemo(() => {
    const v: any = (student as any)?.is_active;
    return v === true || v === 1 || v === "1";
  }, [student]);

  useEffect(() => {
    if (!currentEnrollment) return;
    const id = currentEnrollment.id;
    if (initialPaymentByEnrollment[id]) return;

    setInitialPaymentByEnrollment((prev) => ({
      ...prev,
      [id]: { paid: false, paid_on: todayYmd(), method: "cash" },
    }));
  }, [currentEnrollment?.id]);

  useEffect(() => {
    if (!open || !currentEnrollment) return;

    const id = currentEnrollment.id;

    (async () => {
      setPaymentLoading(true);
      try {
        const charge: any = await getInitialPayment(id);

        const paid = String(charge.status) === "paid";
        const paid_on = (charge.paid_on as any) ?? todayYmd();
        const method = (charge.method as any) ?? "cash";

        setInitialPaymentByEnrollment((prev) => ({
          ...prev,
          [id]: { paid, paid_on, method },
        }));

        setReceiptByEnrollment((prev) => ({
          ...prev,
          [id]: charge ? (charge as InitialReceipt) : null,
        }));
      } catch {
        // backend aún no implementado
      } finally {
        setPaymentLoading(false);
      }
    })();
  }, [open, currentEnrollment?.id]);

  const initialPayment = currentEnrollment ? initialPaymentByEnrollment[currentEnrollment.id] : null;
  const isPaid = !!initialPayment?.paid;

  const currentReceipt = currentEnrollment ? receiptByEnrollment[currentEnrollment.id] ?? null : null;

  if (!open || !student) return null;

  const initials = `${student.first_name?.[0] ?? ""}${student.last_name?.[0] ?? ""}`.toUpperCase();

  async function handleToggleActive() {
    try {
      setErr(null);
      setLoading(true);
      await onToggleActive(student);
    } catch (e) {
      setErr(getApiErrorMessage(e));
    } finally {
      setLoading(false);
    }
  }

  async function handleDeleteStudent() {
    if (!window.confirm(`¿Eliminar a ${formatName(student)}?`)) return;
    try {
      setErr(null);
      setLoading(true);
      await onDeleteStudent(student);
      onClose();
    } catch (e) {
      setErr(getApiErrorMessage(e));
    } finally {
      setLoading(false);
    }
  }

  function setPaymentPatch(patch: Partial<InitialPayment>) {
    if (!currentEnrollment) return;
    const id = currentEnrollment.id;
    setInitialPaymentByEnrollment((prev) => ({
      ...prev,
      [id]: {
        paid: prev[id]?.paid ?? false,
        paid_on: prev[id]?.paid_on ?? todayYmd(),
        method: prev[id]?.method ?? "cash",
        ...patch,
      },
    }));
  }

  async function commitInitialPayment() {
    if (!currentEnrollment) return;

    const localMethod = initialPayment?.method ?? "cash";
    const localPaidOn = initialPayment?.paid_on ?? todayYmd();

    setPaymentPatch({ paid: true });

    try {
      setPaymentLoading(true);

      const res: any = await saveInitialPayment(currentEnrollment.id, {
        paid: true,
        method: localMethod,
        paid_on: localPaidOn,
      });

      setInitialPaymentByEnrollment((prev) => ({
        ...prev,
        [currentEnrollment.id]: {
          paid: String(res.status) === "paid",
          paid_on: (res.paid_on as any) ?? localPaidOn,
          method: (res.method as any) ?? localMethod,
        },
      }));

      setReceiptByEnrollment((prev) => ({
        ...prev,
        [currentEnrollment.id]: res ? (res as InitialReceipt) : null,
      }));

      setReceiptOpen(true);
    } catch (e: any) {
      setErr(getApiErrorMessage(e));
      setPaymentPatch({ paid: false });
    } finally {
      setPaymentLoading(false);
    }
  }

  return (
    <>
      <ReceiptModal
        open={receiptOpen}
        onClose={() => setReceiptOpen(false)}
        receipt={currentReceipt}
        student={student}
        enrollment={currentEnrollment}
        amountCents={currentFeeCents}
      />

      <div style={overlayStyle} onMouseDown={onClose}>
        <div style={profileCardStyle} onMouseDown={(e) => e.stopPropagation()}>
          <div style={premiumBannerStyle}>
            <button style={closeCircleStyle} onClick={onClose}>
              <X size={20} color="white" />
            </button>

            <div style={lightEffectStyle} />

            <div style={headerContentStyle}>
              <div style={avatarContainerStyle}>
                <div style={largeAvatarStyle}>{initials}</div>
                <div style={onlineStatusStyle(isActive)} />
              </div>

              <div style={bannerInfoStyle}>
                <div style={{ display: "flex", alignItems: "center", gap: "12px" }}>
                  <h1 style={nameTitleStyle}>{formatName(student).toUpperCase()}</h1>
                  {isActive && <ShieldCheck size={26} color="#4ade80" />}
                </div>

                <div style={badgeRowStyle}>
                  <span style={premiumBadgeStyle}>DNI: {(student as any).document_number ?? "—"}</span>
                  <span style={statusPillStyle(isActive)}>
                    {isActive ? "• CUENTA ACTIVA" : "• CUENTA INACTIVA"}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div style={dynamicStatsBarStyle}>
            <div style={statColumnStyle}>
              <div style={statLabelContainer}>
                <Zap size={12} /> ESTADO ACTUAL
              </div>
              <div style={statValueStyle}>{isActive ? "Activo" : "Inactivo"}</div>
            </div>

            <div style={statColumnStyle}>
              <div style={statLabelContainer}>
                <Award size={12} /> CATEGORÍA
              </div>
              <div style={statValueStyle}>
                {currentEnrollment?.category ? categoryLabel(currentEnrollment.category as any) : "Sin Matrícula"}
              </div>
            </div>

            <div style={statColumnStyleHighlight}>
              <div style={statLabelContainerHighlight}>
                <CreditCard size={12} /> CUOTA MENSUAL
              </div>
              <div style={statValueStyleHighlight}>{moneyPENFromCents(currentFeeCents)}</div>
            </div>
          </div>

          {err && (
            <div style={errorAlertStyle}>
              <AlertCircle size={16} /> {err}
            </div>
          )}

          <div style={mainContentGrid}>
            <div style={contentPanel}>
              <div style={panelHeaderStyle}>
                <h3 style={sectionTitleStyle}>DATOS DEL ESTUDIANTE</h3>
                <button style={minimalEditBtn} onClick={() => onEdit(student)}>
                  <Edit3 size={14} /> EDITAR PERFIL
                </button>
              </div>

              <div style={infoGridModern}>
                <InfoTile icon={<User size={18} />} label="Nombre completo" value={formatName(student)} />
                <InfoTile icon={<Fingerprint size={18} />} label="Documento (DNI)" value={(student as any).document_number ?? "—"} />
                <InfoTile
                  icon={<Calendar size={18} />}
                  label="Fecha de nacimiento"
                  value={`${(student as any).birthdate ?? "—"} (${calcAge((student as any).birthdate)} años)`}
                />
                <InfoTile icon={<Phone size={18} />} label="Teléfono personal" value={(student as any).phone || "No registrado"} />
                <InfoTile icon={<Mail size={18} />} label="Correo electrónico" value={(student as any).email || "—"} />
              </div>

              <h3 style={{ ...sectionTitleStyle, marginTop: "30px", borderLeftColor: "#4ade80" }}>
                CONTACTO DE EMERGENCIA
              </h3>
              <div style={infoGridModern}>
                <InfoTile icon={<HeartPulse size={18} />} label="Nombre de contacto" value={(student as any).emergency_contact_name || "No asignado"} />
                <InfoTile icon={<Phone size={18} />} label="Teléfono de emergencia" value={(student as any).emergency_contact_phone || "No asignado"} />
              </div>

              <div style={actionRowContainer}>
                <button style={secondaryActionBtn(isActive)} onClick={handleToggleActive} disabled={loading}>
                  {isActive ? <Ban size={14} /> : <CheckCircle2 size={14} />}
                  {isActive ? "SUSPENDER" : "ACTIVAR CUENTA"}
                </button>

                <button style={dangerActionBtn} onClick={handleDeleteStudent} disabled={loading}>
                  <Trash2 size={14} /> ELIMINAR
                </button>
              </div>
            </div>

            <div style={contentPanel}>
              <h3 style={sectionTitleStyle}>GESTIÓN FINANCIERA</h3>

              {currentEnrollment ? (
                <div style={{ display: "flex", flexDirection: "column", gap: "22px" }}>
                  <div style={isPaid ? paymentDoneStyle : paymentPendingStyle}>
                    <div style={paymentHeader}>
                      <div style={{ display: "flex", alignItems: "center", gap: 10 }}>
                        <span style={paymentTitle}>PAGO INICIAL (MATRÍCULA)</span>

                        {isPaid ? (
                          <button
                            type="button"
                            style={receiptIconBtn}
                            title="Ver nota de venta"
                            onClick={() => setReceiptOpen(true)}
                          >
                            <FileText size={16} />
                          </button>
                        ) : null}
                      </div>

                      <span style={paymentAmount}>{moneyPENFromCents(currentFeeCents)}</span>
                    </div>

                    {!isPaid ? (
                      <div style={paymentActionGroup}>
                        <select
                          style={modernSelect}
                          value={initialPayment?.method ?? "cash"}
                          onChange={(e) => setPaymentPatch({ method: e.target.value as PaymentMethod })}
                          disabled={paymentLoading}
                        >
                          <option value="cash">Efectivo</option>
                          <option value="card">Tarjeta</option>
                          <option value="yape">Yape</option>
                          <option value="plin">Plin</option>
                          <option value="transfer">Transferencia</option>
                        </select>

                        <input
                          style={modernDateInput}
                          type="date"
                          value={initialPayment?.paid_on ?? todayYmd()}
                          onChange={(e) => setPaymentPatch({ paid_on: e.target.value })}
                          disabled={paymentLoading}
                        />

                        <button style={primaryValidateBtn} disabled={paymentLoading} onClick={commitInitialPayment}>
                          <CheckCircle2 size={16} />
                          {paymentLoading ? "..." : "VALIDAR PAGO"}
                        </button>
                      </div>
                    ) : (
                      <div style={{ display: "grid", gap: 10 }}>
                        <div style={successMessageContainer}>
                          <CheckCircle2 size={18} /> MATRÍCULA PAGADA
                        </div>

                        <div style={paidNoteStyle}>
                          ✅ Matrícula pagada y registrada. Puedes ver/imprimir la nota de venta.
                        </div>

                        <button type="button" style={receiptPrintBtn} onClick={() => setReceiptOpen(true)}>
                          <Printer size={16} /> Imprimir nota de venta
                        </button>
                      </div>
                    )}
                  </div>

                  <CreditPanel
                    enrollment={currentEnrollment}
                    monthlyFeeCents={currentFeeCents}
                    enabled={isPaid}
                    loading={loading}
                    setLoading={setLoading}
                    setErr={setErr}
                    onRefresh={refreshEnrollments}
                  />

                  {/* ✅ BOTÓN ACTUALIZADO: redirige a la ficha */}
                  <button
                    type="button"
                    onClick={() => {
                      onClose(); // opcional: cierra modal antes de navegar
                      navigate(`/students/${student.id}/enrollment-sheet`);
                    }}
                    style={printActionBtn}
                  >
                    <div style={printIconWrapper}>
                      <FileText size={20} />
                    </div>
                    <div style={{ textAlign: "left" }}>
                      <div style={{ fontSize: "14px", fontWeight: 900 }}>IMPRIMIR FICHA</div>
                      <div style={{ fontSize: "10px", opacity: 0.7 }}>EXPEDIENTE #00{student.id}</div>
                    </div>
                    <Printer size={18} style={{ marginLeft: "auto", opacity: 0.5 }} />
                  </button>
                </div>
              ) : (
                <div style={emptyStateContainer}>
                  <GraduationCap size={48} color="#e5e7eb" />
                  <p style={{ fontWeight: 700, color: "#9ca3af" }}>Sin Matrícula Activa</p>
                  <button style={createBtnStyle} onClick={() => setManageOpen(true)}>
                    MATRICULAR AHORA
                  </button>
                </div>
              )}
            </div>
          </div>

          <div style={footerArea}>
            <button style={footerToggleBtn(manageOpen)} onClick={() => setManageOpen(!manageOpen)}>
              {manageOpen ? <X size={16} /> : <Settings size={16} />}
              <span>{manageOpen ? "CERRAR HISTORIAL" : "HISTORIAL DE MATRÍCULAS"}</span>
            </button>

            {manageOpen && (
              <div style={collapsibleWrapper}>
                <EnrollmentManager
                  studentId={student.id}
                  categories={categories}
                  enrollments={enrollments}
                  loading={loading}
                  setLoading={setLoading}
                  setErr={setErr}
                  onRefresh={refreshEnrollments}
                />
              </div>
            )}
          </div>
        </div>
      </div>
    </>
  );
}

// Sub-componentes
function InfoTile({ icon, label, value }: any) {
  return (
    <div style={infoTileStyle}>
      <div style={tileIconBox}>{icon}</div>
      <div>
        <div style={tileLabel}>{label}</div>
        <div style={tileValue}>{value}</div>
      </div>
    </div>
  );
}









/* ========= ESTILOS (los tuyos + extras nota de venta) ========= */
const overlayStyle: React.CSSProperties = {
  position: "fixed",
  inset: 0,
  background: "rgba(15, 23, 42, 0.9)",
  backdropFilter: "blur(12px)",
  display: "grid",
  placeItems: "center",
  padding: 20,
  zIndex: 100,
};

const profileCardStyle: React.CSSProperties = {
  width: "min(1100px, 100%)",
  maxHeight: "94vh",
  background: "#ffffff",
  borderRadius: "40px",
  overflowY: "auto",
  position: "relative",
};

const premiumBannerStyle: React.CSSProperties = {
  background: "linear-gradient(135deg, #ff5722 0%, #f4511e 50%, #d84315 100%)",
  height: "190px",
  padding: "0 60px",
  display: "flex",
  alignItems: "center",
  position: "relative",
  overflow: "hidden",
};

const lightEffectStyle: React.CSSProperties = {
  position: "absolute",
  top: "-50px",
  right: "-50px",
  width: "300px",
  height: "300px",
  background: "radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%)",
  borderRadius: "50%",
  pointerEvents: "none",
};

const headerContentStyle: React.CSSProperties = {
  display: "flex",
  alignItems: "center",
  gap: "35px",
  marginTop: "40px",
  zIndex: 2,
};

const largeAvatarStyle: React.CSSProperties = {
  width: "130px",
  height: "130px",
  borderRadius: "38px",
  background: "#0f172a",
  color: "#fff",
  display: "grid",
  placeItems: "center",
  fontSize: "44px",
  fontWeight: 900,
  border: "6px solid #fff",
  boxShadow: "0 20px 40px rgba(0,0,0,0.2)",
};

const avatarContainerStyle: React.CSSProperties = { position: "relative" };

const onlineStatusStyle = (active: boolean): React.CSSProperties => ({
  width: 26,
  height: 26,
  borderRadius: "50%",
  background: active ? "#22c55e" : "#ef4444",
  position: "absolute",
  bottom: 4,
  right: 10,
  border: "5px solid #fff",
});

const nameTitleStyle: React.CSSProperties = {
  color: "#fff",
  fontSize: "34px",
  fontWeight: 900,
  margin: 0,
  letterSpacing: "-1.5px",
};

const badgeRowStyle: React.CSSProperties = { display: "flex", gap: "12px", marginTop: "10px" };

const premiumBadgeStyle: React.CSSProperties = {
  background: "rgba(0,0,0,0.25)",
  color: "#fff",
  padding: "6px 14px",
  borderRadius: "10px",
  fontSize: "11px",
  fontWeight: 800,
};

const statusPillStyle = (active: boolean): React.CSSProperties => ({
  background: active ? "#0f172a" : "#fff",
  color: active ? "#fff" : "#0f172a",
  padding: "6px 14px",
  borderRadius: "10px",
  fontSize: "11px",
  fontWeight: 900,
});

const dynamicStatsBarStyle: React.CSSProperties = {
  display: "grid",
  gridTemplateColumns: "1fr 1fr 1.2fr",
  padding: "25px 60px",
  background: "#f8fafc",
  borderBottom: "1px solid #e2e8f0",
};

const statColumnStyle: React.CSSProperties = { display: "flex", flexDirection: "column" };

const statColumnStyleHighlight: React.CSSProperties = {
  ...statColumnStyle,
  borderLeft: "2px solid #e2e8f0",
  paddingLeft: "30px",
};

const statLabelContainer: React.CSSProperties = {
  fontSize: "10px",
  fontWeight: 800,
  color: "#94a3b8",
  display: "flex",
  alignItems: "center",
  gap: "6px",
};

const statLabelContainerHighlight: React.CSSProperties = { ...statLabelContainer, color: "#ff5722" };

const statValueStyle: React.CSSProperties = { fontSize: "18px", fontWeight: 800, color: "#1e293b" };

const statValueStyleHighlight: React.CSSProperties = { fontSize: "22px", fontWeight: 900, color: "#000" };

const mainContentGrid: React.CSSProperties = {
  display: "grid",
  gridTemplateColumns: "repeat(auto-fit, minmax(400px, 1fr))",
  gap: "40px",
  padding: "50px 60px",
};

const contentPanel: React.CSSProperties = { background: "#fff" };

const sectionTitleStyle: React.CSSProperties = {
  fontSize: "14px",
  fontWeight: 900,
  marginBottom: "30px",
  borderLeft: "5px solid #ff5722",
  paddingLeft: "20px",
  color: "#0f172a",
};

const panelHeaderStyle: React.CSSProperties = {
  display: "flex",
  justifyContent: "space-between",
  alignItems: "center",
  marginBottom: "30px",
};

const infoGridModern: React.CSSProperties = { display: "flex", flexDirection: "column", gap: "10px" };

const infoTileStyle: React.CSSProperties = {
  display: "flex",
  alignItems: "center",
  padding: "18px",
  background: "#f8fafc",
  borderRadius: "20px",
};

const tileIconBox: React.CSSProperties = {
  width: "42px",
  height: "42px",
  borderRadius: "14px",
  background: "#fff",
  color: "#ff5722",
  display: "grid",
  placeItems: "center",
  marginRight: "18px",
  boxShadow: "0 4px 10px rgba(0,0,0,0.05)",
};

const tileLabel: React.CSSProperties = { fontSize: "9px", fontWeight: 900, color: "#94a3b8", textTransform: "uppercase" };

const tileValue: React.CSSProperties = { fontSize: "15px", fontWeight: 700, color: "#1e293b" };

const actionRowContainer: React.CSSProperties = { display: "flex", gap: "15px", marginTop: "35px" };

const secondaryActionBtn = (active: boolean): React.CSSProperties => ({
  flex: 1,
  padding: "15px",
  borderRadius: "18px",
  border: "2px solid #e2e8f0",
  background: "#fff",
  color: active ? "#64748b" : "#ff5722",
  fontWeight: 800,
  fontSize: "12px",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  gap: "8px",
  opacity: 1,
});

const dangerActionBtn: React.CSSProperties = {
  flex: 1,
  padding: "15px",
  borderRadius: "18px",
  border: "none",
  background: "#fef2f2",
  color: "#ef4444",
  fontWeight: 800,
  fontSize: "12px",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  gap: "8px",
};

const paymentPendingStyle: React.CSSProperties = {
  background: "#fffdf5",
  padding: "30px",
  borderRadius: "30px",
  border: "2px solid #fff3d6",
};

const paymentDoneStyle: React.CSSProperties = {
  background: "#f0fdf4",
  padding: "30px",
  borderRadius: "30px",
  border: "2px solid #dcfce7",
};

const paymentHeader: React.CSSProperties = {
  display: "flex",
  justifyContent: "space-between",
  alignItems: "center",
  marginBottom: "20px",
};

const paymentTitle: React.CSSProperties = { fontWeight: 900, fontSize: "12px", color: "#854d0e" };
const paymentAmount: React.CSSProperties = { fontSize: "28px", fontWeight: 900, color: "#000" };

const paymentActionGroup: React.CSSProperties = { display: "flex", gap: "12px", alignItems: "center", flexWrap: "wrap" };

const modernSelect: React.CSSProperties = {
  flex: 1,
  minWidth: 160,
  padding: "14px",
  borderRadius: "16px",
  border: "1px solid #e2e8f0",
  background: "#fff",
  fontWeight: 700,
  fontSize: "14px",
};

const modernDateInput: React.CSSProperties = {
  minWidth: 150,
  padding: "14px",
  borderRadius: "16px",
  border: "1px solid #e2e8f0",
  background: "#fff",
  fontWeight: 700,
  fontSize: "14px",
};

const primaryValidateBtn: React.CSSProperties = {
  background: "#ff5722",
  color: "#fff",
  border: "none",
  padding: "14px 18px",
  borderRadius: "16px",
  fontWeight: 900,
  fontSize: "13px",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  gap: "10px",
  whiteSpace: "nowrap",
};

const successMessageContainer: React.CSSProperties = {
  color: "#16a34a",
  textAlign: "center",
  fontWeight: 900,
  fontSize: "14px",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  gap: "10px",
};

const printActionBtn: React.CSSProperties = {
  width: "100%",
  padding: "18px 25px",
  borderRadius: "24px",
  background: "#1e293b",
  color: "#fff",
  border: "none",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  gap: "15px",
  boxShadow: "0 10px 25px -5px rgba(15, 23, 42, 0.3)",
};

const printIconWrapper: React.CSSProperties = {
  width: "45px",
  height: "45px",
  background: "rgba(255,255,255,0.1)",
  borderRadius: "14px",
  display: "grid",
  placeItems: "center",
  color: "#4ade80",
};

const footerArea: React.CSSProperties = { padding: "0 60px 60px 60px" };

const footerToggleBtn = (open: boolean): React.CSSProperties => ({
  width: "100%",
  padding: "20px",
  borderRadius: "22px",
  background: open ? "#000" : "#f1f5f9",
  color: open ? "#fff" : "#475569",
  border: "none",
  fontWeight: 800,
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  gap: "12px",
});

const closeCircleStyle: React.CSSProperties = {
  position: "absolute",
  top: "35px",
  right: "35px",
  background: "rgba(0,0,0,0.15)",
  border: "none",
  color: "#fff",
  width: "45px",
  height: "45px",
  borderRadius: "50%",
  cursor: "pointer",
  display: "grid",
  placeItems: "center",
  zIndex: 10,
};

const emptyStateContainer: React.CSSProperties = {
  textAlign: "center",
  padding: "60px 20px",
  display: "flex",
  flexDirection: "column",
  alignItems: "center",
  gap: "15px",
};

const createBtnStyle: React.CSSProperties = {
  padding: "12px 25px",
  background: "#ff5722",
  color: "#fff",
  border: "none",
  borderRadius: "12px",
  fontWeight: 900,
  cursor: "pointer",
};

const collapsibleWrapper: React.CSSProperties = {
  marginTop: "25px",
  padding: "30px",
  background: "#fff",
  borderRadius: "30px",
  border: "1px solid #e2e8f0",
};

const bannerInfoStyle: React.CSSProperties = { marginBottom: 0 };

const minimalEditBtn: React.CSSProperties = {
  background: "none",
  border: "none",
  color: "#ff5722",
  fontWeight: 900,
  fontSize: "11px",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  gap: "6px",
};

const errorAlertStyle: React.CSSProperties = {
  margin: "20px 60px",
  padding: "15px",
  background: "#fee2e2",
  color: "#b91c1c",
  borderRadius: "15px",
  fontSize: "14px",
  fontWeight: 800,
  display: "flex",
  alignItems: "center",
  gap: "10px",
};

/* ====== Extras Nota de venta ====== */
const paidNoteStyle: React.CSSProperties = {
  textAlign: "center",
  padding: "12px 14px",
  borderRadius: "16px",
  border: "1px solid #dcfce7",
  background: "#f0fdf4",
  color: "#166534",
  fontWeight: 800,
  fontSize: "12px",
};

const receiptIconBtn: React.CSSProperties = {
  border: "1px solid rgba(0,0,0,.10)",
  background: "#fff",
  color: "#0f172a",
  borderRadius: 12,
  padding: "8px 10px",
  cursor: "pointer",
  display: "inline-flex",
  alignItems: "center",
  justifyContent: "center",
  boxShadow: "0 2px 8px rgba(0,0,0,0.05)",
};

const receiptPrintBtn: React.CSSProperties = {
  width: "100%",
  padding: "14px 16px",
  borderRadius: "16px",
  background: "#0f172a",
  color: "#fff",
  border: "none",
  fontWeight: 900,
  fontSize: "12px",
  cursor: "pointer",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  gap: 10,
};

const receiptOverlay: React.CSSProperties = {
  position: "fixed",
  inset: 0,
  background: "rgba(15, 23, 42, 0.65)",
  backdropFilter: "blur(10px)",
  display: "grid",
  placeItems: "center",
  padding: 16,
  zIndex: 200,
};

const receiptCard: React.CSSProperties = {
  width: "min(720px, 100%)",
  background: "#fff",
  borderRadius: 24,
  padding: 16,
  boxShadow: "0 30px 80px rgba(0,0,0,0.35)",
};

const receiptCloseBtn: React.CSSProperties = {
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
