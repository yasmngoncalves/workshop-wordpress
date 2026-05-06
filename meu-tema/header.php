<?php
/**
 * header.php — Topo de todas as páginas.
 *
 * Contém <!DOCTYPE>, <head> e o header visual com logo e navegação.
 *
 * @package DevFolio
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header" id="site-header" role="banner">
  <div class="container">
    <div class="site-header__inner">

      <!-- Logo: imagem do painel ou handle em JetBrains Mono -->
      <?php devfolio_logo(); ?>

      <!-- Navegação principal -->
      <nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Menu principal', 'dev-folio' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav__list',
            'link_before'    => '',
            'link_after'     => '',
            'item_spacing'   => 'discard',
            'depth'          => 1,
            'fallback_cb'    => 'devfolio_fallback_nav',
        ] );
        ?>
      </nav>

      <div class="site-header__actions">
        <!-- Botão hamburguer — aparece via CSS em mobile -->
        <button
          class="nav-toggle"
          id="nav-toggle"
          aria-expanded="false"
          aria-controls="site-nav"
          aria-label="<?php esc_attr_e( 'Abrir menu', 'dev-folio' ); ?>"
        >
          <span class="nav-toggle__bar"></span>
          <span class="nav-toggle__bar"></span>
          <span class="nav-toggle__bar"></span>
        </button>
      </div>

    </div><!-- /.site-header__inner -->
  </div><!-- /.container -->
</header><!-- /.site-header -->
