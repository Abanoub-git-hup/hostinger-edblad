<?php
/**
 * Cart page template.
 * Adapted from WooCommerce core templates/cart/cart.php.
 * Replaces the default <table> line-item markup with our own cart-item
 * cards, but keeps every core hook, nonce, and cart function call so
 * AJAX quantity updates, item removal, and shipping calculation keep
 * working exactly as WooCommerce expects.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$edblad_free_shipping_threshold = 60;
$edblad_cart_subtotal           = (float) WC()->cart->get_subtotal();
$edblad_remaining               = max( 0, $edblad_free_shipping_threshold - $edblad_cart_subtotal );
$edblad_progress_pct            = min( 100, ( $edblad_cart_subtotal / $edblad_free_shipping_threshold ) * 100 );
?>

<div class="cart-intro">
	<h1><?php esc_html_e( 'Your cart', 'edblad-store' ); ?></h1>
</div>

<div class="shipping-bar">
	<p class="shipping-bar__message text-caption">
		<?php if ( $edblad_remaining > 0 ) : ?>
			<?php
			printf(
				/* translators: %s: remaining amount formatted as price */
				esc_html__( 'Add %s more for free delivery.', 'edblad-store' ),
				wp_kses_post( wc_price( $edblad_remaining ) )
			);
			?>
		<?php else : ?>
			<?php esc_html_e( 'Free delivery unlocked.', 'edblad-store' ); ?>
		<?php endif; ?>
	</p>
	<div class="shipping-bar__track" role="progressbar" aria-label="<?php esc_attr_e( 'Progress toward free delivery', 'edblad-store' ); ?>" aria-valuenow="<?php echo esc_attr( round( $edblad_progress_pct ) ); ?>" aria-valuemin="0" aria-valuemax="100">
		<div class="shipping-bar__fill" style="width: <?php echo esc_attr( round( $edblad_progress_pct ) ); ?>%;"></div>
	</div>
</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="cart">
		<div class="cart__items">
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					continue;
				}

				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<article class="cart-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
					<div class="cart-item__media">
						<?php
						$edblad_thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
						echo wp_kses_post( $edblad_thumbnail );
						?>
					</div>
					<div class="cart-item__body">
						<p class="cart-item__name">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
							} else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}
							?>
						</p>

						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

						<div class="cart-item__row">
							<div class="cart-item__qty">
								<?php
								if ( $_product->is_sold_individually() ) {
									$edblad_quantity_html = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', esc_attr( $cart_item_key ) );
								} else {
									$edblad_quantity_html = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}
								echo apply_filters( 'woocommerce_cart_item_quantity', $edblad_quantity_html, $cart_item_key, $cart_item );
								?>
							</div>
							<p class="text-price">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</p>
						</div>

						<div class="cart-item__row">
							<?php
							echo apply_filters(
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="cart-item__remove text-caption remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr__( 'Remove this item', 'edblad-store' ),
									esc_attr( $product_id ),
									esc_attr( $cart_item_key ),
									esc_attr( $_product->get_sku() ),
									esc_html__( 'Remove', 'edblad-store' )
								),
								$cart_item_key
							);
							?>
						</div>
					</div>
				</article>
				<?php
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<div class="gift-message">
				<input type="checkbox" id="gift-toggle" class="visually-hidden">
				<label class="gift-message__label" for="gift-toggle">
					<span aria-hidden="true">+</span>
					<span><?php esc_html_e( 'Add a gift message', 'edblad-store' ); ?></span>
				</label>
				<label class="visually-hidden" for="gift-note"><?php esc_html_e( 'Gift message', 'edblad-store' ); ?></label>
				<textarea id="gift-note" class="gift-message__field" name="edblad_gift_message" placeholder="<?php esc_attr_e( 'Write a short note. We will include it in the box.', 'edblad-store' ); ?>"></textarea>
			</div>

			<div class="cart-actions">
				<button type="submit" class="btn btn--secondary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'edblad-store' ); ?>"><?php esc_html_e( 'Update cart', 'edblad-store' ); ?></button>
				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</div>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</div>

		<aside class="summary">
			<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

			<h2 class="summary__heading"><?php esc_html_e( 'Order summary', 'edblad-store' ); ?></h2>

			<div class="summary__row">
				<span><?php esc_html_e( 'Subtotal', 'edblad-store' ); ?></span>
				<span><?php wc_cart_totals_subtotal_html(); ?></span>
			</div>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<?php do_action( 'woocommerce_cart_totals_shipping' ); ?>
			<?php endif; ?>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="summary__row">
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
					<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</div>
			<?php endforeach; ?>

			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<div class="summary__row">
					<span><?php echo esc_html( $fee->name ); ?></span>
					<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</div>
			<?php endforeach; ?>

			<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="summary__row">
						<span><?php echo esc_html( $tax->label ); ?></span>
						<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="summary__row summary__row--total">
				<span><?php esc_html_e( 'Total', 'edblad-store' ); ?></span>
				<span><?php wc_cart_totals_order_total_html(); ?></span>
			</div>

			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--ghost summary__continue"><?php esc_html_e( 'Continue shopping', 'edblad-store' ); ?></a>

			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</aside>
	</div>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
