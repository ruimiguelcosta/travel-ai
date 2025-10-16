import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Plus, FileText, Clock, CheckCircle, XCircle } from 'lucide-react';

export default function Orcamento() {
  const orcamentos = [
    { id: 1, cliente: 'Empresa ABC', valor: 'R$ 15.000', status: 'aprovado', data: '15/01/2025' },
    { id: 2, cliente: 'Startup XYZ', valor: 'R$ 8.500', status: 'pendente', data: '18/01/2025' },
    { id: 3, cliente: 'Tech Corp', valor: 'R$ 32.000', status: 'em_analise', data: '20/01/2025' },
    { id: 4, cliente: 'Digital Solutions', valor: 'R$ 12.300', status: 'rejeitado', data: '22/01/2025' },
  ];

  const getStatusBadge = (status: string) => {
    const variants: Record<string, { variant: "default" | "secondary" | "destructive" | "outline", icon: any, label: string }> = {
      aprovado: { variant: "default", icon: CheckCircle, label: "Aprovado" },
      pendente: { variant: "secondary", icon: Clock, label: "Pendente" },
      em_analise: { variant: "outline", icon: FileText, label: "Em Análise" },
      rejeitado: { variant: "destructive", icon: XCircle, label: "Rejeitado" },
    };
    const config = variants[status];
    const Icon = config.icon;
    
    return (
      <Badge variant={config.variant} className="flex items-center gap-1 w-fit">
        <Icon className="h-3 w-3" />
        {config.label}
      </Badge>
    );
  };

  return (
    <div className="space-y-8">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-4xl font-bold mb-2 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
            Orçamentos
          </h1>
          <p className="text-muted-foreground">
            Gerencie e acompanhe suas propostas comerciais
          </p>
        </div>
        <Button className="bg-gradient-to-r from-primary to-secondary">
          <Plus className="h-4 w-4 mr-2" />
          Novo Orçamento
        </Button>
      </div>

      <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">R$ 67.8K</CardTitle>
            <CardDescription>Total em orçamentos</CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">68%</CardTitle>
            <CardDescription>Taxa de aprovação</CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">R$ 15.2K</CardTitle>
            <CardDescription>Ticket médio</CardDescription>
          </CardHeader>
        </Card>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Orçamentos Recentes</CardTitle>
          <CardDescription>Últimas propostas enviadas</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {orcamentos.map((orc) => (
              <div 
                key={orc.id}
                className="flex items-center justify-between p-4 rounded-lg border bg-card hover:bg-accent/50 transition-colors cursor-pointer"
              >
                <div className="flex items-center gap-4">
                  <div className="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center">
                    <FileText className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <p className="font-semibold">{orc.cliente}</p>
                    <p className="text-sm text-muted-foreground">Criado em {orc.data}</p>
                  </div>
                </div>
                <div className="flex items-center gap-4">
                  <div className="text-right">
                    <p className="font-bold text-lg">{orc.valor}</p>
                    {getStatusBadge(orc.status)}
                  </div>
                  <Button variant="ghost" size="sm">
                    Ver detalhes
                  </Button>
                </div>
              </div>
            ))}
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
