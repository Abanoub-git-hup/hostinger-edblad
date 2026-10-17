<?php
/**
 * Title: Hero Section
 * Slug: edblad/hero
 * Categories: featured
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$edblad_hero_headline  = get_theme_mod( 'edblad_hero_headline', 'Jewellery that moves with you.' );
$edblad_hero_cta_text  = get_theme_mod( 'edblad_hero_cta_text', 'Discover the collection' );
$edblad_hero_video_url = get_theme_mod( 'edblad_hero_video_url', '' );
$edblad_hero_poster    = 'https://placehold.co/1600x900?text=Hero+16%3A9+Poster';

$edblad_cover_attrs = array(
	'url'             => $edblad_hero_video_url ? esc_url_raw( $edblad_hero_video_url ) : esc_url_raw( $edblad_hero_poster ),
	'useFeaturedImage' => false,
	'dimRatio'        => 40,
	'minHeight'       => 100,
	'minHeightUnit'   => 'vh',
	'contentPosition' => 'center center',
	'isDark'          => true,
	'align'           => 'full',
);

if ( $edblad_hero_video_url ) {
	$edblad_cover_attrs['backgroundType'] = 'video';
}
?>
<!-- wp:cover <?php echo wp_json_encode( $edblad_cover_attrs ); ?> -->
<div class="wp-block-cover alignfull is-dark-theme" style="min-height:100vh">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim-40 has-background-dim"></span>
	<?php if ( $edblad_hero_video_url ) : ?>
		<video class="wp-block-cover__video-background" autoplay muted loop playsinline poster="<?php echo esc_url( $edblad_hero_poster ); ?>" src="<?php echo esc_url( $edblad_hero_video_url ); ?>"></video>
	<?php else : ?>
		<img class="wp-block-cover__image-background" src="<?php echo esc_url( $edblad_hero_poster ); ?>" alt="" data-object-fit="cover">
	<?php endif; ?>
	<div class="wp-block-cover__inner-container">

		<!-- wp:heading {"textAlign":"center","level":1,"fontFamily":"heading","style":{"typography":{"fontWeight":"300"}}} -->
		<h1 class="wp-block-heading has-text-align-center has-heading-font-family" style="font-weight:300"><?php echo esc_html( $edblad_hero_headline ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/shop/"><?php echo esc_html( $edblad_hero_cta_text ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
</div>
<!-- /wp:cover -->
