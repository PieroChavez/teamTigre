import React, { useEffect, useState } from "react";
import "./LoadingScreen.css";

const LoadingScreen: React.FC<{ isLoading: boolean }> = ({ isLoading }) => {
  const [show, setShow] = useState(true);

  useEffect(() => {
    if (!isLoading) {
      // Espera un poco antes de desaparecer
      const timer = setTimeout(() => {
        setShow(false);
      }, 500);
      return () => clearTimeout(timer);
    }
  }, [isLoading]);

  if (!show) return null;

  return (
    <div className={`loading-screen ${!isLoading ? "fade-out" : ""}`}>
      <div className="loading-container">
        <div className="loading-logo">
          <img src="/hero/logo.png" alt="Logo Box School" />
        </div>
        <div className="spinner"></div>
        <p className="loading-text">Cargando...</p>
      </div>
    </div>
  );
};

export default LoadingScreen;
