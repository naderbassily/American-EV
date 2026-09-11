<?php /** @package AmericanEV */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="container header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'American EV Solutions home', 'american-ev' ); ?>">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/header-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		</a>
		<nav class="primary-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'american-ev' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1 ) );
			} else {
				aev_fallback_menu();
			}
			?>
		</nav>
		<div class="header-actions">
			<?php if ( class_exists( 'WooCommerce' ) && WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
				<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Cart', 'american-ev' ); ?> <span>(<?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>)</span></a>
			<?php endif; ?>
			<a class="btn header-cta" href="<?php echo esc_url( aev_home_anchor( 'contact' ) ); ?>"><?php esc_html_e( 'Request a quote', 'american-ev' ); ?></a>
			<button class="menu-toggle" type="button" aria-controls="primary-navigation" aria-expanded="false"><span></span><span class="screen-reader-text"><?php esc_html_e( 'Toggle menu', 'american-ev' ); ?></span></button>
		</div>
	</div>
</header>
