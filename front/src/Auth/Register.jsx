import React from "react";

export default function Register() {
  return (
    <div className="d-flex justify-content-center align-items-center min-vh-100 bg-light">
      <div className="card p-4 shadow-sm" style={{ width: "100%", maxWidth: "380px" }}>
        <h3 className="text-center mb-4">Crear Cuenta</h3>

        <form>
          <div className="mb-3">
            <label className="form-label">Nombre</label>
            <input
              type="text"
              className="form-control"
              placeholder="Tu nombre completo"
            />
          </div>

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

          <div className="mb-3">
            <label className="form-label">Confirmar Contraseña</label>
            <input
              type="password"
              className="form-control"
              placeholder="••••••••"
            />
          </div>

          <button type="submit" className="btn btn-dark w-100 mt-2">
            Crear cuenta
          </button>

          <p className="text-center mt-3 mb-0">
            ¿Ya tienes una cuenta?{" "}
            <a href="#" className="text-decoration-none">
              Inicia sesión
            </a>
          </p>
        </form>
      </div>
    </div>
  );
}
