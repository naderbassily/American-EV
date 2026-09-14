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
				<div>
					<h3><?php esc_html_e( 'Navigation', 'american-ev' ); ?></h3>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
						<li><a href="<?php echo esc_url( home_url( '/filters/' ) ); ?>">Parts</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( aev_contact_url( 'contact-form' ) ); ?>">Contact Us</a></li>
					</ul>
				</div>
				<div>
					<h3><?php esc_html_e( 'Get in touch', 'american-ev' ); ?></h3>
					<ul><li><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li><li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li></ul>
					<a class="footer-social" href="https://www.linkedin.com/company/american-ev-solutions/" target="_blank" rel="noopener noreferrer" aria-label="American EV Solutions on LinkedIn">
						<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.5 8.3H3.2V21h3.3V8.3ZM4.9 3A1.9 1.9 0 1 0 5 6.8 1.9 1.9 0 0 0 4.9 3ZM21 13.7c0-3.8-2-5.6-4.7-5.6a4.1 4.1 0 0 0-3.7 2V8.3H9.4V21h3.3v-6.3c0-1.7.3-3.3 2.4-3.3s2.1 1.9 2.1 3.4V21H21v-7.3Z"/></svg>
						<span>LinkedIn</span>
					</a>
				</div>
			</div>
		</div>
		<div class="footer-bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> American EV Solutions LLC.</span></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
