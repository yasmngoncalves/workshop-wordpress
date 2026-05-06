<?php
/**
 * index.php — Homepage do portfólio (5 seções).
 *
 * Hierarquia: front-page.php → home.php → index.php (este arquivo).
 *
 * @package DevFolio
 */

get_header();
?>

<main id="main" class="site-main" role="main">


  <!-- ============================================================
       SEÇÃO 1: HERO
       Número decorativo, disponibilidade, nome em 2 linhas,
       role, botões, stats e scroll indicator.
       ============================================================ -->
  <section class="hero section" id="home" aria-labelledby="hero-heading">
    <div class="container">

      <div class="hero__layout">
      <div class="hero__inner">

        <!-- Label "Disponível para projetos" com bolinha verde pulsante -->
        <div class="hero__availability">
          <span class="hero__availability-dot" aria-hidden="true"></span>
          <span><?php esc_html_e( 'Disponível para projetos', 'dev-folio' ); ?></span>
        </div>

        <!-- Nome em duas linhas: primeira normal, segunda em itálico serifado -->
        <h1 class="hero__heading" id="hero-heading">
          <span class="hero__name-first">
            <?php echo esc_html( get_theme_mod( 'devfolio_hero_name_first', __( 'Yasmin', 'dev-folio' ) ) ); ?>
          </span>
          <em class="hero__name-last">
            <?php echo esc_html( get_theme_mod( 'devfolio_hero_name_last', __( 'Gonçalves.', 'dev-folio' ) ) ); ?>
          </em>
        </h1>

        <!-- Role / bio curta -->
        <p class="hero__role">
          <?php echo esc_html( get_theme_mod(
            'devfolio_hero_role',
            __( 'Desenvolvedora front-end que cria temas WordPress, interfaces editoriais e experiências digitais simples de manter.', 'dev-folio' )
          ) ); ?>
        </p>

        <!-- CTAs: primário + outline -->
        <div class="hero__actions">
          <a href="#projetos" class="btn btn--primary">
            <?php esc_html_e( 'Ver projetos', 'dev-folio' ); ?>
          </a>
          <a href="#contato" class="btn btn--outline">
            <?php esc_html_e( 'Fale comigo', 'dev-folio' ); ?>
          </a>
        </div>

        <!-- Rodapé do hero: 3 stats -->
        <footer class="hero__footer" aria-label="<?php esc_attr_e( 'Estatísticas', 'dev-folio' ); ?>">

          <div class="hero__stats">
            <div class="hero__stat">
              <span class="hero__stat-number">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_1_number', __( '3+', 'dev-folio' ) ) ); ?>
              </span>
              <span class="hero__stat-label">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_1_label', __( 'anos de exp.', 'dev-folio' ) ) ); ?>
              </span>
            </div>
            <div class="hero__stat">
              <span class="hero__stat-number">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_2_number', __( '20+', 'dev-folio' ) ) ); ?>
              </span>
              <span class="hero__stat-label">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_2_label', __( 'projetos', 'dev-folio' ) ) ); ?>
              </span>
            </div>
            <div class="hero__stat">
              <span class="hero__stat-number">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_3_number', __( '8+', 'dev-folio' ) ) ); ?>
              </span>
              <span class="hero__stat-label">
                <?php echo esc_html( get_theme_mod( 'devfolio_stat_3_label', __( 'tecnologias', 'dev-folio' ) ) ); ?>
              </span>
            </div>
          </div>

        </footer><!-- /.hero__footer -->

      </div><!-- /.hero__inner -->
      <figure class="hero__media" aria-hidden="true">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-workspace.svg' ); ?>"
          alt=""
          class="hero__image"
          loading="eager"
        >
      </figure>
      </div><!-- /.hero__layout -->
    </div><!-- /.container -->
  </section><!-- /.hero -->


  <!-- ============================================================
       SEÇÃO 2: PROJETOS
       WP_Query no CPT project (5 posts), primeiro card featured.
       ============================================================ -->
  <section class="section section--projects" id="projetos" aria-labelledby="projects-heading">
    <div class="container">

      <header class="section__header">
        <span class="section__label"><?php esc_html_e( 'trabalhos', 'dev-folio' ); ?></span>
        <h2 class="section__title" id="projects-heading">
          <?php esc_html_e( 'Projetos selecionados', 'dev-folio' ); ?>
        </h2>
      </header>

      <?php
      /*
       * WP_Query no CPT project. Nunca use query_posts() — ele interfere
       * na query principal e causa bugs difíceis de rastrear.
       */
      $projects = new WP_Query( [
          'post_type'      => 'project',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
          'orderby'        => 'date',
          'order'          => 'DESC',
      ] );
      ?>

      <?php if ( $projects->have_posts() ) : ?>

        <div class="projects-grid">
          <?php
          $project_index = 0;
          while ( $projects->have_posts() ) :
              $projects->the_post();
              /*
               * Passa featured e index via $args (disponível em WP 5.5+).
               * featured = true apenas para o primeiro card.
               */
              get_template_part( 'template-parts/card', 'project', [
                  'featured' => ( 0 === $project_index ),
                  'index'    => $project_index,
              ] );
              $project_index++;
          endwhile;
          // Obrigatório após WP_Query customizada
          wp_reset_postdata();
          ?>
        </div><!-- /.projects-grid -->

      <?php else : ?>

        <?php
        /*
         * Projetos de exemplo mantem a home bonita no workshop.
         * Quando projetos reais forem cadastrados, o CPT assume esta grade.
         */
        $demo_projects = [
            [
                'title' => __( 'Ateliê Aurora', 'dev-folio' ),
                'text'  => __( 'Loja conceito para produtos artesanais, com vitrine editorial, página de coleção e chamadas para compra.', 'dev-folio' ),
                'tags'  => [ __( 'WordPress', 'dev-folio' ), __( 'WooCommerce', 'dev-folio' ), __( 'CSS', 'dev-folio' ) ],
                'image' => 'project-atelier.svg',
                'year'  => __( '2026', 'dev-folio' ),
            ],
            [
                'title' => __( 'Studio Norte', 'dev-folio' ),
                'text'  => __( 'Site institucional para uma empresa criativa, com foco em apresentação de serviços e captação de contatos.', 'dev-folio' ),
                'tags'  => [ __( 'Tema WP', 'dev-folio' ), __( 'Customizer', 'dev-folio' ) ],
                'image' => 'project-studio.svg',
                'year'  => __( '2026', 'dev-folio' ),
            ],
            [
                'title' => __( 'Café Linha', 'dev-folio' ),
                'text'  => __( 'Landing page para cafeteria local com cardápio resumido, área de destaque e links de reserva.', 'dev-folio' ),
                'tags'  => [ __( 'HTML', 'dev-folio' ), __( 'JavaScript', 'dev-folio' ) ],
                'image' => 'project-cafe.svg',
                'year'  => __( '2025', 'dev-folio' ),
            ],
            [
                'title' => __( 'Marca Prisma', 'dev-folio' ),
                'text'  => __( 'Portfólio visual para designer independente, combinando projetos, bastidores e formulário de orçamento.', 'dev-folio' ),
                'tags'  => [ __( 'Portfólio', 'dev-folio' ), __( 'Acessibilidade', 'dev-folio' ) ],
                'image' => 'project-prisma.svg',
                'year'  => __( '2025', 'dev-folio' ),
            ],
            [
                'title' => __( 'Painel Raiz', 'dev-folio' ),
                'text'  => __( 'Interface administrativa fictícia para organizar pedidos, clientes e tarefas de uma pequena operação.', 'dev-folio' ),
                'tags'  => [ __( 'Dashboard', 'dev-folio' ), __( 'UX', 'dev-folio' ) ],
                'image' => 'project-dashboard.svg',
                'year'  => __( '2025', 'dev-folio' ),
            ],
        ];
        ?>

        <div class="projects-grid projects-grid--demo">
          <?php foreach ( $demo_projects as $project_index => $project ) : ?>
            <?php $is_featured = ( 0 === $project_index ); ?>
            <article
              class="<?php echo esc_attr( $is_featured ? 'card-project card-project--featured' : 'card-project' ); ?>"
              data-animate
              data-animate-delay="<?php echo esc_attr( $project_index ); ?>"
            >
              <div class="card-project__thumbnail">
                <img
                  src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $project['image'] ); ?>"
                  class="card-project__img"
                  alt="<?php echo esc_attr( $project['title'] ); ?>"
                  loading="<?php echo esc_attr( $is_featured ? 'eager' : 'lazy' ); ?>"
                >
              </div>

              <div class="card-project__body">
                <div class="card-project__tags" aria-label="<?php esc_attr_e( 'Tecnologias', 'dev-folio' ); ?>">
                  <?php foreach ( $project['tags'] as $tag ) : ?>
                    <span class="tag"><?php echo esc_html( $tag ); ?></span>
                  <?php endforeach; ?>
                </div>

                <h3 class="card-project__title"><?php echo esc_html( $project['title'] ); ?></h3>
                <p class="card-project__excerpt"><?php echo esc_html( $project['text'] ); ?></p>

                <footer class="card-project__footer">
                  <div class="card-project__links">
                    <span class="card-project__link"><?php esc_html_e( 'Projeto exemplo', 'dev-folio' ); ?></span>
                  </div>
                  <span class="card-project__year"><?php echo esc_html( $project['year'] ); ?></span>
                </footer>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

      <?php endif; ?>

    </div><!-- /.container -->
  </section>


  <!-- ============================================================
       SEÇÃO 3: SOBRE
       Grid 2 colunas: conteúdo editorial (esq.) + info pessoal (dir.)
       ============================================================ -->
  <section class="section" id="sobre" aria-labelledby="about-heading">
    <div class="container">

      <div class="about__grid">

        <!-- Coluna esquerda: headline + lead itálico + body -->
        <div class="about__content" data-animate>
          <h2 class="about__headline" id="about-heading">
            <?php echo esc_html( get_theme_mod(
              'devfolio_about_headline',
              __( 'Construindo interfaces para marcas, portfólios e lojas pequenas.', 'dev-folio' )
            ) ); ?>
          </h2>

          <!-- Lead em itálico serifado — conforme spec -->
          <p class="about__lead">
            <?php echo esc_html( get_theme_mod(
              'devfolio_about_lead',
              __( 'Bom design e código limpo trabalham juntos: um guia a experiência, o outro sustenta a evolução.', 'dev-folio' )
            ) ); ?>
          </p>

          <p class="about__text">
            <?php echo esc_html( get_theme_mod(
              'devfolio_about_text',
              __( 'Este tema foi pensado como exemplo de workshop: genérico o suficiente para virar portfólio, loja conceito ou site de empresa criativa sem perder uma base profissional.', 'dev-folio' )
            ) ); ?>
          </p>
        </div>

        <!-- Coluna direita: lista com labels em monospace uppercase -->
        <aside class="about__info" data-animate data-animate-delay="1" aria-label="<?php esc_attr_e( 'Informações pessoais', 'dev-folio' ); ?>">
          <ul class="about__info-list">

            <li class="about__info-item">
              <span class="about__info-label"><?php esc_html_e( 'Atuação', 'dev-folio' ); ?></span>
              <span class="about__info-value">
                <?php echo esc_html( get_theme_mod( 'devfolio_hero_role', __( 'Desenvolvedora Front-end', 'dev-folio' ) ) ); ?>
              </span>
            </li>

            <li class="about__info-item">
              <span class="about__info-label"><?php esc_html_e( 'Localização', 'dev-folio' ); ?></span>
              <span class="about__info-value">
                <?php echo esc_html( get_theme_mod( 'devfolio_about_location', 'São Paulo, BR' ) ); ?>
              </span>
            </li>

            <li class="about__info-item">
              <span class="about__info-label"><?php esc_html_e( 'Disponibilidade', 'dev-folio' ); ?></span>
              <span class="about__info-value">
                <?php esc_html_e( 'Aberto a projetos', 'dev-folio' ); ?>
              </span>
            </li>

            <li class="about__info-item">
              <span class="about__info-label"><?php esc_html_e( 'E-mail', 'dev-folio' ); ?></span>
              <span class="about__info-value">
                <a href="mailto:<?php echo esc_attr( get_theme_mod( 'devfolio_about_email', __( 'contato@yasmndev.com', 'dev-folio' ) ) ); ?>">
                  <?php echo esc_html( get_theme_mod( 'devfolio_about_email', __( 'contato@yasmndev.com', 'dev-folio' ) ) ); ?>
                </a>
              </span>
            </li>

          </ul>
        </aside>

      </div><!-- /.about__grid -->

    </div><!-- /.container -->
  </section>


  <!-- ============================================================
       SEÇÃO 4: SKILLS
       Grid auto-fill minmax(260px, 1fr) com grupos por categoria.
       Títulos dos grupos em monospace uppercase.
       ============================================================ -->
  <section class="section" id="skills" aria-labelledby="skills-heading">
    <div class="container">

      <header class="section__header">
        <span class="section__label"><?php esc_html_e( 'habilidades', 'dev-folio' ); ?></span>
        <h2 class="section__title" id="skills-heading">
          <?php esc_html_e( 'Tecnologias & ferramentas', 'dev-folio' ); ?>
        </h2>
      </header>

      <div class="skills-grid">

        <?php
        // Grupos de skills com título monospace e tags — conforme spec
        $skill_groups = [
            [
                'title' => __( 'Front-end', 'dev-folio' ),
                'tags'  => [ __( 'HTML5', 'dev-folio' ), __( 'CSS3', 'dev-folio' ), __( 'JavaScript', 'dev-folio' ), __( 'TypeScript', 'dev-folio' ), __( 'React', 'dev-folio' ), __( 'Vue.js', 'dev-folio' ) ],
            ],
            [
                'title' => __( 'Ferramentas', 'dev-folio' ),
                'tags'  => [ __( 'Git', 'dev-folio' ), __( 'Webpack', 'dev-folio' ), __( 'Vite', 'dev-folio' ), __( 'Figma', 'dev-folio' ), __( 'VS Code', 'dev-folio' ), __( 'npm', 'dev-folio' ) ],
            ],
            [
                'title' => __( 'CMS', 'dev-folio' ),
                'tags'  => [ __( 'WordPress', 'dev-folio' ), __( 'Headless WP', 'dev-folio' ), __( 'ACF', 'dev-folio' ), __( 'WooCommerce', 'dev-folio' ) ],
            ],
            [
                'title' => __( 'Habilidades Humanas', 'dev-folio' ),
                'tags'  => [ __( 'Design System', 'dev-folio' ), __( 'Acessibilidade', 'dev-folio' ), __( 'Performance', 'dev-folio' ), __( 'Revisão de Código', 'dev-folio' ) ],
            ],
        ];

        foreach ( $skill_groups as $i => $group ) :
        ?>
          <div class="skill-group" data-animate data-animate-delay="<?php echo esc_attr( $i ); ?>">
            <h3 class="skill-group__title"><?php echo esc_html( $group['title'] ); ?></h3>
            <div class="skill-group__tags">
              <?php foreach ( $group['tags'] as $tag ) : ?>
                <span class="tag"><?php echo esc_html( $tag ); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

      </div><!-- /.skills-grid -->

    </div><!-- /.container -->
  </section>


  <!-- ============================================================
       SEÇÃO 5: CONTATO
       Centralizado, e-mail grande serifado, redes sociais em monospace.
       ============================================================ -->
  <section class="section" id="contato" aria-labelledby="contact-heading">
    <div class="container">

      <div class="contact__inner">

        <span class="section__label contact__label">
          <?php esc_html_e( 'contato', 'dev-folio' ); ?>
        </span>

        <h2 class="contact__title" id="contact-heading">
          <?php esc_html_e( 'Vamos trabalhar', 'dev-folio' ); ?>
          <em><?php esc_html_e( 'juntos?', 'dev-folio' ); ?></em>
        </h2>

        <!-- E-mail em fonte grande serifada clicável — conforme spec -->
        <a
          href="mailto:<?php echo esc_attr( get_theme_mod( 'devfolio_contact_email', __( 'contato@yasmndev.com', 'dev-folio' ) ) ); ?>"
          class="contact__email"
        >
          <?php echo esc_html( get_theme_mod( 'devfolio_contact_email', __( 'contato@yasmndev.com', 'dev-folio' ) ) ); ?>
        </a>

        <!-- Links de redes sociais em monospace — conforme spec -->
        <nav class="contact__social" aria-label="<?php esc_attr_e( 'Redes sociais', 'dev-folio' ); ?>">

          <?php if ( $github = get_theme_mod( 'devfolio_github_url', '' ) ) : ?>
            <a href="<?php echo esc_url( $github ); ?>" class="contact__social-link" target="_blank" rel="noopener noreferrer">
              <?php esc_html_e( 'github', 'dev-folio' ); ?>
            </a>
          <?php endif; ?>

          <?php if ( $linkedin = get_theme_mod( 'devfolio_linkedin_url', '' ) ) : ?>
            <a href="<?php echo esc_url( $linkedin ); ?>" class="contact__social-link" target="_blank" rel="noopener noreferrer">
              <?php esc_html_e( 'linkedin', 'dev-folio' ); ?>
            </a>
          <?php endif; ?>

          <?php if ( $twitter = get_theme_mod( 'devfolio_twitter_url', '' ) ) : ?>
            <a href="<?php echo esc_url( $twitter ); ?>" class="contact__social-link" target="_blank" rel="noopener noreferrer">
              <?php esc_html_e( 'x/twitter', 'dev-folio' ); ?>
            </a>
          <?php endif; ?>

        </nav>

      </div><!-- /.contact__inner -->

    </div><!-- /.container -->
  </section>


</main><!-- /#main -->

<?php get_footer(); ?>
