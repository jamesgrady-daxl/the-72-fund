	</main><!-- END .page-content -->

	<?php

	$footer_logo = get_field('footer_logo', 'options');
	$main_email = get_field('main_email', 'options');
	$healthcare_disclaimer = get_field('healthcare_disclaimer', 'options');

	if ( ! function_exists( 'the72fund_get_site_credit_item_markup' ) ) {
		function the72fund_get_site_credit_item_markup( $text, $url = '' ) {
			if ( ! $text ) {
				return '';
			}

			if ( $url ) {
					return '<span class="section-credit-value"><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $text ) . the72fund_get_new_tab_text() . '</a></span>';
			}

			return '<span class="section-credit-value">' . esc_html( $text ) . '</span>';
		}
	}

	if ( ! function_exists( 'the72fund_format_site_credit_items' ) ) {
		function the72fund_format_site_credit_items( $items ) {
			$count = count( $items );

			if ( 0 === $count ) {
				return '';
			}

			if ( 1 === $count ) {
				return $items[0];
			}

			if ( 2 === $count ) {
				return $items[0] . '<span class="section-credit-separator"> and </span>' . $items[1];
			}

			$last_item = array_pop( $items );

			return implode( '<span class="section-credit-separator">, </span>', $items ) . '<span class="section-credit-separator">, and </span>' . $last_item;
		}
	}

	ob_start();
	get_template_part( 'template-parts/templates/template', 'social_links_options' );
	$social_links = ob_get_clean();

	$footer_menu = wp_nav_menu( array(
		'theme_location' => 'footer_menu',
		'menu_class'     => 'footer_menu',
		'depth'          => 2,
		'echo'           => false,
	) );

	$last_sub_menu_pos = strrpos( $footer_menu, '<ul class="sub-menu">' );

	if ( false !== $last_sub_menu_pos ) {
		$last_sub_menu_end_pos = strpos( $footer_menu, '</ul>', $last_sub_menu_pos );

		if ( false !== $last_sub_menu_end_pos ) {
			$footer_menu = substr_replace(
				$footer_menu,
				'<li class="menu-item footer-social-menu-item">' . $social_links . '</li>',
				$last_sub_menu_end_pos,
				0
			);
		}
	}

	$footer_menu_mobile = $footer_menu;
	$footer_menu_mobile_links = '<li class="menu-item footer-modal-menu-item"><a class="modal-link" href="#healthcare-disclaimer" data-page-target="healthcare-disclaimer" data-modal-target="healthcare-disclaimer-modal">Healthcare Disclaimer</a></li>';
