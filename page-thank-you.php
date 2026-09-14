<?php
/**
 * Thank-you page template.
 *
 * @package AmericanEV
 */

add_filter( 'wp_robots', function ( $robots ) {
	$robots['noindex'] = true;
	return $robots;
} );

get_header();
?>
<main class="site-main thank-you-page">
	<section class="thank-you-hero">
		<div class="thank-you-hero__glow" aria-hidden="true"></div>
		<div class="container thank-you-hero__content">
			<div class="thank-you-mark" aria-hidden="true">
				<svg viewBox="0 0 64 64"><circle cx="32" cy="32" r="29"/><path d="m19 33 8 8 18-20"/></svg>
			</div>
			<p class="eyebrow">Request Received</p>
			<h1 class="display">Thank you.<br>We’ll take it from here.</h1>
			<p class="lead">Your request has been received by American EV Solutions. Our team will review the information you provided and follow up using your contact details.</p>
			<div class="thank-you-actions"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Return Home</a><a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/filters/' ) ); ?>">Explore Filters</a></div>
		</div>
	</section>

	<section class="thank-you-next">
		<div class="container thank-you-next__grid">
			<div><p class="eyebrow eyebrow--blue">What Happens Next</p><h2>Clear, practical follow-up.</h2></div>
			<div class="thank-you-steps">
				<div><span>01</span><p><strong>We review your request</strong>Your charger, component, or maintenance details help us understand what you need.</p></div>
				<div><span>02</span><p><strong>We contact you</strong>We’ll follow up with available information, any questions, and the appropriate next steps.</p></div>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
