<?php
/**
 * single.php — Template para posts individuais do blog.
 *
 * @package DevFolio
 */

get_header();
?>

<main id="main" class="site-main" role="main">
  <div class="container">
    <div class="post-layout">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <article <?php post_class( 'post-single' ); ?> id="post-<?php the_ID(); ?>">

        <header class="post-single__header">

          <!-- Categorias em monospace -->
          <div class="post-single__cats">
            <?php the_category( esc_html__( ' / ', 'dev-folio' ) ); ?>
          </div>

          <h1 class="post-single__title"><?php echo esc_html( get_the_title() ); ?></h1>

          <div class="post-single__meta">
            <span><?php echo esc_html( get_the_author() ); ?></span>
            <span><?php echo esc_html__( '/', 'dev-folio' ); ?></span>
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
              <?php echo esc_html( get_the_date() ); ?>
            </time>
            <span><?php echo esc_html__( '/', 'dev-folio' ); ?></span>
            <span><?php echo esc_html( devfolio_reading_time() ); ?></span>
          </div>

          <?php if ( has_post_thumbnail() ) : ?>
            <figure class="post-single__thumbnail">
              <?php
              the_post_thumbnail( 'large', [
                  'loading' => 'eager',
                  'alt'     => esc_attr( get_the_title() ),
              ] );
              ?>
            </figure>
          <?php endif; ?>

        </header><!-- /.post-single__header -->

        <div class="post-single__content entry-content">
          <?php the_content(); ?>
          <?php
          wp_link_pages( [
              'before' => '<nav class="page-links"><span>' . esc_html__( 'Páginas:', 'dev-folio' ) . '</span>',
              'after'  => '</nav>',
          ] );
          ?>
        </div><!-- /.post-single__content -->

        <footer class="post-single__footer">
          <?php the_tags( '<div class="post-tags">', '', '</div>' ); ?>
        </footer>

        <nav class="post-nav" aria-label="<?php esc_attr_e( 'Navegação entre posts', 'dev-folio' ); ?>">
          <?php
          the_post_navigation( [
              'prev_text' => esc_html__( 'Anterior: %title', 'dev-folio' ),
              'next_text' => esc_html__( 'Próximo: %title', 'dev-folio' ),
          ] );
          ?>
        </nav>

      </article><!-- /.post-single -->

      <?php
      if ( comments_open() || get_comments_number() ) {
          comments_template();
      }
      ?>

      <?php endwhile; endif; ?>

    </div><!-- /.post-layout -->
  </div><!-- /.container -->
</main>

<?php get_footer(); ?>
