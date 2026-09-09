<?php get_header(); ?>

<section class="default">
	<div class="container">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<h1 class="screen-reader-text"><?php the_title(); ?></h1>
			
			<?php if (has_post_thumbnail()) { ?>
				<div class="page-thumb aos fadeup" data-animDelay="250" data-animSpeed="750">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php } ?>
			<h2 class="page-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_title(); ?></h2>
			<!-- <hr class="aos fadeup" data-animDelay="250" data-animSpeed="750" /> -->
			<div class="page-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_content(); ?></div>
			
		<?php endwhile; endif; ?>
	</div>
</section>

<?php get_footer(); ?>
