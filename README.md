# American EV Solutions theme

Custom classic WordPress theme based on the approved Superdesign commercial charging homepage.

## Editing the homepage

The homepage is the published **Home** page. Edit it in WordPress and use the **American EV Homepage** field panel to update the hero, section headings, descriptions, images, email address, and phone number. A standard WordPress custom logo can be set under Appearance.

If an ACF value is left empty, the theme keeps the approved default copy and bundled artwork.

## Quote requests

The quote form validates requests with a WordPress nonce and honeypot, emails the site's contact address, and stores a private backup under **Quote Requests** in the dashboard. Production email delivery still depends on the host's mail configuration; an SMTP plugin is recommended before launch.

## WooCommerce

WooCommerce support, product-gallery features, catalog/cart/checkout styling, and a Parts-to-Shop link are included. The cart link appears in the header when the cart contains an item.

## GitHub theme updates

The bundled Plugin Update Checker (the same library used by the Alfred Basta theme)
checks `https://github.com/naderbassily/American-EV/` on `main` for newer versions.
This public repository does not require a GitHub token.

### One-time installation on Hostinger

1. Back up the live site and confirm the active theme folder is `american-ev-solutions`.
2. In WordPress, open **Appearance → Themes → Add New Theme → Upload Theme** and upload
   `american-ev-solutions-1.3.1.zip`. Choose **Replace current with uploaded** for the existing theme.
3. Open the theme details and select **Enable auto-updates** if updates should install
   automatically. Otherwise, install available updates manually through WordPress.

### Publishing future changes

1. Update the theme code and increment both `Version` in `style.css` and
   `AEV_THEME_VERSION` in `functions.php` to the same higher version.
2. Validate the changes, commit, and push to GitHub `main`.
3. WordPress checks periodically (the library defaults to every 12 hours), then
   offers the new version. Automatic installation also depends on WordPress cron
   and the host allowing automatic updates; a GitHub push is not an instant deployment.

Keep live theme code changes in GitHub because theme updates replace theme files.
WordPress pages, settings, and uploads are stored separately from this theme.

## Main theme files

- `front-page.php` — homepage sections and quote form
- `functions.php` — setup, ACF fields, WooCommerce support, and form processing
- `style.css` — design system and responsive styling
- `assets/js/theme.js` — accessible mobile navigation
- `assets/images/` — bundled reference logo and commercial charging artwork
