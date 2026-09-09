<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$background_position = get_sub_field('background_position');
$text_color = get_sub_field('text_color');
$text = get_sub_field('text');

?>

<section class="text-section mobile600 background-<?php echo esc_attr($background_position); ?>"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

         <div class="section-text <?php echo esc_attr($text_color); ?>-text text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($text); ?></div>

    </div>
</section>