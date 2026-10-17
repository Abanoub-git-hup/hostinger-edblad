<?php
/**
 * Fallback classic template.
 * WordPress requires every theme to have this file. In this hybrid
 * theme it only serves as a last-resort fallback for a request that
 * matches nothing else in the classic template hierarchy — content
 * pages route through the FSE templates/ directory, and store pages
 * route through woocommerce/ and the page-cart.php / page-checkout.php
 * overrides.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main>
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</article>
				<?php
			endwhile;
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'edblad-store' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
