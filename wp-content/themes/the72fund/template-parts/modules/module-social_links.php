<?php

$social_links = array(
    'amazon'            => array( 'icon' => 'fa-brands fa-amazon', 'label' => __( 'Amazon', 'the-72-fund' ) ),
    'apple_app_store'   => array( 'icon' => 'fa-brands fa-apple', 'label' => __( 'App Store', 'the-72-fund' ) ),
    'behance'           => array( 'icon' => 'fa-brands fa-behance', 'label' => __( 'Behance', 'the-72-fund' ) ),
    'discord'           => array( 'icon' => 'fa-brands fa-discord', 'label' => __( 'Discord', 'the-72-fund' ) ),
    'email'             => array( 'icon' => 'fa-regular fa-envelope', 'label' => __( 'Email', 'the-72-fund' ), 'email' => true ),
    'facebook'          => array( 'icon' => 'fa-brands fa-facebook-f', 'label' => __( 'Facebook', 'the-72-fund' ) ),
    'google_play_store' => array( 'icon' => 'fa-brands fa-google-play', 'label' => __( 'Play Store', 'the-72-fund' ) ),
    'instagram'         => array( 'icon' => 'fa-brands fa-instagram', 'label' => __( 'Instagram', 'the-72-fund' ) ),
    'kickstarter'       => array( 'icon' => 'fa-brands fa-kickstarter-k', 'label' => __( 'Kickstarter', 'the-72-fund' ) ),
    'linkedin'          => array( 'icon' => 'fa-brands fa-linkedin', 'label' => __( 'LinkedIn', 'the-72-fund' ) ),
    'pateron'           => array( 'icon' => 'fa-brands fa-patreon', 'label' => __( 'Patreon', 'the-72-fund' ) ),
    'pinterest'         => array( 'icon' => 'fa-brands fa-pinterest-p', 'label' => __( 'Pinterest', 'the-72-fund' ) ),
    'podcast'           => array( 'icon' => 'fa-solid fa-podcast', 'label' => __( 'Podcast', 'the-72-fund' ) ),
    'reddit'            => array( 'icon' => 'fa-brands fa-reddit-alien', 'label' => __( 'Reddit', 'the-72-fund' ) ),
    'spotify'           => array( 'icon' => 'fa-brands fa-spotify', 'label' => __( 'Spotify', 'the-72-fund' ) ),
    'threads'           => array( 'icon' => 'fa-brands fa-threads', 'label' => __( 'Threads', 'the-72-fund' ) ),
    'tiktok'            => array( 'icon' => 'fa-brands fa-tiktok', 'label' => __( 'TikTok', 'the-72-fund' ) ),
    'tumblr'            => array( 'icon' => 'fa-brands fa-tumblr', 'label' => __( 'Tumblr', 'the-72-fund' ) ),
    'twitch'            => array( 'icon' => 'fa-brands fa-twitch', 'label' => __( 'Twitch', 'the-72-fund' ) ),
    'vimeo'             => array( 'icon' => 'fa-brands fa-vimeo-v', 'label' => __( 'Vimeo', 'the-72-fund' ) ),
    'x'                 => array( 'icon' => 'fa-brands fa-x-twitter', 'label' => __( 'X', 'the-72-fund' ) ),
    'youtube'           => array( 'icon' => 'fa-brands fa-youtube', 'label' => __( 'YouTube', 'the-72-fund' ) ),
);

$layout = get_row_layout();

if ( ! empty( $social_links[ $layout ] ) ) :
    $social_link = $social_links[ $layout ];
    $link = get_sub_field( 'link' );

    if ( $link ) :
        $is_email = ! empty( $social_link['email'] );
        $href = $is_email ? 'mailto:' . sanitize_email( $link ) : esc_url( $link );
        $aria_label = $is_email ? $social_link['label'] : sprintf( __( '%s opens in a new tab', 'the-72-fund' ), $social_link['label'] );
        ?>
        <div class="social-link">
            <a href="<?php echo esc_attr( $href ); ?>" aria-label="<?php echo esc_attr( $aria_label ); ?>" <?php if ( ! $is_email ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                <i class="<?php echo esc_attr( $social_link['icon'] ); ?>" aria-hidden="true"></i>
            </a>
            <span aria-hidden="true"><?php echo esc_html( $social_link['label'] ); ?></span>
        </div>
    <?php endif;
endif; ?>
