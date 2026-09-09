<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$eyebrow_title = get_sub_field('eyebrow_title');
$main_title = get_sub_field('main_title');
$main_text = get_sub_field('main_text');

?>

<section class="latest-insights mobile600"
         <?php if ( ! empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
         <?php echo $section_data_attrs; ?>
         <?php echo $section_style_attr; ?>>
    <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
         <?php echo $container_data_attrs; ?>
         <?php echo $container_style_attr; ?>>

        <?php if ( $eyebrow_title || $main_title || $main_text ) : ?>
            <div class="section-head">
                <?php if ( $eyebrow_title ) : ?>
                    <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $eyebrow_title; ?></h4>
                <?php endif;
                if ( $eyebrow_title && ! $main_title ) : ?>
                    <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                <?php endif;
                if ( $main_title ) : ?>
                    <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $main_title; ?></h2>
                <?php endif;
                if ( $main_text ) : ?>
                    <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post($main_text); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        $latest_insights = get_sub_field('latest_insights');
        if ( $latest_insights ) : ?>
            <div class="section-block">
                <?php foreach ( $latest_insights as $post_item ) :

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
                        <?php endif; ?>

                        <?php if ( $title ) : ?>
                            <h3 class="section-title aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <?php echo $title; ?> <!-- esc_html removed from variable so they can put <em> in title -->
                            </h3>
                        <?php endif; ?>

                        <?php // if ( $text ) : ?>
                            <!-- <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <?php // echo wp_kses_post( wpautop( $text ) ); ?>
                            </div> -->
                        <?php // endif; ?>

                        <?php if ( $url && $title ) : ?>
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
