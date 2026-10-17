<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$edblad_is_hero_context = is_front_page();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class( $edblad_is_hero_context ? 'has-transparent-header' : '' ); ?>>
<?php wp_body_open(); ?>

<div class="site-announcement" data-announcement>
	<p class="text-label"><?php echo esc_html( get_theme_mod( 'edblad_announcement_text', 'Swedish design · Bestsellers · Free delivery over €60' ) ); ?></p>
	<button class="site-announcement__close" data-announcement-close aria-label="<?php esc_attr_e( 'Dismiss announcement', 'edblad-store' ); ?>">&times;</button>
</div>

<header class="site-header<?php echo $edblad_is_hero_context ? ' site-header--transparent-context' : ''; ?>" data-site-header>
	<div class="container site-header__inner">
		<button class="site-header__toggle" data-menu-toggle aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'edblad-store' ); ?>">
			<span class="site-header__toggle-icon"></span>
		</button>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" aria-label="<?php esc_attr_e( 'Edblad home', 'edblad-store' ); ?>">
			<svg class="site-header__logo-mark" viewBox="0 0 160 28" role="img" aria-label="Edblad">
				<text x="0" y="21" font-family="'Cormorant Garamond', serif" font-size="24" letter-spacing="2" fill="currentColor">EDBLAD</text>
			</svg>
		</a>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-header__nav',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		?>

		<div class="site-header__icons">
			<button class="site-header__icon-btn" aria-label="<?php esc_attr_e( 'Search', 'edblad-store' ); ?>">
				<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			</button>
			<a class="site-header__icon-btn" href="<?php echo function_exists( 'wc_get_account_url' ) ? esc_url( wc_get_account_url() ) : esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Account', 'edblad-store' ); ?>">
				<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 20c0-4 4-6 8-6s8 2 8 6"></path></svg>
			</a>
			<a class="site-header__icon-btn" href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'edblad-store' ); ?>">
				<svg viewBox="0 0 24 24"><path d="M6 8h12l-1 12H7L6 8Z"></path><path d="M9 8V6a3 3 0 0 1 6 0v2"></path></svg>
				<span class="site-header__bag-count"><?php echo ( function_exists( 'WC' ) && WC()->cart ) ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?></span>
			</a>
		</div>
	</div>

	<nav id="mobile-nav" class="mobile-nav" data-mobile-nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'edblad-store' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => has_nav_menu( 'mobile' ) ? 'mobile' : 'primary',
				'container'      => false,
				'menu_class'     => 'mobile-nav__list',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
</header>
