<?php

get_header();

$events_options_post_id = 'events_options';
$eyebrow_title          = get_field( 'events_eyebrow_title', $events_options_post_id );
$main_title             = get_field( 'events_main_title', $events_options_post_id );
$main_text              = get_field( 'events_main_text', $events_options_post_id );

$eyebrow_title = $eyebrow_title ?: get_field( 'events_eyebrow_title', 'options' );
$main_title     = $main_title ?: get_field( 'events_main_title', 'options' );
$main_text      = $main_text ?: get_field( 'events_main_text', 'options' );
$page_h1        = post_type_archive_title( '', false ) ?: __( 'Events', 'the-72-fund' );

$events_archive_url      = get_post_type_archive_link( 'events' );
$selected_event_view     = ! empty( $_GET['event_view'] ) ? sanitize_key( wp_unslash( $_GET['event_view'] ) ) : 'upcoming';
$selected_event_view     = 'past' === $selected_event_view ? 'past' : 'upcoming';
$selected_priority_area  = ! empty( $_GET['priority_area'] ) ? sanitize_title( wp_unslash( $_GET['priority_area'] ) ) : '';
$show_event_view_filters = THE72FUND_SHOW_EVENT_VIEW_FILTERS;

/*
 * Temporary combined events view: Past/Upcoming buttons are hidden and all dated events are shown.
 * To restore the original archive, set THE72FUND_SHOW_EVENT_VIEW_FILTERS to true in functions.php.
 * The original buttons, date-filtered query, filter/pagination URLs, ordering, and empty-state copy
 * are preserved behind that flag.
 */

if ( ! $events_archive_url ) {
    $events_archive_url = home_url( '/events/' );
}

$priority_area_terms = get_terms(
    array(
        'taxonomy'   => 'priority_area',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    )
);

$selected_priority_area_label = __( 'Priority Areas', 'the-72-fund' );

if ( $selected_priority_area && ! is_wp_error( $priority_area_terms ) ) {
    foreach ( $priority_area_terms as $priority_area_term ) {
        if ( $selected_priority_area === $priority_area_term->slug ) {
            $selected_priority_area_label = $priority_area_term->name;
            break;
        }
    }
}

$event_filter_url = function( $event_view, $priority_area = '' ) use ( $events_archive_url, $show_event_view_filters ) {
    $args = array();

    if ( $show_event_view_filters ) {
        $args['event_view'] = 'past' === $event_view ? 'past' : 'upcoming';
    }

    if ( $priority_area ) {
        $args['priority_area'] = $priority_area;
    }

    return add_query_arg( $args, $events_archive_url );
};

?>

