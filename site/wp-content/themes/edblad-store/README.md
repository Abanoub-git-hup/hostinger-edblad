# Edblad Store — Theme Handoff

A hybrid WordPress theme: Full Site Editing for content pages (Home, About, Contact), custom PHP templates for WooCommerce store pages (Shop, Product, Cart, Checkout).

## 1. Install and activate the theme

1. Zip the `edblad-store` folder (the folder itself, not its contents, should be at the root of the zip).
2. In wp-admin, go to **Appearance → Themes → Add New → Upload Theme**, upload the zip, then **Activate**.
3. Install and activate **WooCommerce** first if it isn't already active — several theme files check for it and will silently skip WooCommerce-specific behavior if it's missing, so the site won't break, but the store won't work until WooCommerce is on.
4. During WooCommerce's setup wizard, let it create the default **Cart**, **Checkout**, **My Account**, and **Shop** pages.

## 2. Install required plugins

| Plugin | Why |
|---|---|
| **WooCommerce** | Core — the entire store layer depends on it. |
| **WPML** or **Polylang** | Multilingual support (brief requires WPML-ready). The theme's language switcher in the footer auto-detects WPML if active; Polylang works but won't show the switcher without a small filter addition. |
| **Contact Form 7** or **WPForms** | The Contact page's form in the static design is plain HTML — pick one of these and either replace the form block with the plugin's shortcode/block, or wire the plugin's submit handler to the existing form markup. |
| **Mailchimp for WordPress** (or equivalent ESP plugin) | The footer newsletter form posts to `admin-post.php?action=edblad_newsletter_signup` and fires `edblad_before_newsletter_fields` / `edblad_after_newsletter_fields` action hooks specifically so a newsletter plugin can inject its own hidden fields and handle the submission. No email list is wired up by default — that's plugin territory. |
| **Instagram feed plugin** (e.g. Smash Balloon, or WP Instagram Widget) | The homepage Instagram Grid pattern (`patterns/instagram-grid.php`) currently uses static placeholder images. Swap its `wp:html` block content for the plugin's shortcode/block once connected, or ask your developer to wire the plugin's API into that pattern. |
| **Store locator plugin** (e.g. WP Store Locator) | The Contact page's map/store list in the original static design was a placeholder image and hardcoded addresses — no map plugin is wired in yet. Install one and embed it in the Contact page content via the block editor. |

## 3. Configure the Customizer

Go to **Appearance → Customize**:

- **Announcement Bar** — the scrolling text at the very top (only affects WooCommerce pages; on the FSE Home/About/Contact pages, edit the announcement text directly in the header template part instead — see note below).
- **Brand Colors** — Primary, Accent, Background. Changing these only affects the three raw CSS custom properties; the semantic tokens (text/surface/border) derive from them automatically.
- **Typography** — locked to Cormorant Garamond (headings) and DM Sans (body), since those are the only two fonts actually loaded.
- **Hero Section** — headline, CTA button text, and an optional video URL (direct link to an `.mp4` file). Leave the video URL blank to show a static poster image instead.
- **Footer** — newsletter heading and copyright text (again, WooCommerce pages only — see note below).

**Important limitation:** the announcement bar text and footer copyright text are pulled from the Customizer only on classic-templated WooCommerce pages (Shop, Product, Cart, Checkout). The FSE pages (Home, About, Contact) use `parts/header.html` and `parts/footer.html`, which are static block templates — WordPress can't run PHP inside them to pull a Customizer value. If you change the announcement or copyright text, also open **Appearance → Editor → Header/Footer** and update the text there directly (it's an ordinary editable paragraph block).

## 4. Configure WooCommerce settings

Go to **WooCommerce → Settings**:

