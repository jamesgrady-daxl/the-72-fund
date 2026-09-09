<?php

$section_anchor = get_sub_field('section_anchor');

$container = get_sub_field('container');
$section_top_margin_desktop = get_sub_field('section_top_margin');
$section_bottom_margin_desktop = get_sub_field('section_bottom_margin');
$section_top_margin_mobile = get_sub_field('section_top_margin_mobile');
$section_bottom_margin_mobile = get_sub_field('section_bottom_margin_mobile');

$button = get_sub_field('button');
$button_url = $button['url'];
$button_title = $button['title'];
$button_target = $button['target'] ? $button['target'] : '_self';
$button_rel = '_blank' === $button_target ? 'noopener noreferrer' : '';
$button_alignment = get_sub_field('button_alignment');
$button_size = get_sub_field('button_size');
$button_color = get_sub_field('button_color');
$button_hover_color = get_sub_field('button_hover_color');

?>

<section class="button" id="<?php echo $section_anchor; ?>">
    <div class="container <?php echo $container; ?> mobile600"
         data-top-margin-desktop="<?php echo $section_top_margin_desktop; ?>" data-bottom-margin-desktop="<?php echo $section_bottom_margin_desktop; ?>"
         data-top-margin-mobile="<?php echo $section_top_margin_mobile; ?>" data-bottom-margin-mobile="<?php echo $section_bottom_margin_mobile; ?>"
         style="margin-top:<?php echo $section_top_margin_desktop; ?>px; margin-bottom:<?php echo $section_bottom_margin_desktop; ?>px;">
        <!-- <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750"> -->
            <?php if( $button ):  ?>
                <div class="section-button button-<?php echo $button_alignment; ?> aos fadeup" data-animDelay="250" data-animSpeed="750">
	                    <a class="btn <?php echo esc_attr($button_size); ?>-btn <?php echo esc_attr($button_color); ?>-btn <?php echo esc_attr($button_hover_color); ?>-hvr" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" <?php if ( $button_rel ) : ?>rel="<?php echo esc_attr($button_rel); ?>"<?php endif; ?>><?php echo esc_html($button_title); ?><?php echo '_blank' === $button_target ? the72fund_get_new_tab_text() : ''; ?></a>
                </div>
            <?php endif; ?>
        <!-- </div> -->
	</div>
</section>
