'use client'

import { useEffect, useMemo, useRef, useState, useCallback } from "react";
import { Link } from "react-router-dom";

type Slide = {
  image: string;
  badge: string;
  title: string;
  highlight: string;
  text: string;
};

function ParticlesCanvas() {
  const ref = useRef<HTMLCanvasElement | null>(null);

  useEffect(() => {
    const canvas = ref.current;
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    let raf = 0;
    const resize = () => {
      const parent = canvas.parentElement;
      if (!parent) return;
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      canvas.width = Math.floor(parent.clientWidth * dpr);
      canvas.height = Math.floor(parent.clientHeight * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };

    resize();
    window.addEventListener("resize", resize);
    const parent = canvas.parentElement!;
    const W = () => parent.clientWidth;
    const H = () => parent.clientHeight;

    const count = Math.max(40, Math.floor((W() * H()) / 25000));
    const pts = Array.from({ length: count }).map(() => ({
      x: Math.random() * W(),
      y: Math.random() * H(),
      vx: (Math.random() - 0.5) * 0.3,
      vy: (Math.random() - 0.5) * 0.3,
      r: Math.random() * 1.5 + 0.5,
    }));

    const step = () => {
      ctx.clearRect(0, 0, W(), H());
      for (const p of pts) {
        p.x += p.vx; p.y += p.vy;
        if (p.x < -20) p.x = W() + 20; if (p.x > W() + 20) p.x = -20;
        if (p.y < -20) p.y = H() + 20; if (p.y > H() + 20) p.y = -20;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = "rgba(255,255,255,0.15)";
        ctx.fill();
      }
      for (let i = 0; i < pts.length; i++) {
        for (let j = i + 1; j < pts.length; j++) {
          const a = pts[i], b = pts[j];
          const d = Math.sqrt((a.x - b.x)**2 + (a.y - b.y)**2);
          if (d < 100) {
            ctx.strokeStyle = `rgba(253,117,21,${(1 - d / 100) * 0.1})`;
            ctx.lineWidth = 0.8;
            ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke();
          }
        }
      }
      raf = requestAnimationFrame(step);
    };
    raf = requestAnimationFrame(step);
    return () => { cancelAnimationFrame(raf); window.removeEventListener("resize", resize); };
  }, []);

  return <canvas ref={ref} className="absolute inset-0 z-[3] pointer-events-none" aria-hidden="true" />;
}

export default function PublicHome() {
  const slides: Slide[] = useMemo(() => [
    {
      image: "/hero/slide-1.png",
      badge: "ACADEMIA • BOX",
      title: "Una escuela de box para",
      highlight: "formar campeones",
      text: "Disciplina, técnica y acompañamiento real. Aquí construyes confianza, carácter y una mentalidad ganadora desde el primer día.",
    },
    {
      image: "/hero/slide-2.png",
      badge: "CLASES • TODOS LOS NIVELES",
      title: "Aprende, progresa y",
      highlight: "supera tus límites",
      text: "Entrenamientos claros y medibles. Ideal para principiantes y avanzados: sube de nivel con un plan real de progreso.",
    },
    {
      image: "/hero/slide-3.png",
      badge: "EQUIPO • AMBIENTE",
      title: "Entrena en un",
      highlight: "lugar que inspira",
      text: "Un espacio que te exige y te cuida. Ven a probar una clase y siente la diferencia en técnica, físico y confianza.",
    },
  ], []);

  const [active, setActive] = useState(0);
  const [kenKey, setKenKey] = useState(0);

  const nextSlide = useCallback(() => {
    setActive((p) => (p + 1) % slides.length);
    setKenKey((k) => k + 1);
  }, [slides.length]);

  useEffect(() => {
    const id = window.setInterval(nextSlide, 2000);
    return () => window.clearInterval(id);
  }, [nextSlide]);

  return (
    <section className="relative w-full min-h-screen bg-black overflow-hidden flex flex-col items-center justify-center">
      
      {/* CAPA 0: EL VIDEO (FONDO ABSOLUTO) */}
      <div className="absolute inset-0 z-0 w-full h-full">
        <video 
          autoPlay muted loop playsInline
          className="w-full h-full object-cover opacity-60"
        >
          <source src="/hero/entrenamiento.mp4" type="video/mp4" />
        </video>
      </div>

      {/* CAPA 1: IMÁGENES DE APOYO (Muy baja opacidad para no tapar el video) */}
      {slides.map((s, i) => (
        <div
          key={`${i}-${kenKey}`}
          className={`absolute inset-0 bg-cover bg-center transition-opacity duration-1000 z-[1] w-full h-full ${
            i === active ? "opacity-20 animate-[kenburns_10s_ease-out_forwards]" : "opacity-0"
          }`}
          style={{ backgroundImage: `url(${s.image})` }}
        />
      ))}

      {/* CAPA 2: DEGRADADO DE LECTURA (Encima del video y las fotos) */}
      <div className="absolute inset-0 z-[2] w-full h-full bg-gradient-to-t from-black via-black/20 to-black/60" />

      {/* CAPA 3: PARTÍCULAS */}
      <ParticlesCanvas />

      {/* CAPA 10: CONTENIDO (TEXTO Y BOTONES) */}
      <div className="relative z-[10] w-full min-h-screen flex items-center px-6 md:px-12 lg:px-24">
        <div className="max-w-4xl pt-20">
          <div className="inline-flex items-center gap-3 bg-white/5 backdrop-blur-sm border border-white/10 px-4 py-2 rounded-full mb-8">
            <span className="w-2 h-2 rounded-full bg-[#FD7515] animate-pulse" />
            <span className="text-[10px] font-black tracking-[0.4em] text-white uppercase italic">
              {slides[active].badge}
            </span>
          </div>

          <h1 className="text-5xl md:text-7xl lg:text-9xl font-black text-white leading-[0.85] tracking-tighter uppercase transition-all duration-500">
            {slides[active].title} <br />
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6A00] to-[#FD7515] italic">
              {slides[active].highlight}
            </span>
          </h1>

          <p className="mt-8 max-w-xl text-lg md:text-xl text-gray-300 font-light leading-relaxed tracking-wide">
            {slides[active].text}
          </p>

          <div className="mt-12 flex flex-wrap gap-4">
            <Link 
              to="/login"
              className="px-10 py-5 bg-[#FD7515] text-white text-[11px] font-black uppercase tracking-[0.3em] hover:bg-white hover:text-black transition-all duration-300 shadow-[0_0_40px_rgba(253,117,21,0.2)]"
            >
              Únete ahora
            </Link>
            <Link 
              to="/contacto"
              className="px-10 py-5 border border-white/20 text-white text-[11px] font-black uppercase tracking-[0.3em] hover:bg-white/10 backdrop-blur-sm transition-all duration-300"
            >
              Ver horarios
            </Link>
          </div>
        </div>
      </div>

      {/* INDICADORES (DOTS) */}
      <div className="absolute bottom-12 right-8 lg:right-16 z-[20] flex flex-col gap-4">
        {slides.map((_, i) => (
          <button
            key={i}
            onClick={() => { setActive(i); setKenKey((k) => k + 1); }}
            className="group flex items-center justify-end gap-4"
            type="button"
          >
            <span className={`text-[10px] font-black transition-all duration-500 tracking-widest ${
              i === active ? "text-[#FD7515]" : "text-white/40"
            }`}>
              0{i + 1}
            </span>
            <div className={`h-[2px] transition-all duration-500 rounded-full ${
              i === active ? "w-16 bg-[#FD7515]" : "w-8 bg-white/20 group-hover:bg-white/50"
            }`} />
          </button>
        ))}
      </div>

      <style>{`
        @keyframes kenburns {
          0% { transform: scale(1); }
          100% { transform: scale(1.1); }
        }
      `}</style>
    </section>
  );
}