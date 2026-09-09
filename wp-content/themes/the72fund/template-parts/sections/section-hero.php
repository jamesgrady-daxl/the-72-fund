<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$main_icon = get_sub_field('main_icon');
$main_icon_url = ! empty($main_icon['url']) ? $main_icon['url'] : '';
$main_icon_type = ! empty($main_icon['mime_type']) ? $main_icon['mime_type'] : '';
$main_icon_alt = ! empty($main_icon['alt']) ? $main_icon['alt'] : '';
$main_title = get_sub_field('main_title');
$main_text = get_sub_field('main_text');
$main_text2 = get_sub_field('main_text2');
$main_media = get_sub_field('main_media');
$main_media_url = ! empty($main_media['url']) ? $main_media['url'] : '';
$main_media_type = ! empty($main_media['mime_type']) ? $main_media['mime_type'] : '';
$main_media_alt = ! empty($main_media['alt']) ? $main_media['alt'] : '';

$main_media_is_image = $main_media_type && 0 === strpos($main_media_type, 'image/');
$main_media_is_video = $main_media_type && 0 === strpos($main_media_type, 'video/');
$main_icon_is_image = $main_icon_type && 0 === strpos($main_icon_type, 'image/');
$main_icon_is_video = $main_icon_type && 0 === strpos($main_icon_type, 'video/');

?>

<section class="hero mobile600"
         <?php if( !empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <?php if ( $main_icon_url && ( $main_icon_is_image || $main_icon_is_video ) ) : ?>
            <div class="section-icon aos fadeup" data-animDelay="250" data-animSpeed="750">
                <?php if ( $main_icon_is_image ) : ?>
                    <img src="<?php echo esc_url($main_icon_url); ?>" alt="<?php echo esc_attr($main_icon_alt); ?>" />
                <?php elseif ( $main_icon_is_video ) : ?>
                    <video autoplay muted playsinline preload="metadata">
                        <source src="<?php echo esc_url($main_icon_url); ?>" type="<?php echo esc_attr($main_icon_type); ?>" />
                    </video>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="section-block">
            <?php if( $main_title ): ?>
                <div class="section-title aos wiperight" data-animDelay="250" data-animSpeed="750">
                    <h2><?php echo $main_title; ?></h2>
                </div>
            <?php endif;
            if( $main_text ): ?>
                <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750">
                    <?php echo $main_text; ?>
                </div>
            <?php endif;
            if( $main_text2 ): ?>
                <div class="section-text section-text2 aos fadeup" data-animDelay="250" data-animSpeed="750">
                    <?php echo $main_text2; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if( $main_media_url && ( $main_media_is_image || $main_media_is_video ) ): ?>
            <div class="section-media">
                <?php if ( $main_media_is_image ) : ?>
                    <img src="<?php echo esc_url($main_media_url); ?>" alt="<?php echo esc_attr($main_media_alt); ?>" />
                <?php elseif ( $main_media_is_video ) : ?>
                    <video autoplay muted playsinline preload="metadata">
                        <source src="<?php echo esc_url($main_media_url); ?>" type="<?php echo esc_attr($main_media_type); ?>" />
                    </video>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <a class="arrow aos fadeup" data-animDelay="250" data-animSpeed="750" href="#solutions" data-desktop-target="#solutions" data-mobile-target="#hero-priorities">
            <img src="<?php bloginfo('template_directory'); ?>/images/arrow-down.png" alt="" aria-hidden="true">
        </a>
        
        <?php
        $priorities_options_post_id = 'priorities_options';
        $priorities_landing_post_id = have_rows('priorities_landing', $priorities_options_post_id) ? $priorities_options_post_id : 'options'; ?>

        <section class="columns mobile-only" id="hero-priorities">
            <div class="container default pad">

                <div class="section-head">
                    <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750">Our Priorities</h4>
                </div>

                <div class="section-block large-img">
                    <?php
                    $priorities_query = new WP_Query( array(
                        'post_type'      => 'priorities',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                    ) );

                    if ( $priorities_query->have_posts() ) : while ( $priorities_query->have_posts() ) : $priorities_query->the_post();
                    
                        $image_id = get_field('small_image');
                        $image_url = wp_get_attachment_image_url($image_id, 'full');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); ?>

                        <a class="section-part" href="<?php the_permalink(); ?>">
                            <div class="section-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <!-- <img src="<?php // echo esc_url($image_url); ?>" alt="<?php // echo esc_attr($image_alt); ?>" /> -->
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="" />
                            </div>
                            <h3 class="section-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_title(); ?></h3>
                            <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_excerpt(); ?></div>
                            <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <span class="btn white-btn">Read More</span>
                            </div>
                        </a>

                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>

            </div>
        </section>

    </div>
</section>
