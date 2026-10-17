<?php
/**
 * The Shop archive template.
 * Adapted from WooCommerce core templates/archive-product.php.
 * Removes core wrappers, sidebar, and page title; adds our filter bar
 * and grid markup. Loop start/end still use core functions — their
 * output is remapped to our grid markup via filters in inc/woo-hooks.php.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main>
	<div class="container">

		<section class="shop-intro">
			<h1 class="shop-intro__heading"><?php woocommerce_page_title(); ?></h1>
			<p class="shop-intro__subheading"><?php esc_html_e( 'Jewellery for every day — in steel, silver and gold.', 'edblad-store' ); ?></p>
		</section>

		<?php
		$edblad_selected_cats = isset( $_GET['product_cat'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['product_cat'] ) ) : array();
		$edblad_product_cats  = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			)
		);
		?>

		<form class="filter-bar" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="get">
			<div class="filter-bar__groups">
				<?php if ( ! empty( $edblad_product_cats ) && ! is_wp_error( $edblad_product_cats ) ) : ?>
					<details class="filter-bar__group">
						<summary class="filter-bar__summary">
							<span><?php esc_html_e( 'Category', 'edblad-store' ); ?></span>
							<svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
						</summary>
						<div class="filter-bar__panel">
							<?php foreach ( $edblad_product_cats as $edblad_term ) : ?>
								<label class="filter-bar__option">
									<input type="checkbox" name="product_cat[]" value="<?php echo esc_attr( $edblad_term->slug ); ?>" <?php checked( in_array( $edblad_term->slug, $edblad_selected_cats, true ) ); ?>>
									<?php echo esc_html( $edblad_term->name ); ?>
								</label>
							<?php endforeach; ?>
						</div>
					</details>
				<?php endif; ?>
			</div>

			<div class="filter-bar__sort">
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</form>

		<?php
		if ( woocommerce_product_loop() ) {

			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			do_action( 'woocommerce_after_shop_loop' );

		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>

		<div class="shop-toolbar">
			<?php woocommerce_pagination(); ?>
		</div>

	</div>
</main>

<?php
get_footer();
