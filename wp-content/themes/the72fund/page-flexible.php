<?php 
/*
Template Name: Flexible
*/

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
		<h1 class="screen-reader-text"><?php the_title(); ?></h1>
	<?php endwhile;
	rewind_posts();
endif;

get_template_part( 'template-parts/templates/template', 'flexible_sections' );

get_footer(); ?>
