import React, { useState } from "react";
import "./alertaRegistro.css";

interface FormData {
  nombres_apellidos: string;
  edad: string;
  celular: string;
  correo: string;
}

interface AlertaRegistroProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: () => void;
}

const AlertaRegistro: React.FC<AlertaRegistroProps> = ({ isOpen, onClose, onSuccess }) => {
  const [formData, setFormData] = useState<FormData>({
    nombres_apellidos: "",
    edad: "",
    celular: "",
    correo: "",
  });

  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    // Validación básica
    if (
      !formData.nombres_apellidos.trim() ||
      !formData.edad ||
      !formData.celular.trim() ||
      !formData.correo.trim()
    ) {
      setError("Por favor completa todos los campos");
      setLoading(false);
      return;
    }

    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(formData.correo)) {
      setError("Por favor ingresa un correo válido");
      setLoading(false);
      return;
    }

    // Validar edad
    const edad = parseInt(formData.edad);
    if (isNaN(edad) || edad < 1 || edad > 120) {
      setError("Por favor ingresa una edad válida");
      setLoading(false);
      return;
    }

    // Validar celular (solo números)
    if (!/^\d{7,15}$/.test(formData.celular.replace(/\s/g, ""))) {
      setError("El celular debe tener entre 7 y 15 dígitos");
      setLoading(false);
      return;
    }

    try {
      // Aquí puedes hacer la solicitud a tu API
      console.log("Datos del formulario:", formData);
      
      setSubmitted(true);
      
      // Guardar en localStorage para no mostrar nuevamente
      localStorage.setItem("registroCompleted", "true");
      
      setFormData({
        nombres_apellidos: "",
        edad: "",
        celular: "",
        correo: "",
      });

      // Llamar al callback de éxito
      if (onSuccess) {
        setTimeout(() => {
          onSuccess();
          onClose();
          setSubmitted(false);
        }, 2000);
      } else {
        setTimeout(() => {
          setSubmitted(false);
          onClose();
        }, 2000);
      }
    } catch (err) {
      setError("Error al enviar el formulario. Intenta nuevamente.");
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  if (!isOpen) return null;

  return (
    <div className="alerta-overlay">
      <div className="alerta-backdrop" onClick={onClose} />
      
      <div className="alerta-modal">
        <button className="alerta-close" onClick={onClose} aria-label="Cerrar">
          ✕
        </button>

        <div className="alerta-content">
          {/* Logo */}
          <div className="alerta-logo-wrapper">
            <img 
              src="/hero/logo.png" 
              alt="Logo Academia Box" 
              className="alerta-logo"
            />
          </div>

          {/* Title */}
          <h1 className="alerta-title">Nuevo por aquí</h1>
          <p className="alerta-subtitle">
            Completa tus datos para unirte a nuestra academia y comienza tu transformación
          </p>

          {/* Success Message */}
          {submitted && (
            <div className="alerta-message alerta-success">
              <span className="alerta-icon">✓</span>
              <div>
                <p className="alerta-message-title">¡Registro exitoso!</p>
                <p className="alerta-message-text">Nos contactaremos pronto con más información.</p>
              </div>
            </div>
          )}

          {/* Error Message */}
          {error && (
            <div className="alerta-message alerta-error">
              <span className="alerta-icon">⚠</span>
              <div>
                <p className="alerta-message-title">Error en el registro</p>
                <p className="alerta-message-text">{error}</p>
              </div>
            </div>
          )}

          {/* Form */}
          <form onSubmit={handleSubmit} className="alerta-form">
            {/* Nombres y Apellidos */}
            <div className="form-group">
              <label htmlFor="nombres_apellidos" className="form-label">
                👤 Nombres y Apellidos
              </label>
              <input
                type="text"
                id="nombres_apellidos"
                name="nombres_apellidos"
                value={formData.nombres_apellidos}
                onChange={handleChange}
                placeholder="Ej: Juan Carlos Pérez"
                className="form-input"
                required
              />
            </div>

            {/* Edad */}
            <div className="form-group">
              <label htmlFor="edad" className="form-label">
                🎂 Edad
              </label>
              <input
                type="number"
                id="edad"
                name="edad"
                value={formData.edad}
                onChange={handleChange}
                placeholder="Ej: 25"
                className="form-input"
                min="1"
                max="120"
                required
              />
            </div>

            {/* Celular */}
            <div className="form-group">
              <label htmlFor="celular" className="form-label">
                📱 Nro de Celular
              </label>
              <input
                type="tel"
                id="celular"
                name="celular"
                value={formData.celular}
                onChange={handleChange}
                placeholder="Ej: +58 412 1234567"
                className="form-input"
                required
              />
            </div>

            {/* Correo */}
            <div className="form-group">
              <label htmlFor="correo" className="form-label">
                ✉️ Correo Electrónico
              </label>
              <input
                type="email"
                id="correo"
                name="correo"
                value={formData.correo}
                onChange={handleChange}
                placeholder="Ej: tu@correo.com"
                className="form-input"
                required
              />
            </div>

            {/* Submit Button */}
            <button
              type="submit"
              disabled={loading}
              className={`form-submit ${loading ? "is-loading" : ""}`}
            >
              {loading ? (
                <>
                  <span className="spinner" />
                  Enviando...
                </>
              ) : (
                <>
                  <span>🚀</span>
                  Registrarme
                </>
              )}
            </button>
          </form>

          {/* Footer */}
          <p className="alerta-footer">
            ¿Ya tienes cuenta?{" "}
            <a href="/login" className="alerta-link">
              Inicia sesión aquí
            </a>
          </p>

          <div className="alerta-branding">
            <p>Academia Box • Disciplina • Técnica • Progreso</p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AlertaRegistro;