<?php
/**
 * template-parts/card-project.php — Card do CPT project.
 *
 * Chamado via get_template_part( 'template-parts/card', 'project', $args ).
 * Recebe $args['featured'] (bool) e $args['index'] (int).
 *
 * @package DevFolio
 */

// $args está disponível diretamente no escopo do template (WP 5.5+)
$is_featured = ! empty( $args['featured'] );
$index       = isset( $args['index'] ) ? (int) $args['index'] : 0;

$post_id   = get_the_ID();
$live_url  = devfolio_project_live_url( $post_id );
$repo_url  = devfolio_project_repo_url( $post_id );
$year      = devfolio_project_year( $post_id );

// Taxonomia tech_stack para as tags
$terms = get_the_terms( $post_id, 'tech_stack' );
?>

<article
  class="<?php echo esc_attr( $is_featured ? 'card-project card-project--featured' : 'card-project' ); ?>"
  id="project-<?php echo esc_attr( get_the_ID() ); ?>"
  data-animate
  data-animate-delay="<?php echo esc_attr( $index ); ?>"
>

  <!-- Thumbnail com aspect-ratio diferente para featured (21/9 vs 16/9) -->
  <div class="card-project__thumbnail">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php
      the_post_thumbnail( $is_featured ? 'full' : 'large', [
          'class'   => 'card-project__img',
          'loading' => 'lazy',
          'alt'     => esc_attr( get_the_title() ),
      ] );
      ?>
    <?php else : ?>
      <!-- Placeholder textual evita depender de imagem no workshop. -->
      <div class="card-project__placeholder" aria-hidden="true"><?php echo esc_html__( 'Projeto', 'dev-folio' ); ?></div>
    <?php endif; ?>
  </div>

  <div class="card-project__body">

    <!-- Tags da taxonomia tech_stack -->
    <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
      <div class="card-project__tags" aria-label="<?php esc_attr_e( 'Tecnologias', 'dev-folio' ); ?>">
        <?php foreach ( $terms as $term ) : ?>
          <span class="tag"><?php echo esc_html( $term->name ); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Título linkado -->
    <h3 class="card-project__title">
      <a href="<?php echo esc_url( get_permalink() ); ?>">
        <?php echo esc_html( get_the_title() ); ?>
      </a>
    </h3>

    <!-- Excerpt do projeto -->
    <?php if ( has_excerpt() ) : ?>
      <p class="card-project__excerpt">
        <?php echo esc_html( devfolio_excerpt( 30 ) ); ?>
      </p>
    <?php endif; ?>

    <!-- Footer: links (live + repo) e ano -->
    <footer class="card-project__footer">

      <div class="card-project__links">
        <?php if ( $live_url ) : ?>
          <a
            href="<?php echo esc_url( $live_url ); ?>"
            class="card-project__link"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="<?php echo esc_attr( sprintf( __( 'Ver %s ao vivo', 'dev-folio' ), get_the_title() ) ); ?>"
          >
            <?php esc_html_e( 'Site', 'dev-folio' ); ?>
          </a>
        <?php endif; ?>

        <?php if ( $repo_url ) : ?>
          <a
            href="<?php echo esc_url( $repo_url ); ?>"
            class="card-project__link"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="<?php echo esc_attr( sprintf( __( 'Ver repositório de %s', 'dev-folio' ), get_the_title() ) ); ?>"
          >
            <?php esc_html_e( 'Código', 'dev-folio' ); ?>
          </a>
        <?php endif; ?>
      </div>

      <!-- Ano em monospace -->
      <span class="card-project__year"><?php echo esc_html( $year ); ?></span>

    </footer>

  </div><!-- /.card-project__body -->

</article><!-- /.card-project -->
