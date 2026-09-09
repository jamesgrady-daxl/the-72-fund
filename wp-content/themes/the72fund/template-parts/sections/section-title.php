<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$title_font = get_sub_field('title_font');
$title_color = get_sub_field('title_color');
$title_alignment = get_sub_field('title_alignment');
$title = get_sub_field('title');

if ( ! in_array( $title_font, array( 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) {
    $title_font = 'h2';
}

?>

<section class="title-section mobile600"
         <?php if( !empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <?php if( $title ): ?>
            <<?php echo esc_html( $title_font ); ?> class="section-title <?php echo esc_attr($title_color); ?>-text align-<?php echo esc_attr($title_alignment); ?> aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($title); ?></<?php echo esc_html( $title_font ); ?>>
        <?php endif; ?>
        
    </div>
</section>
