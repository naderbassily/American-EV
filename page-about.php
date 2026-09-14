<?php
/**
 * Template Name: About Page
 *
 * @package AmericanEV
 */

get_header();

$hero_image    = aev_image_url( 'about_hero_image', '/assets/images/services-hero-maintenance.webp' );
$who_image     = aev_image_url( 'about_who_image', '/assets/images/commercial-charging-hero.webp' );
$why_image     = aev_image_url( 'about_why_image', '/assets/images/replacement-filters.webp' );
$support_image = aev_image_url( 'about_support_image', '/assets/images/about-support-plaza.webp' );
$cta_image     = aev_image_url( 'about_cta_image', '/assets/images/about-cta-plaza.webp' );
$shop_url      = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : aev_home_anchor( 'contact' );
?>
<main class="site-main about-page">

	<section class="about-hero" id="top">
		<div class="about-hero__media">
			<img src="<?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>"<?php echo aev_theme_image_srcset( 'services-hero-maintenance', $hero_image, array( 900 => 'services-hero-maintenance-900.webp', 1536 => 'services-hero-maintenance.webp' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?> sizes="100vw" width="1536" height="1024" alt="<?php esc_attr_e( 'Technician servicing a commercial EV charger cabinet', 'american-ev' ); ?>">
		</div>
		<div class="container about-hero__content">
			<div class="about-hero__copy">
				<p class="eyebrow"><?php esc_html_e( 'About American EV Solutions', 'american-ev' ); ?></p>
				<h1 class="display"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_hero_title', "Practical support for a\nchanging EV landscape." ) ) ) ); ?></h1>
				<p class="lead"><?php echo esc_html( aev_field( 'about_hero_body', 'American EV Solutions supports commercial EV charging infrastructure with replacement parts, component sourcing, and preventive maintenance solutions built around real equipment needs.' ) ); ?></p>
				<a class="btn" href="<?php echo esc_url( aev_contact_url( 'contact-form' ) ); ?>"><?php esc_html_e( 'Contact Us', 'american-ev' ); ?></a>
			</div>
			<p class="about-hero__stamp" aria-hidden="true"><?php esc_html_e( 'Keeping chargers working', 'american-ev' ); ?></p>
		</div>
	</section>

	<section class="section about-who" id="who-we-are">
		<div class="container about-who__grid" data-reveal>
			<div class="about-who__copy">
				<p class="eyebrow eyebrow--blue"><?php esc_html_e( 'Who We Are', 'american-ev' ); ?></p>
				<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_who_title', "Focused on the parts that\nkeep charging equipment working." ) ) ) ); ?></h2>
				<?php
				aev_paragraphs(
					aev_field(
						'about_who_body',
						"American EV Solutions was built around a simple idea: keeping commercial EV charging equipment operating should not become unnecessarily complicated.\n"
						. "When replacement components are difficult to locate or routine maintenance gets overlooked, even a small issue can affect charger availability.\n"
						. "We focus on practical support — helping customers identify replacement components, source harder-to-find parts, and stay ahead of routine maintenance needs.\n"
						. 'No inflated promises. Just straightforward support for the equipment behind commercial EV charging.'
					)
				);
				?>
			</div>
			<figure class="about-who__image">
				<img src="<?php echo $who_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>" loading="lazy" alt="<?php esc_attr_e( 'Commercial EV charging equipment detail', 'american-ev' ); ?>">
				<figcaption><?php esc_html_e( 'Real components. Real support.', 'american-ev' ); ?></figcaption>
			</figure>
		</div>
	</section>

	<section class="section about-values" id="what-matters">
		<div class="container">
			<p class="eyebrow" data-reveal><?php esc_html_e( 'What Matters to Us', 'american-ev' ); ?></p>
			<div class="about-values__rows">
				<?php
				$values = array(
					array(
						'icon'  => '<circle cx="12" cy="12" r="3.2"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-1.87-.34 1.7 1.7 0 0 0-1 1.56V21a2 2 0 1 1-4 0v-.1A1.7 1.7 0 0 0 8.9 19.3a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.56-1H3a2 2 0 1 1 0-4h.1A1.7 1.7 0 0 0 4.7 8.9a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.56V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.56 1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9v0a1.7 1.7 0 0 0 1.56 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/>',
						'title' => __( 'Practical Solutions', 'american-ev' ),
						'copy'  => __( 'We focus on real equipment needs, clear answers, and solutions customers can actually use.', 'american-ev' ),
					),
					array(
						'icon'  => '<path d="M12 3 4.5 6v5.4c0 4.3 3.1 7.7 7.5 9.1 4.4-1.4 7.5-4.8 7.5-9.1V6L12 3Z"/><path d="m8.9 11.9 2.3 2.3 4-4.4"/>',
						'title' => __( 'Reliable Support', 'american-ev' ),
						'copy'  => __( 'From identifying a replacement component to planning routine maintenance, our goal is to make the next step easier.', 'american-ev' ),
					),
					array(
						'icon'  => '<path d="M5 20V13"/><path d="M12 20V7"/><path d="M19 20V10"/>',
						'title' => __( 'Long-Term Equipment Care', 'american-ev' ),
						'copy'  => __( 'Replacing the right component and maintaining equipment regularly can help protect performance and reduce avoidable service problems.', 'american-ev' ),
					),
				);
				foreach ( $values as $index => $value ) :
					?>
					<article class="about-values__row" data-reveal>
						<span class="about-values__num" aria-hidden="true"><?php echo esc_html( str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
						<svg class="about-values__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $value['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed inline SVG. ?></svg>
						<h3><?php echo esc_html( $value['title'] ); ?></h3>
						<p><?php echo esc_html( $value['copy'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section about-why" id="why-were-here">
		<div class="container about-why__grid" data-reveal>
			<figure class="about-why__image">
				<img src="<?php echo $why_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>" loading="lazy" alt="<?php esc_attr_e( 'Replacement filter component for commercial EV charging equipment', 'american-ev' ); ?>">
			</figure>
			<div class="about-why__copy">
				<p class="eyebrow eyebrow--blue"><?php esc_html_e( "Why We're Here", 'american-ev' ); ?></p>
				<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_why_title', "Because sometimes the\nhardest part is finding the part." ) ) ) ); ?></h2>
				<?php
				aev_paragraphs(
					aev_field(
						'about_why_body',
						"Commercial EV charging equipment contains components that may become difficult to source through traditional channels.\n"
						. "Filters, cooling components, service parts, and other replacement items can create unnecessary delays when the right component is not readily available.\n"
						. 'American EV Solutions is building its business around helping close that gap — while also supporting preventive maintenance that helps keep charging equipment ready for service.'
					)
				);
				?>
				<a class="text-link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse Replacement Parts', 'american-ev' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section about-approach" id="our-approach">
		<div class="container about-approach__grid">
			<div class="about-approach__intro" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Our Approach', 'american-ev' ); ?></p>
				<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_approach_title', "Straightforward from the\nfirst question to the\nnext service need." ) ) ) ); ?></h2>
				<p class="lead"><?php echo esc_html( aev_field( 'about_approach_body', 'We keep the process simple and focused on what matters — getting you the right component or service so your charging equipment can stay in operation.' ) ); ?></p>
			</div>
			<div class="about-approach__steps">
				<?php
				$steps = array(
					array(
						'icon'  => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.4-4.4"/>',
						'title' => __( 'Understand the equipment', 'american-ev' ),
						'copy'  => __( 'We start with the charger, component, model, part number, or maintenance need.', 'american-ev' ),
					),
					array(
						'icon'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>',
						'title' => __( 'Identify the right direction', 'american-ev' ),
						'copy'  => __( 'We review the available information and help determine the appropriate component or service.', 'american-ev' ),
					),
					array(
						'icon'  => '<path d="M20 14.5a2.5 2.5 0 0 1-2.5 2.5H8l-4 3.5V6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5Z"/><path d="M8.5 9h7M8.5 12.5h4"/>',
						'title' => __( 'Keep communication clear', 'american-ev' ),
						'copy'  => __( 'Availability, timing, pricing, and next steps should always be easy to understand.', 'american-ev' ),
					),
					array(
						'icon'  => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.8-3.8a6 6 0 0 1-8 8l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a6 6 0 0 1 8-8l-3.8 3.8Z"/>',
						'title' => __( 'Support what comes next', 'american-ev' ),
						'copy'  => __( 'A replacement part may solve today’s problem. Preventive maintenance can help address tomorrow’s.', 'american-ev' ),
					),
				);
				foreach ( $steps as $step ) :
					?>
					<article class="about-step" data-reveal>
						<span class="about-step__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $step['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed inline SVG. ?></svg></span>
						<div><h3><?php echo esc_html( $step['title'] ); ?></h3><p><?php echo esc_html( $step['copy'] ); ?></p></div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section about-support" id="who-we-support">
		<div class="container about-support__grid" data-reveal>
			<div class="about-support__copy">
				<p class="eyebrow eyebrow--blue"><?php esc_html_e( 'Who We Support', 'american-ev' ); ?></p>
				<h2 class="section-title"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_support_title', "Commercial charging\nenvironments of all kinds." ) ) ) ); ?></h2>
				<div class="about-support__list">
					<?php
					$audiences = array(
						array(
							'icon'  => '<path d="M3 7h11v9H3z"/><path d="M14 10h4l3 3v3h-7z"/><circle cx="7" cy="18" r="1.8"/><circle cx="17.5" cy="18" r="1.8"/>',
							'title' => __( 'Fleet Depots', 'american-ev' ),
							'copy'  => __( 'Charging infrastructure supporting operational and commercial vehicle fleets.', 'american-ev' ),
						),
						array(
							'icon'  => '<path d="M4 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v16"/><path d="M15 10h3a2 2 0 0 1 2 2v9"/><path d="M8 8h3M8 12h3M8 16h3"/>',
							'title' => __( 'Commercial Properties', 'american-ev' ),
							'copy'  => __( 'Workplace, tenant, visitor, and destination charging equipment.', 'american-ev' ),
						),
						array(
							'icon'  => '<circle cx="9" cy="8" r="3"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17.5" cy="9.5" r="2.4"/><path d="M15 20a5 5 0 0 1 6.9-4.6"/>',
							'title' => __( 'Public Charging Networks', 'american-ev' ),
							'copy'  => __( 'Charging infrastructure serving public EV drivers.', 'american-ev' ),
						),
					);
					foreach ( $audiences as $audience ) :
						?>
						<article>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $audience['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed inline SVG. ?></svg>
							<h3><?php echo esc_html( $audience['title'] ); ?></h3>
							<p><?php echo esc_html( $audience['copy'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
			<figure class="about-support__image">
				<img src="<?php echo $support_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>"<?php echo aev_theme_image_srcset( 'about-support-plaza', $support_image, array( 800 => 'about-support-plaza-800.webp', 1200 => 'about-support-plaza.webp' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?> sizes="(max-width: 900px) 100vw, 45vw" width="1200" height="586" loading="lazy" alt="<?php esc_attr_e( 'Commercial EV charging stations in a parking area', 'american-ev' ); ?>">
			</figure>
		</div>
	</section>

	<section class="about-cta" id="about-contact">
		<div class="about-cta__media" aria-hidden="true">
			<img src="<?php echo $cta_image; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in aev_image_url(). ?>"<?php echo aev_theme_image_srcset( 'about-cta-plaza', $cta_image, array( 1100 => 'about-cta-plaza-1100.webp', 1920 => 'about-cta-plaza.webp' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?> sizes="100vw" width="1920" height="900" loading="lazy" alt="">
		</div>
		<div class="container about-cta__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( "Let's Talk", 'american-ev' ); ?></p>
			<h2 class="display"><?php echo wp_kses_post( nl2br( esc_html( aev_field( 'about_cta_title', "Need a part? Have a charger\nthat needs attention?" ) ) ) ); ?></h2>
			<p class="lead"><?php echo esc_html( aev_field( 'about_cta_body', 'Tell us what you’re working with. We’ll help identify the right next step — whether that’s a replacement component, part sourcing, or preventive maintenance support.' ) ); ?></p>
			<div class="about-cta__actions">
				<a class="btn" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Request a Part', 'american-ev' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( aev_contact_url( 'contact-form' ) ); ?>"><?php esc_html_e( 'Contact Us', 'american-ev' ); ?></a>
			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
