<?php
/**
 * Page template override for the WooCommerce Checkout page (slug: checkout).
 * Routes it through our classic header.php/footer.php instead of the
 * FSE page template, so woocommerce/checkout/form-checkout.php renders
 * inside our store chrome. Requires the Checkout page to use the
 * [woocommerce_checkout] shortcode rather than the block-based Checkout
 * block — see README.md.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php
get_footer();
