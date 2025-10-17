# Configuração Vite.js e Tailwind CSS

Este documento descreve a configuração do Vite.js e Tailwind CSS no projeto Laravel.

## Configuração Atual

### Vite.js
- **Arquivo de configuração**: `vite.config.js`
- **Assets principais**: `resources/css/app.css` e `resources/js/app.js`
- **Output**: `public/build/`

### Tailwind CSS
- **Versão**: 3.4.0
- **Arquivo de configuração**: `tailwind.config.js`
- **PostCSS**: `postcss.config.js`
- **Plugins**: `@tailwindcss/forms`, `@tailwindcss/typography`

## Comandos Disponíveis

### Desenvolvimento
```bash
npm run dev
```
Inicia o servidor de desenvolvimento do Vite com hot reload.

### Produção
```bash
npm run build
```
Compila os assets para produção na pasta `public/build/`.

## Estrutura de Arquivos

```
resources/
├── css/
│   └── app.css          # Arquivo principal do CSS com Tailwind
├── js/
│   ├── app.js           # Arquivo principal do JavaScript
│   └── bootstrap.js     # Configuração do Axios
└── views/
    └── layouts/
        └── app.blade.php # Layout principal com @vite directive
```

## Cores Personalizadas

O projeto inclui um sistema de cores personalizado baseado no design system:

- **Primary**: `hsl(262 83% 58%)` - Roxo principal
- **Secondary**: `hsl(220 70% 50%)` - Azul secundário
- **Background**: `hsl(240 10% 98%)` - Fundo claro
- **Foreground**: `hsl(240 10% 10%)` - Texto principal
- **Card**: `hsl(0 0% 100%)` - Fundo dos cards
- **Muted**: `hsl(240 5% 96%)` - Cores suaves

## Componentes CSS Personalizados

### Botões
```css
.btn              # Classe base para botões
.btn-primary      # Botão primário
.btn-secondary    # Botão secundário
```

### Gradientes
```css
.gradient-text    # Texto com gradiente
.gradient-bg      # Fundo com gradiente
.gradient-bg-light # Fundo com gradiente claro
```

### Sidebar
```css
.sidebar-collapsed   # Sidebar recolhida
.sidebar-expanded    # Sidebar expandida
.sidebar-transition  # Transição da sidebar
```

## Como Usar

### 1. Incluir Assets no Blade
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### 2. Usar Classes Tailwind
```blade
<div class="bg-card p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-card-foreground">Título</h2>
    <p class="text-muted-foreground">Conteúdo</p>
    <button class="btn btn-primary">Botão</button>
</div>
```

### 3. Usar Componentes Personalizados
```blade
<h1 class="gradient-text">Título com Gradiente</h1>
<div class="gradient-bg p-4 rounded">Fundo Gradiente</div>
```

## Teste da Configuração

Para testar se tudo está funcionando, acesse:
```
http://aitravel.test/test-tailwind
```

Esta página demonstra todos os componentes e estilos configurados.

## Troubleshooting

### Assets não carregam
1. Verifique se o Vite está rodando: `npm run dev`
2. Verifique se os assets foram compilados: `npm run build`
3. Verifique se o `@vite` directive está no layout

### Estilos não aplicam
1. Verifique se o Tailwind está configurado corretamente
2. Verifique se as classes estão no arquivo `tailwind.config.js`
3. Execute `npm run build` para recompilar

### Hot Reload não funciona
1. Verifique se o Vite está rodando em modo desenvolvimento
2. Verifique se não há erros no console do navegador
3. Reinicie o servidor de desenvolvimento
