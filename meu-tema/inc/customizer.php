<?php
/**
 * inc/customizer.php — Painel de personalização do Dev Folio.
 *
 * Estrutura por seção:
 *   devfolio_identity → handle e nome
 *   devfolio_hero     → role, stats
 *   devfolio_about    → headline, lead, texto, info pessoal
 *   devfolio_contact  → e-mail e redes sociais
 *
 * @package DevFolio
 */

if ( ! defined( 'ABSPATH' ) ) exit;


function devfolio_customizer( $wp_customize ) {

	/* ============================================================
	   SEÇÃO: IDENTIDADE
	   ============================================================ */

	$wp_customize->add_section( 'devfolio_identity', [
		'title'    => __( 'Identidade', 'dev-folio' ),
		'priority' => 25,
	] );

	// Handle exibido no logo (@yasmndev)
	$wp_customize->add_setting( 'devfolio_handle', [
		'default'           => __( 'yasmndev', 'dev-folio' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'devfolio_handle', [
		'label'       => __( 'Handle (logo)', 'dev-folio' ),
		'description' => __( 'Exibido como @handle no cabeçalho.', 'dev-folio' ),
		'section'     => 'devfolio_identity',
		'type'        => 'text',
	] );

	// Primeira linha do nome (normal)
	$wp_customize->add_setting( 'devfolio_hero_name_first', [
		'default'           => __( 'Yasmin', 'dev-folio' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'devfolio_hero_name_first', [
		'label'   => __( 'Nome — 1ª linha', 'dev-folio' ),
		'section' => 'devfolio_identity',
		'type'    => 'text',
	] );

	// Segunda linha do nome (itálico serifado)
	$wp_customize->add_setting( 'devfolio_hero_name_last', [
		'default'           => __( 'Gonçalves.', 'dev-folio' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'devfolio_hero_name_last', [
		'label'       => __( 'Nome — 2ª linha (itálico)', 'dev-folio' ),
		'section'     => 'devfolio_identity',
		'type'        => 'text',
	] );


	/* ============================================================
	   SEÇÃO: HERO
	   ============================================================ */

	$wp_customize->add_section( 'devfolio_hero', [
		'title'    => __( 'Hero', 'dev-folio' ),
		'priority' => 30,
	] );

	// Atuação / bio curta
	$wp_customize->add_setting( 'devfolio_hero_role', [
		'default'           => __( 'Desenvolvedora front-end que cria temas WordPress, interfaces editoriais e experiências digitais simples de manter.', 'dev-folio' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( 'devfolio_hero_role', [
		'label'   => __( 'Atuação / Bio curta', 'dev-folio' ),
		'section' => 'devfolio_hero',
		'type'    => 'textarea',
	] );

	// Stats (3 números com labels)
	$stats = [
		[ 'id' => 'devfolio_stat_1_number', 'label' => __( 'Stat 1 — Número', 'dev-folio' ), 'default' => __( '3+', 'dev-folio' ) ],
		[ 'id' => 'devfolio_stat_1_label',  'label' => __( 'Stat 1 — Label', 'dev-folio' ),  'default' => __( 'anos de exp.', 'dev-folio' ) ],
		[ 'id' => 'devfolio_stat_2_number', 'label' => __( 'Stat 2 — Número', 'dev-folio' ), 'default' => __( '20+', 'dev-folio' ) ],
		[ 'id' => 'devfolio_stat_2_label',  'label' => __( 'Stat 2 — Label', 'dev-folio' ),  'default' => __( 'projetos', 'dev-folio' ) ],
		[ 'id' => 'devfolio_stat_3_number', 'label' => __( 'Stat 3 — Número', 'dev-folio' ), 'default' => __( '8+', 'dev-folio' ) ],
		[ 'id' => 'devfolio_stat_3_label',  'label' => __( 'Stat 3 — Label', 'dev-folio' ),  'default' => __( 'tecnologias', 'dev-folio' ) ],
	];

	foreach ( $stats as $stat ) {
		$wp_customize->add_setting( $stat['id'], [
			'default'           => $stat['default'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( $stat['id'], [
			'label'   => $stat['label'],
			'section' => 'devfolio_hero',
			'type'    => 'text',
		] );
	}


	/* ============================================================
	   SEÇÃO: SOBRE
	   ============================================================ */

	$wp_customize->add_section( 'devfolio_about', [
		'title'    => __( 'Sobre', 'dev-folio' ),
		'priority' => 35,
	] );

	$about_fields = [
		[
			'id'      => 'devfolio_about_headline',
			'label'   => __( 'Headline', 'dev-folio' ),
			'default' => __( 'Construindo interfaces para marcas, portfólios e lojas pequenas.', 'dev-folio' ),
			'type'    => 'text',
		],
		[
			'id'      => 'devfolio_about_lead',
			'label'   => __( 'Parágrafo lead (itálico serifado)', 'dev-folio' ),
			'default' => __( 'Bom design e código limpo trabalham juntos: um guia a experiência, o outro sustenta a evolução.', 'dev-folio' ),
			'type'    => 'textarea',
		],
		[
			'id'      => 'devfolio_about_text',
			'label'   => __( 'Parágrafo body', 'dev-folio' ),
			'default' => __( 'Este tema foi pensado como exemplo de workshop: genérico o suficiente para virar portfólio, loja conceito ou site de empresa criativa sem perder uma base profissional.', 'dev-folio' ),
			'type'    => 'textarea',
		],
		[
			'id'      => 'devfolio_about_location',
			'label'   => __( 'Localização', 'dev-folio' ),
			'default' => 'São Paulo, BR',
			'type'    => 'text',
		],
		[
			'id'      => 'devfolio_about_email',
			'label'   => __( 'E-mail (seção Sobre)', 'dev-folio' ),
			'default' => __( 'contato@yasmndev.com', 'dev-folio' ),
			'type'    => 'text',
		],
	];

	foreach ( $about_fields as $field ) {
		$sanitize = ( 'textarea' === $field['type'] ) ? 'sanitize_textarea_field' : 'sanitize_text_field';

		$sanitize = ( false !== strpos( $field['id'], 'email' ) ) ? 'sanitize_email' : $sanitize;

		$wp_customize->add_setting( $field['id'], [
			'default'           => $field['default'],
			'sanitize_callback' => $sanitize,
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( $field['id'], [
			'label'   => $field['label'],
			'section' => 'devfolio_about',
			'type'    => $field['type'],
		] );
	}


	/* ============================================================
	   SEÇÃO: CONTATO
	   ============================================================ */

	$wp_customize->add_section( 'devfolio_contact', [
		'title'    => __( 'Contato', 'dev-folio' ),
		'priority' => 40,
	] );

	$contact_fields = [
		[ 'id' => 'devfolio_contact_email', 'label' => __( 'E-mail', 'dev-folio' ),    'default' => __( 'contato@yasmndev.com', 'dev-folio' ) ],
		[ 'id' => 'devfolio_github_url',    'label' => __( 'GitHub URL', 'dev-folio' ), 'default' => 'https://github.com/yasmndev' ],
		[ 'id' => 'devfolio_linkedin_url',  'label' => __( 'LinkedIn URL', 'dev-folio' ), 'default' => 'https://linkedin.com/in/yasmndev' ],
		[ 'id' => 'devfolio_twitter_url',   'label' => __( 'X/Twitter URL', 'dev-folio' ), 'default' => '' ],
	];

	foreach ( $contact_fields as $field ) {
		$sanitize = ( false !== strpos( $field['id'], 'email' ) ) ? 'sanitize_email' : 'esc_url_raw';

		$wp_customize->add_setting( $field['id'], [
			'default'           => $field['default'],
			'sanitize_callback' => $sanitize,
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( $field['id'], [
			'label'   => $field['label'],
			'section' => 'devfolio_contact',
			'type'    => 'text',
		] );
	}
}
add_action( 'customize_register', 'devfolio_customizer' );
