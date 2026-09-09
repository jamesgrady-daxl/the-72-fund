<?php

// Add theme support for post thumbnails
add_theme_support( 'post-thumbnails' );

// Keep the blog index on the main query while ignoring sticky posts
add_action( 'pre_get_posts', 'the72fund_ignore_sticky_posts_on_blog' );
function the72fund_ignore_sticky_posts_on_blog( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_home() ) {
        $query->set( 'ignore_sticky_posts', true );
    }
}

// Redirect modal-only CPT single views to their public listing experiences
add_action( 'template_redirect', 'the72fund_redirect_modal_only_single_posts' );
function the72fund_redirect_modal_only_single_posts() {
    if ( is_singular( 'team' ) ) {
        wp_safe_redirect( home_url( '/about/#our-team' ), 301 );
        exit;
    }

    if ( is_singular( 'investments' ) ) {
        $investments_url = get_post_type_archive_link( 'investments' );

        if ( ! $investments_url ) {
            $investments_url = home_url( '/our-investments/' );
        }

        wp_safe_redirect( $investments_url, 301 );
        exit;
    }
}

// Register Custom Menus
add_action('init', 'register_custom_menu');
function register_custom_menu() {
    register_nav_menu('header_menu', __('Header Menu'));
    register_nav_menu('footer_menu', __('Footer Menu'));
    register_nav_menu('slideout_menu', __('Slideout Menu'));
}

// Add additional ACF options pages
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Options',
        'menu_title'    => 'Options',
        'menu_slug'     => 'options',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Brand Toolkit Settings',
        'menu_title'    => 'Brand Toolkit',
        'parent_slug'   => 'options',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Healthcare Disclaimer Settings',
        'menu_title'    => 'Healthcare Disclaimer',
        'parent_slug'   => 'options',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Site Credits Settings',
        'menu_title'    => 'Site Credits',
        'parent_slug'   => 'options',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'options',
    ));
    acf_add_options_page(array(
        'page_title'    => 'Our Priorities Settings',
        'menu_title'    => 'Our Priorities',
        'menu_slug'     => 'acf-options-our-priorities',
        'parent_slug'   => 'options',
        'post_id'       => 'priorities_options',
    ));
    acf_add_options_page(array(
        'page_title'    => 'Our Investments Settings',
        'menu_title'    => 'Our Investments',
        'menu_slug'     => 'acf-options-our-investments',
        'parent_slug'   => 'options',
        'post_id'       => 'investments_options',
    ));
    acf_add_options_page(array(
        'page_title'    => 'Events Settings',
        'menu_title'    => 'Events',
        'menu_slug'     => 'acf-options-events',
        'parent_slug'   => 'options',
        'post_id'       => 'events_options',
    ));
}

add_theme_support( 'html5', array( 'search-form' ) );

function the72fund_get_new_tab_text() {
    return '<span class="screen-reader-text">' . esc_html__( ' opens in a new tab', 'the-72-fund' ) . '</span>';
}

