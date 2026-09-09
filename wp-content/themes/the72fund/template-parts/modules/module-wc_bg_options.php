<?php
$wc_bg_post_ids = array();

if ( is_singular() ) {
    $wc_bg_post_ids[] = get_queried_object_id();
}

if ( is_post_type_archive('priorities') || is_singular('priorities') ) {
    $wc_bg_post_ids[] = 'priorities_options';
} elseif ( is_post_type_archive('investments') || is_singular('investments') ) {
    $wc_bg_post_ids[] = 'investments_options';
} elseif ( is_post_type_archive('events') || is_singular('events') ) {
    $wc_bg_post_ids[] = 'events_options';
} elseif ( is_home() || is_singular('post') ) {
    $wc_bg_post_ids[] = get_option('page_for_posts');
}

$wc_bg_post_ids[] = 'options';
$wc_bg_post_ids = array_values(array_unique(array_filter($wc_bg_post_ids)));

$static_wc_bg = false;
$static_wc_bg_opacity = false;
$static_wc_bg_top = false;
$static_wc_bg_movement = false;
$dynamic_wc_bgs_post_id = false;

foreach ( $wc_bg_post_ids as $wc_bg_post_id ) {
    $static_wc_bg = get_field('static_wc_bg', $wc_bg_post_id);

    if ( $static_wc_bg ) {
        $static_wc_bg_opacity = get_field('static_wc_bg_opacity', $wc_bg_post_id);
        $static_wc_bg_top = get_field('static_wc_bg_top', $wc_bg_post_id);
        $static_wc_bg_movement = get_field('static_wc_bg_movement', $wc_bg_post_id);
        break;
    }
}

if ( ! $static_wc_bg ) {
    foreach ( $wc_bg_post_ids as $wc_bg_post_id ) {
        $static_wc_bg_opacity_value = get_field('static_wc_bg_opacity', $wc_bg_post_id);
        $static_wc_bg_opacity_value = is_string($static_wc_bg_opacity_value) ? trim($static_wc_bg_opacity_value) : $static_wc_bg_opacity_value;

        if ( $static_wc_bg_opacity_value !== '' && $static_wc_bg_opacity_value !== null && $static_wc_bg_opacity_value !== false ) {
            $static_wc_bg_opacity = $static_wc_bg_opacity_value;
            break;
        }
    }
}

foreach ( $wc_bg_post_ids as $wc_bg_post_id ) {
    if ( have_rows('dynamic_wc_bgs', $wc_bg_post_id) ) {
        $dynamic_wc_bgs_post_id = $wc_bg_post_id;
        break;
    }
}

$static_wc_bg_top = is_numeric($static_wc_bg_top) ? $static_wc_bg_top : 8;
$static_wc_bg_opacity = is_string($static_wc_bg_opacity) ? rtrim(trim($static_wc_bg_opacity), '%') : $static_wc_bg_opacity;
$static_wc_bg_opacity = is_numeric($static_wc_bg_opacity) ? (float) $static_wc_bg_opacity : 25;
$static_wc_bg_opacity = $static_wc_bg_opacity > 1 ? $static_wc_bg_opacity / 100 : $static_wc_bg_opacity;
$static_wc_bg_opacity = max(0, min(1, $static_wc_bg_opacity));
$static_wc_bg_movement = is_numeric($static_wc_bg_movement) ? $static_wc_bg_movement : 8;
if( $static_wc_bg ): ?>
    <img class="static-WC_BG" src="<?php echo esc_url($static_wc_bg); ?>" alt="" aria-hidden="true" data-start-top="<?php echo esc_attr($static_wc_bg_top); ?>" data-movement="<?php echo esc_attr($static_wc_bg_movement); ?>" style="opacity:<?php echo esc_attr($static_wc_bg_opacity); ?>; top:<?php echo esc_attr($static_wc_bg_top); ?>%;">
<?php endif;

