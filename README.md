# American EV Solutions theme

Custom classic WordPress theme based on the approved Superdesign commercial charging homepage.

## Editing the homepage

The homepage is the published **Home** page. Edit it in WordPress and use the **American EV Homepage** field panel to update the hero, section headings, descriptions, images, email address, and phone number. A standard WordPress custom logo can be set under Appearance.

If an ACF value is left empty, the theme keeps the approved default copy and bundled artwork.

## Quote requests

The quote form validates requests with a WordPress nonce and honeypot, emails the site's contact address, and stores a private backup under **Quote Requests** in the dashboard. Production email delivery still depends on the host's mail configuration; an SMTP plugin is recommended before launch.

## WooCommerce

WooCommerce support, product-gallery features, catalog/cart/checkout styling, and a Parts-to-Shop link are included. The cart link appears in the header when the cart contains an item.

## Main theme files

- `front-page.php` — homepage sections and quote form
- `functions.php` — setup, ACF fields, WooCommerce support, and form processing
- `style.css` — design system and responsive styling
- `assets/js/theme.js` — accessible mobile navigation
- `assets/images/` — bundled reference logo and commercial charging artwork
