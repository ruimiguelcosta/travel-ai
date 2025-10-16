import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Search, Mail, Phone, MapPin } from 'lucide-react';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';

export default function Clientes() {
  const clientes = [
    { 
      id: 1, 
      nome: 'João Silva', 
      email: 'joao@empresaabc.com', 
      empresa: 'Empresa ABC',
      telefone: '(11) 98765-4321',
      status: 'ativo',
      valor: 'R$ 45.2K'
    },
    { 
      id: 2, 
      nome: 'Maria Santos', 
      email: 'maria@startupxyz.com', 
      empresa: 'Startup XYZ',
      telefone: '(21) 99876-5432',
      status: 'ativo',
      valor: 'R$ 32.8K'
    },
    { 
      id: 3, 
      nome: 'Pedro Costa', 
      email: 'pedro@techcorp.com', 
      empresa: 'Tech Corp',
      telefone: '(11) 97654-3210',
      status: 'inativo',
      valor: 'R$ 18.5K'
    },
    { 
      id: 4, 
      nome: 'Ana Oliveira', 
      email: 'ana@digitalsolutions.com', 
      empresa: 'Digital Solutions',
      telefone: '(31) 98765-1234',
      status: 'ativo',
      valor: 'R$ 67.3K'
    },
  ];

  const getInitials = (nome: string) => {
    return nome.split(' ').map(n => n[0]).join('').toUpperCase();
  };

  return (
    <div className="space-y-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-4xl font-bold mb-2 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
            Clientes
          </h1>
          <p className="text-muted-foreground">
            Gerencie sua base de clientes e contatos
          </p>
        </div>
        <Button className="bg-gradient-to-r from-primary to-secondary">
          <Plus className="h-4 w-4 mr-2" />
          Novo Cliente
        </Button>
      </div>

      <div className="grid gap-6 md:grid-cols-4">
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">{clientes.length}</CardTitle>
            <CardDescription>Total de Clientes</CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">{clientes.filter(c => c.status === 'ativo').length}</CardTitle>
            <CardDescription>Clientes Ativos</CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">R$ 163.8K</CardTitle>
            <CardDescription>Valor Total</CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">R$ 40.9K</CardTitle>
            <CardDescription>Ticket Médio</CardDescription>
          </CardHeader>
        </Card>
      </div>

      <Card>
        <CardHeader>
          <div className="flex items-center justify-between">
            <div>
              <CardTitle>Lista de Clientes</CardTitle>
              <CardDescription>Todos os seus clientes cadastrados</CardDescription>
            </div>
            <div className="relative w-64">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input placeholder="Buscar clientes..." className="pl-9" />
            </div>
          </div>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {clientes.map((cliente) => (
              <Card key={cliente.id} className="hover:shadow-md transition-all cursor-pointer">
                <CardContent className="p-6">
                  <div className="flex items-start justify-between">
                    <div className="flex gap-4 flex-1">
                      <Avatar className="h-12 w-12 border-2 border-primary/20">
                        <AvatarFallback className="bg-gradient-to-br from-primary to-secondary text-white">
                          {getInitials(cliente.nome)}
                        </AvatarFallback>
                      </Avatar>
                      <div className="flex-1">
                        <div className="flex items-center gap-2 mb-2">
                          <h3 className="font-semibold text-lg">{cliente.nome}</h3>
                          <Badge variant={cliente.status === 'ativo' ? 'default' : 'secondary'}>
                            {cliente.status}
                          </Badge>
                        </div>
                        <p className="text-sm text-muted-foreground font-medium mb-3">{cliente.empresa}</p>
                        <div className="flex flex-wrap gap-4 text-sm text-muted-foreground">
                          <div className="flex items-center gap-1">
                            <Mail className="h-4 w-4" />
                            {cliente.email}
                          </div>
                          <div className="flex items-center gap-1">
                            <Phone className="h-4 w-4" />
                            {cliente.telefone}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="text-right">
                      <p className="text-2xl font-bold text-primary mb-2">{cliente.valor}</p>
                      <Button variant="outline" size="sm">
                        Ver perfil
                      </Button>
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