if ( $dynamic_wc_bgs_post_id && have_rows('dynamic_wc_bgs', $dynamic_wc_bgs_post_id) ) :
    while ( have_rows('dynamic_wc_bgs', $dynamic_wc_bgs_post_id) ) : the_row();
        $dynamic_wc_bg = get_sub_field('dynamic_wc_bg');
        $dynamic_wc_bg_horizontal_side = get_sub_field('dynamic_wc_bg_horizontal_side');
        $dynamic_wc_bg_vertical_side = get_sub_field('dynamic_wc_bg_vertical_side');
        $dynamic_wc_bg_left = get_sub_field('dynamic_wc_bg_left');
        $dynamic_wc_bg_right = get_sub_field('dynamic_wc_bg_right');
        $dynamic_wc_bg_top = get_sub_field('dynamic_wc_bg_top');
        $dynamic_wc_bg_bottom = get_sub_field('dynamic_wc_bg_bottom');
        $dynamic_wc_bg_width = get_sub_field('dynamic_wc_bg_width');
        $dynamic_wc_bg_opacity = get_sub_field('dynamic_wc_bg_opacity');

        $dynamic_wc_bg_horizontal_side = in_array($dynamic_wc_bg_horizontal_side, array('left', 'right'), true) ? $dynamic_wc_bg_horizontal_side : 'left';
        $dynamic_wc_bg_vertical_side = in_array($dynamic_wc_bg_vertical_side, array('top', 'bottom'), true) ? $dynamic_wc_bg_vertical_side : 'top';

        $dynamic_wc_bg_horizontal_value = 'left' === $dynamic_wc_bg_horizontal_side ? $dynamic_wc_bg_left : $dynamic_wc_bg_right;
        $dynamic_wc_bg_vertical_value = 'top' === $dynamic_wc_bg_vertical_side ? $dynamic_wc_bg_top : $dynamic_wc_bg_bottom;

        $dynamic_wc_bg_styles = array();

        if ( is_numeric($dynamic_wc_bg_horizontal_value) ) {
            $dynamic_wc_bg_styles[] = $dynamic_wc_bg_horizontal_side . ':' . $dynamic_wc_bg_horizontal_value . '%';
        }

        if ( is_numeric($dynamic_wc_bg_vertical_value) ) {
            $dynamic_wc_bg_styles[] = $dynamic_wc_bg_vertical_side . ':' . $dynamic_wc_bg_vertical_value . '%';
        }

        if ( is_numeric($dynamic_wc_bg_width) ) {
            $dynamic_wc_bg_styles[] = 'width:' . $dynamic_wc_bg_width . 'px';
        }

        if ( is_string($dynamic_wc_bg_opacity) ) {
            $dynamic_wc_bg_opacity = rtrim(trim($dynamic_wc_bg_opacity), '%');
            $dynamic_wc_bg_opacity = preg_replace('/[^0-9.]/', '', $dynamic_wc_bg_opacity);
        }

        if ( is_numeric($dynamic_wc_bg_opacity) ) {
            $dynamic_wc_bg_opacity = (float) $dynamic_wc_bg_opacity;
            $dynamic_wc_bg_opacity = $dynamic_wc_bg_opacity > 1 ? $dynamic_wc_bg_opacity / 100 : $dynamic_wc_bg_opacity;
            $dynamic_wc_bg_styles[] = 'opacity:' . max(0, min(1, $dynamic_wc_bg_opacity));
        } ?>
        <?php if ( $dynamic_wc_bg ) : ?>
            <img class="dynamic-WC_BG" src="<?php echo esc_url($dynamic_wc_bg); ?>" alt="" aria-hidden="true"
                 style="<?php echo esc_attr(implode('; ', $dynamic_wc_bg_styles)); ?>;">
        <?php endif; ?>
    <?php
    endwhile;
endif; ?>

<div class="white-overlay"></div>
