import React, { useEffect, useState } from "react";
import { BrowserRouter, Route, Routes, Navigate, Outlet } from "react-router-dom";
import { AuthProvider, useAuth } from "./auth/AuthContext";
import { ProtectedRoute } from "./routes/ProtectedRoute";
import { Layout } from "./components/Layout";
import LoadingScreen from "./components/LoadingScreen";

import LoginPage from "./pages/Login";
import DashboardPage from "./pages/Dashboard";
import StudentsPage from "./pages/Students/StudentsPage";
import CategoriesPage from "./pages/CategoriesPage";
import PaymentsPage from "./pages/Payments";
import StorePage from "./pages/Store";
import EventsPage from "./pages/Events";
import StudentHome from "./pages/Students/StudentHome";

import EnrollmentSheetPage from "./pages/Students/EnrollmentSheetPage";
import StoreCategoriesPage from "./pages/StoreCategoriesPage";
import StoreOrdersPage from "./pages/StoreOrdersPage";

import PublicLayout from "./layouts/PublicLayout";
import PublicHome from "./pages/public/Home";
import PublicAbout from "./pages/public/About";
import PublicContact from "./pages/public/Contact";
import PublicStoreFront from "./pages/public/StoreFront";
import PublicProductPage from "./pages/public/ProductPage"; // ✅ NUEVO

import AttendancePage from "./pages/AttendancePage";

/** ✅ Guard genérico por roles */
function RoleGuard({ allowed }: { allowed: string[] }) {
  const { roles, loading } = useAuth();
  if (loading) return null;

  const keys = (roles ?? []).map((r: any) => r?.key);
  const ok = allowed.some((k) => keys.includes(k));

  if (!ok) return <Navigate to="/home" replace />;
  return <Outlet />;
}

function HomeRedirect() {
  const { user, loading, roles } = useAuth();

  if (loading) return null;
  if (!user) return <Navigate to="/login" replace />;

  const keys = (roles ?? []).map((r: any) => r?.key);

  if (keys.includes("admin")) return <Navigate to="/admin" replace />;
  if (keys.includes("attendance_controller")) return <Navigate to="/attendance" replace />;
  if (keys.includes("student")) return <Navigate to="/student" replace />;

  // ⚠️ si no tienes panel coach, no lo mandes a /events (admin-only)
  if (keys.includes("coach")) return <Navigate to="/home" replace />;

  return <Navigate to="/login" replace />;
}

export default function App() {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Simula el tiempo de carga (puedes cambiar esto según tu necesidad)
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 2000);

    return () => clearTimeout(timer);
  }, []);

  return (
    <>
      <LoadingScreen isLoading={isLoading} />
      <BrowserRouter>
      <AuthProvider>
        <Routes>
          {/* ======= WEB PÚBLICA ======= */}
          <Route path="/" element={<PublicLayout />}>
            <Route index element={<PublicHome />} />
            <Route path="nosotros" element={<PublicAbout />} />
            <Route path="contacto" element={<PublicContact />} />

            {/* ✅ Tienda pública */}
            <Route path="tienda" element={<PublicStoreFront />} />
            <Route path="tienda/:slug" element={<PublicProductPage />} /> {/* ✅ NUEVO */}
          </Route>

          {/* ======= LOGIN ======= */}
          <Route path="/login" element={<LoginPage />} />

          {/* ======= PRIVADO ======= */}
          <Route element={<ProtectedRoute />}>
            <Route path="/home" element={<HomeRedirect />} />

            {/* Panel alumno */}
            <Route path="/student" element={<StudentHome />} />

            {/* Panel con Layout (sidebar) */}
            <Route element={<Layout />}>
              {/* ✅ SOLO ADMIN */}
              <Route element={<RoleGuard allowed={["admin"]} />}>
                <Route path="/admin" element={<DashboardPage />} />
                <Route path="/students" element={<StudentsPage />} />
                <Route path="/students/:id/enrollment-sheet" element={<EnrollmentSheetPage />} />
                <Route path="/categories" element={<CategoriesPage />} />
                <Route path="/payments" element={<PaymentsPage />} />
                <Route path="/store" element={<StorePage />} />
                <Route path="/store-categories" element={<StoreCategoriesPage />} />
                <Route path="/store-orders" element={<StoreOrdersPage />} />
                <Route path="/events" element={<EventsPage />} />
              </Route>

              {/* ✅ ADMIN o CONTROL ASISTENCIA */}
              <Route element={<RoleGuard allowed={["admin", "attendance_controller"]} />}>
                <Route path="/attendance" element={<AttendancePage />} />
              </Route>
            </Route>
          </Route>

          <Route path="*" element={<div style={{ padding: 16 }}>404</div>} />
        </Routes>
      </AuthProvider>
    </BrowserRouter>
    </>
  );
}
