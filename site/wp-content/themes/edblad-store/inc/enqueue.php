<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function edblad_enqueue_assets() {

	wp_enqueue_style(
		'edblad-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400&family=DM+Sans:wght@400;500&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'edblad-style',
		get_stylesheet_uri(),
		array( 'edblad-google-fonts' ),
		filemtime( get_theme_file_path( 'style.css' ) )
	);

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'edblad-woocommerce',
			get_theme_file_uri( 'assets/css/woocommerce.css' ),
			array( 'edblad-style' ),
			filemtime( get_theme_file_path( 'assets/css/woocommerce.css' ) )
		);
	}

	wp_enqueue_script(
		'edblad-main',
		get_theme_file_uri( 'assets/js/main.js' ),
		array(),
		filemtime( get_theme_file_path( 'assets/js/main.js' ) ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'edblad_enqueue_assets' );
