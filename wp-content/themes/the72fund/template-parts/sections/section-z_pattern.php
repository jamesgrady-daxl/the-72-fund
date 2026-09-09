<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$eyebrow_title = get_sub_field('eyebrow_title');
$main_title = get_sub_field('main_title');
$main_text = get_sub_field('main_text');

$content_order = get_sub_field('content_order');
$content_alignment = get_sub_field('content_alignment');
$media_width = get_sub_field('media_width');

$image = get_sub_field('image');
$max_image_size = get_sub_field('max_image_size');
$image_bg_swatch = get_sub_field('image_bg_swatch');

$image_url = '';
$image_alt = '';
$image_caption = '';
$image_bg_swatch_url = '';

if ( is_array($image) ) {
    $image_url = ! empty($image['url']) ? $image['url'] : '';
    $image_alt = ! empty($image['alt']) ? $image['alt'] : '';
    $image_caption = ! empty($image['caption']) ? $image['caption'] : '';
} elseif ( is_numeric($image) ) {
    $image_url = wp_get_attachment_image_url($image, 'full');
    $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
} elseif ( is_string($image) ) {
    $image_url = $image;
}

if ( is_array($image_bg_swatch) ) {
    $image_bg_swatch_url = ! empty($image_bg_swatch['url']) ? $image_bg_swatch['url'] : '';
} elseif ( is_numeric($image_bg_swatch) ) {
    $image_bg_swatch_url = wp_get_attachment_image_url($image_bg_swatch, 'full');
} elseif ( is_string($image_bg_swatch) ) {
    $image_bg_swatch_url = $image_bg_swatch;
}

$text_width = get_sub_field('text_width');
$text = get_sub_field('text');

$button = get_sub_field('button');

?>

<section class="z-pattern mobile600"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?> <?php echo $content_order; ?> content-align-<?php echo $content_alignment; ?>"
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
        
        <div class="section-block">
            <?php if ($content_order == 'mediafirst') { ?>
            <div class="section-half media-half aos fadeup" data-animDelay="250" data-animSpeed="750" style="width:<?php echo $media_width; ?>%;">
            <?php } else { ?>
            <div class="section-half media-half aos fadeup" data-animDelay="250" data-animSpeed="750" style="width:calc(100% - <?php echo $text_width; ?>%);">
            <?php } ?>
                <?php if ( $image_bg_swatch_url ) : ?>
                    <img class="img-bg-swatch" src="<?php echo esc_url($image_bg_swatch_url); ?>" alt="" aria-hidden="true" />
                <?php endif;
                if ( $image_url ) : ?>
                    <img class="<?php echo esc_attr($max_image_size); ?>Img" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                    <?php if ( $image_caption ) : ?>
                        <div class="image-caption"><?php echo wp_kses_post($image_caption); ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if ($content_order == 'textfirst') { ?>
            <div class="section-half text-half text aos fadeup" data-animDelay="250" data-animSpeed="750" style="width:<?php echo $text_width; ?>%;">
            <?php } else { ?>
            <div class="section-half text-half text aos fadeup" data-animDelay="250" data-animSpeed="750" style="width:calc(100% - <?php echo $media_width; ?>%);">
            <?php } ?>
                <?php echo $text;
                if( $button ):
                    $button_url = $button['url'];
                    $button_title = $button['title'];
                    $button_target = $button['target'] ? $button['target'] : '_self';
                    $button_rel = '_blank' === $button_target ? 'noopener noreferrer' : ''; ?>
                    <div class="section-button">
                        <a class="btn secondary-btn primary-hvr secondary-bdr" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" <?php if ( $button_rel ) : ?>rel="<?php echo esc_attr($button_rel); ?>"<?php endif; ?>><span><?php echo esc_html($button_title); ?><?php echo '_blank' === $button_target ? the72fund_get_new_tab_text() : ''; ?></span></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>
