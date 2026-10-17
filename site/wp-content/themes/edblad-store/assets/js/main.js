(function () {
	'use strict';

	var ANNOUNCEMENT_STORAGE_KEY = 'edblad_announcement_dismissed';

	function initStickyHeader() {
		var header = document.querySelector( '[data-site-header]' );
		if ( ! header ) {
			return;
		}

		var isHeroContext = document.body.classList.contains( 'has-transparent-header' );
		var scrollThreshold = isHeroContext ? Math.round( window.innerHeight * 0.6 ) : 40;

		function updateHeaderOnScroll() {
			if ( window.scrollY > scrollThreshold ) {
				header.classList.add( 'site-header--scrolled' );
			} else {
				header.classList.remove( 'site-header--scrolled' );
			}
		}

		window.addEventListener( 'scroll', updateHeaderOnScroll, { passive: true } );
		updateHeaderOnScroll();
	}

	function initMobileMenu() {
		var header = document.querySelector( '[data-site-header]' );
		var menuToggle = document.querySelector( '[data-menu-toggle]' );
		var mobileNav = document.querySelector( '[data-mobile-nav]' );

		if ( ! menuToggle || ! mobileNav ) {
			return;
		}

		menuToggle.addEventListener( 'click', function () {
			var isOpen = mobileNav.classList.toggle( 'mobile-nav--open' );

			if ( header ) {
				header.classList.toggle( 'is-menu-open', isOpen );
			}

			menuToggle.setAttribute( 'aria-expanded', String( isOpen ) );
			menuToggle.setAttribute( 'aria-label', isOpen ? 'Close menu' : 'Open menu' );
		} );
	}

	function initProductHoverSwap() {
		var hoverMediaEls = document.querySelectorAll( '[data-hover-media]' );

		hoverMediaEls.forEach( function ( el ) {
			el.addEventListener( 'mouseenter', function () {
				el.classList.add( 'is-hovered' );
			} );
			el.addEventListener( 'mouseleave', function () {
				el.classList.remove( 'is-hovered' );
			} );
		} );
	}

	function initAnnouncementDismiss() {
		var announcement = document.querySelector( '[data-announcement]' );
		var announcementClose = document.querySelector( '[data-announcement-close]' );

		if ( ! announcement ) {
			return;
		}

		var isDismissed = false;
		try {
			isDismissed = window.localStorage.getItem( ANNOUNCEMENT_STORAGE_KEY ) === '1';
		} catch ( error ) {
			isDismissed = false;
		}

		if ( isDismissed ) {
			announcement.classList.add( 'is-dismissed' );
		}

		if ( announcementClose ) {
			announcementClose.addEventListener( 'click', function () {
				announcement.classList.add( 'is-dismissed' );
				try {
					window.localStorage.setItem( ANNOUNCEMENT_STORAGE_KEY, '1' );
				} catch ( error ) {
					/* localStorage unavailable (private browsing, disabled storage) — dismissal still works for this page view. */
				}
			} );
		}
	}

	function initCartFragmentEnhancement() {
		var cartIcon = document.querySelector( '.site-header__icon-btn .site-header__bag-count' );

		if ( ! cartIcon || typeof window.jQuery === 'undefined' ) {
			return;
		}

		/**
		 * WooCommerce's own wc-cart-fragments.js already replaces the
		 * .site-header__bag-count markup with fresh HTML from the
		 * woocommerce_add_to_cart_fragments filter (see inc/woo-hooks.php).
		 * This only adds a brief visual pulse once that swap happens.
		 */
		window.jQuery( document.body ).on( 'added_to_cart wc_fragments_refreshed', function () {
			var updatedIcon = document.querySelector( '.site-header__icon-btn .site-header__bag-count' );
			if ( ! updatedIcon ) {
				return;
			}
			updatedIcon.classList.add( 'is-updated' );
			window.setTimeout( function () {
				updatedIcon.classList.remove( 'is-updated' );
			}, 300 );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initStickyHeader();
		initMobileMenu();
		initProductHoverSwap();
		initAnnouncementDismiss();
		initCartFragmentEnhancement();
	} );
})();
