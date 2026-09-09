<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$main_title = get_sub_field('main_title');
$subtitle = get_sub_field('subtitle');
$main_text = get_sub_field('main_text');
$feature_first_person = get_sub_field('feature_first_person');
$posts = get_sub_field('team');

global $the72fund_team_modal_items, $the72fund_team_modal_slugs, $the72fund_team_modal_footer_registered;

if ( ! isset( $the72fund_team_modal_items ) ) {
	$the72fund_team_modal_items = array();
}

if ( ! isset( $the72fund_team_modal_slugs ) ) {
	$the72fund_team_modal_slugs = array();
}

if ( ! function_exists( 'the72fund_register_team_modal_item' ) ) {
	function the72fund_register_team_modal_item( $team_post ) {
		global $the72fund_team_modal_items, $the72fund_team_modal_slugs;

		$post_id = is_object( $team_post ) ? $team_post->ID : $team_post;

		if ( ! $post_id ) {
			return '';
		}

		$name       = get_the_title( $post_id );
		$first_name = strtok( trim( $name ), " \t\n\r\0\x0B" );
		$position   = get_field( 'position', $post_id );
		$headshot   = get_field( 'headshot', $post_id );
		$swatch     = get_field( 'swatch_color', $post_id );
		$bio        = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
		$areas      = get_the_terms( $post_id, 'area' );
		$area_names = ! empty( $areas ) && ! is_wp_error( $areas ) ? wp_list_pluck( $areas, 'name' ) : array();
		$slug       = sanitize_title( $name );

		if ( ! $slug ) {
			$slug = 'team-member-' . $post_id;
		}

		if ( ! isset( $the72fund_team_modal_slugs[ $slug ] ) ) {
			$the72fund_team_modal_slugs[ $slug ] = 0;
		}

		$the72fund_team_modal_slugs[ $slug ]++;
		$page_id = 1 === $the72fund_team_modal_slugs[ $slug ] ? $slug : $slug . '-' . $the72fund_team_modal_slugs[ $slug ];

		$the72fund_team_modal_items[] = array(
			'page_id'      => $page_id,
			'name'         => $name,
			'first_name'   => $first_name,
			'position'     => $position,
			'headshot_url' => ! empty( $headshot['url'] ) ? $headshot['url'] : '',
			'headshot_alt' => ! empty( $headshot['alt'] ) ? $headshot['alt'] : $name,
			'swatch'       => $swatch,
			'bio'          => $bio,
			'areas'        => $area_names,
		);

		return $page_id;
	}
}

if ( empty( $the72fund_team_modal_footer_registered ) ) {
	$the72fund_team_modal_footer_registered = true;

	add_action( 'wp_footer', function() {
		global $the72fund_team_modal_items;

		if ( empty( $the72fund_team_modal_items ) ) {
			return;
		} ?>

		<div id="team-members-modal" class="custom-modal team-members-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php esc_attr_e( 'Team member details', 'the-72-fund' ); ?>" inert>
			<div class="modal-block">
				<button class="modal-close" type="button" aria-label="<?php esc_attr_e( 'Close modal', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
				<button class="modal-arrow previous-arrow" type="button" aria-label="<?php esc_attr_e( 'Previous team member', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-prev.png" alt="" aria-hidden="true" /></button>

				<?php foreach ( $the72fund_team_modal_items as $modal_item ) : ?>
					<div id="<?php echo esc_attr( $modal_item['page_id'] ); ?>" class="modal-page">
						<div class="team-modal-content">
							<?php if ( ! empty( $modal_item['areas'] ) ) : ?>
								<div class="team-category FT-gradient-line"><strong><?php echo esc_html( implode( ', ', $modal_item['areas'] ) ); ?></strong></div>
							<?php endif; ?>
							<div class="left-side">
								<?php if ( $modal_item['headshot_url'] ) : ?>
									<div class="team-modal-image TFT-gradient-line">
										<?php if ( $modal_item['swatch'] ) : ?>
											<img class="swatch" src="<?php echo esc_url( get_template_directory_uri() . '/images/swatches/swatch_' . $modal_item['swatch'] . '.png' ); ?>" alt="" aria-hidden="true" />
										<?php endif; ?>
										<img class="headshot" src="<?php echo esc_url( $modal_item['headshot_url'] ); ?>" alt="<?php echo esc_attr( $modal_item['headshot_alt'] ); ?>" />
									</div>
								<?php endif;
								if ( $modal_item['name'] ) : ?>
									<h3 class="section-name title"><?php echo esc_html( $modal_item['name'] ); ?></h3>
								<?php endif;
								if ( $modal_item['position'] ) : ?>
									<h6 class="section-position"><?php echo esc_html( $modal_item['position'] ); ?></h6>
								<?php endif; ?>
							</div>
							<div class="right-side">
								<div class="team-modal-copy">
									<?php if ( $modal_item['first_name'] ) : ?>
										<h3 class="section-about"><?php echo esc_html( 'About ' . $modal_item['first_name'] ); ?></h3>
									<?php endif; ?>
									<?php if ( $modal_item['bio'] ) : ?>
										<div class="section-text"><?php echo wp_kses_post( $modal_item['bio'] ); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

				<button class="modal-arrow next-arrow" type="button" aria-label="<?php esc_attr_e( 'Next team member', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-next.png" alt="" aria-hidden="true" /></button>
			</div>
		</div>

		<?php
	} );
}

