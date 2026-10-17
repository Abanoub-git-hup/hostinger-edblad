<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function edblad_theme_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'edblad-store' ),
			'footer'  => __( 'Footer Menu', 'edblad-store' ),
			'mobile'  => __( 'Mobile Menu', 'edblad-store' ),
		)
	);
}
add_action( 'after_setup_theme', 'edblad_theme_setup' );

/**
 * Flags the front page so both header.php (classic, WooCommerce pages)
 * and parts/header.html (FSE, no PHP available inside the template part)
 * can style the header as transparent-over-hero via the same body class.
 */
function edblad_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'has-transparent-header';
	}
	return $classes;
}
add_filter( 'body_class', 'edblad_body_class' );
