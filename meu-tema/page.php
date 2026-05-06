<?php
/**
 * page.php — Template para páginas estáticas.
 *
 * @package DevFolio
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <?php while ( have_posts() ) : the_post(); ?>

    <article <?php post_class( 'page-content' ); ?> id="page-<?php the_ID(); ?>">

      <header class="page-header">
        <div class="container">
          <h1 class="page-header__title"><?php echo esc_html( get_the_title() ); ?></h1>
        </div>
      </header>

      <div class="container">
        <div class="page-body entry-content">
          <?php the_content(); ?>
          <?php
          wp_link_pages( [
              'before' => '<nav class="page-links">',
              'after'  => '</nav>',
          ] );
          ?>
        </div>
      </div>

    </article>

  <?php endwhile; ?>

</main>

<?php get_footer(); ?>
