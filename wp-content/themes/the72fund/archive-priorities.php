<?php get_header(); ?>

<div class="landing-page priorities-landing">
    
    <?php

    $priorities_options_post_id = 'priorities_options';
    $priorities_landing_post_id = have_rows('priorities_landing', $priorities_options_post_id) ? $priorities_options_post_id : 'options';

    $eyebrow_title = get_field('priorities_eyebrow_title', $priorities_options_post_id);
    $main_title = get_field('priorities_main_title', $priorities_options_post_id);
    $main_text = get_field('priorities_main_text', $priorities_options_post_id);

    $eyebrow_title = $eyebrow_title ?: get_field('priorities_eyebrow_title', 'options');
    $main_title = $main_title ?: get_field('priorities_main_title', 'options');
    $main_text = $main_text ?: get_field('priorities_main_text', 'options');
    $page_h1 = post_type_archive_title( '', false ) ?: __( 'Our Priorities', 'the-72-fund' );

    ?>

    <section class="columns">
        <div class="container default pad">
            <h1 class="screen-reader-text"><?php echo esc_html( $page_h1 ); ?></h1>

            <?php if ( $eyebrow_title || $main_title || $main_text ) : ?>
                <div class="section-head">
                    <?php if ( $eyebrow_title ) : ?>
                        <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $eyebrow_title; ?></h4>
                    <?php endif;
                    if ( $main_title ) : ?>
                        <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $main_title; ?></h2>
                    <?php endif;
                    if ( $main_text ) : ?>
                        <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($main_text); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="section-block large-img">
                <?php if (have_posts()) : while (have_posts()) : the_post();
                
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

                <?php endwhile; endif; ?>
            </div>

        </div>
    </section>

    <?php
    while(the_repeater_field('priorities_landing', $priorities_landing_post_id)):
        get_template_part( 'template-parts/templates/template', 'flexible_sections' );
    endwhile; ?>

</div>

<?php get_footer(); ?>