<div class="landing-page events-landing">
    <section class="events">
        <div class="container default pad">
            <h1 class="screen-reader-text"><?php echo esc_html( $page_h1 ); ?></h1>

            <?php if ( $eyebrow_title || $main_title || $main_text ) : ?>
                <div class="section-head">
                    <?php if ( $eyebrow_title ) : ?>
                        <h4 class="eyebrow-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post( $eyebrow_title ); ?></h4>
                    <?php endif; ?>
                    <?php if ( $main_title ) : ?>
                        <h2 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post( $main_title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $main_text ) : ?>
                        <div class="main-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo wp_kses_post( $main_text ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="section-filters events-filters aos fadeup" data-animDelay="250" data-animSpeed="750" role="group" aria-label="<?php esc_attr_e( 'Event filters', 'the-72-fund' ); ?>">
                <?php if ( $show_event_view_filters ) : ?>
                    <a class="btn <?php echo 'past' === $selected_event_view ? 'primary-btn primary-bdr' : 'white-btn primary-hvr primary-bdr'; ?>" href="<?php echo esc_url( $event_filter_url( 'past', $selected_priority_area ) ); ?>"<?php echo 'past' === $selected_event_view ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Past Events', 'the-72-fund' ); ?></a>

                    <a class="btn <?php echo 'upcoming' === $selected_event_view ? 'primary-btn primary-bdr' : 'white-btn primary-hvr primary-bdr'; ?>" href="<?php echo esc_url( $event_filter_url( 'upcoming', $selected_priority_area ) ); ?>"<?php echo 'upcoming' === $selected_event_view ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Upcoming Events', 'the-72-fund' ); ?></a>
                <?php endif; ?>

                <?php if ( ! is_wp_error( $priority_area_terms ) && $priority_area_terms ) : ?>
                    <div class="filter-dropdown">
                        <button class="filter-button btn white-btn primary-hvr primary-bdr" type="button" aria-expanded="false" aria-controls="event-priority-area-filter-menu" aria-haspopup="true">
                            <?php echo esc_html( $selected_priority_area_label ); ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/images/filter-carat.png' ); ?>" alt="" aria-hidden="true" />
                        </button>
                        <div id="event-priority-area-filter-menu" class="filter-menu" aria-label="<?php esc_attr_e( 'Priority area filters', 'the-72-fund' ); ?>" hidden>
                            <ul>
                                <li>
                                    <a class="<?php echo $selected_priority_area ? '' : 'active'; ?>" href="<?php echo esc_url( $event_filter_url( $selected_event_view ) ); ?>">
                                        <?php esc_html_e( 'All Areas', 'the-72-fund' ); ?>
                                    </a>
                                </li>
                                <?php foreach ( $priority_area_terms as $priority_area_term ) : ?>
                                    <li>
                                        <a class="<?php echo $selected_priority_area === $priority_area_term->slug ? 'active' : ''; ?>" href="<?php echo esc_url( $event_filter_url( $selected_event_view, $priority_area_term->slug ) ); ?>">
                                            <?php echo esc_html( $priority_area_term->name ); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="events-list">
                <?php
                $previous_month = '';

                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();

                        $event_date = the72fund_get_event_date();

                        if ( ! $event_date ) {
                            continue;
                        }

                        $event_month_key   = $event_date->format( 'Ym' );
                        $event_month_label = wp_date( 'F Y', $event_date->getTimestamp(), wp_timezone() );
                        $event_date_label  = wp_date( 'M j', $event_date->getTimestamp(), wp_timezone() );
                        $event_venue       = get_field( 'event_venue' );
                        $event_city_state  = get_field( 'event_city_state' );
                        $event_terms       = get_the_terms( get_the_ID(), 'priority_area' );
                        $event_term        = $event_terms && ! is_wp_error( $event_terms ) ? reset( $event_terms ) : false;
                        $event_icon        = $event_term ? the72fund_get_priority_area_icon( $event_term->term_id ) : array( 'id' => 0, 'url' => '' );
                        $event_location    = implode( ' — ', array_filter( array( $event_venue, $event_city_state ) ) );

                        if ( $event_month_key !== $previous_month ) :
                            $previous_month = $event_month_key; ?>
                            <h2 class="event-month aos fadeup" data-animDelay="250" data-animSpeed="750"><?php echo esc_html( $event_month_label ); ?></h2>
                        <?php endif; ?>

                        <article class="event-list-item aos fadeup" data-animDelay="250" data-animSpeed="750">
                            <time class="event-list-date" datetime="<?php echo esc_attr( $event_date->format( 'Y-m-d' ) ); ?>"><?php echo esc_html( $event_date_label ); ?></time>
                            <a class="event-card" href="<?php the_permalink(); ?>">
                                <span class="event-priority-icon" aria-hidden="true">
                                    <?php if ( ! empty( $event_icon['url'] ) ) : ?>
                                        <?php if ( ! empty( $event_icon['id'] ) ) : ?>
                                            <?php echo wp_get_attachment_image( $event_icon['id'], 'full', false, array( 'alt' => '' ) ); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url( $event_icon['url'] ); ?>" alt="" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>

                                <span class="event-card-content">
                                    <h3 class="event-card-title"><?php echo esc_html( get_the_title() ); ?></h3>
                                    <?php if ( $event_location ) : ?>
                                        <span class="event-card-location"><?php echo esc_html( $event_location ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $event_term ) : ?>
                                        <span class="event-card-priority"><?php echo esc_html( $event_term->name ); ?></span>
                                    <?php endif; ?>
                                </span>

                                <span class="event-card-cta">
                                    <span><?php esc_html_e( 'Join Us', 'the-72-fund' ); ?></span>
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/arrow-next.png' ); ?>" alt="" aria-hidden="true" />
                                </span>
                            </a>
                        </article>
                    <?php endwhile;
                else : ?>
                    <p class="events-empty aos fadeup" data-animDelay="250" data-animSpeed="750">
                        <?php
                        if ( ! $show_event_view_filters ) {
                            esc_html_e( 'No events were found.', 'the-72-fund' );
                        } elseif ( 'past' === $selected_event_view ) {
                            esc_html_e( 'No past events were found.', 'the-72-fund' );
                        } else {
                            esc_html_e( 'No upcoming events are currently scheduled.', 'the-72-fund' );
                        } ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
                <nav class="pagination aos fadeup" data-animDelay="250" data-animSpeed="750" aria-label="<?php esc_attr_e( 'Events pagination', 'the-72-fund' ); ?>">
                    <?php
                    $big = 999999999;
                    echo wp_kses_post(
                        paginate_links(
                            array(
                                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format'    => '?paged=%#%',
                                'prev_text' => '<span aria-hidden="true">&lt;</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'the-72-fund' ) . '</span>',
                                'next_text' => '<span aria-hidden="true">&gt;</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'the-72-fund' ) . '</span>',
                                'current'   => max( 1, get_query_var( 'paged' ) ),
                                'add_args'  => array_filter(
                                    array(
                                        'event_view'    => $show_event_view_filters ? $selected_event_view : '',
                                        'priority_area' => $selected_priority_area,
                                    )
                                ),
                            )
                        )
                    ); ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>
