<?php

$section_anchor = get_sub_field('section_anchor');
$container_padding = get_sub_field('container_padding');
$container_width = get_sub_field('container_width');

/**
 * Optional visuals
 */
$background_image = get_sub_field('background_image');
$background_color = get_sub_field('background_color');

/**
 * Toggles
 */
$enable_custom_section_margin = (bool) get_sub_field('enable_custom_section_margin');
$enable_custom_container_padding = (bool) get_sub_field('enable_custom_container_padding');

/**
 * Section margin fields
 */
$section_top_margin_desktop = get_sub_field('section_top_margin');
$section_bottom_margin_desktop = get_sub_field('section_bottom_margin');
$section_top_margin_mobile = get_sub_field('section_top_margin_mobile');
$section_bottom_margin_mobile = get_sub_field('section_bottom_margin_mobile');

/**
 * Container padding fields
 */
$container_top_padding_desktop = get_sub_field('container_top_padding');
$container_bottom_padding_desktop = get_sub_field('container_bottom_padding');
$container_top_padding_mobile = get_sub_field('container_top_padding_mobile');
$container_bottom_padding_mobile  = get_sub_field('container_bottom_padding_mobile');

/**
 * Build styles (single style attr per element)
 */
$section_styles = array();
$container_styles = array();

// Background color first (image can sit on top if you use overlays/etc)
if( !empty($background_color) ) {
    $section_styles[] = 'background-color:rgb(var(--' . esc_attr($background_color) . '))';
}

if( !empty($background_image) ) {
    $section_styles[] = "background-image:url('" . esc_url($background_image) . "')";
}

if( $enable_custom_section_margin ) {
    if( $section_top_margin_desktop !== '' && $section_top_margin_desktop !== null ) {
        $section_styles[] = 'margin-top:' . intval($section_top_margin_desktop) . 'px';
    }
    if( $section_bottom_margin_desktop !== '' && $section_bottom_margin_desktop !== null ) {
        $section_styles[] = 'margin-bottom:' . intval($section_bottom_margin_desktop) . 'px';
    }
}

if( $enable_custom_container_padding ) {
    if( $container_top_padding_desktop !== '' && $container_top_padding_desktop !== null ) {
        $container_styles[] = 'padding-top:' . intval($container_top_padding_desktop) . 'px';
    }
    if( $container_bottom_padding_desktop !== '' && $container_bottom_padding_desktop !== null ) {
        $container_styles[] = 'padding-bottom:' . intval($container_bottom_padding_desktop) . 'px';
    }
}

$section_style_attr = !empty($section_styles)
    ? ' style="' . esc_attr(implode('; ', $section_styles)) . ';"'
    : '';

$container_style_attr = !empty($container_styles)
    ? ' style="' . esc_attr(implode('; ', $container_styles)) . ';"'
    : '';

/**
 * Data attributes (only when enabled)
 */
$section_data_attrs = '';
$container_data_attrs = '';

if( $enable_custom_section_margin ) {
    $section_data_attrs =
        ' data-top-margin-desktop="' . esc_attr($section_top_margin_desktop) . '"' .
        ' data-bottom-margin-desktop="' . esc_attr($section_bottom_margin_desktop) . '"' .
        ' data-top-margin-mobile="' . esc_attr($section_top_margin_mobile) . '"' .
        ' data-bottom-margin-mobile="' . esc_attr($section_bottom_margin_mobile) . '"';
}

if( $enable_custom_container_padding ) {
    $container_data_attrs =
        ' data-top-padding-desktop="' . esc_attr($container_top_padding_desktop) . '"' .
        ' data-bottom-padding-desktop="' . esc_attr($container_bottom_padding_desktop) . '"' .
        ' data-top-padding-mobile="' . esc_attr($container_top_padding_mobile) . '"' .
        ' data-bottom-padding-mobile="' . esc_attr($container_bottom_padding_mobile) . '"';
}

?>