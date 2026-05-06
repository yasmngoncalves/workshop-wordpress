# WS Theme — Tema WordPress para Workshop

Tema WordPress moderno, minimalista e comentado.
Desenvolvido para o **Workshop de Front-end** da Yasmin Gonçalves.

---

## 📁 Estrutura de Arquivos

```
ws-theme/
│
├── style.css                  ← OBRIGATÓRIO: cabeçalho do tema + estilos globais
├── functions.php              ← Coração do tema: setup, hooks, enqueue, helpers
├── index.php                  ← Template principal (homepage + fallback)
├── single.php                 ← Template para posts individuais
├── page.php                   ← Template para páginas estáticas
├── 404.php                    ← Página de erro "não encontrado"
├── header.php                 ← Topo incluído em todos os templates
├── footer.php                 ← Rodapé incluído em todos os templates
├── comments.php               ← Seção de comentários
│
├── template-parts/            ← Componentes reutilizáveis (chamados por get_template_part)
│   ├── card-feature.php       ← Card de feature/recurso
│   └── card-post.php          ← Card de post do blog
│
├── inc/                       ← Arquivos PHP incluídos no functions.php
│   └── customizer.php         ← Configurações do painel de personalização
│
├── assets/
│   ├── css/                   ← CSS extra (se precisar separar do style.css)
│   ├── js/
│   │   └── main.js            ← JavaScript principal (vanilla JS)
│   └── images/                ← Imagens do tema (ícones, background, etc.)
│
└── languages/                 ← Arquivos de tradução (.po, .mo)
```

---

## 🏗️ Hierarquia de Templates

O WordPress escolhe o template seguindo esta ordem:

```
Página inicial:  front-page.php → home.php → index.php
Post único:      single-{tipo}-{slug}.php → single-{tipo}.php → single.php → singular.php → index.php
Página estática: page-{slug}.php → page-{id}.php → page.php → singular.php → index.php
Categoria:       category-{slug}.php → category-{id}.php → category.php → archive.php → index.php
404:             404.php
```

---

## 🪝 Hooks Usados

| Hook | Onde | Para que serve |
|------|------|----------------|
| `after_setup_theme` | functions.php | Setup de recursos do WP |
| `wp_enqueue_scripts` | functions.php | Carregar CSS e JS |
| `widgets_init` | functions.php | Registrar sidebars |
| `body_class` | functions.php | Adicionar classes ao body |
| `wp_head` | header.php | Injeta CSS do Customizer |
| `customize_register` | inc/customizer.php | Registra campos no Customizer |

---

## ✅ Boas Práticas Aplicadas

- **Segurança:** Sanitização com `esc_html()`, `esc_url()`, `esc_attr()` em todos os outputs
- **Performance:** Scripts com `defer`, lazy loading nas imagens, sem jQuery
- **Acessibilidade:** `aria-label`, `aria-expanded`, `role`, `sr-only`, foco visível
- **BEM CSS:** `.bloco__elemento--modificador` para CSS previsível e escalável
- **CSS Variables:** Design tokens centralizados no `:root`
- **PHP:** Sem SQL direto, usando funções nativas do WordPress
- **Internacionalização:** `__()`, `esc_html_e()` para todos os textos

---

## 🚀 Como instalar

1. Copie a pasta `ws-theme` para `wp-content/themes/`
2. Acesse **Aparência > Temas** no painel do WordPress
3. Ative o tema **WS Theme**
4. Acesse **Aparência > Menus** para criar o menu principal
5. Acesse **Aparência > Personalizar** para editar cores e textos

---

## 📖 Dependências

- WordPress 6.0+
- PHP 7.4+
- Fontes: [Syne](https://fonts.google.com/specimen/Syne) + [DM Sans](https://fonts.google.com/specimen/DM+Sans) (Google Fonts, carregadas pelo tema)
