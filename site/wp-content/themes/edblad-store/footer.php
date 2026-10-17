<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Edblad_Footer_Nav_Walker' ) ) {
	/**
	 * Renders a two-level "footer" menu as labeled columns:
	 * top-level items become column headings, their children become links.
	 * Appearance > Menus > Footer Menu must be built with Shop / About /
	 * Customer Care as parent items, each with the relevant child links.
	 */
	class Edblad_Footer_Nav_Walker extends Walker_Nav_Menu {

		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$output .= '<ul class="site-footer__list">';
		}

		public function end_lvl( &$output, $depth = 0, $args = null ) {
			$output .= '</ul></div>';
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			if ( 0 === $depth ) {
				$output .= '<div class="site-footer__column"><h3 class="site-footer__heading">' . esc_html( $item->title ) . '</h3>';
			} else {
				$output .= '<li><a class="site-footer__link" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
			}
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			if ( 1 === $depth ) {
				$output .= '</li>';
			}
		}
	}
}
?>
	</main>

	<footer class="site-footer">
		<div class="container">
			<div class="site-footer__grid">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'walker'         => new Edblad_Footer_Nav_Walker(),
						'fallback_cb'    => false,
					)
				);
				?>

				<div class="site-footer__column">
					<h3 class="site-footer__heading"><?php echo esc_html( get_theme_mod( 'edblad_footer_newsletter_heading', 'Join the list' ) ); ?></h3>
					<p class="text-caption" style="margin-bottom: var(--space-3);"><?php esc_html_e( 'Quiet updates. New arrivals, early access, nothing more.', 'edblad-store' ); ?></p>

					<form class="site-footer__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
						<?php do_action( 'edblad_before_newsletter_fields' ); ?>
						<input type="hidden" name="action" value="edblad_newsletter_signup">
						<?php wp_nonce_field( 'edblad_newsletter_signup', 'edblad_newsletter_nonce' ); ?>
						<label class="visually-hidden" for="newsletter-email"><?php esc_html_e( 'Email address', 'edblad-store' ); ?></label>
						<input class="site-footer__input" id="newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Email', 'edblad-store' ); ?>" required>
						<?php do_action( 'edblad_after_newsletter_fields' ); ?>
						<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Sign up', 'edblad-store' ); ?></button>
					</form>

					<div class="site-footer__socials">
						<a href="https://www.instagram.com/edbladofficial" aria-label="<?php esc_attr_e( 'Edblad on Instagram', 'edblad-store' ); ?>">
							<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.5"></circle></svg>
						</a>
						<a href="https://www.facebook.com/edblad" aria-label="<?php esc_attr_e( 'Edblad on Facebook', 'edblad-store' ); ?>">
							<svg viewBox="0 0 24 24"><path d="M15 4h-2a4 4 0 0 0-4 4v3H7v4h2v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3V4Z"></path></svg>
						</a>
						<a href="https://www.pinterest.com/edblad" aria-label="<?php esc_attr_e( 'Edblad on Pinterest', 'edblad-store' ); ?>">
							<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M9 17c1-2 1.6-4.4 2-6.4A2.6 2.6 0 1 1 15.8 10c0 2-1 5-3.3 5-.8 0-1.4-.4-1.6-1"></path></svg>
						</a>
					</div>
				</div>
			</div>

			<div class="site-footer__bottom">
				<div class="site-footer__bottom-row">
					<p class="text-caption"><?php echo wp_kses_post( get_theme_mod( 'edblad_footer_copyright', '&copy; 2026 Edblad. All rights reserved.' ) ); ?></p>

					<div class="site-footer__payments">
						<span class="text-caption">Klarna</span>
						<span class="text-caption">Visa</span>
						<span class="text-caption">Mastercard</span>
						<span class="text-caption">PayPal</span>
					</div>

					<div class="site-footer__language">
						<?php if ( function_exists( 'icl_get_languages' ) ) : ?>
							<?php $edblad_languages = icl_get_languages( 'skip_missing=0' ); ?>
							<?php foreach ( (array) $edblad_languages as $edblad_lang ) : ?>
								<a class="text-caption" href="<?php echo esc_url( $edblad_lang['url'] ); ?>"><?php echo esc_html( $edblad_lang['native_name'] ); ?></a>
							<?php endforeach; ?>
						<?php else : ?>
							<span class="text-caption">EU / English</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
