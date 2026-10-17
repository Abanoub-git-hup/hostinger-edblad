<?php
/**
 * Checkout form template.
 * Adapted from WooCommerce core templates/checkout/form-checkout.php.
 * Restructures the two default column groups (customer details, order
 * review) into our own two-column grid. Order review, payment gateway
 * list, terms checkbox, and the Place Order button are left to fire via
 * their normal core hooks (checkout/review-order.php) rather than
 * reimplemented — that preserves nonces and gateway JS bindings.
 *
 * @var WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'edblad-store' ) ) );
	return;
}
?>

<h1 class="checkout-intro"><?php esc_html_e( 'Checkout', 'edblad-store' ); ?></h1>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="checkout-grid">

		<div class="checkout-grid__billing">
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<?php do_action( 'woocommerce_checkout_billing' ); ?>

				<?php do_action( 'woocommerce_checkout_shipping' ); ?>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
		</div>

		<div class="checkout-grid__order">

			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

			<h2 id="order_review_heading"><?php esc_html_e( 'Your order', 'edblad-store' ); ?></h2>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<div class="checkout-payment-icons">
				<span class="text-caption">Klarna</span>
				<span class="text-caption">Stripe</span>
				<span class="text-caption">PayPal</span>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
