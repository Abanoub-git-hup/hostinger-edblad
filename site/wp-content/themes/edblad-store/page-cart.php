<?php
/**
 * Page template override for the WooCommerce Cart page (slug: cart).
 * Routes it through our classic header.php/footer.php instead of the
 * FSE page template, so woocommerce/cart/cart.php renders inside our
 * store chrome. Requires the Cart page to use the [woocommerce_cart]
 * shortcode rather than the block-based Cart block — see README.md.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php
get_footer();
