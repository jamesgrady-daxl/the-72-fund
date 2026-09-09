<?php get_header();

include locate_template('template-parts/modules/module-section_toolkit.php');

$show_image_popup_button = get_field( 'show_image_popup_button' );
$image_popup_button_text = get_field( 'image_popup_button_text' ) ?: 'View Full Screen';
$image_popup_image = get_field( 'image_popup_image' );
$image_popup_text = get_field( 'image_popup_text' );
$image_popup_image_url = '';
$image_popup_image_alt = get_the_title();

if ( is_array( $image_popup_image ) ) {
    $image_popup_image_url = ! empty( $image_popup_image['url'] ) ? $image_popup_image['url'] : '';
    $image_popup_image_alt = ! empty( $image_popup_image['alt'] ) ? $image_popup_image['alt'] : $image_popup_image_alt;
}

?>

<div class="post-single priorities-single">

    <div class="container large" style="padding-bottom:0 !important;">
        <a class="back-btn btn tertiary-btn primary_100-hvr tertiary-bdr aos fadeup" data-animDelay="250" data-animSpeed="750" href="<?php echo home_url(); ?>/our-priorities/">
            <img src="<?php bloginfo('template_directory'); ?>/images/arrow-left_primary.png" alt="" aria-hidden="true" />
            Our Priorities
        </a>
    </div>
    <section class="post-content">
        <div class="container medium pad" style="padding-block:0 !important;">
            <button class="featured-image modal-link aos fadeup" type="button" data-animDelay="250" data-animSpeed="750" data-page-target="priority-full-screen" data-modal-target="priority-full-screen-modal" aria-label="<?php echo esc_attr( 'View ' . get_the_title() . ' full screen' ); ?>">
                <?php the_post_thumbnail(); ?>
            </button>
        </div>
        <div class="container small pad" style="padding-top:0 !important;">
            <?php if ( $show_image_popup_button ) : ?>
                <button class="modal-link full-screen-btn btn icon-btn tertiary-btn primary_100-hvr tertiary-bdr aos fadeup" type="button" data-animDelay="250" data-animSpeed="750" data-page-target="priority-full-screen" data-modal-target="priority-full-screen-modal" aria-label="<?php echo esc_attr( $image_popup_button_text ); ?>">
                    <img class="icon" src="<?php bloginfo('template_directory'); ?>/images/icon-burst-orange.png" alt="" aria-hidden="true"><?php echo esc_html( $image_popup_button_text ); ?>
                </button>
            <?php endif; ?>
            <h1 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_title(); ?></h1>
            <h3 class="section-excerpt aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_excerpt(); ?></h3>
            <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
            <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_content(); ?></div>
        </div>
    </section>

    <div id="priority-full-screen-modal" class="custom-modal priority-full-screen-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php echo esc_attr( get_the_title() . ' full screen image' ); ?>" inert>
        <div class="modal-block">
            <button class="modal-close" type="button" aria-label="<?php esc_attr_e( 'Close modal', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
            <div id="priority-full-screen" class="modal-page">
                <?php if ( $image_popup_image_url ) : ?>
                    <img src="<?php echo esc_url( $image_popup_image_url ); ?>" alt="<?php echo esc_attr( $image_popup_image_alt ); ?>" />
                <?php else : ?>
                    <?php the_post_thumbnail(); ?>
                <?php endif; ?>
                <?php if ( $image_popup_text ) : ?>
                    <div class="image-popup-text"><?php echo wp_kses_post( wpautop( $image_popup_text ) ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php

    $related = get_field('related');
    $related_carousel_class = is_array( $related ) && count( $related ) > 3 ? ' has-related-carousel' : '';
    $related_button = get_field( 'related_button' );
    $related_button_url = ! empty( $related_button['url'] ) ? $related_button['url'] : '';
    $related_button_title = ! empty( $related_button['title'] ) ? $related_button['title'] : '';
    $related_button_target = ! empty( $related_button['target'] ) ? $related_button['target'] : '_self';
    $related_button_rel = '_blank' === $related_button_target ? 'noopener noreferrer' : '';
    $related_eyebrow_title = 'Related articles & upcoming events';
    // $related_main_title = get_sub_field('main_title');
    // $related_main_text = get_sub_field('main_text');

    ?>

    <?php if ( $related ) : ?>
    <section class="latest-insights<?php echo esc_attr( $related_carousel_class ); ?>" id="related">
        <div class="container default pad">

            <?php if ( $related_eyebrow_title || $related_main_title || $related_main_text ) : ?>
                <div class="section-head">
                    <?php if ( $related_eyebrow_title ) : ?>
                        <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $related_eyebrow_title; ?></h4>
                    <?php endif;
                    if ( $related_eyebrow_title && ! $related_main_title ) : ?>
                        <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                    <?php endif;
                    if ( $related_button_url && $related_button_title ) : ?>
                        <a class="related-button btn white-btn secondary-hvr secondary-bdr aos fadeup" data-animDelay="250" data-animSpeed="750" href="<?php echo esc_url( $related_button_url ); ?>" target="<?php echo esc_attr( $related_button_target ); ?>" <?php if ( $related_button_rel ) : ?>rel="<?php echo esc_attr( $related_button_rel ); ?>"<?php endif; ?>><span><?php echo esc_html( $related_button_title ); ?><?php echo '_blank' === $related_button_target ? the72fund_get_new_tab_text() : ''; ?></span></a>
                    <?php endif;
                    // if ( $related_main_title ) : ?>
                        <!-- <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php // echo $related_main_title; ?></h2> -->
                    <?php // endif;
                    // // if ( $related_main_text ) : ?>
                        <!-- <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php // echo wp_kses_post($related_main_text); ?></div> -->
                    <?php // endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( $related ) : ?>
                <div class="section-block">
                    <?php foreach ( $related as $post_item ) :

                        $post_id = is_object( $post_item ) ? $post_item->ID : $post_item;

                        $title = get_the_title( $post_id );
                        $text  = get_the_excerpt( $post_id );
                        $url   = get_permalink( $post_id );

                        $image_url = get_the_post_thumbnail_url( $post_id, 'full' );
                        $image_alt = '';

                        if ( has_post_thumbnail( $post_id ) ) {
                            $thumbnail_id = get_post_thumbnail_id( $post_id );
                            $image_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );

                            if ( ! $image_alt ) {
                                $image_alt = $title;
                            }
                        } else {
                            $image_url = get_template_directory_uri() . '/images/placeholder.png';
                            $image_alt = $title;
                        } ?>

                        <a class="section-part" href="<?php echo esc_url( $url ); ?>">
                            <?php if ( $image_url ) : ?>
                                <div class="section-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" />
                                </div>
                            <?php endif;
                            if ( $title ) : ?>
                                <h3 class="section-title aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <?php echo $title; ?> <!-- esc_html removed from variable so they can put <em> in title -->
                                </h3>
                            <?php endif;
                            // if ( $text ) : ?>
                                <!-- <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <?php // echo wp_kses_post( wpautop( $text ) ); ?>
                                </div> -->
                            <?php // endif;
                            if ( $url && $title ) : ?>
                                <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <span class="btn white-btn">Read More</span>
                                </div>
                            <?php endif; ?>
                        </a>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
    <?php endif; ?>

    <?php

    $columns_eyebrow_title = 'See All Our Priorities';
    // $columns_columns_main_title = get_sub_field('main_title');
    // $columns_main_text = get_sub_field('main_text');

    $current_post_id   = get_the_ID();
    $current_post_type = get_post_type($current_post_id);

    $other_posts = new WP_Query(array(
        'post_type'      => $current_post_type,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'post__not_in'   => array($current_post_id),
    ));

    ?>

    <?php if ( $other_posts->have_posts() ) : ?>
    <section class="columns" style="margin-bottom:20px;">
        <div class="container default pad">

            <?php if ( $columns_eyebrow_title || $columns_main_title || $columns_main_text ) : ?>
                <div class="section-head">
                    <?php if ( $columns_eyebrow_title ) : ?>
                        <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $columns_eyebrow_title; ?></h4>
                    <?php endif;
                    if ( $columns_eyebrow_title && ! $columns_main_title ) : ?>
                        <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                    <?php endif;
                    // if ( $columns_main_title ) : ?>
                        <!-- <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php // echo $columns_main_title; ?></h2> -->
                    <?php // endif;
                    // if ( $columns_main_text ) : ?>
                        <!-- <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php // echo wp_kses_post($columns_main_text); ?></div> -->
                    <?php // endif; ?>
                </div>
            <?php endif; ?>

            <div class="section-block large-img">
                <?php
                while ($other_posts->have_posts()) : $other_posts->the_post();

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

                <?php
                endwhile;
                wp_reset_postdata(); ?>
            </div>

        </div>
    </section>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
