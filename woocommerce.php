<?php get_header(); ?>
<?php if ( is_shop() ) : ?>
	<main class="site-main filters-shop">
		<section class="filters-hero">
			<div class="container filters-hero__grid">
				<div class="filters-hero__copy" data-reveal>
					<p class="eyebrow">Replacement Parts</p>
					<h1 class="display">Filters that keep every charge moving.</h1>
					<p class="lead">Replacement air filters and service components for commercial EV charging equipment.</p>
					<a class="btn" href="#filter-products">Browse Filters</a>
				</div>
				<div class="filters-hero__visual" data-reveal><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/replacement-filters.png' ); ?>" alt="Replacement filters for commercial EV charging equipment"></div>
			</div>
		</section>
		<section class="section filters-catalog" id="filter-products">
			<div class="container">
				<div class="filters-catalog__intro" data-reveal>
					<p class="eyebrow eyebrow--blue">Available Components</p>
					<h2 class="section-title">Replacement filters.</h2>
					<p class="lead">Select a replacement filter for your charging equipment or contact us if you need help confirming compatibility.</p>
				</div>
				<?php if ( have_posts() ) : ?>
					<?php woocommerce_product_loop_start(); ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php do_action( 'woocommerce_shop_loop' ); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
					<?php woocommerce_product_loop_end(); ?>
				<?php else : ?>
					<p class="filters-empty">Products are being added now. Contact us for replacement filter availability.</p>
				<?php endif; ?>
			</div>
		</section>
	</main>
<?php else : ?>
	<?php woocommerce_content(); ?>
<?php endif; ?>
<?php get_footer(); ?>
