<?php get_header(); ?>

<section class="default">
	<div class="container">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Page not found', 'the-72-fund' ); ?></h1>
				
		<h2 class="page-title aos fadeup" data-animDelay="250" data-animSpeed="750">Error: 404</h2>
		<!-- <hr class="aos fadeup" data-animDelay="250" data-animSpeed="750" /> -->
		<div class="page-text aos fadeup" data-animDelay="250" data-animSpeed="750">
			<p style="font-size:30px; line-height:1.33; text-align:center;">
			Whoops, no page here!<br>
			Back to <a href="<?php echo home_url(); ?>">Homepage</a>
			</p>
		</div>
			
	</div>
</section>

<?php get_footer(); ?>