register_sidebar( array(
    'id'          => 'main-sidebar',
    'name'        => __( 'Default Sidebar' ),
    'description' => __( 'This is the default sidebar.' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
));

register_sidebar( array(
    'name'          => 'Podcasts Landing/Search Results',
    'id'            => 'podcasts-sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
));

// Allow webp Image Uploads ======================================================================================================================================

function allow_webp_upload($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('mime_types', 'allow_webp_upload');

// Button Shortcode ======================================================================================================================================

// The shortcode is: [button color="secondary" hover="primary" border="secondary" url="https://www.example.com" text="Example" target="_self"]
	function button_function( $atts ) {
		$a = shortcode_atts( array(
			'color' => 'secondary',
		'hover' => 'primary',
		'border' => 'secondary',
		'url' => '',
		'text' => '',
			'target' => '_self',
		), $atts );

		$target = '_blank' === $a['target'] ? '_blank' : '_self';
		$rel = '_blank' === $target ? ' rel="noopener noreferrer"' : '';
		$new_tab_text = '_blank' === $target ? the72fund_get_new_tab_text() : '';

		return '<span class="btnshrtcd"><a class="btn ' . esc_attr( $a['color'] ) . '-btn ' . esc_attr( $a['hover'] ) . '-hvr ' . esc_attr( $a['border'] ) . '-bdr" href="' . esc_url( $a['url'] ) . '" target="' . esc_attr( $target ) . '"' . $rel . '><span>' . esc_html( $a['text'] ) . $new_tab_text . '</span></a></span>';
	}
add_shortcode( 'button', 'button_function' );

// Normalize blockquote punctuation so CSS can render consistent quote marks ========================================================================================

add_filter( 'the_content', 'the72fund_strip_blockquote_quote_marks', 12 );
function the72fund_strip_blockquote_quote_marks( $content ) {
    if ( false === stripos( $content, '<blockquote' ) ) {
        return $content;
    }

    return preg_replace_callback(
        '/<blockquote\b[^>]*>.*?<\/blockquote>/is',
        function( $matches ) {
            $blockquote = $matches[0];

            $blockquote = preg_replace(
                '/(<p\b[^>]*>\s*(?:<[^>]+>\s*)*)(?:[“"]|&ldquo;|&#8220;|&#x201c;)\s*/iu',
                '$1',
                $blockquote,
                1
            );

            $last_paragraph_pattern = '/(<p\b[^>]*>.*)\s*(?:[”"]|&rdquo;|&#8221;|&#x201d;)(\s*<\/p>)(?!.*<p\b)/isu';
            $blockquote = preg_replace( $last_paragraph_pattern, '$1$2', $blockquote, 1 );

            return $blockquote;
        },
        $content
    );
}

// Customize the post excerpt ======================================================================================================================================

function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' [...]';
    } else {
            $excerpt = implode(" ",$excerpt);
    }	
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    return $excerpt;
}
 
function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
            array_pop($content);
            $content = implode(" ",$content).' [...]';
    } else {
            $content = implode(" ",$content);
    }	
    $content = preg_replace('/[.+]/','', $content);
    $content = apply_filters('the_content', $content); 
    $content = str_replace(']]>', ']]>', $content);
    return $content;
}

// Remove Tags Support From Posts ==================================================================================================================================

function custom_unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'custom_unregister_tags', 100 );

// Priority Areas Taxonomy ==========================================================================================================================================

add_action( 'init', 'priority_area_taxonomy' );
function priority_area_taxonomy() {
    register_taxonomy(
        'priority_area',
        array( 'post', 'events' ),
        array(
            'labels' => array(
                'name'          => __( 'Priority Areas' ),
                'singular_name' => __( 'Priority Area' ),
            ),
            'rewrite'           => array( 'slug' => 'priority-area' ),
            'hierarchical'      => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
        )
    );
}

// Filter Blog Index ================================================================================================================================================

add_action( 'pre_get_posts', 'the72fund_filter_blog_index' );
function the72fund_filter_blog_index( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
        return;
    }

    if ( ! empty( $_GET['resource'] ) ) {
        $query->set( 'category_name', sanitize_title( wp_unslash( $_GET['resource'] ) ) );
    }

    if ( ! empty( $_GET['priority_area'] ) ) {
        $query->set(
            'tax_query',
            array(
                array(
                    'taxonomy' => 'priority_area',
                    'field'    => 'slug',
                    'terms'    => sanitize_title( wp_unslash( $_GET['priority_area'] ) ),
                ),
            )
        );
    }
}

// Team CPT =================================================================================================================================================

