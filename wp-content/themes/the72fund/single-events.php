<?php

get_header();

$events_archive_url = get_post_type_archive_link( 'events' );

if ( ! $events_archive_url ) {
    $events_archive_url = home_url( '/events/' );
}

$format_event_time = function( $time_value ) {
    if ( ! $time_value ) {
        return '';
    }

    foreach ( array( 'H:i:s', 'H:i' ) as $time_format ) {
        $event_time = DateTimeImmutable::createFromFormat( '!' . $time_format, $time_value, wp_timezone() );

        if ( $event_time instanceof DateTimeImmutable ) {
            return wp_date( 'g:i a', $event_time->getTimestamp(), wp_timezone() );
        }
    }

    return sanitize_text_field( $time_value );
};

?>

<div class="post-single events-single">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : ?>
            <?php
            the_post();

            $event_date             = the72fund_get_event_date();
            $event_start_time       = $format_event_time( get_post_meta( get_the_ID(), 'event_start_time', true ) );
            $event_end_time         = $format_event_time( get_post_meta( get_the_ID(), 'event_end_time', true ) );
            $event_venue            = get_field( 'event_venue' );
            $event_city_state       = get_field( 'event_city_state' );
            $event_registration_url = get_field( 'event_registration_url' );
            $event_terms            = get_the_terms( get_the_ID(), 'priority_area' );
            $event_term             = $event_terms && ! is_wp_error( $event_terms ) ? reset( $event_terms ) : false;
            $event_icon             = $event_term ? the72fund_get_priority_area_icon( $event_term->term_id ) : array( 'id' => 0, 'url' => '' );
            $event_time_label       = '';

            if ( $event_start_time && $event_end_time ) {
                $event_time_label = $event_start_time . '–' . $event_end_time;
            } elseif ( $event_start_time ) {
                $event_time_label = $event_start_time;
            }
            ?>

            <div class="container large events-single-back">
                <a class="back-btn btn tertiary-btn primary_100-hvr tertiary-bdr aos fadeup" data-animDelay="250" data-animSpeed="750" href="<?php echo esc_url( $events_archive_url ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/arrow-left_primary.png' ); ?>" alt="" aria-hidden="true" />
                    <?php esc_html_e( 'All Events', 'the-72-fund' ); ?>
                </a>
            </div>

            <section class="post-content event-content">
                <div class="container small pad">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-image aos fadeup" data-animDelay="250" data-animSpeed="750">
                            <?php the_post_thumbnail( 'full' ); ?>
                        </div>
                    <?php endif; ?>

                    <h1 class="main-title aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_title(); ?></h1>

                    <?php if ( $event_date || $event_time_label || $event_venue || $event_city_state || $event_term ) : ?>
                        <div class="event-details aos fadeup" data-animDelay="250" data-animSpeed="750">
                            <?php if ( ! empty( $event_icon['url'] ) ) : ?>
                                <div class="event-details-icon" aria-hidden="true">
                                    <?php if ( ! empty( $event_icon['id'] ) ) : ?>
                                        <?php echo wp_get_attachment_image( $event_icon['id'], 'full', false, array( 'alt' => '' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( $event_icon['url'] ); ?>" alt="" />
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <dl class="event-details-list">
                                <?php if ( $event_date ) : ?>
                                    <div class="event-detail">
                                        <dt><?php esc_html_e( 'Date', 'the-72-fund' ); ?></dt>
                                        <dd><time datetime="<?php echo esc_attr( $event_date->format( 'Y-m-d' ) ); ?>"><?php echo esc_html( wp_date( 'F j, Y', $event_date->getTimestamp(), wp_timezone() ) ); ?></time></dd>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $event_time_label ) : ?>
                                    <div class="event-detail">
                                        <dt><?php esc_html_e( 'Time', 'the-72-fund' ); ?></dt>
                                        <dd><?php echo esc_html( $event_time_label ); ?></dd>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $event_venue || $event_city_state ) : ?>
                                    <div class="event-detail">
                                        <dt><?php esc_html_e( 'Location', 'the-72-fund' ); ?></dt>
                                        <dd>
                                            <?php if ( $event_venue ) : ?>
                                                <span><?php echo esc_html( $event_venue ); ?></span>
                                            <?php endif; ?>
                                            <?php if ( $event_city_state ) : ?>
                                                <span><?php echo esc_html( $event_city_state ); ?></span>
                                            <?php endif; ?>
                                        </dd>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $event_term ) : ?>
                                    <div class="event-detail">
                                        <dt><?php esc_html_e( 'Priority Area', 'the-72-fund' ); ?></dt>
                                        <dd><?php echo esc_html( $event_term->name ); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                    <?php endif; ?>

                    <div class="section-divider TFT-gradient-line long aos fadeup" data-animDelay="250" data-animSpeed="750"></div>
                    <div class="section-text aos fadeup" data-animDelay="250" data-animSpeed="750"><?php the_content(); ?></div>

                    <?php if ( $event_registration_url ) : ?>
                        <div class="event-registration aos fadeup" data-animDelay="250" data-animSpeed="750">
                            <a class="btn secondary-btn primary-hvr secondary-bdr" href="<?php echo esc_url( $event_registration_url ); ?>" target="_blank" rel="noopener noreferrer">
                                <?php esc_html_e( 'Register', 'the-72-fund' ); ?><?php echo the72fund_get_new_tab_text(); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
