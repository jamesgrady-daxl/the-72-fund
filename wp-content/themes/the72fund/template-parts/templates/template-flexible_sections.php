<div class="flexible">

	<?php
	if(have_rows('flexible_content')):
	    while(have_rows('flexible_content')): the_row();
	
			if(get_row_layout()=='hero'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='hero'):
									
										get_template_part( 'template-parts/sections/section', 'hero' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'hero' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='title'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='title'):
									
										get_template_part( 'template-parts/sections/section', 'title' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'title' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='text'): // SEO/Accessibility DONE ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='text'):
									
										get_template_part( 'template-parts/sections/section', 'text' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'text' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='button'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='button'):
									
										get_template_part( 'template-parts/sections/section', 'button' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'button' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='columns'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='columns'):
									
										get_template_part( 'template-parts/sections/section', 'columns' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'columns' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='logos'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='logos'):
									
										get_template_part( 'template-parts/sections/section', 'logos' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'logos' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='latest_insights'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='latest_insights'):
									
										get_template_part( 'template-parts/sections/section', 'latest_insights' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'latest_insights' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='quote'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='quote'):
									
										get_template_part( 'template-parts/sections/section', 'quote' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'quote' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='z_pattern'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='z_pattern'):
									
										get_template_part( 'template-parts/sections/section', 'z_pattern' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'z_pattern' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='team'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='team'):
									
										get_template_part( 'template-parts/sections/section', 'team' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'team' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='contact'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='contact'):
									
										get_template_part( 'template-parts/sections/section', 'contact' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'contact' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='video'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='video'):
									
										get_template_part( 'template-parts/sections/section', 'video' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'video' );

						endwhile;
					endif;

				}
				
			elseif(get_row_layout()=='linkedin'): // ============================================================
				
				$use_premade_module = get_sub_field('use_premade_module');
				if ( $use_premade_module ) {

					$module = get_sub_field('premade_module');
					if($module):
						foreach($module as $post):
							setup_postdata($post);
							
							if(have_rows('flexible_content')):
								while(have_rows('flexible_content')): the_row();
							
									if(get_row_layout()=='linkedin'):
									
										get_template_part( 'template-parts/sections/section', 'linkedin' );

									endif;
		   
								endwhile;
							endif;
							
						endforeach;
					wp_reset_postdata();
					endif;

				} else {

					if ( have_rows('section') ) :
						while ( have_rows('section') ) : the_row();

							get_template_part( 'template-parts/sections/section', 'linkedin' );

						endwhile;
					endif;

				}
				
			endif;
		   
		endwhile;
	endif; ?>

</div>