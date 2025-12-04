import React from "react";

export default function Login() {
  return (
    <div className="d-flex justify-content-center align-items-center min-vh-100 bg-light">
      <div className="card p-4 shadow-sm" style={{ width: "100%", maxWidth: "380px" }}>
        <h3 className="text-center mb-4">Iniciar Sesión</h3>

        <form>
          <div className="mb-3">
            <label className="form-label">Correo</label>
            <input
              type="email"
              className="form-control"
              placeholder="ejemplo@gmail.com"
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Contraseña</label>
            <input
              type="password"
              className="form-control"
              placeholder="••••••••"
            />
          </div>

          <button type="submit" className="btn btn-dark w-100 mt-2">
            Entrar
          </button>

          <p className="text-center mt-3 mb-0">
            <a href="#" className="text-decoration-none">¿Olvidaste tu contraseña?</a>
          </p>
        </form>
      </div>
    </div>
  );
}
