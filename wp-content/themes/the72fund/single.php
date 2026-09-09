<?php get_header();

include locate_template('template-parts/modules/module-section_toolkit.php');

?>

<div class="post-single insights-single">

    <div class="container large aos fadeup" data-animDelay="250" data-animSpeed="750" style="padding-bottom:0 !important;">
        <a class="back-btn btn tertiary-btn primary_100-hvr tertiary-bdr" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
            <img src="<?php bloginfo('template_directory'); ?>/images/arrow-left_primary.png" alt="" aria-hidden="true" />
            All Insights
        </a>
    </div>
    <section class="post-content">
        <div class="container small pad" style="padding-top:0 !important;">

            <div class="featured-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                <?php
                if ( have_posts() ) : while ( have_posts() ) : the_post();

                    // Function to get the filtered post (previous or next)
                    function get_filtered_post($direction = 'next') {
                        if ($direction === 'previous') {
                            $post = get_previous_post();
                            $get_post_function = 'get_previous_post';
                        } else {
                            $post = get_next_post();
                            $get_post_function = 'get_next_post';
                        }
                        return $post;
                    }

                    // Display the link to the next post
                    $next_post = get_filtered_post('next');
                    if ($next_post) {
                        $next_post_link = get_permalink($next_post->ID);
                        $next_post_title = get_the_title($next_post->ID);
                        echo '<a class="post-nav-arrow left-arrow" href="' . esc_url($next_post_link) . '" aria-label="' . esc_attr( sprintf( __( 'Next insight: %s', 'the-72-fund' ), $next_post_title ) ) . '"><img src="' . esc_url( get_template_directory_uri() . '/images/arrow-prev.png' ) . '" alt="" aria-hidden="true" /></a>';
                    }

                    // Display the link to the previous post
                    $previous_post = get_filtered_post('previous');
                    if ($previous_post) {
                        $previous_post_link = get_permalink($previous_post->ID);
                        $previous_post_title = get_the_title($previous_post->ID);
                        echo '<a class="post-nav-arrow right-arrow" href="' . esc_url($previous_post_link) . '" aria-label="' . esc_attr( sprintf( __( 'Previous insight: %s', 'the-72-fund' ), $previous_post_title ) ) . '"><img src="' . esc_url( get_template_directory_uri() . '/images/arrow-next.png' ) . '" alt="" aria-hidden="true" /></a>';
                    }

                endwhile; endif;
                the_post_thumbnail(); ?>
            </div>
            <h1 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_title(); ?></h1>
            <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
            <?php
            $reading_time_content = wp_strip_all_tags( strip_shortcodes( get_the_content() ) );
            $reading_time_minutes = max( 1, ceil( str_word_count( $reading_time_content ) / 200 ) );
            $resource_terms = get_the_category();
            $priority_terms = get_the_terms( get_the_ID(), 'priority_area' );
            $post_date_label = get_the_date( 'M j, Y' );
            $resource_label = ! empty( $resource_terms ) ? $resource_terms[0]->name : __( 'Article', 'the-72-fund' );
            $priority_label = ( $priority_terms && ! is_wp_error( $priority_terms ) ) ? $priority_terms[0]->name : '';
            $intro_text = get_field( 'intro_text' ); ?>
            <div class="section-icons aos fadeup" data-animDelay="250" data-animSpeed="750">
                <button class="section-icon" type="button" aria-expanded="false" aria-label="<?php echo esc_attr( sprintf( __( 'Published %1$s, %2$d minute read', 'the-72-fund' ), $post_date_label, $reading_time_minutes ) ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-calendar.png' ); ?>" alt="" aria-hidden="true" />
                    <span class="section-icon-tooltip"><?php echo esc_html( $post_date_label ); ?> &bull; <?php echo esc_html( $reading_time_minutes ); ?> min</span>
                </button>
                <?php if ( $priority_label ) : ?>
                    <button class="section-icon" type="button" aria-expanded="false" aria-label="<?php echo esc_attr( sprintf( __( 'Priority: %s', 'the-72-fund' ), $priority_label ) ); ?>">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-stars.png' ); ?>" alt="" aria-hidden="true" />
                        <span class="section-icon-tooltip">Priority: <?php echo esc_html( $priority_label ); ?></span>
                    </button>
                <?php endif; ?>
                <button class="section-icon" type="button" aria-expanded="false" aria-label="<?php echo esc_attr( sprintf( __( 'Resource: %s', 'the-72-fund' ), $resource_label ) ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-doc.png' ); ?>" alt="" aria-hidden="true" />
                    <span class="section-icon-tooltip">Resource: <?php echo esc_html( $resource_label ); ?></span>
                </button>
                <button class="section-icon" type="button" aria-expanded="false" aria-label="<?php echo esc_attr( sprintf( __( 'Author: %s', 'the-72-fund' ), get_the_author() ) ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-smile.png' ); ?>" alt="" aria-hidden="true" />
                    <span class="section-icon-tooltip">Author: <?php echo esc_html( get_the_author() ); ?></span>
                </button>
            </div>
            <h3 class="section-excerpt aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html( $intro_text ); ?></h3>
            <div class="section-divider TFT-gradient-line long aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
            <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_content(); ?></div>
            <?php if ( have_rows( 'sources' ) ) : ?>
                <div class="section-sources">
                    <div class="section-divider long TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                    <h6 class="aos fadeup" data-animDelay="250" data-animSpeed="750"><?php esc_html_e( 'Sources', 'the-72-fund' ); ?></h6>
                    <ul>
                        <?php while ( have_rows( 'sources' ) ) :
                            the_row();

                            $source_text = get_sub_field( 'text' );
                            $source_url  = get_sub_field( 'url' ); ?>
                            <?php if ( $source_text || $source_url ) : ?>
                                <li class="aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <?php if ( $source_text ) : ?>
                                        <span><?php echo esc_html( $source_text ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $source_text && $source_url ) : ?>
                                        <?php echo esc_html( ' ' ); ?>
                                    <?php endif; ?>
                                    <?php if ( $source_url ) : ?>
                                        <a href="<?php echo esc_url( $source_url ); ?>" target="_blank" rel="noopener noreferrer">
                                            <?php echo esc_html( $source_url ); ?><?php echo the72fund_get_new_tab_text(); ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>

                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php

    $related = get_field('related');
    $related_eyebrow_title = 'Related articles & upcoming events';
    // $related_main_title = get_sub_field('main_title');
    // $related_main_text = get_sub_field('main_text');

    ?>

    <?php if ( $related ) : ?>
    <section class="latest-insights" id="related">
        <div class="container default pad">

            <?php if ( $related_eyebrow_title || $related_main_title || $related_main_text ) : ?>
                <div class="section-head">
                    <?php if ( $related_eyebrow_title ) : ?>
                        <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $related_eyebrow_title; ?></h4>
                    <?php endif;
                    if ( $related_eyebrow_title && ! $related_main_title ) : ?>
                        <div class="section-divider TFT-gradient-line aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
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
                                    <?php echo esc_html( $title ); ?>
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

</div>

<?php get_footer(); ?>
