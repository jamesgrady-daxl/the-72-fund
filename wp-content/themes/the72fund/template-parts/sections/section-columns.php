<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$eyebrow_title = get_sub_field('eyebrow_title');
$main_title = get_sub_field('main_title');
$main_text = get_sub_field('main_text');
$column_image_size = get_sub_field('column_image_size');
$enable_mobile_carousel = get_sub_field('enable_mobile_carousel');
$mobile_carousel_class = $enable_mobile_carousel ? ' has-mobile-carousel' : '';

?>

<section class="columns mobile600<?php echo esc_attr($mobile_carousel_class); ?>"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <?php if ( $eyebrow_title || $main_title || $main_text ) : ?>
            <div class="section-head">
                <?php if ( $eyebrow_title ) : ?>
                    <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $eyebrow_title; ?></h4>
                <?php endif;
                if ( $eyebrow_title && ! $main_title ) : ?>
                    <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                <?php endif;
                if ( $main_title ) : ?>
                    <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $main_title; ?></h2>
                <?php endif;
                if ( $main_text ) : ?>
                    <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($main_text); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="section-block <?php echo esc_attr($column_image_size); ?>-img">
            <?php if ( have_rows('columns') ) : ?>
                <?php while ( have_rows('columns') ) : the_row();

                    $image = get_sub_field('image');
                    $title = get_sub_field('title');
                    $text = get_sub_field('text');
                    $button = get_sub_field('button');

                    $image_url = '';
                    $image_alt = '';

                    if ( is_array($image) ) {
                        $image_url = ! empty($image['url']) ? $image['url'] : '';
                        $image_alt = ! empty($image['alt']) ? $image['alt'] : '';
                    } elseif ( is_numeric($image) ) {
                        $image_url = wp_get_attachment_image_url($image, 'full');
                        $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                    } elseif ( is_string($image) ) {
                        $image_url = $image;
                    }
                    
                    if ( $button ) {
                    $button_url = ! empty($button['url']) ? $button['url'] : '';
                    $button_title = ! empty($button['title']) ? $button['title'] : '';
                    $button_target = ! empty($button['target']) ? $button['target'] : '_self';
                    $button_rel = '_blank' === $button_target ? 'noopener noreferrer' : ''; ?>
                    <a class="section-part" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" <?php if ( $button_rel ) : ?>rel="<?php echo esc_attr($button_rel); ?>"<?php endif; ?>>
                    <?php } else { ?>
                    <div class="section-part">
                    <?php }
                        if ( $image_url ) : ?>
                            <div class="section-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo $button && $title ? '' : esc_attr($image_alt); ?>" />
                            </div>
                        <?php endif;
                        if ( $title ) : ?>
                            <h3 class="section-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($title); ?></h3>
                        <?php endif;
                        if ( $text ) : ?>
                            <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($text); ?></div>
                        <?php endif;
                        if ( $button ) : ?>
                            <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <span class="btn white-btn">
                                    <span><?php echo esc_html($button_title); ?></span>
                                </span>
                            </div>
                        <?php endif;
                    if ( $button ) { ?>
                    </a>
                    <?php } else { ?>
                    </div>
                    <?php } ?>

                <?php
                endwhile;
            endif; ?>
        </div>

    </div>
</section>