add_action( 'init', 'team_cpt' );
function team_cpt() {
    register_post_type( 'team',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Team' ),
                'singular_name' => __( 'Team Member' )
            ),
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                // 'thumbnail'
            ),
            'public' => true,
            // 'show_ui' => true, // DISPLAYS CPT IN ADMIN EVEN IF PUBLIC = FALSE
            'has_archive' => true,
            'rewrite' => array('slug' => 'team'),
            'menu_position' => 4,
            'menu_icon' => 'dashicons-admin-users', // FIND THESE AT: https://developer.wordpress.org/resource/dashicons/#menu
        )
    );
}
// Area Taxonomy ------------------------------------
add_action( 'init', 'area_taxonomy' );
function area_taxonomy() {
    register_taxonomy(
        'area',
        'team',
        array(
            'label' => __( 'Area' ),
            'rewrite' => array( 'slug' => 'area' ),
            'hierarchical' => true,
            'show_admin_column' => true // Shows column for this taxonomy in the wp admin
        )
    );
}

// Priorities CPT =================================================================================================================================================

add_action( 'init', 'priorities_cpt' );
function priorities_cpt() {
    register_post_type( 'priorities',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Our Priorities' ),
                'singular_name' => __( 'Priority' )
            ),
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ),
            'public' => true,
            // 'show_ui' => true, // DISPLAYS CPT IN ADMIN EVEN IF PUBLIC = FALSE
            'has_archive' => true,
            'rewrite' => array('slug' => 'our-priorities'),
            'menu_position' => 4,
            // 'menu_icon' => 'dashicons-admin-users', // FIND THESE AT: https://developer.wordpress.org/resource/dashicons/#menu
        )
    );
}

// Investments CPT =================================================================================================================================================

add_action( 'init', 'investments_cpt' );
function investments_cpt() {
    register_post_type( 'investments',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Our Investments' ),
                'singular_name' => __( 'Investment' )
            ),
            'supports' => array(
                'title',
                'editor',
                'page-attributes'
            ),
            'public' => true,
            // 'show_ui' => true, // DISPLAYS CPT IN ADMIN EVEN IF PUBLIC = FALSE
            'has_archive' => true,
            'rewrite' => array('slug' => 'our-investments'),
            'menu_position' => 4,
            // 'menu_icon' => 'dashicons-admin-users', // FIND THESE AT: https://developer.wordpress.org/resource/dashicons/#menu
        )
    );
}

// Events CPT =====================================================================================================================================================

add_action( 'init', 'events_cpt' );
function events_cpt() {
    register_post_type(
        'events',
        array(
            'labels' => array(
                'name'          => __( 'Events', 'the-72-fund' ),
                'singular_name' => __( 'Event', 'the-72-fund' ),
                'add_new_item'  => __( 'Add New Event', 'the-72-fund' ),
                'edit_item'     => __( 'Edit Event', 'the-72-fund' ),
                'new_item'      => __( 'New Event', 'the-72-fund' ),
                'view_item'     => __( 'View Event', 'the-72-fund' ),
                'search_items'  => __( 'Search Events', 'the-72-fund' ),
                'not_found'     => __( 'No events found.', 'the-72-fund' ),
            ),
            'supports'      => array(
                'title',
                'editor',
                'thumbnail',
            ),
            'public'        => true,
            'has_archive'   => true,
            'rewrite'       => array(
                'slug'       => 'events',
                'with_front' => false,
            ),
            'show_in_rest'  => true,
            'menu_position' => 4,
            'menu_icon'     => 'dashicons-calendar-alt',
        )
    );
}

// Events Archive Query -------------------------------------------------------------------------------------------------------------------------------------------

define( 'THE72FUND_SHOW_EVENT_VIEW_FILTERS', false ); // Set to 'true' to reinstate 'past' and 'upcoming' filtering

