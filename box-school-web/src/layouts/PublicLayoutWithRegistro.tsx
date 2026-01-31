import { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import PublicLayout from "./PublicLayout";
import AlertaRegistro from "./alertaRegistro";
import { useAuth } from "../auth/AuthContext";

export default function PublicLayoutWithRegistro() {
  const [showRegistroModal, setShowRegistroModal] = useState(false);
  const [hasRegistered, setHasRegistered] = useState(false);
  const { user, loading } = useAuth();
  const location = useLocation();
  let registroInterval: ReturnType<typeof setInterval>;

  useEffect(() => {
    // Verificar si ya se registró (localStorage)
    const registered = localStorage.getItem("registroCompleted");
    if (registered) {
      setHasRegistered(true);
    }
  }, []);

  useEffect(() => {
    // Solo mostrar modal en la página principal (/) y si el usuario NO está autenticado
    // y no ha completado el registro
    if (location.pathname === "/" && !loading && !user && !hasRegistered) {
      // Mostrar el modal después de 5 segundos por primera vez
      const initialTimer = setTimeout(() => {
        setShowRegistroModal(true);
      }, 5000);

      // Luego, mostrar cada 5 segundos (solo si está cerrado)
      const intervalTimer = setTimeout(() => {
        registroInterval = setInterval(() => {
          setShowRegistroModal(true);
        }, 5000);
      }, 5000);

      return () => {
        clearTimeout(initialTimer);
        clearTimeout(intervalTimer);
        if (registroInterval) clearInterval(registroInterval);
      };
    }

    return () => {
      if (registroInterval) clearInterval(registroInterval);
    };
  }, [user, loading, location.pathname, hasRegistered]);

  const handleCloseRegistro = () => {
    setShowRegistroModal(false);
  };

  const handleSuccessRegistro = () => {
    setHasRegistered(true);
    localStorage.setItem("registroCompleted", "true");
    setShowRegistroModal(false);
    
    // Limpiar el interval
    if (registroInterval) clearInterval(registroInterval);
  };

  return (
    <>
      {/* ❌ ALERTAREGISTRO COMENTADO POR AHORA */}
      {/* <AlertaRegistro 
        isOpen={showRegistroModal} 
        onClose={handleCloseRegistro}
        onSuccess={handleSuccessRegistro}
      /> */}
      <PublicLayout />
    </>
  );
}
