import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { CheckCircle2, ArrowRight, Users, TrendingUp, DollarSign, Activity } from 'lucide-react';
import { Progress } from '@/components/ui/progress';

export default function Dashboard() {
  const [completedSteps, setCompletedSteps] = useState<number[]>([]);

  const onboardingSteps = [
    { id: 1, title: "Configure seu perfil", description: "Adicione suas informações básicas" },
    { id: 2, title: "Conecte integrações", description: "Vincule suas ferramentas favoritas" },
    { id: 3, title: "Importe clientes", description: "Adicione sua base de clientes" },
    { id: 4, title: "Configure orçamentos", description: "Defina modelos de orçamento" },
  ];

  const toggleStep = (id: number) => {
    setCompletedSteps(prev => 
      prev.includes(id) ? prev.filter(s => s !== id) : [...prev, id]
    );
  };

  const progress = (completedSteps.length / onboardingSteps.length) * 100;

  const stats = [
    { title: "Total de Clientes", value: "1,248", icon: Users, change: "+12.5%" },
    { title: "Orçamentos Ativos", value: "342", icon: TrendingUp, change: "+8.2%" },
    { title: "Receita Mensal", value: "R$ 45.2K", icon: DollarSign, change: "+23.1%" },
    { title: "Taxa de Conversão", value: "68%", icon: Activity, change: "+5.4%" },
  ];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-4xl font-bold mb-2 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
          Dashboard
        </h1>
        <p className="text-muted-foreground">Bem-vindo de volta! Aqui está um resumo do seu negócio.</p>
      </div>

      {completedSteps.length < onboardingSteps.length && (
        <Card className="border-primary/20 bg-gradient-to-r from-primary/5 to-secondary/5">
          <CardHeader>
            <CardTitle className="flex items-center justify-between">
              <span>Complete sua configuração</span>
              <span className="text-sm font-normal text-muted-foreground">
                {completedSteps.length}/{onboardingSteps.length} concluídos
              </span>
            </CardTitle>
            <CardDescription>
              Siga estes passos para aproveitar ao máximo a plataforma
            </CardDescription>
            <Progress value={progress} className="mt-4" />
          </CardHeader>
          <CardContent className="space-y-3">
            {onboardingSteps.map((step) => (
              <div 
                key={step.id}
                className={`flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer hover:border-primary/50 ${
                  completedSteps.includes(step.id) ? 'bg-accent/50 border-primary/30' : 'bg-card'
                }`}
                onClick={() => toggleStep(step.id)}
              >
                <div className={`mt-0.5 rounded-full p-1 ${
                  completedSteps.includes(step.id) ? 'bg-primary text-primary-foreground' : 'bg-muted'
                }`}>
                  <CheckCircle2 className="h-4 w-4" />
                </div>
                <div className="flex-1">
                  <h4 className="font-semibold">{step.title}</h4>
                  <p className="text-sm text-muted-foreground">{step.description}</p>
                </div>
                <Button variant="ghost" size="sm">
                  <ArrowRight className="h-4 w-4" />
                </Button>
              </div>
            ))}
          </CardContent>
        </Card>
      )}

      <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        {stats.map((stat, index) => (
          <Card key={index} className="transition-all hover:shadow-lg hover:border-primary/30">
            <CardHeader className="flex flex-row items-center justify-between pb-2">
              <CardTitle className="text-sm font-medium text-muted-foreground">
                {stat.title}
              </CardTitle>
              <stat.icon className="h-4 w-4 text-primary" />
            </CardHeader>
            <CardContent>
              <div className="text-3xl font-bold">{stat.value}</div>
              <p className="text-xs text-green-600 mt-1">
                {stat.change} vs último mês
              </p>
            </CardContent>
          </Card>
        ))}
      </div>

      <div className="grid gap-6 md:grid-cols-2">
        <Card>
          <CardHeader>
            <CardTitle>Atividade Recente</CardTitle>
            <CardDescription>Últimas ações no sistema</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                  <div className="h-2 w-2 rounded-full bg-primary" />
                  <div className="flex-1">
                    <p className="text-sm font-medium">Novo orçamento criado</p>
                    <p className="text-xs text-muted-foreground">há {i} hora(s)</p>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Próximas Tarefas</CardTitle>
            <CardDescription>Ações pendentes</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                  <div className="h-2 w-2 rounded-full bg-secondary" />
                  <div className="flex-1">
                    <p className="text-sm font-medium">Revisar proposta #{i}</p>
                    <p className="text-xs text-muted-foreground">Vence amanhã</p>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
