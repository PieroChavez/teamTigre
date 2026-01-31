import React from "react";
import { useAuth } from "../../auth/AuthContext";

export default function StudentHome() {
  const { user, roles, signOut } = useAuth();

  return (
    <div style={{ padding: 24 }}>
      <h2 style={{ fontWeight: 900 }}>Panel del Alumno</h2>
      <p style={{ marginTop: 8 }}>
        Bienvenido: <b>{user?.name ?? user?.email}</b>
      </p>
      <p style={{ color: "rgba(0,0,0,.6)" }}>
        Rol: <b>{roles?.map((r) => r.key).join(", ") || "—"}</b>
      </p>

      <button className="btn btn-primary" onClick={signOut} style={{ marginTop: 16 }}>
        Cerrar sesión
      </button>
    </div>
  );
}
