<?php
/**
 * functions.php — Núcleo do tema Dev Folio.
 *
 * @package DevFolio
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Carrega configurações do Customizer
require_once get_template_directory() . '/inc/customizer.php';


/* ============================================================
   1. SETUP DO TEMA
   ============================================================ */

function devfolio_setup() {
	load_theme_textdomain( 'dev-folio', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'wp-block-styles' );

	register_nav_menus( [
		'primary' => __( 'Menu Principal', 'dev-folio' ),
		'footer'  => __( 'Menu Rodapé', 'dev-folio' ),
	] );
}
add_action( 'after_setup_theme', 'devfolio_setup' );


/* ============================================================
   2. ESTILOS E SCRIPTS
   ============================================================ */

function devfolio_assets() {
	// Três famílias de fontes do design system
	wp_enqueue_style(
		'devfolio-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'devfolio-style',
		get_stylesheet_uri(),
		[ 'devfolio-google-fonts' ],
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'devfolio-main',
		get_template_directory_uri() . '/assets/js/main.js',
		[],
		wp_get_theme()->get( 'Version' ),
		[
			'strategy'  => 'defer',
			'in_footer' => true,
		]
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'devfolio_assets' );


/* ============================================================
   3. CUSTOM POST TYPE: project
   ============================================================ */

function devfolio_register_project_cpt() {
	$labels = [
		'name'               => __( 'Projetos', 'dev-folio' ),
		'singular_name'      => __( 'Projeto', 'dev-folio' ),
		'add_new'            => __( 'Adicionar Projeto', 'dev-folio' ),
		'add_new_item'       => __( 'Adicionar Novo Projeto', 'dev-folio' ),
		'edit_item'          => __( 'Editar Projeto', 'dev-folio' ),
		'new_item'           => __( 'Novo Projeto', 'dev-folio' ),
		'view_item'          => __( 'Ver Projeto', 'dev-folio' ),
		'search_items'       => __( 'Buscar Projetos', 'dev-folio' ),
		'not_found'          => __( 'Nenhum projeto encontrado', 'dev-folio' ),
		'not_found_in_trash' => __( 'Nenhum projeto na lixeira', 'dev-folio' ),
		'menu_name'          => __( 'Projetos', 'dev-folio' ),
	];

	register_post_type( 'project', [
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'projects' ],
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'show_in_rest' => true,
	] );
}
add_action( 'init', 'devfolio_register_project_cpt' );


/* ============================================================
   4. TAXONOMIA: tech_stack (não hierárquica, tipo tag)
   ============================================================ */

function devfolio_register_tech_stack() {
	$labels = [
		'name'          => __( 'Tech Stack', 'dev-folio' ),
		'singular_name' => __( 'Tecnologia', 'dev-folio' ),
		'search_items'  => __( 'Buscar Tecnologias', 'dev-folio' ),
		'all_items'     => __( 'Todas as Tecnologias', 'dev-folio' ),
		'edit_item'     => __( 'Editar Tecnologia', 'dev-folio' ),
		'add_new_item'  => __( 'Adicionar Nova Tecnologia', 'dev-folio' ),
		'menu_name'     => __( 'Tech Stack', 'dev-folio' ),
	];

	register_taxonomy( 'tech_stack', 'project', [
		'labels'       => $labels,
		'hierarchical' => false, // tipo tag, não categoria
		'public'       => true,
		'rewrite'      => [ 'slug' => 'tech' ],
		'show_in_rest' => true,
	] );
}
add_action( 'init', 'devfolio_register_tech_stack' );


/* ============================================================
   5. META BOXES DO PROJETO
   ============================================================ */

