<?php
get_header();
$hero_image  = aev_image_url( 'hero_image', '/assets/images/commercial-charging-hero.webp' );
$parts_image = aev_image_url( 'parts_image', '/assets/images/commercial-charging-hero.webp' );
$hero_srcset = array( 900 => 'commercial-charging-hero-900.webp', 1600 => 'commercial-charging-hero.webp' );
$email = aev_field( 'contact_email', 'info@americanevsolutions.com' );
$phone = aev_field( 'contact_phone', '404-309-4880' );
?>
<main class="site-main">
	<section class="hero" id="top">
		<div class="hero-media"><img src="<?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>"<?php echo aev_theme_image_srcset( 'commercial-charging-hero', $hero_image, $hero_srcset ); // phpcs:ignore WordPress.Security.EscapeOutput ?> sizes="100vw" width="1600" height="667" alt="<?php esc_attr_e( 'Commercial EV charging depot', 'american-ev' ); ?>"></div>
		<div class="container hero-content">
			<div class="hero-copy">
				<p class="eyebrow"><?php echo esc_html( aev_field( 'hero_eyebrow', 'Commercial EV Charging Support' ) ); ?></p>
				<h1 class="display"><?php echo esc_html( aev_field( 'hero_title', 'Built for uptime.' ) ); ?></h1>
				<p class="lead"><?php echo esc_html( aev_field( 'hero_body', 'Replacement parts and preventive maintenance support for commercial EV charging infrastructure — with a focus on components that are difficult to source.' ) ); ?></p>
				<div class="hero-actions"><a class="btn" href="#parts">Explore Parts</a><a class="btn btn--ghost" href="#contact">Request a Part</a></div>
			</div>
			<p class="hero-audiences">Fleet depots&nbsp;&nbsp; / &nbsp;&nbsp;Commercial properties&nbsp;&nbsp; / &nbsp;&nbsp;Public charging networks</p>
		</div>
	</section>

	<section class="section" id="intro"><div class="container intro-grid" data-reveal>
		<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'intro_title', 'Keeping commercial charging moving.' ) ) ) ); ?></h2>
		<div><div class="lead"><?php echo wp_kses_post( wpautop( esc_html( aev_field( 'intro_body', "American EV Solutions supports commercial EV charging infrastructure with reliable replacement components and preventive maintenance solutions.\n\nFrom routine service needs to harder-to-source components, we focus on practical support that helps keep charging equipment operational." ) ) ) ); ?></div>
			<div class="audience-grid"><div><h3>Hard-to-Find Parts</h3><p>Specialized replacement components that can be difficult to source through traditional channels.</p></div><div><h3>Commercial EV Focus</h3><p>Parts and support specifically for commercial EV charging infrastructure.</p></div><div><h3>Straightforward Support</h3><p>A practical approach to identifying and sourcing the components you need.</p></div></div>
		</div>
	</div></section>

	<section class="section parts" id="parts"><div class="container split" data-reveal>
		<div class="service-image"><img src="<?php echo $parts_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>"<?php echo aev_theme_image_srcset( 'commercial-charging-hero', $parts_image, $hero_srcset ); // phpcs:ignore WordPress.Security.EscapeOutput ?> sizes="(max-width: 900px) 100vw, 45vw" width="1600" height="667" loading="lazy" alt="<?php esc_attr_e( 'Commercial charging hardware', 'american-ev' ); ?>"></div>
		<div class="service-copy"><p class="eyebrow eyebrow--blue">Parts</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'parts_title', "The right part.\nBack in service." ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'parts_body', 'Replacement components selected for your commercial charging equipment, helping your team restore service with confidence.' ) ); ?></p><ul class="check-list"><li>Filters and cooling components</li><li>Cables and heavy-duty connectors</li><li>Internal charging components</li></ul><?php if ( class_exists( 'WooCommerce' ) ) : ?><a class="text-link" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Explore parts</a><?php else : ?><a class="text-link" href="#contact">Explore parts</a><?php endif; ?></div>
	</div></section>

	<section class="section maintenance" id="maintenance"><div class="container split" data-reveal>
		<div class="service-copy"><p class="eyebrow">Maintenance</p><h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'maintenance_title', "Prevent downtime.\nProtect performance." ) ) ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'maintenance_body', 'Scheduled preventive maintenance designed to identify potential issues, support reliable operation, and help reduce avoidable downtime.' ) ); ?></p>
			<div class="maintenance-grid"><div class="maintenance-item"><span class="maintenance-number">01</span><div><h3>Visual Inspections</h3><p>Inspection of accessible equipment and components for signs of wear or service needs.</p></div></div><div class="maintenance-item"><span class="maintenance-number">02</span><div><h3>Cooling System Care</h3><p>Cooling system inspections, cleaning, and filter replacement.</p></div></div><div class="maintenance-item"><span class="maintenance-number">03</span><div><h3>Electrical Checks</h3><p>Inspection of electrical components for visible signs of wear or potential issues.</p></div></div><div class="maintenance-item"><span class="maintenance-number">04</span><div><h3>Service Reports</h3><p>Clear documentation of maintenance performed and recommended next steps.</p></div></div></div><a class="text-link" href="#contact">Explore maintenance</a>
		</div>
		<figure class="maintenance-chart-card" data-maintenance-chart>
			<div class="maintenance-chart-card__top">
				<span class="maintenance-chart-card__icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M21.1 4.2a6 6 0 0 1-7.4 7.4L7 18.3a2.1 2.1 0 1 1-3-3l6.7-6.7a6 6 0 0 1 7.4-7.4l-3.3 3.3.7 2.8 2.8.7 2.8-3.8Z"/></svg></span>
				<span class="maintenance-chart-card__label">Maintenance focus</span>
			</div>
			<div class="maintenance-chart-card__intro">
				<h3>Protect performance over time.</h3>
				<p>Routine maintenance helps keep your charging equipment operating reliably and reduces the risk of unexpected downtime.</p>
			</div>
			<div class="maintenance-chart-wrap">
				<svg class="maintenance-chart" viewBox="0 0 640 300" role="img" aria-labelledby="maintenance-chart-title maintenance-chart-desc">
					<title id="maintenance-chart-title">Illustrative equipment performance over time</title>
					<desc id="maintenance-chart-desc">A green line shows steadier performance with preventive maintenance. A blue line shows declining performance without routine maintenance.</desc>
					<defs>
						<linearGradient id="aev-green-area" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#42d98a" stop-opacity=".2"/><stop offset="1" stop-color="#42d98a" stop-opacity="0"/></linearGradient>
						<linearGradient id="aev-blue-area" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#3f92ff" stop-opacity=".15"/><stop offset="1" stop-color="#3f92ff" stop-opacity="0"/></linearGradient>
						<filter id="aev-point-glow" x="-200%" y="-200%" width="400%" height="400%"><feGaussianBlur stdDeviation="5" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
					</defs>
					<g class="maintenance-chart__grid" aria-hidden="true">
						<path d="M52 48V244M106 48V244M160 48V244M214 48V244M268 48V244M322 48V244M376 48V244M430 48V244M484 48V244"/>
						<path d="M52 80H500M52 126H500M52 172H500M52 218H500"/>
					</g>
					<path class="maintenance-chart__axis" d="M52 42V244M44 234H515" aria-hidden="true"/>
					<text class="maintenance-chart__axis-label maintenance-chart__axis-label--y" x="22" y="163" transform="rotate(-90 22 163)">Performance</text>
					<text class="maintenance-chart__axis-label" x="262" y="270">Time →</text>
					<path class="maintenance-chart__area maintenance-chart__area--blue" d="M52 78C142 78 178 104 246 146S384 215 500 221L500 234L52 234Z"/>
					<path class="maintenance-chart__area maintenance-chart__area--green" d="M52 78C120 57 174 72 238 70S373 76 500 89L500 234L52 234Z"/>
					<path class="maintenance-chart__line maintenance-chart__line--blue" pathLength="1" d="M52 78C142 78 178 104 246 146S384 215 500 221"/>
					<path class="maintenance-chart__line maintenance-chart__line--green" pathLength="1" d="M52 78C120 57 174 72 238 70S373 76 500 89"/>
					<g class="maintenance-chart__endpoint maintenance-chart__endpoint--green"><circle class="maintenance-chart__halo" cx="500" cy="89" r="11"/><circle cx="500" cy="89" r="5"/><text x="514" y="78"><tspan x="514" dy="0">With Preventive</tspan><tspan x="514" dy="19">Maintenance</tspan></text></g>
					<g class="maintenance-chart__endpoint maintenance-chart__endpoint--blue"><circle class="maintenance-chart__halo" cx="500" cy="221" r="11"/><circle cx="500" cy="221" r="5"/><text x="514" y="211"><tspan x="514" dy="0">Without</tspan><tspan x="514" dy="19">Routine Maintenance</tspan></text></g>
				</svg>
				<div class="maintenance-chart-mobile-legend" aria-hidden="true"><span class="maintenance-chart-mobile-legend__green">With preventive maintenance</span><span class="maintenance-chart-mobile-legend__blue">Without routine maintenance</span></div>
			</div>
			<figcaption class="maintenance-chart-callout">
				<span class="maintenance-chart-callout__icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 3 5.5 5.5v5.8c0 4.1 2.6 7.8 6.5 9.7 3.9-1.9 6.5-5.6 6.5-9.7V5.5L12 3Zm0 2.2 4.5 1.7v4.4c0 3-1.7 5.9-4.5 7.5V5.2Z"/></svg></span>
				<span>Regular inspection, cleaning, and component replacement can help maintain equipment performance and extend service life.</span>
			</figcaption>
		</figure>
	</div></section>

	<section class="section" id="process"><div class="container" data-reveal><h2 class="section-title process-title">How we work.</h2><div class="process-grid"><article class="process-step"><div class="process-step__number">01 — Identify</div><h3>Tell Us What You Need</h3><p>Share the charger manufacturer, model, part number, or component you’re looking for. We’ll review the details and help identify the right solution.</p></article><article class="process-step"><div class="process-step__number">02 — Supply &amp; Service</div><h3>Get the Right Solution</h3><p>We’ll confirm the appropriate part or maintenance service and provide clear information on availability, timing, and next steps.</p></article><article class="process-step"><div class="process-step__number">03 — Support</div><h3>Keep Equipment Running</h3><p>From replacement parts to preventive maintenance, we provide ongoing support to help keep your charging equipment in service.</p></article></div></div></section>

	<section class="section contact-section" id="contact"><div class="container">
		<div class="contact-intro" data-reveal><h2 class="section-title"><?php echo esc_html( aev_field( 'contact_title', 'Keep your network moving.' ) ); ?></h2><p class="lead"><?php echo esc_html( aev_field( 'contact_body', 'Tell us what you need — from replacement parts to preventive maintenance — and our team will help identify the right solution for your charging equipment.' ) ); ?></p></div>
		<div class="quote-card">
			<?php if ( isset( $_GET['quote'] ) && 'success' === sanitize_key( wp_unslash( $_GET['quote'] ) ) ) : ?><div class="form-alert form-alert--success" role="status">Thanks—your request has been received. We’ll be in touch shortly.</div><?php elseif ( isset( $_GET['quote'] ) ) : ?><div class="form-alert form-alert--error" role="alert">Please check the required fields and try again.</div><?php endif; ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="aev_quote_request"><?php wp_nonce_field( 'aev_quote_request', 'aev_quote_nonce' ); ?>
				<div class="hp-field" aria-hidden="true"><label>Leave this field empty <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>
				<div class="form-grid"><div class="field"><label for="quote-name">Name *</label><input id="quote-name" name="name" type="text" autocomplete="name" required></div><div class="field"><label for="quote-email">Email *</label><input id="quote-email" name="email" type="email" autocomplete="email" required></div><div class="field"><label for="quote-phone">Phone</label><input id="quote-phone" name="phone" type="tel" autocomplete="tel"></div><div class="field"><label for="quote-company">Company</label><input id="quote-company" name="company" type="text" autocomplete="organization"></div><div class="field field--full"><label for="quote-service">How can we help?</label><select id="quote-service" name="service"><option value="Parts">Replacement parts</option><option value="Maintenance">Preventive maintenance</option><option value="Parts and maintenance">Parts and maintenance</option><option value="Other">Other</option></select></div><div class="field field--full"><label for="quote-message">Tell us about your equipment, sites, or service needs *</label><textarea id="quote-message" name="message" required></textarea></div></div>
				<div class="form-actions"><button class="btn" type="submit">Request a quote</button><div class="form-contact"><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><span><?php echo esc_html( antispambot( $email ) ); ?></span></a><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.69 2.8a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.84.56 2.8.69A2 2 0 0 1 22 16.92Z"/></svg><span><?php echo esc_html( $phone ); ?></span></a></div></div>
			</form>
		</div>
	</div></section>
</main>
<?php get_footer(); ?>
