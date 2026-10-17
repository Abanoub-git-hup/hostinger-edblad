<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disable WooCommerce's bundled frontend stylesheets so assets/css/woocommerce.css
 * has full, conflict-free control of every store page's appearance.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Remove default WooCommerce breadcrumbs.
 * Core registers this at priority 20 on woocommerce_before_main_content.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove default WooCommerce shop/archive page title.
 * Our custom archive-product.php supplies its own heading markup instead.
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Remove default WooCommerce sidebar.
 * Core registers this at priority 10 on woocommerce_sidebar.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Brand the loop add-to-cart button as a circular gold overlay control.
 * Positioning (absolute, bottom-left over the product image) lives in
 * assets/css/woocommerce.css; this filter only shapes the markup/classes
 * so the button is branded consistently anywhere WooCommerce's default
 * loop renders it (widgets, shortcodes, search results), independent of
 * the fully custom content-product.php used on the shop and related loops.
 */
function edblad_loop_add_to_cart_args( $args, $product ) {
	$existing_classes = isset( $args['class'] ) ? $args['class'] : '';
	$args['class']    = trim( $existing_classes . ' product-card__add' );
	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'edblad_loop_add_to_cart_args', 10, 2 );

function edblad_loop_add_to_cart_link( $html, $product, $args ) {
	if ( false === strpos( $html, 'product-card__add' ) ) {
		return $html;
	}

	$icon = '<svg class="product-card__add-icon" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

	return str_replace( $args['before'] . $args['before_add_to_cart_text'], $args['before'] . $icon, $html );
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'edblad_loop_add_to_cart_link', 10, 3 );

/**
 * Price format: plain EUR symbol, no decimals, symbol before the number.
 * Enforced in code so it matches the brand brief regardless of what is
 * selected in WooCommerce > Settings > General.
 */
add_filter( 'wc_get_price_decimals', function () {
	return 0;
}, 10 );

add_filter( 'woocommerce_currency', function () {
	return 'EUR';
}, 10 );

add_filter( 'woocommerce_currency_pos', function () {
	return 'left';
}, 10 );

/**
 * Keep the header cart count live via WooCommerce's AJAX cart fragments,
 * so the number updates after add-to-cart without a page reload.
 */
function edblad_cart_count_fragment( $fragments ) {
	ob_start();
	?>
	<span class="site-header__bag-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
	<?php
	$fragments['span.site-header__bag-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'edblad_cart_count_fragment', 10, 1 );

/**
 * Swap the default <ul class="products"> loop wrapper for our own
 * grid container, while still calling the core loop start/end functions
 * (archive-product.php and content-product.php rely on this).
 */
add_filter( 'woocommerce_product_loop_start', function () {
	return '<div class="grid--product">';
} );
add_filter( 'woocommerce_product_loop_end', function () {
	return '</div>';
} );

/**
 * Render variation attribute selectors (e.g. Finish: Gold / Silver) as
 * circular swatches instead of WooCommerce's default <select> dropdown.
 * Reuses WooCommerce's own computed field name so its core variation
 * matching script (wc-add-to-cart-variation) still detects the selection.
 */
function edblad_variation_swatches( $html, $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'options'   => false,
			'attribute' => false,
			'product'   => false,
			'selected'  => false,
			'name'      => '',
			'id'        => '',
		)
	);

	if ( empty( $args['options'] ) || empty( $args['attribute'] ) || ! ( $args['product'] instanceof WC_Product ) ) {
		return $html;
	}

	$product   = $args['product'];
	$attribute = $args['attribute'];
	$options   = $args['options'];
	$selected  = $args['selected'];
	$name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );

	if ( taxonomy_exists( $attribute ) ) {
		$terms         = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
		$swatch_source = 'taxonomy';
	} else {
		$terms         = $options;
		$swatch_source = 'custom';
	}

	ob_start();
	?>
	<fieldset class="product__variants" role="radiogroup" aria-label="<?php echo esc_attr( wc_attribute_label( $attribute ) ); ?>">
		<legend class="visually-hidden"><?php echo esc_html( wc_attribute_label( $attribute ) ); ?></legend>
		<?php foreach ( $terms as $edblad_term ) : ?>
			<?php
			$term_slug = 'taxonomy' === $swatch_source ? $edblad_term->slug : sanitize_title( $edblad_term );
			$term_name = 'taxonomy' === $swatch_source ? $edblad_term->name : $edblad_term;

			if ( ! in_array( $term_slug, $options, true ) ) {
				continue;
			}

			$swatch_color = ( false !== stripos( $term_name, 'gold' ) ) ? 'var(--color-gold)' : '#c7c7c9';
			?>
			<label class="product__variant">
				<input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $term_slug ); ?>" class="visually-hidden" <?php checked( $selected, $term_slug ); ?>>
				<span class="product__swatch" style="--swatch-color: <?php echo esc_attr( $swatch_color ); ?>;"></span>
				<span class="product__variant-label"><?php echo esc_html( $term_name ); ?></span>
			</label>
		<?php endforeach; ?>
	</fieldset>
	<?php
	return ob_get_clean();
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'edblad_variation_swatches', 10, 2 );

/**
 * Rename and extend the single-product tabs to match the brief:
 * Description / Material and Care / Size Guide / Delivery and Returns.
 */
function edblad_product_tabs( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = __( 'Description', 'edblad-store' );
	}
	unset( $tabs['additional_information'] );

	$tabs['material_care'] = array(
		'title'    => __( 'Material and Care', 'edblad-store' ),
		'priority' => 20,
		'callback' => 'edblad_product_tab_material_care',
	);
	$tabs['size_guide'] = array(
		'title'    => __( 'Size Guide', 'edblad-store' ),
		'priority' => 30,
		'callback' => 'edblad_product_tab_size_guide',
	);
	$tabs['delivery_returns'] = array(
		'title'    => __( 'Delivery and Returns', 'edblad-store' ),
		'priority' => 40,
		'callback' => 'edblad_product_tab_delivery_returns',
	);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'edblad_product_tabs' );

function edblad_product_tab_material_care() {
	global $product;
	$content = get_post_meta( $product->get_id(), '_edblad_material_care', true );
	echo wp_kses_post( wpautop( $content ? $content : __( 'Store away from moisture and perfume. Polish gently with a soft cloth. Avoid chlorine and saltwater.', 'edblad-store' ) ) );
}

function edblad_product_tab_size_guide() {
	global $product;
	$content = get_post_meta( $product->get_id(), '_edblad_size_guide', true );
	echo wp_kses_post( wpautop( $content ? $content : __( 'Chain length and fit vary by piece. See the product description for exact measurements.', 'edblad-store' ) ) );
}

function edblad_product_tab_delivery_returns() {
	echo wp_kses_post( wpautop( __( 'Dispatched within one to two working days. Standard delivery takes two to four days. Free over &euro;60. Returns accepted within 30 days.', 'edblad-store' ) ) );
}