- **General → Currency**: set to **Euro (€)**. The theme also force-enforces EUR with no decimals in code (`inc/woo-hooks.php`) so pricing matches the brand design regardless, but keep the setting consistent to avoid confusing the admin order screens.
- **General → Selling locations / Shipping zones**: set up your shipping zones and a flat or free-shipping method. The cart's "free delivery over €60" progress bar is a fixed threshold in `woocommerce/cart/cart.php` (`$edblad_free_shipping_threshold = 60`) — update that constant if the real threshold differs from your actual shipping zone rules.
- **Payments**: enable **Klarna**, **Stripe**, and **PayPal** (via their respective official WooCommerce extensions/gateways). The checkout page displays these three as labels regardless of which are active — remove any you don't actually enable from `woocommerce/checkout/form-checkout.php`.
- **Advanced → Page setup**: confirm Cart and Checkout pages are assigned.
- **Advanced → Cart & Checkout blocks**: this theme's custom Cart/Checkout templates only render if those pages use the **classic shortcodes** `[woocommerce_cart]` and `[woocommerce_checkout]`. If your WooCommerce version defaults new installs to the block-based Cart/Checkout, edit both pages and swap the block for the shortcode (or the "Classic Cart"/"Classic Checkout" block if offered). Otherwise, the block-based cart/checkout will render instead of `woocommerce/cart/cart.php` and `woocommerce/checkout/form-checkout.php`, bypassing the custom design entirely.
- **Products → Inventory**: configure stock display as needed; the product card and single product page both respect WooCommerce's native stock status.

## 5. Set up Menus

Go to **Appearance → Menus** and create three menus, then assign each to its location:

- **Primary Menu** → location "Primary Menu". Flat links: Shop, Collections, About, Stores.
- **Mobile Menu** → location "Mobile Menu". Usually the same links as Primary; if left unassigned, the mobile drawer automatically falls back to the Primary menu.
- **Footer Menu** → location "Footer Menu". This one must be built with **three top-level parent items** — Shop, About, Customer Care — each with **child links** nested under it (drag child items to the right in the menu editor). The top-level items become column headings; children become the links in each column. A parent item with no children won't render its heading properly, so don't leave one empty.

## 6. Add products with correct variant setup (Gold / Silver)

1. **Products → Attributes**, create an attribute called **Finish** (or similar) with terms **Gold** and **Silver**.
2. When creating a product, set **Product data → Variable product**, add the Finish attribute, check "Used for variations," and generate variations for Gold and Silver (set price/SKU/stock per variation as needed).
3. The variation selector renders as circular swatches automatically — gold-toned for any term containing the word "gold" (case-insensitive), grey for anything else. No further setup needed.
4. **Product card material line**: add a custom field `_edblad_material` (via a custom fields UI, or ACF, or the block editor's custom fields panel) with text like "14K gold-plated stainless steel." If left blank, the theme falls back to the product's short description.
5. **Material & Care / Size Guide tabs**: add custom fields `_edblad_material_care` and `_edblad_size_guide` per product for tab-specific copy. If blank, generic fallback copy is shown.
6. **Sale badge**: set a Sale price on the product — the "Sale" badge appears automatically top-right on the product card.

## 7. Edit homepage content via the block editor

The homepage (`templates/home.html`) is built from six patterns, each independently editable:

- **Hero** — headline/CTA text come from the Customizer (Hero section), not the block editor directly.
- **New Arrivals** / **Bestsellers** — these are live WooCommerce Products blocks (Recent Products / Best Selling Products), so they update automatically as you add products. No manual editing needed.
- **Category Tiles**, **Editorial Trio**, **Instagram Grid** — open **Appearance → Editor → Home** to edit these visually: replace placeholder images, rewrite headlines and body copy, and update links directly in the block editor.

To edit **About** or **Contact**, go to **Pages** in wp-admin and edit them like any normal WordPress page — the block editor content is what renders inside `templates/page.html`.

---

## Full file list

```
edblad-store/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── page-cart.php
├── page-checkout.php
├── theme.json
├── README.md
├── inc/
│   ├── theme-setup.php
│   ├── enqueue.php
│   ├── woo-hooks.php
│   └── customizer.php
├── assets/
│   ├── css/woocommerce.css
│   └── js/main.js
├── parts/
│   ├── header.html
│   └── footer.html
├── templates/
│   ├── index.html
│   ├── home.html
│   ├── page.html
│   └── 404.html
├── patterns/
│   ├── hero.php
│   ├── new-arrivals.php
│   ├── category-tiles.php
│   ├── bestsellers.php
│   ├── editorial-trio.php
│   └── instagram-grid.php
└── woocommerce/
    ├── archive-product.php
    ├── content-product.php
    ├── single-product.php
    ├── cart/cart.php
    └── checkout/form-checkout.php
```

`page-cart.php` and `page-checkout.php` route the WooCommerce Cart/Checkout pages through the classic `header.php`/`footer.php` rather than the FSE page template — without them, Cart/Checkout would render inside the FSE header/footer instead of the intended store chrome.
