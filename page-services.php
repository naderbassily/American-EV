<?php
/**
 * Services page template.
 *
 * @package AmericanEV
 */

get_header();

$email = aev_field( 'contact_email', 'info@americanevsolutions.com' );
$phone = aev_field( 'contact_phone', '404-309-4880' );
?>
<main class="site-main services-page">
	<section class="services-hero" id="top">
		<div class="services-hero__media"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/services-hero-maintenance.png' ); ?>" alt="<?php esc_attr_e( 'Technician servicing commercial EV charging equipment', 'american-ev' ); ?>"></div>
		<div class="container services-hero__content">
			<div class="services-hero__copy">
				<p class="eyebrow">EV Charging Services</p>
				<h1 class="display"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_hero_title', "Parts, service,\nand practical support." ) ) ) ); ?></h1>
				<p class="lead"><?php echo esc_html( aev_field( 'services_hero_body', 'Replacement parts, component sourcing, and preventive maintenance support for commercial EV charging equipment.' ) ); ?></p>
			</div>
		</div>
	</section>

	<section class="section services-overview" id="services-overview">
		<div class="container services-editorial-split" data-reveal>
			<div><p class="eyebrow eyebrow--blue">What We Do</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_overview_title', "Support for the equipment\nbehind every charge." ) ) ) ); ?></h2></div>
			<div class="services-overview__detail">
				<p class="lead">Commercial charging equipment depends on a wide range of components working together.</p>
				<p>American EV Solutions supports charging operators with replacement parts, harder-to-source components, and preventive maintenance services designed around real equipment needs.</p>
				<div class="services-link-rows">
					<a href="#replacement-parts"><span><strong>Replacement Parts</strong><small>Find replacement and service components for commercial EV charging equipment.</small></span><b aria-hidden="true">→</b></a>
					<a href="#preventive-maintenance"><span><strong>Preventive Maintenance</strong><small>Routine inspection, cleaning, filter replacement, and maintenance support.</small></span><b aria-hidden="true">→</b></a>
				</div>
			</div>
		</div>
	</section>

	<section class="section services-parts" id="replacement-parts">
		<div class="container services-product-split" data-reveal>
			<div class="services-parts-image"><video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.png' ); ?>" aria-label="Commercial EV charging equipment components"><source src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-components.mp4' ); ?>" type="video/mp4"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.png' ); ?>" alt="<?php esc_attr_e( 'Replacement air filters for commercial EV charging equipment', 'american-ev' ); ?>"></video></div>
			<div class="services-detail-copy">
				<p class="eyebrow eyebrow--blue">Replacement Parts</p>
				<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_parts_title', "The right component\nwhen you need it." ) ) ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aev_field( 'services_parts_body', 'We provide replacement components for commercial EV charging equipment, with particular focus on parts that can be difficult to locate through traditional supply channels.' ) ); ?></p>
				<ul class="check-list"><li>Replacement filters</li><li>Cooling and airflow components</li><li>Service and maintenance components</li><li>Additional parts available by request</li></ul>
			</div>
		</div>
	</section>

	<section class="section sourcing-section" id="part-sourcing">
		<div class="container sourcing-grid" data-reveal>
			<div class="sourcing-copy"><p class="eyebrow">Part Sourcing</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_sourcing_title', "Hard to find\ndoesn’t mean impossible." ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'services_sourcing_body', 'Some EV charging components become difficult to source as equipment ages, suppliers change, or individual replacement parts become less readily available.' ) ); ?></p><p>Send us the information you have and we’ll help identify available replacement options.</p><a class="btn" href="#service-request">Request a Part</a><small>Even a photo or equipment label can help us start identifying the component.</small></div>
			<div class="identification-panel">
				<div class="identification-panel__head"><span>Useful information</span><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h10"/></svg></div>
				<ol><li><span>01</span>Manufacturer</li><li><span>02</span>Charger model</li><li><span>03</span>Part number</li><li><span>04</span>Component photo</li><li><span>05</span>Label or specification</li></ol>
			</div>
		</div>
	</section>

	<section class="section featured-filter" id="featured-component">
		<div class="container featured-filter__grid" data-reveal>
			<div class="featured-filter__copy"><p class="eyebrow eyebrow--blue">Featured Component</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_featured_title', "Replacement filters\nfor commercial charging equipment." ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'services_featured_body', 'Cooling and airflow components can play an important role in maintaining proper operating conditions inside commercial charging equipment.' ) ); ?></p><p>American EV Solutions is developing its parts offering around replacement components that maintenance teams may otherwise have difficulty sourcing.</p><a class="text-link" href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#service-request' ); ?>">Order Now</a></div>
			<div class="featured-filter__image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.png' ); ?>" alt="<?php esc_attr_e( 'Replacement air filters for commercial EV charging equipment', 'american-ev' ); ?>"></div>
		</div>
	</section>

	<section class="section maintenance-editorial" id="preventive-maintenance">
		<div class="container maintenance-editorial__grid">
			<div class="maintenance-editorial__intro" data-reveal><p class="eyebrow">Preventive Maintenance</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_maintenance_title', "Small maintenance.\nFewer surprises." ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'services_maintenance_body', 'Routine inspection and maintenance can help identify wear, airflow issues, dirty filters, and other service needs before they contribute to larger equipment problems.' ) ); ?></p><a class="btn" href="#service-request">Request Maintenance</a></div>
			<div class="maintenance-rows">
				<article data-reveal><span>01</span><div><h3>Visual Inspections</h3><p>Inspection of accessible equipment and components for visible signs of wear, damage, or service needs.</p></div></article>
				<article data-reveal><span>02</span><div><h3>Cooling &amp; Airflow</h3><p>Cooling-system inspection, cleaning, airflow checks, and filter replacement.</p></div></article>
				<article data-reveal><span>03</span><div><h3>Component Condition</h3><p>Review of accessible charger components and connections for visible service concerns.</p></div></article>
				<article data-reveal><span>04</span><div><h3>Maintenance Documentation</h3><p>Clear documentation of work performed and recommended follow-up items.</p></div></article>
			</div>
		</div>
	</section>

	<section class="section service-request" id="service-request">
		<div class="container service-request__grid" data-reveal>
			<div class="service-request__intro"><p class="eyebrow eyebrow--blue">Request Support</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'services_request_title', "Looking for a specific\npart or service?" ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'services_request_body', 'Tell us about your charger, component, or maintenance need and we’ll help determine the next step.' ) ); ?></p></div>
			<div class="service-request__form">
				<?php if ( isset( $_GET['quote'] ) && 'success' === sanitize_key( wp_unslash( $_GET['quote'] ) ) ) : ?><div class="form-alert form-alert--success" role="status">Thanks—your request has been received. We’ll be in touch shortly.</div><?php elseif ( isset( $_GET['quote'] ) ) : ?><div class="form-alert form-alert--error" role="alert">Please check the required fields and try again.</div><?php endif; ?>
				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="aev_quote_request"><input type="hidden" name="redirect_to" value="<?php echo esc_url( get_permalink() . '#service-request' ); ?>"><?php wp_nonce_field( 'aev_quote_request', 'aev_quote_nonce' ); ?>
					<div class="hp-field" aria-hidden="true"><label>Leave this field empty <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>
					<div class="form-grid"><div class="field"><label for="service-name">Name *</label><input id="service-name" name="name" type="text" autocomplete="name" required></div><div class="field"><label for="service-email">Email *</label><input id="service-email" name="email" type="email" autocomplete="email" required></div><div class="field"><label for="service-company">Company</label><input id="service-company" name="company" type="text" autocomplete="organization"></div><div class="field"><label for="service-phone">Phone</label><input id="service-phone" name="phone" type="tel" autocomplete="tel"></div><div class="field field--full"><label for="service-type">What do you need?</label><select id="service-type" name="service"><option value="Replacement Part">Replacement Part</option><option value="Part Sourcing">Part Sourcing</option><option value="Preventive Maintenance">Preventive Maintenance</option><option value="General Inquiry">General Inquiry</option></select></div><div class="field"><label for="charger-manufacturer">Charger Manufacturer</label><input id="charger-manufacturer" name="charger_manufacturer" type="text"></div><div class="field"><label for="charger-model">Charger Model</label><input id="charger-model" name="charger_model" type="text"></div><div class="field field--full"><label for="part-number">Part Number</label><input id="part-number" name="part_number" type="text"></div><div class="field field--full"><label for="service-message">Tell us what you’re looking for *</label><textarea id="service-message" name="message" required></textarea></div><div class="field field--full"><label for="service-attachment">Upload Photo or Document</label><input id="service-attachment" name="attachment" type="file" accept="image/jpeg,image/png,image/webp,application/pdf"><small>Upload a component photo, equipment label, specification, or reference image.</small></div></div>
					<div class="service-request__actions"><button class="btn" type="submit">Send Request</button><div class="form-contact"><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><span><?php echo esc_html( antispambot( $email ) ); ?></span></a><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.69 2.8a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.84.56 2.8.69A2 2 0 0 1 22 16.92Z"/></svg><span><?php echo esc_html( $phone ); ?></span></a></div></div>
				</form>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
