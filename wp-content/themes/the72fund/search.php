<?php get_header(); ?>

<section class="default">
	<div class="container">
		<h1 class="screen-reader-text"><?php echo esc_html__( 'Search', 'the-72-fund' ); ?></h1>

		<h2 class="page-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html__( 'Search', 'the72fund' ); ?></h2>
		<!-- <hr class="aos fadeup" data-animDelay="250" data-animSpeed="750" /> -->
		<div class="page-text aos fadeup" data-animDelay="250" data-animSpeed="750">
			<p style="font-size:30px; line-height:1.33; text-align:center;">
			<?php echo esc_html__( 'Search is not currently available.', 'the72fund' ); ?><br>
			<?php echo esc_html__( 'Back to', 'the72fund' ); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html__( 'Homepage', 'the72fund' ); ?></a>
			</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
