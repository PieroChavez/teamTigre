'use client'

import { useState, useMemo, useEffect, useCallback } from 'react'
import {
  Dialog,
  DialogBackdrop,
  DialogPanel,
  PopoverGroup,
} from '@headlessui/react'
import { 
  Bars3Icon, 
  MagnifyingGlassIcon, 
  XMarkIcon,
  UserIcon,
  ArrowRightOnRectangleIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from '@heroicons/react/24/outline'
import { Outlet, Link, NavLink, useNavigate, useLocation } from "react-router-dom"
import { useAuth } from "../auth/AuthContext"

export default function PublicLayout() {
  const [open, setOpen] = useState(false)
  const [isScrolled, setIsScrolled] = useState(false)
  const [currentSlide, setCurrentSlide] = useState(0)
  
  const navigate = useNavigate()
  const location = useLocation()
  const { user, loading, signOut } = useAuth()
  const isHome = location.pathname === "/";

  // --- Lógica de Scroll para el Navbar ---
  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 50)
    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  // --- Datos del Slider ---
  const slides = useMemo(() => [
    {
      id: 1,
      title: "Tu mejor versión se construye golpe a golpe.",
      subtitle: "No importa tu nivel. En Club de Box El Tigre te enseñamos la disciplina, la técnica y la fuerza para conquistar tus metas.",
      cta: "¡Reserva tu clase de prueba gratis!",
      video: "/hero/entrenamiento.mp4"
    },
    {
      id: 2,
      title: "Disciplina, Coraje y Poder.",
      subtitle: "Entrenamiento de alto rendimiento para todas las edades: Niños, jóvenes y adultos.",
      cta: "Ver Horarios",
      video: "/hero/entrenamiento.mp4" 
    }
  ], [])

  const nextSlide = useCallback(() => {
    setCurrentSlide((prev) => (prev + 1) % slides.length)
  }, [slides.length])

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length)
  }

  // --- Slider Automático (Cada 2 segundos) ---
  useEffect(() => {
    if (!isHome) return;
    const interval = setInterval(nextSlide, 2000)
    return () => clearInterval(interval)
  }, [nextSlide, isHome])

  const navLinkClass = ({ isActive }: { isActive: boolean }) =>
    `text-[11px] font-bold uppercase tracking-[0.2em] transition-all duration-300 ${
      isActive 
        ? "text-[#FD7515]" 
        : isScrolled ? "text-white hover:text-[#FFBA00]" : "text-black hover:text-[#5E2129]"
    }`;

  return (
    <div className="bg-[#FFFFFF] min-h-screen flex flex-col font-sans selection:bg-[#FFBA00] selection:text-[#5E2129]">
      
      {/* 1. NAVBAR DINÁMICO */}
      <header 
        className={`fixed top-0 w-full z-50 transition-all duration-500 ${
          isScrolled 
            ? "bg-black py-3 shadow-2xl" 
            : "bg-white/80 backdrop-blur-md py-5"
        }`}
      >
        <div className={`h-[2px] absolute top-0 w-full transition-colors duration-500 ${isScrolled ? "bg-[#FFBA00]" : "bg-[#5E2129]"}`} />
        
        <nav className="mx-auto max-w-7xl px-6 lg:px-8">
          <div className="flex justify-between items-center h-12">
            
            {/* IZQUIERDA: Menús (Desktop) y Hamburguesa (Mobile) */}
            <div className="flex flex-1 items-center">
              <button 
                onClick={() => setOpen(true)} 
                className={`lg:hidden p-2 -ml-2 transition-colors ${isScrolled ? "text-white" : "text-black"}`}
              >
                <Bars3Icon className="size-7" />
              </button>

              <PopoverGroup className="hidden lg:flex lg:space-x-10">
                {['Inicio', 'Nosotros', 'Servicios', 'Tienda', 'Contacto'].map((item) => (
                  <NavLink key={item} to={item === 'Inicio' ? '/' : `/${item.toLowerCase()}`} end className={navLinkClass}>
                    {item}
                  </NavLink>
                ))}
              </PopoverGroup>
            </div>

            {/* CENTRO: Logo */}
            <div className="flex-shrink-0">
              <Link to="/" className="block">
                <img 
                  src="/hero/logo.png" 
                  alt="Logo" 
                  className={`h-12 w-auto object-contain transition-all duration-500 ${isScrolled ? "brightness-200" : "hover:scale-105"}`} 
                />
              </Link>
            </div>

            {/* DERECHA: Login / Acceso */}
            <div className="flex flex-1 justify-end items-center space-x-6">
              <button className={`hidden sm:block transition-colors ${isScrolled ? "text-white/70 hover:text-[#FFBA00]" : "text-black/70 hover:text-[#5E2129]"}`}>
                <MagnifyingGlassIcon className="size-5" />
              </button>

              {!loading && !user ? (
                <Link to="/login" className="flex flex-col items-center group">
                  <UserIcon className={`size-5 transition-colors ${isScrolled ? "text-white group-hover:text-[#FFBA00]" : "text-black group-hover:text-[#5E2129]"}`} />
                  <span className={`text-[8px] font-black uppercase mt-1 tracking-tighter ${isScrolled ? "text-white" : "text-black"}`}>Acceso</span>
                </Link>
              ) : (
                <button onClick={() => signOut()} className={`flex flex-col items-center ${isScrolled ? "text-white" : "text-black"}`}>
                  <ArrowRightOnRectangleIcon className="size-5" />
                  <span className="text-[8px] font-black uppercase mt-1">Salir</span>
                </button>
              )}
            </div>
          </div>
        </nav>
      </header>

      {/* 2. SLIDER / CARRUSEL HERO */}
      {isHome && (
        <section className="relative h-screen w-full overflow-hidden bg-black">
          {slides.map((slide, index) => (
            <div 
              key={slide.id}
              className={`absolute inset-0 transition-all duration-[1500ms] ease-in-out transform ${
                index === currentSlide ? "opacity-100 scale-100" : "opacity-0 scale-110"
              }`}
            >
              <video autoPlay loop muted playsInline className="absolute inset-0 h-full w-full object-cover opacity-40">
                <source src={slide.video} type="video/mp4" />
              </video>
              
              <div className="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-black/60" />

              <div className="relative z-10 flex h-full flex-col items-center justify-center px-6 text-center text-white">
                <h1 className="max-w-5xl text-5xl font-black uppercase tracking-[ -0.05em] sm:text-7xl lg:text-8xl leading-[0.85]">
                  {slide.title.split(' ').slice(0, -2).join(' ')} <br />
                  <span className="text-[#FFBA00] italic">{slide.title.split(' ').slice(-2).join(' ')}</span>
                </h1>
                <p className="mt-8 max-w-2xl text-base sm:text-xl font-light text-[#E7E4E1] tracking-wide leading-relaxed">
                  {slide.subtitle}
                </p>
                <Link
                  to="/contacto"
                  className="mt-12 group relative inline-flex items-center justify-center overflow-hidden bg-[#FFBA00] px-12 py-5 transition-all duration-300 hover:bg-[#FD7515]"
                >
                  <span className="relative z-10 text-[11px] font-black uppercase tracking-[0.3em] text-[#5E2129] group-hover:text-white transition-colors">
                    {slide.cta}
                  </span>
                </Link>
              </div>
            </div>
          ))}

          {/* Controles del Slider (Desktop) */}
          <div className="hidden lg:block">
            <button onClick={prevSlide} className="absolute left-8 top-1/2 z-30 -translate-y-1/2 text-white/20 hover:text-[#FFBA00] transition-all transform hover:scale-110">
              <ChevronLeftIcon className="size-12" />
            </button>
            <button onClick={nextSlide} className="absolute right-8 top-1/2 z-30 -translate-y-1/2 text-white/20 hover:text-[#FFBA00] transition-all transform hover:scale-110">
              <ChevronRightIcon className="size-12" />
            </button>
          </div>

          {/* Indicadores de Línea */}
          <div className="absolute bottom-12 left-1/2 z-30 flex -translate-x-1/2 space-x-4">
            {slides.map((_, i) => (
              <button 
                key={i} 
                onClick={() => setCurrentSlide(i)}
                className={`h-[3px] transition-all duration-700 ${i === currentSlide ? "w-16 bg-[#FFBA00]" : "w-8 bg-white/20 hover:bg-white/40"}`} 
              />
            ))}
          </div>
        </section>
      )}

      {/* 3. MENU MOBILE (Corregido) */}
      <Dialog open={open} onClose={setOpen} className="relative z-[100] lg:hidden">
        <DialogBackdrop transition className="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300" />
        <div className="fixed inset-0 z-[100] flex">
          <DialogPanel transition className="relative flex w-full max-w-xs transform flex-col bg-white h-full shadow-2xl transition duration-300 ease-in-out data-[closed]:-translate-x-full">
            <div className="flex px-8 py-8 justify-between items-center border-b border-gray-100">
              <img src="/hero/logo.png" alt="Logo" className="h-8 w-auto" />
              <button onClick={() => setOpen(false)} className="text-black">
                <XMarkIcon className="size-8" />
              </button>
            </div>
            <div className="flex flex-col space-y-1 px-4 py-8">
              {['Inicio', 'Nosotros', 'Servicios', 'Tienda', 'Contacto'].map((item) => (
                <Link 
                  key={item} 
                  to={item === 'Inicio' ? '/' : `/${item.toLowerCase()}`} 
                  onClick={() => setOpen(false)} 
                  className="px-4 py-4 text-2xl font-black uppercase tracking-tighter text-black hover:bg-[#FFBA00] hover:text-[#5E2129] transition-all"
                >
                  {item}
                </Link>
              ))}
            </div>
          </DialogPanel>
        </div>
      </Dialog>

      {/* 4. CONTENIDO DINÁMICO */}
      <main className={isHome ? "" : "flex-grow"}>
        <Outlet />
      </main>

      {/* 5. FOOTER OSCURO PROFESIONAL */}
      <footer className="bg-black text-white py-20 border-t border-white/5">
        <div className="mx-auto max-w-7xl px-8">
          <div className="flex flex-col md:flex-row justify-between items-center gap-12">
            <div className="flex flex-col items-center md:items-start">
              <img src="/hero/logo.png" alt="Logo" className="h-10 brightness-200 grayscale mb-6" />
              <p className="text-[10px] tracking-[0.4em] text-white/30 uppercase font-bold">Heredia, Costa Rica</p>
            </div>
            
            <div className="flex flex-col items-center">
              <div className="flex space-x-10 text-[11px] font-black uppercase tracking-[0.2em]">
                <Link to="/nosotros" className="hover:text-[#FFBA00] transition-colors">Nosotros</Link>
                <Link to="/servicios" className="hover:text-[#FFBA00] transition-colors">Servicios</Link>
                <Link to="/tienda" className="hover:text-[#FFBA00] transition-colors">Tienda</Link>
              </div>
              <div className="mt-8 flex space-x-4">
                <div className="h-1.5 w-1.5 rounded-full bg-[#FFBA00]" />
                <div className="h-1.5 w-1.5 rounded-full bg-[#5E2129]" />
                <div className="h-1.5 w-1.5 rounded-full bg-[#FD7515]" />
              </div>
            </div>

            <div className="text-center md:text-right">
              <p className="text-[11px] font-black tracking-[0.4em] text-[#FFBA00] mb-2 uppercase">Disciplina • Técnica • Progreso</p>
              <p className="text-[9px] text-white/20 font-medium uppercase tracking-widest">
                © {new Date().getFullYear()} El Tigre Boxing Club. All rights reserved.
              </p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  )
}