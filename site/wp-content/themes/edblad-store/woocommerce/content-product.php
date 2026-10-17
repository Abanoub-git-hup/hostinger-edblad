<?php
/**
 * Product card template, used by the shop loop, related products,
 * up-sells, and anywhere else WooCommerce calls content-product.php.
 * Adapted from WooCommerce core templates/content-product.php.
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$edblad_primary_image_id   = $product->get_image_id();
$edblad_gallery_ids        = $product->get_gallery_image_ids();
$edblad_secondary_image_id = ! empty( $edblad_gallery_ids ) ? $edblad_gallery_ids[0] : $edblad_primary_image_id;

$edblad_material = get_post_meta( $product->get_id(), '_edblad_material', true );
if ( ! $edblad_material ) {
	$edblad_material = wp_strip_all_tags( $product->get_short_description() );
}
?>
<article <?php wc_product_class( 'product-card', $product ); ?>>

	<div class="product-card__media-wrap">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-card__image-link" aria-hidden="true" tabindex="-1">
			<div class="product-card__media" data-hover-media>
				<?php if ( $product->is_on_sale() ) : ?>
					<span class="product-card__badge"><?php esc_html_e( 'Sale', 'edblad-store' ); ?></span>
				<?php endif; ?>

				<?php
				echo wp_get_attachment_image(
					$edblad_primary_image_id,
					'woocommerce_thumbnail',
					false,
					array(
						'class' => 'product-card__image product-card__image--primary',
						'alt'   => esc_attr( $product->get_name() ),
					)
				);

				echo wp_get_attachment_image(
					$edblad_secondary_image_id,
					'woocommerce_thumbnail',
					false,
					array(
						'class' => 'product-card__image product-card__image--secondary',
						'alt'   => '',
					)
				);
				?>
			</div>
		</a>

		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-card__info-link">
		<div class="product-card__info">
			<h2 class="product-card__name"><?php echo esc_html( $product->get_name() ); ?></h2>
			<?php if ( $edblad_material ) : ?>
				<p class="product-card__variant text-caption"><?php echo esc_html( $edblad_material ); ?></p>
			<?php endif; ?>
			<p class="product-card__price text-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
		</div>
	</a>

</article>
