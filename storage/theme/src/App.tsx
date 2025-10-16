import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./contexts/AuthContext";
import { ProtectedRoute } from "./components/ProtectedRoute";
import { AdminLayout } from "./components/AdminLayout";
import Login from "./pages/Login";
import Dashboard from "./pages/admin/Dashboard";
import Copilot from "./pages/admin/Copilot";
import Integracoes from "./pages/admin/Integracoes";
import Orcamento from "./pages/admin/Orcamento";
import PosVenda from "./pages/admin/PosVenda";
import Clientes from "./pages/admin/Clientes";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <AuthProvider>
      <TooltipProvider>
        <Toaster />
        <Sonner />
        <BrowserRouter>
          <Routes>
            <Route path="/" element={<Login />} />
            <Route path="/admin" element={<ProtectedRoute><AdminLayout /></ProtectedRoute>}>
              <Route index element={<Dashboard />} />
              <Route path="copilot" element={<Copilot />} />
              <Route path="integracoes" element={<Integracoes />} />
              <Route path="orcamento" element={<Orcamento />} />
              <Route path="pos-venda" element={<PosVenda />} />
              <Route path="clientes" element={<Clientes />} />
            </Route>
            <Route path="*" element={<NotFound />} />
          </Routes>
        </BrowserRouter>
      </TooltipProvider>
    </AuthProvider>
  </QueryClientProvider>
);

export default App;