?>

<section class="team mobile600 <?php echo $feature_first_person ? 'has-featured-person' : 'standard-layout'; ?>"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
	<div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
	     <?php echo $container_data_attrs; ?>
	     <?php echo $container_style_attr; ?>>

		<?php if( $main_title ): ?>
			<h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($main_title); ?></h2>
		<?php endif; ?>
          <?php if( $subtitle ): ?>
			<div class="subtitle TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($subtitle); ?></div>
		<?php endif; ?>
          <?php if( $main_text ): ?>
			<div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($main_text); ?></div>
		<?php endif; ?>

		<?php
		if($posts):

			$featured_post = false;
			$grid_posts = $posts;

			if( $feature_first_person && !empty($posts[0]) ) {
				$featured_post = $posts[0];
				unset($grid_posts[0]);
				$grid_posts = array_values($grid_posts);
			}

			if( $featured_post ):
				$post = $featured_post;
				setup_postdata($post);
				the72fund_register_team_modal_item( $post );

				$name = get_the_title();
				$position = get_field('position');
				$headshot = get_field('headshot');
				$headshot_url = !empty($headshot['url']) ? $headshot['url'] : '';
				$headshot_alt = !empty($headshot['alt']) ? $headshot['alt'] : $name;
				$swatch = get_field('swatch_color');
				// $swatch_url = !empty($swatch_images[$swatch]) ? $swatch_images[$swatch] : '';
				$bio = apply_filters('the_content', get_the_content()); ?>

				<div class="featured-person">
					<div class="featured-person-image TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750">
						<img class="swatch" src="<?php bloginfo('template_directory'); ?>/images/swatches/swatch_<?php echo $swatch; ?>.png" alt="" aria-hidden="true" />

						<?php if( $headshot_url ): ?>
							<img class="headshot" src="<?php echo esc_url($headshot_url); ?>" alt="<?php echo esc_attr($headshot_alt); ?>" />
						<?php endif; ?>
					</div>

					<div class="featured-person-content">
						<?php if( $name ): ?>
							<h3 class="section-name title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($name); ?></h3>
						<?php endif; ?>

						<?php if( $position ): ?>
							<h6 class="section-position aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($position); ?></h6>
						<?php endif; ?>

						<?php if( $bio ): ?>
							<div class="section-text text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $bio; ?></div>
						<?php endif; ?>
					</div>
				</div>

				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if($grid_posts): ?>
				<div class="section-block">
					<?php
					foreach($grid_posts as $post): // variable must be called $post (IMPORTANT)
						setup_postdata($post);

						$name = get_the_title();
						$position = get_field('position');
						$headshot = get_field('headshot');
						$headshot_url = !empty($headshot['url']) ? $headshot['url'] : '';
						$headshot_alt = !empty($headshot['alt']) ? $headshot['alt'] : $name;
						$swatch = get_field('swatch_color');
						// $swatch_url = !empty($swatch_images[$swatch]) ? $swatch_images[$swatch] : '';
						$excerpt = get_the_excerpt();
						$modal_page_id = the72fund_register_team_modal_item( $post );

						if( !$excerpt ) {
							$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '...' );
						} ?>

						<div class="section-part">
							<?php if( $headshot_url || $swatch_url ): ?>
								<div class="section-image TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750">
									<img class="swatch" src="<?php bloginfo('template_directory'); ?>/images/swatches/swatch_<?php echo $swatch; ?>.png" alt="" aria-hidden="true" />

									<?php if( $headshot_url ): ?>
										<img class="headshot" src="<?php echo esc_url($headshot_url); ?>" alt="<?php echo esc_attr($headshot_alt); ?>" />
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div class="section-content">
								<?php if( $name ): ?>
									<h3 class="section-name title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($name); ?></h3>
								<?php endif; ?>

								<?php if( $position ): ?>
									<h6 class="section-position aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($position); ?></h6>
								<?php endif; ?>

								<?php if( $excerpt ): ?>
									<div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($excerpt); ?></div>
								<?php endif; ?>

								<?php if( $modal_page_id ): ?>
									<div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
										<a class="modal-link btn white-btn secondary-hvr secondary-bdr" href="#<?php echo esc_attr( $modal_page_id ); ?>" data-page-target="<?php echo esc_attr( $modal_page_id ); ?>" data-modal-target="team-members-modal"><span>Read More</span></a>
									</div>
								<?php endif; ?>
							</div>
						</div>

					<?php
					endforeach;
					wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>

		<?php endif; ?>

	</div>
</section>
