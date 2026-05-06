<?php
/**
 * template-parts/card-post.php — Card de post do blog.
 *
 * Chamado dentro do Loop do WordPress.
 *
 * @package DevFolio
 */
?>

<article <?php post_class( 'card card--post' ); ?> id="post-<?php echo esc_attr( get_the_ID() ); ?>">

  <?php if ( has_post_thumbnail() ) : ?>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="card__thumbnail" aria-hidden="true" tabindex="-1">
      <?php
      the_post_thumbnail( 'medium_large', [
          'loading' => 'lazy',
          'class'   => 'card__img',
          'alt'     => esc_attr( get_the_title() ),
      ] );
      ?>
    </a>
  <?php endif; ?>

  <div class="card__body">

    <div class="card__cats">
      <?php the_category( esc_html__( ' / ', 'dev-folio' ) ); ?>
    </div>

    <h3 class="card__title">
      <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
    </h3>

    <p class="card__text">
      <?php echo esc_html( devfolio_excerpt( 20 ) ); ?>
    </p>

    <footer class="card__meta">
      <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php echo esc_html( get_the_date() ); ?>
      </time>
      <span><?php echo esc_html__( '/', 'dev-folio' ); ?></span>
      <span><?php echo esc_html( devfolio_reading_time() ); ?></span>
    </footer>

  </div><!-- /.card__body -->

</article>
