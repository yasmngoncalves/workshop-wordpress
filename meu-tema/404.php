<?php
/**
 * 404.php — Página de erro "Não encontrado".
 *
 * @package DevFolio
 */

get_header();
?>

<main id="main" class="site-main" role="main">
  <section class="not-found section">
    <div class="container">
      <div class="not-found__inner">

        <span class="not-found__code" aria-hidden="true">404</span>

        <h1 class="not-found__title">
          <?php esc_html_e( 'Página não', 'dev-folio' ); ?>
          <em><?php esc_html_e( 'encontrada.', 'dev-folio' ); ?></em>
        </h1>

        <p style="margin-bottom: 2rem;">
          <?php esc_html_e( 'A página que você procura não existe ou foi movida.', 'dev-folio' ); ?>
        </p>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
          <?php esc_html_e( 'Voltar ao início', 'dev-folio' ); ?>
        </a>

      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