function devfolio_add_project_meta_boxes() {
	add_meta_box(
		'devfolio-project-links',
		__( 'Links do Projeto', 'dev-folio' ),
		'devfolio_render_project_meta_box',
		'project',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'devfolio_add_project_meta_boxes' );

function devfolio_render_project_meta_box( $post ) {
	wp_nonce_field( 'devfolio_save_project_meta', 'devfolio_project_nonce' );

	$live_url = get_post_meta( $post->ID, '_project_live_url', true );
	$repo_url = get_post_meta( $post->ID, '_project_repo_url', true );
	$year     = get_post_meta( $post->ID, '_project_year', true );
	?>
	<p style="margin-bottom:.75rem">
		<label for="project_live_url" style="display:block;font-weight:600;margin-bottom:4px">
			<?php esc_html_e( 'URL ao vivo', 'dev-folio' ); ?>
		</label>
		<input
			type="url" id="project_live_url" name="_project_live_url"
			value="<?php echo esc_url( $live_url ); ?>"
			class="widefat" placeholder="https://"
		>
	</p>
	<p style="margin-bottom:.75rem">
		<label for="project_repo_url" style="display:block;font-weight:600;margin-bottom:4px">
			<?php esc_html_e( 'Repositório', 'dev-folio' ); ?>
		</label>
		<input
			type="url" id="project_repo_url" name="_project_repo_url"
			value="<?php echo esc_url( $repo_url ); ?>"
			class="widefat" placeholder="https://github.com/"
		>
	</p>
	<p>
		<label for="project_year" style="display:block;font-weight:600;margin-bottom:4px">
			<?php esc_html_e( 'Ano', 'dev-folio' ); ?>
		</label>
		<input
			type="text" id="project_year" name="_project_year"
			value="<?php echo esc_attr( $year ); ?>"
			class="widefat" placeholder="<?php echo esc_attr( gmdate( 'Y' ) ); ?>"
		>
	</p>
	<?php
}

function devfolio_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['devfolio_project_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['devfolio_project_nonce'] ) ),
		'devfolio_save_project_meta'
	) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_project_live_url'] ) ) {
		update_post_meta( $post_id, '_project_live_url', esc_url_raw( wp_unslash( $_POST['_project_live_url'] ) ) );
	}

	if ( isset( $_POST['_project_repo_url'] ) ) {
		update_post_meta( $post_id, '_project_repo_url', esc_url_raw( wp_unslash( $_POST['_project_repo_url'] ) ) );
	}

	if ( isset( $_POST['_project_year'] ) ) {
		update_post_meta( $post_id, '_project_year', sanitize_text_field( wp_unslash( $_POST['_project_year'] ) ) );
	}
}
// Hook no CPT específico evita processar todos os tipos de post
add_action( 'save_post_project', 'devfolio_save_project_meta' );


/* ============================================================
   6. HELPERS
   ============================================================ */

/**
 * Exibe o logo: imagem do painel ou handle em monospace.
 */
function devfolio_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$handle = get_theme_mod( 'devfolio_handle', __( 'yasmndev', 'dev-folio' ) );

	echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="site-header__logo">';
	echo '<span class="logo-handle">@</span>';
	echo esc_html( $handle );
	echo '</a>';
}

/**
 * Retorna a URL ao vivo do projeto.
 *
 * @param int|null $post_id
 * @return string
 */
function devfolio_project_live_url( $post_id = null ) {
	return (string) get_post_meta( $post_id ?: get_the_ID(), '_project_live_url', true );
}

/**
 * Retorna a URL do repositório.
 *
 * @param int|null $post_id
 * @return string
 */
function devfolio_project_repo_url( $post_id = null ) {
	return (string) get_post_meta( $post_id ?: get_the_ID(), '_project_repo_url', true );
}

/**
 * Retorna o ano do projeto. Fallback: ano de publicação do post.
 *
 * @param int|null $post_id
 * @return string
 */
function devfolio_project_year( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$year    = get_post_meta( $post_id, '_project_year', true );
	return $year ? $year : get_the_date( 'Y', $post_id );
}

/**
 * Tempo estimado de leitura em minutos.
 *
 * @param int $wpm Palavras por minuto (padrão: 200).
 * @return string
 */
function devfolio_reading_time( $wpm = 200 ) {
	$words   = str_word_count( strip_tags( get_the_content() ) );
	$minutes = max( 1, (int) ceil( $words / $wpm ) );
	/* translators: %d = número de minutos */
	return sprintf( _n( '%d min', '%d min', $minutes, 'dev-folio' ), $minutes );
}

/**
 * Excerpt customizado com número de palavras configurável.
 *
 * @param int $length
 * @return string
 */
function devfolio_excerpt( $length = 25 ) {
	return wp_trim_words( get_the_excerpt(), $length, __( '...', 'dev-folio' ) );
}

/**
 * Fallback de navegação exibido quando nenhum menu está cadastrado.
 */
function devfolio_fallback_nav() {
	echo '<ul class="nav__list">';
	echo '<li class="nav__item"><a class="nav__link" href="' . esc_url( home_url( '/#projetos' ) ) . '">' . esc_html__( 'projetos', 'dev-folio' ) . '</a></li>';
	echo '<li class="nav__item"><a class="nav__link" href="' . esc_url( home_url( '/#sobre' ) ) . '">' . esc_html__( 'sobre', 'dev-folio' ) . '</a></li>';
	echo '<li class="nav__item"><a class="nav__link" href="' . esc_url( home_url( '/#contato' ) ) . '">' . esc_html__( 'contato', 'dev-folio' ) . '</a></li>';
	echo '</ul>';
}


/* ============================================================
   7. BODY CLASSES
   ============================================================ */

function devfolio_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-homepage';
	}
	return $classes;
}
add_filter( 'body_class', 'devfolio_body_classes' );


/* ============================================================
   8. SEGURANÇA — remove metadados desnecessários do <head>
   ============================================================ */

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
