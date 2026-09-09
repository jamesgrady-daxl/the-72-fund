<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$quote = get_sub_field('quote');
$name = get_sub_field('name');
$position = get_sub_field('position');
$image = get_sub_field('image');

$has_image = !empty($image);
$image_url = $has_image && !empty($image['url']) ? $image['url'] : '';
$image_alt = $has_image && !empty($image['alt']) ? $image['alt'] : '';

if( !function_exists('the72fund_strip_wrapping_quote_marks') ) {
    function the72fund_strip_wrapping_quote_marks($content) {
        $content = trim($content);
        $content = preg_replace('/^(\s*(?:<[^>]+>\s*)*)(?:[“"]|&ldquo;|&#8220;|&#x201c;)\s*/iu', '$1', $content);
        $content = preg_replace('/\s*(?:[”"]|&rdquo;|&#8221;|&#x201d;)((?:\s*<\/[^>]+>)*\s*)$/iu', '$1', $content);

        return $content;
    }
}

?>

<section class="quote mobile600"
         <?php if( !empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <div class="section-block <?php echo $has_image ? 'has-image' : 'no-image'; ?>">

            <div class="left-side<?php if( !$has_image ): ?> empty-image<?php endif; ?>">
                <?php if( $image ): ?>
                    <div class="section-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                    </div>
                <?php endif; ?>
            </div>

            <div class="right-side">
                <?php if( $quote ): ?>
                    <div class="section-quote title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post(the72fund_strip_wrapping_quote_marks($quote)); ?></div>
                <?php endif; ?>

                <?php if( $name || $position ): ?>
                    <div class="section-meta">
                        <?php if( $name ): ?>
                            <h2 class="section-name aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($name); ?></h2>
                        <?php endif; ?>

                        <?php if( $position ): ?>
                            <h6 class="section-position aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html($position); ?></h6>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>
