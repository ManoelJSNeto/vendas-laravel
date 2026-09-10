# Briefing de Front-end — Vendas Laravel

## Contexto do projeto

Aplicação Laravel 13 (Blade + Tailwind CSS + Alpine.js, via Laravel Breeze) de um e-commerce acadêmico. Todo o back-end (rotas, controllers, models, migrations, validação) já está pronto e funcionando. O que falta é **exclusivamente** a camada visual: aplicar uma identidade própria, tema claro/escuro, responsividade e substituir os componentes visuais crus do Breeze por algo com cara de produto real.

Stack de front-end já disponível no projeto (não precisa instalar nada novo além de uma lib de ícones, se optar por isso):
- Tailwind CSS (compilado via Vite — `npm run build` ou `npm run dev`)
- Alpine.js (já carregado globalmente, usado em vários componentes interativos)
- Blade Components em `resources/views/components/` (`x-input-label`, `x-text-input`, `x-primary-button`, `x-secondary-button`, `x-danger-button`, `x-dropdown`, `x-nav-link`, `x-responsive-nav-link`, `x-application-logo`, `x-input-error`)

## O que construir

### 1. Paleta e identidade visual
- Tons neutros: cinza (base) + azul-marinho (cor de destaque/marca). Nada de roxo/índigo padrão do Tailwind (`indigo-600` está espalhado pelo projeto hoje — pode ser substituído).
- Definir uma paleta de 4–6 cores nomeadas (ex: `--color-navy-900`, `--color-navy-600`, `--color-gray-50`...`--color-gray-900`) como ponto de partida, e aplicar de forma consistente.
- Tipografia: pode manter a fonte atual (Figtree, já carregada via Bunny Fonts) ou trocar por outra igualmente neutra/profissional — não usar fontes decorativas.
- **Sem emojis em nenhum lugar da interface** (títulos, botões, mensagens de status, menus).
- Ícones: usar uma biblioteca de ícones própria (ex: Bootstrap Icons via CDN, ou Heroicons/Lucide como SVG inline) em vez de emoji ou texto solto para ações (editar, excluir, carrinho, etc). Manter os ícones num único estilo (outline OU filled, não misturar).

### 2. Tema claro/escuro
- Botão de alternância visível no menu de navegação (`resources/views/layouts/navigation.blade.php`), acessível em toda página autenticada.
- Implementar via classe `dark` no `<html>` (padrão do Tailwind: `darkMode: 'class'` no `tailwind.config.js`) + Alpine.js para o toggle + persistência da preferência do usuário em `localStorage` (client-side puro, não precisa de coluna no banco nem rota nova).
- Aplicar variantes `dark:` em todas as telas — não deixar nenhuma tela "esquecida" só no modo claro.
- Respeitar preferência do sistema operacional como padrão inicial (`prefers-color-scheme`), com o toggle manual sobrescrevendo depois.

### 3. Responsividade
- Todas as telas devem funcionar bem em mobile (o projeto já usa o menu hambúrguer do Breeze como base — mantenha o padrão, só restyling).
- Tabelas (catálogo admin, pedidos admin, usuários admin) precisam de tratamento específico em telas pequenas (scroll horizontal ou cards empilhados — escolher uma abordagem e aplicar a todas).

### 4. Telas a redesenhar (lista completa)
Views públicas/cliente:
- `resources/views/products/index.blade.php` — catálogo com busca/filtro e cards de produto
- `resources/views/cart/index.blade.php` — carrinho
- `resources/views/orders/checkout.blade.php` — checkout (endereço + pagamento)
- `resources/views/orders/index.blade.php` — lista de pedidos
- `resources/views/orders/show.blade.php` — detalhe do pedido
- `resources/views/payments/show.blade.php` — telas de pagamento (Pix, cartão, boleto)
- `resources/views/profile/edit.blade.php` + `resources/views/profile/partials/*.blade.php`
- `resources/views/profile/addresses.blade.php` — múltiplos endereços
- `resources/views/auth/*.blade.php` — login, registro, recuperação de senha

Views admin:
- `resources/views/admin/products/index.blade.php`, `create.blade.php`, `edit.blade.php`
- `resources/views/admin/orders/index.blade.php` — inclui 2 gráficos Chart.js (ver observação abaixo)
- `resources/views/admin/users/index.blade.php`

Estrutural:
- `resources/views/layouts/app.blade.php` — layout base
- `resources/views/layouts/navigation.blade.php` — menu (desktop + mobile), incluindo o toggle de tema
- `resources/views/components/*.blade.php` — componentes reutilizáveis (restyle aqui propaga para todo o projeto)

