import React from "react";

export default function DashboardAdm() {
  return (
    <div className="min-h-screen bg-gray-200 flex">
      {/* Sidebar */}
      <aside className="hidden md:flex flex-col w-64 bg-white shadow-xl p-4">
        <h2 className="text-xl font-semibold mb-6">Panel</h2>
        <nav className="flex flex-col gap-4">
          <a href="#" className="text-gray-700 hover:text-black">Inicio</a>
          <a href="#" className="text-gray-700 hover:text-black">Analytics</a>
          <a href="#" className="text-gray-700 hover:text-black">Configuración</a>
        </nav>
      </aside>

      {/* Main Content */}
      <main className="flex-1 p-4 md:p-8">
        {/* Header inside dashboard */}
        <header className="w-full bg-white rounded-xl p-4 shadow mb-6 flex justify-between items-center">
          <h1 className="text-xl font-semibold">Dashboard</h1>
          <div className="flex items-center gap-4">
            <input
              type="text"
              placeholder="Buscar..."
              className="border rounded-xl px-3 py-2 w-40 md:w-60"
            />
            <div className="w-10 h-10 rounded-full bg-gray-300" />
          </div>
        </header>

        {/* Grid Example */}
        <section className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <div className="bg-white h-40 rounded-xl shadow p-4"></div>
          <div className="bg-white h-40 rounded-xl shadow p-4"></div>
          <div className="bg-white h-40 rounded-xl shadow p-4"></div>
          <div className="bg-white h-40 rounded-xl shadow p-4"></div>
        </section>
      </main>
    </div>
  );
}