<?php
/**
 * Title: New Arrivals
 * Slug: edblad/new-arrivals
 * Categories: featured
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|6","bottom":"var:preset|spacing|6"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--6);padding-bottom:var(--wp--preset--spacing--6)">

	<!-- wp:paragraph {"align":"center","className":"text-label section__label"} -->
	<p class="has-text-align-center text-label section__label">New in</p>
	<!-- /wp:paragraph -->

	<!-- wp:woocommerce/product-new {"columns":4,"rows":2,"limit":8,"align":"wide"} /-->

</div>
<!-- /wp:group -->
