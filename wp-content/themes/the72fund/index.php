<?php

get_header();

$posts_page_id = get_option( 'page_for_posts' );

$eyebrow_title = get_field( 'eyebrow_title', $posts_page_id );
$main_title = get_field( 'main_title', $posts_page_id );
$main_text = get_field( 'main_text', $posts_page_id );
$page_h1 = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Insights', 'the-72-fund' );

$selected_resource      = ! empty( $_GET['resource'] ) ? sanitize_title( wp_unslash( $_GET['resource'] ) ) : '';
$selected_priority_area = ! empty( $_GET['priority_area'] ) ? sanitize_title( wp_unslash( $_GET['priority_area'] ) ) : '';

$resource_terms = get_categories( array(
    'hide_empty' => true,
    'exclude'    => array( (int) get_option( 'default_category' ) ),
) );

$priority_area_terms = get_terms( array(
    'taxonomy'   => 'priority_area',
    'hide_empty' => true,
) );

$filters_base_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );

$get_filter_url = function( $filter_key, $filter_value ) use ( $filters_base_url, $selected_resource, $selected_priority_area ) {
    $args = array();

    if ( $selected_resource ) {
        $args['resource'] = $selected_resource;
    }

    if ( $selected_priority_area ) {
        $args['priority_area'] = $selected_priority_area;
    }

    if ( $filter_value ) {
        $args[ $filter_key ] = $filter_value;
    } else {
        unset( $args[ $filter_key ] );
    }

    return add_query_arg( $args, $filters_base_url );
};

$selected_resource_label = __( 'Resources', 'the-72-fund' );
if ( $selected_resource && $resource_terms ) {
    foreach ( $resource_terms as $resource_term ) {
        if ( $selected_resource === $resource_term->slug ) {
            $selected_resource_label = $resource_term->name;
            break;
        }
    }
}

$selected_priority_area_label = __( 'Priority Areas', 'the-72-fund' );
if ( $selected_priority_area && ! is_wp_error( $priority_area_terms ) ) {
    foreach ( $priority_area_terms as $priority_area_term ) {
        if ( $selected_priority_area === $priority_area_term->slug ) {
            $selected_priority_area_label = $priority_area_term->name;
            break;
        }
    }
}

?>

<div class="landing-page insights-landing">
    <h1 class="screen-reader-text"><?php echo esc_html( $page_h1 ); ?></h1>

    <section class="insights">
        <div class="container default pad">

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

            <?php if ( ( $priority_area_terms && ! is_wp_error( $priority_area_terms ) ) || $resource_terms ) : ?>
                <div class="section-filters aos fadeup" data-animDelay="250" data-animSpeed="750" aria-label="<?php esc_attr_e( 'Insight filters', 'the-72-fund' ); ?>">
                    <?php if ( $priority_area_terms && ! is_wp_error( $priority_area_terms ) ) : ?>
                        <div class="filter-dropdown">
                            <button class="filter-button btn white-btn primary-hvr primary-bdr" type="button" aria-expanded="false" aria-controls="priority-area-filter-menu" aria-haspopup="true">
                                <?php echo esc_html( $selected_priority_area_label ); ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/filter-carat.png' ); ?>" alt="" aria-hidden="true" />
                            </button>
                            <div id="priority-area-filter-menu" class="filter-menu" aria-label="<?php esc_attr_e( 'Priority area filters', 'the-72-fund' ); ?>" hidden>
                                <ul>
                                    <?php foreach ( $priority_area_terms as $priority_area_term ) : ?>
                                        <li>
                                            <a class="<?php echo $selected_priority_area === $priority_area_term->slug ? 'active' : ''; ?>" href="<?php echo esc_url( $get_filter_url( 'priority_area', $priority_area_term->slug ) ); ?>">
                                                <?php echo esc_html( $priority_area_term->name ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $resource_terms ) : ?>
                        <div class="filter-dropdown">
                            <button class="filter-button btn white-btn primary-hvr primary-bdr" type="button" aria-expanded="false" aria-controls="resource-filter-menu" aria-haspopup="true">
                                <?php echo esc_html( $selected_resource_label ); ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/filter-carat.png' ); ?>" alt="" aria-hidden="true" />
                            </button>
                            <div id="resource-filter-menu" class="filter-menu" aria-label="<?php esc_attr_e( 'Resource filters', 'the-72-fund' ); ?>" hidden>
                                <ul>
                                    <?php foreach ( $resource_terms as $resource_term ) : ?>
                                        <li>
                                            <a class="<?php echo $selected_resource === $resource_term->slug ? 'active' : ''; ?>" href="<?php echo esc_url( $get_filter_url( 'resource', $resource_term->slug ) ); ?>">
                                                <?php echo esc_html( $resource_term->name ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="section-block">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();

                        $title     = get_the_title();
                        $url       = get_permalink();
                        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                        $image_alt = '';

                        if ( has_post_thumbnail() ) {
                            $thumbnail_id = get_post_thumbnail_id();
                            $image_alt    = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );

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
                                <h3 class="section-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo $title; ?></h3> <!-- esc_html removed from variable so they can put <em> in title -->
                            <?php endif; ?>
                            <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750">
                                <?php echo wp_kses_post( wpautop( wp_trim_words( get_field( 'intro_text' ), 22 ) ) ); ?>
                            </div>
                            <?php if ( $url && $title ) : ?>
                                <div class="section-button aos fadeup" data-animDelay="250" data-animSpeed="750">
                                    <span class="btn white-btn primary-hvr primary-bdr small-btn"><?php esc_html_e( 'Read More' ); ?></span>
                                </div>
                            <?php endif; ?>
                        </a>

                    <?php
                    endwhile;
                endif; ?>

            </div>
            
            <div class="pagination aos fadeup" data-animDelay="250" data-animSpeed="750">
                <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'prev_text' => '<span aria-hidden="true">&lt;</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'the-72-fund' ) . '</span>',
                    'next_text' => '<span aria-hidden="true">&gt;</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'the-72-fund' ) . '</span>',
                    'current'   => max( 1, get_query_var( 'paged' ) ),
                    'add_args'  => array_filter( array(
                        'resource'      => $selected_resource,
                        'priority_area' => $selected_priority_area,
                    ) ),
                ) ); ?>
            </div>

        </div>
    </section>

    <?php
    while(the_repeater_field('insights_landing', $posts_page_id )):
        get_template_part( 'template-parts/templates/template', 'flexible_sections' );
    endwhile; ?>

</div>

<?php get_footer(); ?>
