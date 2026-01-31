import React, { useEffect, useMemo, useState } from "react";
import { useNavigate } from "react-router-dom";
import {
  Users,
  UserCheck,
  UserX,
  GraduationCap,
  CalendarDays,
  ArrowUpRight,
  RefreshCw,
  ClipboardCheck,
  ShoppingCart,
} from "lucide-react";

import "./Dashboard.css";

import { listStudents } from "../services/students";
import type { Student } from "../services/students";

import { listEnrollments } from "../services/enrollments";
import type { EnrollmentStatus } from "../services/enrollments";

/** Hora exacta Perú (Lima) */
function formatLimaNow(d: Date) {
  return new Intl.DateTimeFormat("es-PE", {
    timeZone: "America/Lima",
    weekday: "short",
    day: "2-digit",
    month: "short",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: false,
  }).format(d);
}

type Stat = { label: string; value: string; hint?: string; icon: React.ReactNode; tone?: "ok" | "warn" | "info" };

export default function DashboardPage() {
  const navigate = useNavigate();

  const [now, setNow] = useState(() => new Date());

  const [busy, setBusy] = useState(false);
  const [err, setErr] = useState<string | null>(null);

  // stats
  const [studentsTotal, setStudentsTotal] = useState<number>(0);
  const [studentsActive, setStudentsActive] = useState<number>(0);
  const [studentsInactive, setStudentsInactive] = useState<number>(0);

  const [enrActive, setEnrActive] = useState<number>(0);
  const [enrEnded, setEnrEnded] = useState<number>(0);

  const [latestStudents, setLatestStudents] = useState<Student[]>([]);

  useEffect(() => {
    const t = setInterval(() => setNow(new Date()), 1000);
    return () => clearInterval(t);
  }, []);

  async function load() {
    setBusy(true);
    setErr(null);
    try {
      // ✅ usamos perPage=1 para traer el total rápido desde paginator.total
      const [stAll, stAct, stInact, eAct, eEnd, stLatest] = await Promise.all([
        listStudents({ page: 1, perPage: 1, active: "" }),
        listStudents({ page: 1, perPage: 1, active: "1" }),
        listStudents({ page: 1, perPage: 1, active: "0" }),

        listEnrollments({ page: 1, perPage: 1, status: "active" as EnrollmentStatus }),
        listEnrollments({ page: 1, perPage: 1, status: "ended" as EnrollmentStatus }),

        listStudents({ page: 1, perPage: 8, active: "" }),
      ]);

      setStudentsTotal(stAll.total ?? 0);
      setStudentsActive(stAct.total ?? 0);
      setStudentsInactive(stInact.total ?? 0);

      setEnrActive(eAct.total ?? 0);
      setEnrEnded(eEnd.total ?? 0);

      setLatestStudents(stLatest.data ?? []);
    } catch (e: any) {
      setErr(e?.message || "Error cargando dashboard");
    } finally {
      setBusy(false);
    }
  }

  useEffect(() => {
    load();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const stats: Stat[] = useMemo(
    () => [
      {
        label: "Estudiantes",
        value: String(studentsTotal),
        hint: "Total registrados",
        icon: <Users size={18} />,
        tone: "info",
      },
      {
        label: "Activos",
        value: String(studentsActive),
        hint: "Cuentas activas",
        icon: <UserCheck size={18} />,
        tone: "ok",
      },
      {
        label: "Inactivos",
        value: String(studentsInactive),
        hint: "Cuentas inactivas",
        icon: <UserX size={18} />,
        tone: "warn",
      },
      {
        label: "Matrículas activas",
        value: String(enrActive),
        hint: "Status = active",
        icon: <GraduationCap size={18} />,
        tone: "ok",
      },
      {
        label: "Finalizadas",
        value: String(enrEnded),
        hint: "Status = ended",
        icon: <CalendarDays size={18} />,
        tone: "info",
      },
    ],
    [studentsTotal, studentsActive, studentsInactive, enrActive, enrEnded]
  );

  return (
    <div className="dash">
      <div className="dash-head">
        <div>
          <div className="dash-title">Dashboard</div>
          <div className="dash-sub">
            Hora Perú (Lima): <b>{formatLimaNow(now)}</b>
          </div>
        </div>

        <div className="dash-actions">
          <button className="dash-btn" onClick={load} disabled={busy}>
            <RefreshCw size={16} className={busy ? "spin" : ""} />
            <span>{busy ? "Cargando..." : "Refrescar"}</span>
          </button>
        </div>
      </div>

      {err && <div className="dash-alert">{err}</div>}

      <section className="dash-grid">
        {stats.map((s) => (
          <div key={s.label} className={`dash-card ${s.tone ?? ""}`}>
            <div className="dash-card-ico">{s.icon}</div>
            <div className="dash-card-body">
              <div className="dash-card-label">{s.label}</div>
              <div className="dash-card-value">{s.value}</div>
              {s.hint && <div className="dash-card-hint">{s.hint}</div>}
            </div>
          </div>
        ))}
      </section>

      <section className="dash-two">
        <div className="dash-panel">
          <div className="dash-panel-head">
            <div className="dash-panel-title">Accesos rápidos</div>
          </div>

          <div className="dash-quick">
            <button className="dash-quick-btn" onClick={() => navigate("/students")}>
              <Users size={18} />
              <span>Estudiantes</span>
              <ArrowUpRight size={16} className="muted" />
            </button>

            <button className="dash-quick-btn" onClick={() => navigate("/attendance")}>
              <ClipboardCheck size={18} />
              <span>Asistencia</span>
              <ArrowUpRight size={16} className="muted" />
            </button>

            <button className="dash-quick-btn" onClick={() => navigate("/store")}>
              <ShoppingCart size={18} />
              <span>Tienda</span>
              <ArrowUpRight size={16} className="muted" />
            </button>
          </div>

          <div className="dash-note">
            * Si luego me pasas services de tienda/pagos, aquí metemos ventas, pedidos y pagos pendientes.
          </div>
        </div>

        <div className="dash-panel">
          <div className="dash-panel-head">
            <div className="dash-panel-title">Últimos estudiantes</div>
          </div>

          <div className="dash-table-wrap">
            <table className="dash-table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>DNI</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                {latestStudents.map((s) => {
                  const full = `${s.first_name ?? ""} ${s.last_name ?? ""}`.trim() || "—";
                  const dni = s.document_number ?? "—";
                  const active = s.is_active === true || s.is_active === (1 as any) || s.is_active === ("1" as any);

                  return (
                    <tr key={s.id}>
                      <td className="name">{full}</td>
                      <td className="mono">{dni}</td>
                      <td>
                        <span className={`pill ${active ? "ok" : "bad"}`}>{active ? "ACTIVO" : "INACTIVO"}</span>
                      </td>
                    </tr>
                  );
                })}

                {latestStudents.length === 0 && (
                  <tr>
                    <td colSpan={3} className="empty">
                      No hay datos.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>

          <div className="dash-panel-foot">
            <button className="dash-btn ghost" onClick={() => navigate("/students")}>
              Ver todos
              <ArrowUpRight size={16} />
            </button>
          </div>
        </div>
      </section>
    </div>
  );
}
