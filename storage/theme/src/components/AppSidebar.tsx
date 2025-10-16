import { LayoutDashboard, MessageSquare, Plug, Calculator, HeadphonesIcon, Users, LogOut } from "lucide-react";
import { NavLink, useNavigate } from "react-router-dom";
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarFooter,
  useSidebar,
} from "@/components/ui/sidebar";
import { Button } from "@/components/ui/button";
import { useAuth } from "@/contexts/AuthContext";

const menuItems = [
  { title: "Dashboard", url: "/admin", icon: LayoutDashboard },
  { title: "AI Copilot", url: "/admin/copilot", icon: MessageSquare },
  { title: "Integrações", url: "/admin/integracoes", icon: Plug },
  { title: "Orçamento", url: "/admin/orcamento", icon: Calculator },
  { title: "Pós-venda", url: "/admin/pos-venda", icon: HeadphonesIcon },
  { title: "Clientes", url: "/admin/clientes", icon: Users },
];

export function AppSidebar() {
  const { state } = useSidebar();
  const { logout, user } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  const isCollapsed = state === "collapsed";

  return (
    <Sidebar className={isCollapsed ? "w-14" : "w-64"}>
      <SidebarContent>
        <div className="px-4 py-6">
          {!isCollapsed && (
            <h2 className="text-xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
              Admin Panel
            </h2>
          )}
        </div>
        
        <SidebarGroup>
          <SidebarGroupLabel>Menu Principal</SidebarGroupLabel>
          <SidebarGroupContent>
            <SidebarMenu>
              {menuItems.map((item) => (
                <SidebarMenuItem key={item.title}>
                  <SidebarMenuButton asChild>
                    <NavLink 
                      to={item.url} 
                      end={item.url === "/admin"}
                      className={({ isActive }) => 
                        isActive 
                          ? "bg-sidebar-accent text-sidebar-accent-foreground" 
                          : ""
                      }
                    >
                      <item.icon className="h-4 w-4" />
                      {!isCollapsed && <span>{item.title}</span>}
                    </NavLink>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              ))}
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>
      </SidebarContent>

      <SidebarFooter className="p-4">
        {!isCollapsed && user && (
          <div className="mb-2 text-sm text-sidebar-foreground/60">
            {user.email}
          </div>
        )}
        <Button 
          variant="ghost" 
          size={isCollapsed ? "icon" : "default"}
          onClick={handleLogout}
          className="w-full justify-start"
        >
          <LogOut className="h-4 w-4" />
          {!isCollapsed && <span className="ml-2">Sair</span>}
        </Button>
      </SidebarFooter>
    </Sidebar>
  );
}