### 4.1. Evitar "cara de IA genérica"
Muito conteúdo gerado por IA converge para um visual reconhecível e genérico. Para fugir disso:
- **Não usar** gradientes roxo/azul (`from-indigo-500 to-purple-600` e variações) como base de identidade — é o clichê mais comum de UI gerada por IA.
- **Não usar** cards genéricos com sombra suave + cantos muito arredondados (`rounded-2xl shadow-lg`) em tudo, sem variação — misture: alguns blocos com borda fina e sem sombra, outros com mais peso visual, para criar hierarquia real.
- **Evitar** layout perfeitamente centralizado e simétrico em toda a página — dar personalidade com alinhamentos assimétricos onde fizer sentido (ex: cabeçalhos alinhados à esquerda, não centralizados).
- **Tipografia com hierarquia real**: pelo menos 3 pesos/tamanhos claramente distintos (título de página, subtítulo, corpo), não tudo no mesmo peso "médio" — títulos podem ser mais condensados/impactantes, não apenas "maiores e em negrito".
- **Espaçamento intencional, não uniforme**: seções mais importantes (resumo do total no carrinho, valor do pedido) merecem mais respiro/destaque que uma linha de tabela comum.
- Usar a paleta neutra (cinza + azul-marinho) como está pedido acima ajuda bastante a fugir do clichê — evite reintroduzir cores vibrantes "por segurança".
- Ícones devem ser consistentes em peso de traço (todos outline com a mesma espessura, ou todos preenchidos) — misturar estilos de ícone é outro sinal comum de pressa/geração automática.

### 5. Observação sobre os gráficos (admin/orders/index.blade.php)
Os gráficos usam Chart.js carregado via CDN dentro de um bloco `@push('scripts')`. As cores das séries estão hardcoded em JavaScript inline (`borderColor: '#4f46e5'`, `backgroundColor: ['#16a34a', '#eab308']`). Ao aplicar a nova paleta, atualize essas cores para combinar com o tema, e ajuste também para o modo escuro (grid/legendas do Chart.js têm opções de cor de texto que hoje usam o padrão).

---

## O que NÃO fazer (limites rígidos)

Este projeto tem um back-end funcional e testado. **Qualquer alteração fora do escopo visual pode quebrar funcionalidades já entregues e avaliadas.** Siga estas regras sem exceção:

1. **Não altere nenhum arquivo PHP fora de `resources/views/`.** Isso inclui: controllers (`app/Http/Controllers/`), models (`app/Models/`), middlewares, migrations, rotas (`routes/web.php`), services (`app/Services/`), Mailables (`app/Mail/`).
2. **Não altere `routes/web.php`.** Nomes de rota, URLs e parâmetros já são usados em toda a aplicação.
3. **Dentro dos arquivos Blade, não altere:**
   - Atributos `name="..."` de inputs, selects e textareas (o back-end espera esses nomes exatos para validação e salvamento).
   - Atributos `action="{{ route(...) }}"` e `method="POST/GET/PATCH/DELETE"` dos formulários.
   - Diretivas `@csrf` e `@method(...)` — nunca remover.
   - A lógica dentro de blocos `x-data="{...}"` do Alpine.js que faz chamadas à API ViaCEP (`fetch('https://viacep.com.br/...')`) ou cálculos (`buscarCep()`, detecção de bandeira de cartão, etc.) — pode reestilizar o HTML ao redor livremente, mas não mude a lógica JavaScript funcional.
   - Variáveis Blade vindas do controller (`{{ $product->name }}`, `@foreach ($items as $item)`, `@if ($order->status === 'paid')`, etc.) — pode mudar onde e como são exibidas, nunca a lógica condicional em si.
4. **Não crie novas rotas, controllers ou migrations.** Se o tema claro/escuro parecer exigir alguma dessas coisas, pare e reconsidere — a solução correta é 100% client-side (Alpine + localStorage + Tailwind `dark:` classes), sem precisar de back-end.
5. **Não instale pacotes Composer.** Se precisar de uma lib de ícones ou de JS, prefira CDN (como já é feito com Chart.js) ou pacotes NPM/Vite (`npm install`), nunca `composer require`.
6. **Não remova campos do formulário**, mesmo que pareçam redundantes visualmente (ex: campo `numero` e `complemento` no endereço) — todos são usados pela validação do back-end.
7. **Preserve os `id`s de elementos referenciados por Alpine ou JavaScript** (ex: `id="vendasPorDiaChart"`, `id="cep"`, `id="logradouro"`) — o Chart.js e outros scripts inline dependem desses IDs para encontrar os elementos.
8. Ao editar `tailwind.config.js` (para `darkMode: 'class'` ou tokens de cor customizados), não altere o array `content` (ele já aponta para os caminhos corretos de Blade/JS do projeto) — apenas adicione ao `theme.extend`.

## Como validar antes de finalizar

- Rodar `npm run build` após qualquer mudança de classes Tailwind novas (o CSS é compilado, classes usadas só em runtime não aparecem sem rebuild).
- Testar em pelo menos 3 larguras de tela: mobile (375px), tablet (768px), desktop (1280px).
- Testar o fluxo completo em ambos os temas (claro e escuro): catálogo → carrinho → checkout → pagamento, e o painel admin (produtos, pedidos com gráficos, usuários).
- Conferir que nenhum formulário parou de funcionar (login, registro, adicionar ao carrinho, checkout, CRUD de produto admin) — teste funcional, não só visual.
