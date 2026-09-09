<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$main_title = get_sub_field('main_title');
$text = get_sub_field('text');
$form_shortcode = get_sub_field('form_shortcode');

?>

<section class="contact mobile600"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <?php if( $main_title ): ?>
            <h2 class="section-title main-heading aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($main_title); ?></h2>
        <?php endif; ?>

        <div class="section-block">
            <?php if( $form_shortcode ): ?>
                <div class="left-side">
                    <div class="form-wrap aos fadeup" data-animDelay="250" data-animSpeed="750">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( $text ): ?>
                <div class="right-side">
                    <div class="section-text text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($text); ?></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>