add_action( 'pre_get_posts', 'the72fund_filter_events_archive' );
function the72fund_filter_events_archive( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'events' ) ) {
        return;
    }

    $query->set( 'meta_key', 'event_date' );
    $query->set( 'meta_type', 'NUMERIC' );
    $query->set( 'orderby', 'meta_value_num' );

    if ( THE72FUND_SHOW_EVENT_VIEW_FILTERS ) {
        $event_view = ! empty( $_GET['event_view'] ) ? sanitize_key( wp_unslash( $_GET['event_view'] ) ) : 'upcoming';
        $event_view = 'past' === $event_view ? 'past' : 'upcoming';
        $today      = current_time( 'Ymd' );

        $query->set(
            'meta_query',
            array(
                array(
                    'key'     => 'event_date',
                    'value'   => $today,
                    'compare' => 'past' === $event_view ? '<' : '>=',
                    'type'    => 'NUMERIC',
                ),
            )
        );
        $query->set( 'order', 'past' === $event_view ? 'DESC' : 'ASC' );
    } else {
        $query->set( 'order', 'DESC' );
    }

    if ( ! empty( $_GET['priority_area'] ) ) {
        $query->set(
            'tax_query',
            array(
                array(
                    'taxonomy' => 'priority_area',
                    'field'    => 'slug',
                    'terms'    => sanitize_title( wp_unslash( $_GET['priority_area'] ) ),
                ),
            )
        );
    }
}

function the72fund_get_event_date( $post_id = 0 ) {
    $post_id        = $post_id ? absint( $post_id ) : get_the_ID();
    $event_date_raw = get_post_meta( $post_id, 'event_date', true );

    if ( ! preg_match( '/^\d{8}$/', (string) $event_date_raw ) ) {
        return false;
    }

    $event_date = DateTimeImmutable::createFromFormat( '!Ymd', $event_date_raw, wp_timezone() );

    return $event_date instanceof DateTimeImmutable ? $event_date : false;
}

function the72fund_get_priority_area_icon( $term_id ) {
    if ( ! $term_id || ! function_exists( 'get_field' ) ) {
        return array(
            'id'  => 0,
            'url' => '',
        );
    }

    $icon = get_field( 'priority_area_icon', 'priority_area_' . absint( $term_id ) );

    if ( is_array( $icon ) ) {
        return array(
            'id'  => ! empty( $icon['ID'] ) ? absint( $icon['ID'] ) : 0,
            'url' => ! empty( $icon['url'] ) ? $icon['url'] : '',
        );
    }

    if ( is_numeric( $icon ) ) {
        $icon_id = absint( $icon );

        return array(
            'id'  => $icon_id,
            'url' => wp_get_attachment_image_url( $icon_id, 'full' ),
        );
    }

    return array(
        'id'  => 0,
        'url' => is_string( $icon ) ? $icon : '',
    );
}
// Investment Area Taxonomy ------------------------------------
add_action( 'init', 'investment_area_taxonomy' );
function investment_area_taxonomy() {
    register_taxonomy(
        'investment_area',
        'investments',
        array(
            'label' => __( 'Investment Areas' ),
            'rewrite' => array( 'slug' => 'investment-area' ),
            'hierarchical' => true,
            'show_admin_column' => true // Shows column for this taxonomy in the wp admin
        )
    );
}

// Modules CPT =================================================================================================================================================

add_action( 'init', 'modules_cpt' );
function modules_cpt() {
    register_post_type( 'modules',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Modules' ),
                'singular_name' => __( 'Module' )
            ),
            'supports' => array(
                'title',
                // 'editor',
                // 'excerpt',
                // 'thumbnail'
            ),
            'public' => true,
            // 'show_ui' => true, // DISPLAYS CPT IN ADMIN EVEN IF PUBLIC = FALSE
            'has_archive' => false,
            'rewrite' => array('slug' => 'modules'),
            'menu_position' => 4,
            // 'menu_icon' => 'dashicons-admin-users', // FIND THESE AT: https://developer.wordpress.org/resource/dashicons/#menu
        )
    );
}
// Content Taxonomy ------------------------------------
add_action( 'init', 'content_taxonomy' );
function content_taxonomy() {
    register_taxonomy(
        'content',
        'modules',
        array(
            'label' => __( 'Content' ),
            'rewrite' => array( 'slug' => 'Content' ),
            'hierarchical' => true,
            'show_admin_column' => true // Shows column for this taxonomy in the wp admin
        )
    );
}
