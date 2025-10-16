import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { MessageSquare, Clock, CheckCircle2, AlertCircle } from 'lucide-react';

export default function PosVenda() {
  const tickets = {
    abertos: [
      { id: 1, cliente: 'Empresa ABC', assunto: 'Dúvida sobre funcionalidade', prioridade: 'alta', tempo: '2h' },
      { id: 2, cliente: 'Startup XYZ', assunto: 'Solicitação de suporte técnico', prioridade: 'media', tempo: '5h' },
      { id: 3, cliente: 'Tech Corp', assunto: 'Erro ao processar pagamento', prioridade: 'alta', tempo: '1h' },
    ],
    em_andamento: [
      { id: 4, cliente: 'Digital Solutions', assunto: 'Atualização de cadastro', prioridade: 'baixa', tempo: '1d' },
      { id: 5, cliente: 'Marketing Pro', assunto: 'Integração com API', prioridade: 'media', tempo: '3h' },
    ],
    resolvidos: [
      { id: 6, cliente: 'Empresa ABC', assunto: 'Configuração inicial', prioridade: 'media', tempo: '2d' },
      { id: 7, cliente: 'Tech Corp', assunto: 'Dúvida sobre relatórios', prioridade: 'baixa', tempo: '1d' },
    ],
  };

  const getPriorityBadge = (prioridade: string) => {
    const variants: Record<string, { variant: "default" | "secondary" | "destructive", label: string }> = {
      alta: { variant: "destructive", label: "Alta" },
      media: { variant: "default", label: "Média" },
      baixa: { variant: "secondary", label: "Baixa" },
    };
    const config = variants[prioridade];
    return <Badge variant={config.variant}>{config.label}</Badge>;
  };

  const renderTicketList = (ticketList: any[], icon: any) => {
    const Icon = icon;
    return (
      <div className="space-y-3">
        {ticketList.map((ticket) => (
          <Card key={ticket.id} className="hover:shadow-md transition-shadow cursor-pointer">
            <CardContent className="p-4">
              <div className="flex items-start justify-between">
                <div className="flex gap-3 flex-1">
                  <div className="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <Icon className="h-5 w-5 text-primary" />
                  </div>
                  <div className="flex-1">
                    <div className="flex items-center gap-2 mb-1">
                      <p className="font-semibold">{ticket.cliente}</p>
                      {getPriorityBadge(ticket.prioridade)}
                    </div>
                    <p className="text-sm text-muted-foreground">{ticket.assunto}</p>
                    <p className="text-xs text-muted-foreground mt-1">há {ticket.tempo}</p>
                  </div>
                </div>
                <Button variant="ghost" size="sm">
                  Ver ticket
                </Button>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>
    );
  };

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-4xl font-bold mb-2 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
          Pós-venda
        </h1>
        <p className="text-muted-foreground">
          Gerencie tickets de suporte e atendimento ao cliente
        </p>
      </div>

      <div className="grid gap-6 md:grid-cols-3">
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">{tickets.abertos.length}</CardTitle>
            <CardDescription className="flex items-center gap-2">
              <AlertCircle className="h-4 w-4" />
              Tickets Abertos
            </CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">{tickets.em_andamento.length}</CardTitle>
            <CardDescription className="flex items-center gap-2">
              <Clock className="h-4 w-4" />
              Em Andamento
            </CardDescription>
          </CardHeader>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle className="text-2xl">{tickets.resolvidos.length}</CardTitle>
            <CardDescription className="flex items-center gap-2">
              <CheckCircle2 className="h-4 w-4" />
              Resolvidos Hoje
            </CardDescription>
          </CardHeader>
        </Card>
      </div>

      <Tabs defaultValue="abertos" className="space-y-4">
        <TabsList className="grid w-full grid-cols-3">
          <TabsTrigger value="abertos">Abertos</TabsTrigger>
          <TabsTrigger value="andamento">Em Andamento</TabsTrigger>
          <TabsTrigger value="resolvidos">Resolvidos</TabsTrigger>
        </TabsList>

        <TabsContent value="abertos">
          {renderTicketList(tickets.abertos, AlertCircle)}
        </TabsContent>

        <TabsContent value="andamento">
          {renderTicketList(tickets.em_andamento, Clock)}
        </TabsContent>

        <TabsContent value="resolvidos">
          {renderTicketList(tickets.resolvidos, CheckCircle2)}
        </TabsContent>
      </Tabs>
    </div>
  );
}
