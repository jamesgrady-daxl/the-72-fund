<?php get_header(); ?>

<div class="landing-page investments-landing">
    
    <?php

    $investments_options_post_id = 'investments_options';
    $investments_landing_post_id = have_rows('investments_landing', $investments_options_post_id) ? $investments_options_post_id : 'options';

    $eyebrow_title = get_field('investments_eyebrow_title', $investments_options_post_id);
    $main_title = get_field('investments_main_title', $investments_options_post_id);
    $main_text = get_field('investments_main_text', $investments_options_post_id);

    $eyebrow_title = $eyebrow_title ?: get_field('investments_eyebrow_title', 'options');
    $main_title = $main_title ?: get_field('investments_main_title', 'options');
    $main_text = $main_text ?: get_field('investments_main_text', 'options');
    $page_h1 = post_type_archive_title( '', false ) ?: __( 'Our Investments', 'the-72-fund' );

    if ( ! function_exists( 'the72fund_get_acf_image_data' ) ) {
        function the72fund_get_acf_image_data( $image, $fallback_alt = '' ) {
            $image_data = array(
                'id'      => 0,
                'url'     => '',
                'alt'     => $fallback_alt,
                'description' => '',
                'caption' => '',
            );

            if ( empty( $image ) ) {
                return $image_data;
            }

            if ( is_array( $image ) ) {
                $image_data['id']      = ! empty( $image['ID'] ) ? absint( $image['ID'] ) : 0;
                $image_data['url']     = ! empty( $image['url'] ) ? $image['url'] : '';
                $image_data['alt']     = ! empty( $image['alt'] ) ? $image['alt'] : $fallback_alt;
                $image_data['description'] = ! empty( $image['description'] ) ? $image['description'] : '';
                $image_data['caption'] = ! empty( $image['caption'] ) ? $image['caption'] : '';
            } elseif ( is_numeric( $image ) ) {
                $image_id              = absint( $image );
                $image_data['id']      = $image_id;
                $image_data['url']     = wp_get_attachment_image_url( $image_id, 'full' );
                $image_data['alt']     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                $image_data['description'] = get_post_field( 'post_content', $image_id );
                $image_data['caption'] = wp_get_attachment_caption( $image_id );
            } elseif ( is_string( $image ) ) {
                $image_data['url'] = $image;
            }

            if ( $image_data['id'] && ! $image_data['description'] ) {
                $image_data['description'] = get_post_field( 'post_content', $image_data['id'] );
            }

            if ( $image_data['id'] && ! $image_data['caption'] ) {
                $image_data['caption'] = wp_get_attachment_caption( $image_data['id'] );
            }

            if ( ! $image_data['alt'] ) {
                $image_data['alt'] = $fallback_alt;
            }

            return $image_data;
        }
    }

    $investment_areas = get_terms( array(
        'taxonomy'   => 'investment_area',
        'hide_empty' => true,
        'orderby'    => 'term_id',
        'order'      => 'ASC',
    ) );

    $modal_investment_ids = array();
    $modal_investment_ids_seen = array();

    ?>

    <section class="investments">
        <div class="container large pad">
            <h1 class="screen-reader-text"><?php echo esc_html( $page_h1 ); ?></h1>

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

            <?php if ( ! is_wp_error( $investment_areas ) && ! empty( $investment_areas ) ) :
                $investment_area_columns = array(
                    array(),
                    array(),
                );

                foreach ( $investment_areas as $investment_area_index => $investment_area ) {
                    $investment_area_columns[ $investment_area_index % 2 ][] = $investment_area;
                } ?>

                <div class="investments-grid">
                    <?php foreach ( $investment_area_columns as $investment_area_column ) : ?>
                        <div class="investments-column">
                            <?php foreach ( $investment_area_column as $investment_area ) :
                                $investment_area_button_id = 'investment-area-summary-' . $investment_area->term_id;
                                $investment_area_panel_id = 'investment-area-posts-' . $investment_area->term_id;
                                $area_icon = the72fund_get_acf_image_data( get_field( 'icon', $investment_area->taxonomy . '_' . $investment_area->term_id ), $investment_area->name );
                                $area_investments = new WP_Query( array(
                                    'post_type'      => 'investments',
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                    'orderby'        => array(
                                        'menu_order' => 'ASC',
                                        'title'      => 'ASC',
                                    ),
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'investment_area',
                                            'field'    => 'term_id',
                                            'terms'    => $investment_area->term_id,
                                        ),
                                    ),
                                ) ); ?>

                                <div id="<?php echo esc_attr( $investment_area->slug ); ?>" class="investment-area-card aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <button id="<?php echo esc_attr( $investment_area_button_id ); ?>" class="investment-area-summary accordion-initial" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $investment_area_panel_id ); ?>">
                                        <?php if ( $area_icon['url'] ) : ?>
                                            <div class="investment-area-icon">
                                                <img src="<?php echo esc_url( $area_icon['url'] ); ?>" alt="<?php echo esc_attr( $area_icon['alt'] ); ?>" />
                                            </div>
                                        <?php endif; ?>

                                        <div class="investment-area-copy">
                                            <h4 class="investment-area-title"><?php echo esc_html( $investment_area->name ); ?></h4>
                                            <?php if ( $investment_area->description ) : ?>
                                                <div class="investment-area-description"><?php echo esc_html( $investment_area->description ); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="investment-area-chevron" aria-hidden="true"></div>
                                    </button>

                                    <?php if ( $area_investments->have_posts() ) : ?>
                                        <div id="<?php echo esc_attr( $investment_area_panel_id ); ?>" class="investment-area-posts accordion-reveal" aria-labelledby="<?php echo esc_attr( $investment_area_button_id ); ?>" hidden>
                                            <div class="investment-area-posts-inner">
                                            <?php while ( $area_investments->have_posts() ) :
                                                $area_investments->the_post();
                                                $investment_id = get_the_ID();
                                                $logo = the72fund_get_acf_image_data( get_field( 'logo' ), get_the_title() . ' logo' );
                                                $modal_page_id = 'investment-' . $investment_id;

                                                if ( ! isset( $modal_investment_ids_seen[ $investment_id ] ) ) {
                                                    $modal_investment_ids[] = $investment_id;
                                                    $modal_investment_ids_seen[ $investment_id ] = true;
                                                } ?>

                                                <div class="investment-list-item">
                                                    <?php if ( $logo['url'] ) : ?>
                                                        <div class="investment-list-logo">
                                                            <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" />
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="investment-list-content">
                                                        <h3 class="investment-list-title"><?php the_title(); ?></h3>
                                                        <a class="modal-link btn tertiary-btn primary_100-hvr tertiary-bdr" href="#<?php echo esc_attr( $modal_page_id ); ?>" data-page-target="<?php echo esc_attr( $modal_page_id ); ?>" data-modal-target="investments-modal"><span>Read More</span></a>
                                                    </div>
                                                </div>

                                            <?php endwhile;
                                            wp_reset_postdata(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php
    $modal_investments = new WP_Query( array(
        'post_type'      => 'investments',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post__in'       => ! empty( $modal_investment_ids ) ? $modal_investment_ids : array( 0 ),
        'orderby'        => 'post__in',
    ) );

    if ( $modal_investments->have_posts() ) : ?>
        <div id="investments-modal" class="custom-modal investments-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php esc_attr_e( 'Investment details', 'the-72-fund' ); ?>" inert>
            <div class="modal-block">
                <button class="modal-close" type="button" aria-label="<?php esc_attr_e( 'Close modal', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
                <button class="modal-arrow previous-arrow" type="button" aria-label="<?php esc_attr_e( 'Previous investment', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-prev.png" alt="" aria-hidden="true" /></button>

                <?php while ( $modal_investments->have_posts() ) :
                    $modal_investments->the_post();
                    $main_image = the72fund_get_acf_image_data( get_field( 'main_image' ), get_the_title() );
                    $logo = the72fund_get_acf_image_data( get_field( 'logo' ), get_the_title() . ' logo' );
                    $investment_button = get_field( 'button' );
                    $investment_button_url = ! empty( $investment_button['url'] ) ? $investment_button['url'] : '';
                    $investment_button_title = ! empty( $investment_button['title'] ) ? $investment_button['title'] : '';
                    $investment_button_target = ! empty( $investment_button['target'] ) ? $investment_button['target'] : '_self';
                    $investment_button_rel = '_blank' === $investment_button_target ? 'noopener noreferrer' : '';
                    $investment_terms = get_the_terms( get_the_ID(), 'investment_area' );
                    $investment_area_name = ! empty( $investment_terms ) && ! is_wp_error( $investment_terms ) ? $investment_terms[0]->name : '';
                    $modal_page_id = 'investment-' . get_the_ID();
                    $has_left_content = $main_image['url'] || $main_image['description'] || $main_image['caption'] || ( $investment_button_url && $investment_button_title ); ?>

                    <div id="<?php echo esc_attr( $modal_page_id ); ?>" class="modal-page">
                        <div class="investment-modal-content">
                            <?php if ( $investment_area_name ) : ?>
                                <div class="investment-modal-area FT-gradient-line"><?php echo esc_html( $investment_area_name ); ?></div>
                            <?php endif; ?>
                            <div class="investment-modal-body <?php echo ! $has_left_content ? 'no-left-content' : ''; ?>">
                                <?php if ( $has_left_content ) : ?>
                                    <div class="investment-modal-left">
                                        <?php if ( $main_image['url'] ) : ?>
                                            <div class="investment-modal-image">
                                                <img src="<?php echo esc_url( $main_image['url'] ); ?>" alt="<?php echo esc_attr( $main_image['alt'] ); ?>" />
                                            </div>
                                        <?php endif;
                                        if ( $main_image['description'] ) : ?>
                                            <div class="investment-modal-description"><?php echo wp_kses_post( $main_image['description'] ); ?></div>
                                        <?php endif;
                                        if ( $main_image['caption'] ) : ?>
                                            <div class="investment-modal-caption"><?php echo esc_html( $main_image['caption'] ); ?></div>
                                        <?php endif;
                                        if ( $investment_button_url && $investment_button_title ) : ?>
                                            <div class="investment-modal-button">
	                                                <a class="btn white-btn secondary-hvr secondary-bdr" href="<?php echo esc_url( $investment_button_url ); ?>" target="<?php echo esc_attr( $investment_button_target ); ?>" <?php if ( $investment_button_rel ) : ?>rel="<?php echo esc_attr( $investment_button_rel ); ?>"<?php endif; ?>><span><?php echo esc_html( $investment_button_title ); ?><?php echo '_blank' === $investment_button_target ? the72fund_get_new_tab_text() : ''; ?></span></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="investment-modal-right">
                                    <?php if ( $logo['url'] ) : ?>
                                        <div class="investment-modal-logo">
                                            <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <h2 class="investment-modal-title"><?php the_title(); ?></h2>
                                    <div class="investment-modal-text">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile;
                wp_reset_postdata(); ?>

                <button class="modal-arrow next-arrow" type="button" aria-label="<?php esc_attr_e( 'Next investment', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-next.png" alt="" aria-hidden="true" /></button>
            </div>
        </div>
    <?php endif; ?>

    <?php
    while(the_repeater_field('investments_landing', $investments_landing_post_id)):
        get_template_part( 'template-parts/templates/template', 'flexible_sections' );
    endwhile; ?>

</div>

<?php get_footer(); ?>
