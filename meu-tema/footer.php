<?php
/**
 * footer.php — Rodapé de todas as páginas.
 *
 * @package DevFolio
 */
?>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="site-footer__inner">

      <!-- Brand: assinatura do tema -->
      <div class="site-footer__brand">
        <?php devfolio_logo(); ?>
        <span class="site-footer__copy">
          <?php
          printf(
            /* translators: %s = ano atual */
            esc_html__( 'Feito por yasmndev para workshop. %s', 'dev-folio' ),
            esc_html( gmdate( 'Y' ) )
          );
          ?>
        </span>
      </div>

      <!-- Menu do rodapé -->
      <?php
      wp_nav_menu( [
          'theme_location' => 'footer',
          'container'      => false,
          'menu_class'     => 'site-footer__links',
          'depth'          => 1,
          'fallback_cb'    => false,
      ] );
      ?>

    </div><!-- /.site-footer__inner -->
  </div><!-- /.container -->
</footer><!-- /.site-footer -->

<?php wp_footer(); ?>

</body>
</html>
