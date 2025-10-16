import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Switch } from '@/components/ui/switch';
import { useState } from 'react';

interface Integration {
  id: string;
  name: string;
  description: string;
  icon: string;
  enabled: boolean;
  category: string;
}

export default function Integracoes() {
  const [integrations, setIntegrations] = useState<Integration[]>([
    { id: '1', name: 'WhatsApp Business', description: 'Conecte sua conta do WhatsApp', icon: '💬', enabled: false, category: 'Comunicação' },
    { id: '2', name: 'Gmail', description: 'Sincronize seus emails', icon: '📧', enabled: true, category: 'Comunicação' },
    { id: '3', name: 'Stripe', description: 'Processe pagamentos', icon: '💳', enabled: true, category: 'Pagamentos' },
    { id: '4', name: 'Slack', description: 'Notificações em tempo real', icon: '💼', enabled: false, category: 'Comunicação' },
    { id: '5', name: 'Google Calendar', description: 'Sincronize agendamentos', icon: '📅', enabled: false, category: 'Produtividade' },
    { id: '6', name: 'Zapier', description: 'Automatize fluxos de trabalho', icon: '⚡', enabled: false, category: 'Automação' },
  ]);

  const toggleIntegration = (id: string) => {
    setIntegrations(prev => 
      prev.map(int => 
        int.id === id ? { ...int, enabled: !int.enabled } : int
      )
    );
  };

  const categories = [...new Set(integrations.map(i => i.category))];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-4xl font-bold mb-2 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
          Integrações
        </h1>
        <p className="text-muted-foreground">
          Conecte suas ferramentas favoritas para automatizar processos
        </p>
      </div>

      {categories.map((category) => (
        <div key={category}>
          <h2 className="text-2xl font-semibold mb-4">{category}</h2>
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            {integrations
              .filter(int => int.category === category)
              .map((integration) => (
                <Card 
                  key={integration.id}
                  className={`transition-all hover:shadow-lg ${
                    integration.enabled ? 'border-primary/50 bg-primary/5' : ''
                  }`}
                >
                  <CardHeader>
                    <div className="flex items-start justify-between">
                      <div className="flex items-center gap-3">
                        <div className="text-3xl">{integration.icon}</div>
                        <div>
                          <CardTitle className="text-lg">{integration.name}</CardTitle>
                          <Badge 
                            variant={integration.enabled ? "default" : "secondary"}
                            className="mt-1"
                          >
                            {integration.enabled ? 'Conectado' : 'Desconectado'}
                          </Badge>
                        </div>
                      </div>
                      <Switch
                        checked={integration.enabled}
                        onCheckedChange={() => toggleIntegration(integration.id)}
                      />
                    </div>
                  </CardHeader>
                  <CardContent>
                    <CardDescription>{integration.description}</CardDescription>
                    <Button 
                      variant="outline" 
                      className="w-full mt-4"
                      onClick={() => toggleIntegration(integration.id)}
                    >
                      {integration.enabled ? 'Configurar' : 'Conectar'}
                    </Button>
                  </CardContent>
                </Card>
              ))}
          </div>
        </div>
      ))}
    </div>
  );
}
