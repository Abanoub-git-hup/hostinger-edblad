<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function edblad_customize_register( $wp_customize ) {

	/**
	 * Announcement Bar
	 */
	$wp_customize->add_section(
		'edblad_announcement',
		array(
			'title'    => __( 'Announcement Bar', 'edblad-store' ),
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'edblad_announcement_text',
		array(
			'default'           => 'Swedish design · Bestsellers · Free delivery over €60',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_announcement_text',
		array(
			'label'   => __( 'Announcement Text', 'edblad-store' ),
			'section' => 'edblad_announcement',
			'type'    => 'text',
		)
	);

	/**
	 * Brand Colors
	 */
	$wp_customize->add_section(
		'edblad_brand_colors',
		array(
			'title'    => __( 'Brand Colors', 'edblad-store' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'edblad_color_primary',
		array(
			'default'           => '#1a1a1a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'edblad_color_primary',
			array(
				'label'   => __( 'Primary Color', 'edblad-store' ),
				'section' => 'edblad_brand_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'edblad_color_accent',
		array(
			'default'           => '#c9a96e',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'edblad_color_accent',
			array(
				'label'   => __( 'Accent Color', 'edblad-store' ),
				'section' => 'edblad_brand_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'edblad_color_background',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'edblad_color_background',
			array(
				'label'   => __( 'Background Color', 'edblad-store' ),
				'section' => 'edblad_brand_colors',
			)
		)
	);

	/**
	 * Typography
	 */
	$wp_customize->add_section(
		'edblad_typography',
		array(
			'title'    => __( 'Typography', 'edblad-store' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'edblad_heading_font',
		array(
			'default'           => 'Cormorant Garamond',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_heading_font',
		array(
			'label'   => __( 'Heading Font', 'edblad-store' ),
			'section' => 'edblad_typography',
			'type'    => 'select',
			'choices' => array(
				'Cormorant Garamond' => __( 'Cormorant Garamond', 'edblad-store' ),
			),
		)
	);

	$wp_customize->add_setting(
		'edblad_body_font',
		array(
			'default'           => 'DM Sans',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_body_font',
		array(
			'label'   => __( 'Body Font', 'edblad-store' ),
			'section' => 'edblad_typography',
			'type'    => 'select',
			'choices' => array(
				'DM Sans' => __( 'DM Sans', 'edblad-store' ),
			),
		)
	);

	/**
	 * Hero Section
	 */
	$wp_customize->add_section(
		'edblad_hero',
		array(
			'title'    => __( 'Hero Section', 'edblad-store' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'edblad_hero_headline',
		array(
			'default'           => 'Jewellery that moves with you.',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_hero_headline',
		array(
			'label'   => __( 'Headline', 'edblad-store' ),
			'section' => 'edblad_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'edblad_hero_cta_text',
		array(
			'default'           => 'Discover the collection',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_hero_cta_text',
		array(
			'label'   => __( 'CTA Button Text', 'edblad-store' ),
			'section' => 'edblad_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'edblad_hero_video_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_hero_video_url',
		array(
			'label'       => __( 'Hero Video URL', 'edblad-store' ),
			'description' => __( 'Direct link to an MP4 file. Leave blank to show the poster image only.', 'edblad-store' ),
			'section'     => 'edblad_hero',
			'type'        => 'url',
		)
	);

	/**
	 * Footer
	 */
	$wp_customize->add_section(
		'edblad_footer',
		array(
			'title'    => __( 'Footer', 'edblad-store' ),
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'edblad_footer_newsletter_heading',
		array(
			'default'           => 'Join the list',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_footer_newsletter_heading',
		array(
			'label'   => __( 'Newsletter Heading', 'edblad-store' ),
			'section' => 'edblad_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'edblad_footer_copyright',
		array(
			'default'           => '&copy; 2026 Edblad. All rights reserved.',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'edblad_footer_copyright',
		array(
			'label'   => __( 'Copyright Text', 'edblad-store' ),
			'section' => 'edblad_footer',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'edblad_customize_register' );
