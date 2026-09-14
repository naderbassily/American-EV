<?php
/**
 * Template Name: Contact Page
 *
 * @package AmericanEV
 */

get_header();

$email = aev_field( 'contact_email', 'info@americanevsolutions.com' );
$phone = aev_field( 'contact_phone', '404-309-4880' );
?>
<main class="site-main contact-page">
	<section class="contact-page-hero">
		<div class="contact-page-hero__glow" aria-hidden="true"></div>
		<div class="container contact-page-hero__grid">
			<div class="contact-page-hero__copy">
				<p class="eyebrow">Contact American EV Solutions</p>
				<h1 class="display"><?php echo esc_html( aev_field( 'contact_page_hero_title', 'Let’s keep your charging equipment moving.' ) ); ?></h1>
				<p class="lead"><?php echo esc_html( aev_field( 'contact_page_hero_body', 'Whether you have a general question, need a replacement component, or want to discuss preventive maintenance, tell us how we can help.' ) ); ?></p>
			</div>
			<aside class="contact-page-details" aria-label="Contact details">
				<p class="contact-page-details__label">Get in touch</p>
				<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><span class="contact-page-details__icon"><svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span><span><small>Email</small><?php echo esc_html( antispambot( $email ) ); ?></span></a>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><span class="contact-page-details__icon"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.69 2.8a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.84.56 2.8.69A2 2 0 0 1 22 16.92Z"/></svg></span><span><small>Phone</small><?php echo esc_html( $phone ); ?></span></a>
				<p class="contact-page-details__hours"><small>Business hours</small>Monday–Friday<br>8 AM–5 PM EST</p>
			</aside>
		</div>
	</section>

	<section class="section contact-page-form" id="contact-form">
		<div class="container">
			<div class="contact-intro" data-reveal>
				<p class="eyebrow eyebrow--blue">General Inquiry</p>
				<h2 class="section-title"><?php echo esc_html( aev_field( 'contact_page_form_title', 'How can we help?' ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aev_field( 'contact_page_form_body', 'Send us a message and our team will review your inquiry and follow up with the appropriate next step.' ) ); ?></p>
			</div>
			<div class="quote-card" data-reveal>
				<?php
				get_template_part(
					'template-parts/request-form',
					null,
					array(
						'form_id'      => 'contact-inquiry',
						'form_type'    => 'general',
						'redirect_to'  => get_permalink() . '#contact-form',
						'button_label' => __( 'Send Inquiry', 'american-ev' ),
					)
				);
				?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
