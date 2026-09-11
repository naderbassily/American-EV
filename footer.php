<?php
$email = aev_field( 'contact_email', 'info@americanevsolutions.com' );
$phone = aev_field( 'contact_phone', '404-309-4880' );
?>
<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
				<p><?php esc_html_e( 'Replacement parts and preventive maintenance for commercial charging networks.', 'american-ev' ); ?></p>
			</div>
			<div class="footer-nav">
				<div><h3><?php esc_html_e( 'Solutions', 'american-ev' ); ?></h3><ul><li><a href="<?php echo esc_url( aev_home_anchor( 'intro' ) ); ?>">Commercial charging</a></li><li><a href="<?php echo esc_url( aev_home_anchor( 'intro' ) ); ?>">Fleet depots</a></li><li><a href="<?php echo esc_url( aev_home_anchor( 'intro' ) ); ?>">Public networks</a></li><?php if ( class_exists( 'WooCommerce' ) ) : ?><li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop parts</a></li><?php endif; ?></ul></div>
				<div><h3><?php esc_html_e( 'Company', 'american-ev' ); ?></h3><ul><li><a href="<?php echo esc_url( aev_home_anchor( 'process' ) ); ?>">About</a></li><li><a href="<?php echo esc_url( aev_home_anchor( 'contact' ) ); ?>">Contact</a></li><li><a href="<?php echo esc_url( aev_home_anchor( 'contact' ) ); ?>">Request a quote</a></li></ul></div>
				<div><h3><?php esc_html_e( 'Get in touch', 'american-ev' ); ?></h3><ul><li><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li><li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li><li>Monday–Friday<br>8 AM–5 PM EST</li></ul></div>
			</div>
		</div>
		<div class="footer-bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> American EV Solutions LLC.</span></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
