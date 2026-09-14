<?php
/**
 * Services page template.
 *
 * @package AmericanEV
 */

get_header();

?>
<main class="site-main services-page">
	<section class="services-hero" id="top">
		<div class="services-hero__media"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/services-hero-maintenance.webp' ); ?>" srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/images/services-hero-maintenance-900.webp' ); ?> 900w, <?php echo esc_url( get_template_directory_uri() . '/assets/images/services-hero-maintenance.webp' ); ?> 1536w" sizes="100vw" width="1536" height="1024" alt="<?php esc_attr_e( 'Technician servicing commercial EV charging equipment', 'american-ev' ); ?>"></div>
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
			<div class="services-parts-image"><video autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.webp' ); ?>" aria-label="Commercial EV charging equipment components"><source src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-components.mp4' ); ?>" type="video/mp4"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.webp' ); ?>" width="800" height="800" loading="lazy" alt="<?php esc_attr_e( 'Replacement air filters for commercial EV charging equipment', 'american-ev' ); ?>"></video></div>
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
			<div class="featured-filter__image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.webp' ); ?>" width="800" height="800" loading="lazy" alt="<?php esc_attr_e( 'Replacement air filters for commercial EV charging equipment', 'american-ev' ); ?>"></div>
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
				<?php
				get_template_part(
					'template-parts/request-form',
					null,
					array(
						'form_id'      => 'services-request',
						'form_type'    => 'service',
						'redirect_to'  => get_permalink() . '#service-request',
						'button_label' => __( 'Send Request', 'american-ev' ),
					)
				);
				?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
