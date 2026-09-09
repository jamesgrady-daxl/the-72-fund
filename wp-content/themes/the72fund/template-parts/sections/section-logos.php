<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$eyebrow_title = get_sub_field('eyebrow_title');
$main_title = get_sub_field('main_title');
$main_text = get_sub_field('main_text');
$button = get_sub_field('button');

?>

<section class="logos mobile600"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
     <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

          <?php if ( $eyebrow_title || $main_title || $main_text ) : ?>
               <div class="section-head">
                    <?php if ( $eyebrow_title ) : ?>
                         <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($eyebrow_title); ?></h4>
                    <?php endif;
                    if ( $eyebrow_title && ! $main_title ) : ?>
                         <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                    <?php endif;
                    if ( $main_title ) : ?>
                         <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($main_title); ?></h2>
                    <?php endif;
                    if ( $main_text ) : ?>
                         <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($main_text); ?></div>
                    <?php endif; ?>
               </div>
          <?php endif; ?>

          <?php if ( have_rows('logos') ) : ?>
               <div class="section-block">
                    <?php while ( have_rows('logos') ) : the_row();

                         $logo = get_sub_field('logo');
                         $logo_url = '';
                         $logo_alt = '';

                         if ( is_array($logo) ) {
                              $logo_url = ! empty($logo['url']) ? $logo['url'] : '';
                              $logo_alt = ! empty($logo['alt']) ? $logo['alt'] : '';
                         } elseif ( is_numeric($logo) ) {
                              $logo_url = wp_get_attachment_image_url($logo, 'full');
                              $logo_alt = get_post_meta($logo, '_wp_attachment_image_alt', true);
                         } elseif ( is_string($logo) ) {
                              $logo_url = $logo;
                         }

                         if ( ! $logo_url ) {
                              continue;
                         } ?>

                         <div class="section-part aos fadeup" data-animDelay="250" data-animSpeed="750">
                              <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" />
                         </div>

                    <?php endwhile; ?>
               </div>
          <?php endif; ?>

          <?php
          if ( $button ) :
               $button_url = ! empty($button['url']) ? $button['url'] : '';
               $button_title = ! empty($button['title']) ? $button['title'] : '';
               $button_target = ! empty($button['target']) ? $button['target'] : '_self';
               $button_rel = '_blank' === $button_target ? 'noopener noreferrer' : '';

               if ( $button_url && $button_title ) : ?>
                    <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
	                         <a class="btn secondary-btn primary-hvr secondary-bdr" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" <?php if ( $button_rel ) : ?>rel="<?php echo esc_attr($button_rel); ?>"<?php endif; ?>><span><?php echo esc_html($button_title); ?><?php echo '_blank' === $button_target ? the72fund_get_new_tab_text() : ''; ?></span></a>
                    </div>
               <?php endif; ?>
          <?php endif; ?>

    </div>
</section>
