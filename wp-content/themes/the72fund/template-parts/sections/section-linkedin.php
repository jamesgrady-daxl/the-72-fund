<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$background_position = get_sub_field('background_position');
$main_text = get_sub_field('main_text');
$full_feed = get_sub_field('full_feed');
$small_feed = get_sub_field('small_feed');

if ( ! function_exists( 'the72fund_add_iframe_title' ) ) {
    function the72fund_add_iframe_title( $embed_html, $title ) {
        if ( empty( $embed_html ) ) {
            return '';
        }

        return preg_replace_callback(
            '/<iframe\b(?![^>]*\btitle=)([^>]*)>/i',
            function( $matches ) use ( $title ) {
                return '<iframe title="' . esc_attr( $title ) . '"' . $matches[1] . '>';
            },
            $embed_html
        );
    }
}

?>

<section class="linkedin mobile600 background-<?php echo esc_attr($background_position); ?>"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>
        <div class="container-inner">
            <div class="main-text text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($main_text); ?></div>
            <div class="feed full-feed aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo the72fund_add_iframe_title( $full_feed, __( 'LinkedIn feed', 'the-72-fund' ) ); ?></div>
            <div class="feed small-feed aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo the72fund_add_iframe_title( $small_feed, __( 'LinkedIn mobile feed', 'the-72-fund' ) ); ?></div>
        </div>
	</div>
</section>