// 	$footer_menu_mobile_links .= '<li class="menu-item footer-modal-menu-item"><a class="modal-link" href="#site-credits" data-page-target="site-credits" data-modal-target="site-credits-modal">Site Credits</a></li>';
	$footer_menu_mobile_end_pos = strrpos( $footer_menu_mobile, '</ul>' );

	if ( false !== $footer_menu_mobile_end_pos ) {
		$footer_menu_mobile = substr_replace(
			$footer_menu_mobile,
			$footer_menu_mobile_links,
			$footer_menu_mobile_end_pos,
			0
		);
	}

	?>

	<footer class="footer" id="footer">
		<img class="watercolor" src="<?php bloginfo('template_directory'); ?>/images/footer-watercolor.png" alt="" aria-hidden="true">
		<div class="container large">
			<div class="footer-top">
				<div class="footer-left">
					<a class="footer-logo" href="<?php echo home_url(); ?>">
							<img src="<?php echo $footer_logo; ?>" alt="<?php esc_attr_e( 'The 72 Fund', 'the-72-fund' ); ?>" />
					</a>
				</div>
				<div class="footer-right white-text">
					<div class="footer-social"><?php get_template_part( 'template-parts/templates/template', 'social_links_options' ); ?></div>
					<nav class="footer-menu" aria-label="<?php esc_attr_e( 'Footer', 'the-72-fund' ); ?>"><?php echo $footer_menu; ?></nav>
				</div>
			</div>
			<div class="footer-bottom white-text">
					<nav class="footer-menu" aria-label="<?php esc_attr_e( 'Footer mobile', 'the-72-fund' ); ?>"><?php echo $footer_menu_mobile; ?></nav>
				<div class="footer-copyright desktop-only">
					© <?php bloginfo('name'); ?>, <?php echo date('Y'); ?> | <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a> | <a class="modal-link" href="#healthcare-disclaimer" data-page-target="healthcare-disclaimer" data-modal-target="healthcare-disclaimer-modal">Healthcare Disclaimer</a> <!--| <a class="modal-link" href="#site-credits" data-page-target="site-credits" data-modal-target="site-credits-modal">Site Credits</a>-->
				</div>
				<div class="footer-copyright mobile-only">
					<div class="divider TFT-gradient-line_white"></div>
					© <?php bloginfo('name'); ?>, <?php echo date('Y'); ?><br>
					<a href="mailto:<?php echo $main_email; ?>"><?php echo $main_email; ?></a>
				</div>
			</div>
		</div>
	</footer>

	<div id="healthcare-disclaimer-modal" class="custom-modal healthcare-disclaimer-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="healthcare-disclaimer-title" inert>
		<div class="modal-block">
			<button class="modal-close" type="button" aria-label="Close modal"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
			<div id="healthcare-disclaimer" class="modal-page">
				<div class="hd-modal-content">
					<div id="healthcare-disclaimer-title" class="hd-title FT-gradient-line"><strong>Healthcare Disclaimer</strong></div>
					<div class="section-text"><?php echo $healthcare_disclaimer; ?></div>
				</div>
			</div>
		</div>
	</div>

	<div id="site-credits-modal" class="custom-modal site-credits-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="site-credits-title" inert>
		<div class="modal-block">
			<button class="modal-close" type="button" aria-label="Close modal"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
			<div id="site-credits" class="modal-page">
				<div class="sc-modal-content white-text">
					<h3 id="site-credits-title">Site Credits</h3>
					<div class="TFT-gradient-line_white"></div>
					<div class="section-block">
						<?php if ( have_rows( 'site_credits', 'options' ) ) : ?>
							<?php while ( have_rows( 'site_credits', 'options' ) ) : the_row();
								$credit_label = get_sub_field( 'label' );
								$credit_items = array();

								if ( have_rows( 'credits' ) ) {
									while ( have_rows( 'credits' ) ) {
										the_row();

										$credit_text = get_sub_field( 'text' );
										$credit_url  = get_sub_field( 'url' );

										$credit_items[] = the72fund_get_site_credit_item_markup( $credit_text, $credit_url );
									}
								}

								$credit_items = array_filter( $credit_items ); ?>
								<?php if ( $credit_label || $credit_items ) : ?>
									<div class="section-part">
										<?php if ( $credit_label ) : ?>
											<span class="section-label"><?php echo esc_html( $credit_label ); ?></span><?php if ( $credit_items ) : ?><span class="section-separator">:</span><?php endif; ?>
										<?php endif; ?>
										<?php if ( $credit_items ) : ?>
											<span class="section-credit-values"><?php echo wp_kses_post( the72fund_format_site_credit_items( $credit_items ) ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>
						<h6 class="copyright">© <?php bloginfo('name'); ?>, <?php echo date('Y'); ?></h6>
					</div>
				</div>
			</div>
		</div>
	</div>

</div><!-- .page-wrapper END -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script> -->

<script src="<?php bloginfo('template_directory'); ?>/js/slick/slick.min.js"></script>

<?php $aosjsVersion = filemtime(get_template_directory() . '/js/aos/aos.js'); ?>
<script src="<?php bloginfo('template_directory'); ?>/js/aos/aos.js?v=<?php echo $aosjsVersion; ?>"></script>

<?php $customModaljsVersion = filemtime(get_template_directory() . '/js/customModal/customModal.js'); ?>
<script src="<?php bloginfo('template_directory'); ?>/js/customModal/customModal.js?v=<?php echo $customModaljsVersion; ?>"></script>
 
<?php $functionsjsVersion = filemtime(get_template_directory() . '/js/functions.js'); ?>
<script src="<?php bloginfo('template_directory'); ?>/js/functions.js?v=<?php echo $functionsjsVersion; ?>"></script>

<?php wp_footer(); ?>

</body>
</html>
