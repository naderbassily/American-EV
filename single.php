<?php get_header(); ?>
<main class="site-main site-main--inner"><div class="content-shell"><?php while ( have_posts() ) : the_post(); ?><article <?php post_class(); ?>><p class="eyebrow eyebrow--blue"><?php echo esc_html( get_the_date() ); ?></p><h1><?php the_title(); ?></h1><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?><div class="entry-content"><?php the_content(); ?></div></article><?php endwhile; ?></div></main>
<?php get_footer(); ?>
