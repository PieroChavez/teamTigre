import React, { useState } from 'react';
import { Calendar, User, Trophy, Menu, X } from 'lucide-react';

// --- COMPONENTES REUTILIZABLES DEL NAVBAR ---

// 1. Componente principal del encabezado (Header)
const Header = ({ currentView, setView, isMenuOpen, setIsMenuOpen }) => (
    // El header se fija en la parte superior y usa z-10 para estar por encima del contenido.
    <header className="bg-gray-900 shadow-xl fixed top-0 w-full z-10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        {/* Logo y Título */}
        <h1 className="text-3xl font-extrabold text-yellow-400 cursor-pointer" onClick={() => setView('Home')}>
          EL TIGRE <span className="text-white text-base font-medium hidden sm:inline"> | Plataforma de Apuestas</span>
        </h1>
  
        {/* Menú de Navegación (Escritorio - visible solo en pantallas medianas y grandes) */}
        <nav className="hidden md:flex space-x-6">
          <NavItem icon={<Calendar className="w-5 h-5" />} label="Eventos" view="Events" currentView={currentView} setView={setView} />
          <NavItem icon={<User className="w-5 h-5" />} label="Peleadores" view="Fighters" currentView={currentView} setView={setView} />
          <NavItem icon={<Trophy className="w-5 h-5" />} label="Resultados" view="Results" currentView={currentView} setView={setView} />
        </nav>
  
        {/* Botón de Menú Móvil (visible solo en pantallas pequeñas) */}
        <button
          className="text-white md:hidden p-2 rounded-lg bg-gray-800 hover:bg-gray-700 transition duration-150"
          onClick={() => setIsMenuOpen(!isMenuOpen)}
          aria-label="Toggle Menu"
        >
          {/* Muestra el ícono de X si el menú está abierto, o el ícono de Menú si está cerrado */}
          {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
        </button>
      </div>
  
      {/* Menú Móvil Desplegable (se muestra con lógica condicional de React) */}
      {isMenuOpen && (
        <div className="md:hidden bg-gray-800 py-2">
          <NavItemMobile label="Eventos" view="Events" setView={setView} setIsMenuOpen={setIsMenuOpen} />
          <NavItemMobile label="Peleadores" view="Fighters" setView={setView} setIsMenuOpen={setIsMenuOpen} />
          <NavItemMobile label="Resultados" view="Results" setView={setView} setIsMenuOpen={setIsMenuOpen} />
        </div>
      )}
    </header>
  );
  
  // 2. Componente para los ítems de navegación en escritorio (con estado activo/inactivo)
  const NavItem = ({ icon, label, view, currentView, setView }) => {
    const isActive = currentView === view;
    const baseClasses = "flex items-center space-x-2 px-3 py-2 rounded-full text-sm font-medium transition duration-200";
    // Clases para el enlace activo (resaltado en amarillo)
    const activeClasses = "bg-yellow-600 text-gray-900 font-bold shadow-lg";
    // Clases para el enlace inactivo
    const inactiveClasses = "text-gray-300 hover:bg-gray-700 hover:text-white";
  
    return (
      <button
        onClick={() => setView(view)}
        className={`${baseClasses} ${isActive ? activeClasses : inactiveClasses}`}
      >
        {icon}
        <span>{label}</span>
      </button>
    );
  };
  
  // 3. Componente para los ítems de navegación en móvil (oculta el menú al hacer click)
  const NavItemMobile = ({ label, view, setView, setIsMenuOpen }) => (
    <button
      onClick={() => { setView(view); setIsMenuOpen(false); }}
      className="block w-full text-left px-4 py-2 text-base text-gray-300 hover:bg-gray-700 hover:text-white transition duration-150"
    >
      {label}
    </button>
  );

// Nuevo componente contenedor y export por defecto
function Navbar() {
  const [currentView, setView] = useState('Home');
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  return (
    <Header
      currentView={currentView}
      setView={setView}
      isMenuOpen={isMenuOpen}
      setIsMenuOpen={setIsMenuOpen}
    />
  );
}

export default Navbar;