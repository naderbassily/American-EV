<?php get_header(); ?>
<main class="site-main site-main--inner"><div class="content-shell"><?php while ( have_posts() ) : the_post(); ?><article <?php post_class(); ?>><h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); ?></div></article><?php endwhile; ?></div></main>
<?php get_footer(); ?>
