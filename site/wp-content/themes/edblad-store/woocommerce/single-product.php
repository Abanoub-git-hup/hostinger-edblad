<?php
/**
 * Single product template.
 * Adapted from WooCommerce core templates/single-product.php +
 * content-single-product.php, merged into one file with our own
 * two-column wrapper. Keeps the core hook architecture — gallery,
 * summary (title/price/short description/add-to-cart), tabs, and
 * related products all still fire via their normal WooCommerce hooks,
 * just inside our own grid markup. Variation swatches and renamed tabs
 * are handled by filters in inc/woo-hooks.php.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main>
	<div class="container">

		<?php while ( have_posts() ) : the_post(); global $product; ?>

			<nav class="breadcrumb text-caption" aria-label="<?php esc_attr_e( 'Breadcrumb', 'edblad-store' ); ?>">
				<?php woocommerce_breadcrumb(); ?>
			</nav>

			<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

				<?php do_action( 'woocommerce_before_single_product' ); ?>

				<section class="product">
					<div class="product__gallery">
						<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
					</div>
					<div class="product__info">
						<?php do_action( 'woocommerce_single_product_summary' ); ?>
					</div>
				</section>

				<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

				<?php do_action( 'woocommerce_after_single_product' ); ?>
			</div>

		<?php endwhile; ?>

	</div>
</main>

<?php
get_footer();
