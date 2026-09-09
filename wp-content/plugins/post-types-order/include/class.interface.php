<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    class PTO_Interface 
        {
            
            var $functions;
            var $CPTO;
            
            // Max number of items queried/shown in the sortable list (performance safeguard)
            var $items_limit           =   500;
            
            // Real total of items found for the current post type (set by list_pages())
            var $total_found_posts     =   0;
            
            /**
            * Constructor
            * 
            */
            function __construct() 
                {

                    $this->functions    =   new CptoFunctions();
                    
                    global $CPTO;
                    $this->CPTO         =   $CPTO;
                    
                    add_action( 'admin_init',                               array ( $this, 'admin_init'), 10 );
                    
                }
            
            
            /**
            * 
            * Check for section actions
            */
            function admin_init()
                {
                    //check for order reset
                    if ( isset ( $_POST['pto_order_reset'] ) && $_POST['pto_order_reset'] == 'true' )
                        {
                            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized 
                            if ( isset ( $_POST['nonce'] )  &&  wp_verify_nonce ( wp_unslash( $_POST['nonce'] ),  'pto-interface-reset' ))
                                { 
                                    $post_type  =   $this->CPTO->current_post_type->name;
                                    
                                    if ( empty ( $post_type ) )  
                                        {
                                            echo '<div id="message" class="updated"><p>' . esc_html__('Invalid post type', 'post-types-order') . '</p></div>';
                                            return;
                                        }    
                                    
                                    global $wpdb;
                                                                       
                                    $results = $wpdb->query(
                                                                $wpdb->prepare(
                                                                    "UPDATE {$wpdb->posts}
                                                                    SET menu_order = %d
                                                                    WHERE post_type = %s",
                                                                    0,
                                                                    $post_type
                                                                )
                                                            );
                                                                            
                                    apply_filters('pto/order_reset', $post_type );
                                    
                                    echo '<div id="message" class="updated"><p>' . esc_html__('Sort order reset successfully', 'post-types-order') . '</p></div>';
                                }
                                else
                                {
                                    echo '<div id="message" class="error"><p>' . esc_html__( 'Invalid Nonce', 'post-types-order' )  . '</p></div>';
                                } 
                        }
                    
                }
            
                
                
            /**
            * Sort interfaces
            * 
            */
            function sort_page() 
                {
                    
                    $options          =     $this->functions->get_options();
                    
                    ?>
                    <div id="cpto" class="wrap">
                        <div class="icon32" id="icon-edit"><br></div>
                        <h2><?php echo esc_html( $this->CPTO->current_post_type->labels->singular_name . ' -  '. esc_html__('Re-Order', 'post-types-order') ); ?></h2>

                        <?php $this->functions->cpt_info_box(); ?>  
                        
                        <div id="ajax-response"></div>
                        
                        <noscript>
                            <div class="error message">
                                <p><?php esc_html_e('This plugin can\'t work without javascript, because it\'s use drag and drop and AJAX.', 'post-types-order'); ?></p>
                            </div>
                        </noscript>
                        
                        <p>&nbsp;</p>      
           
                        <div id="order-objects">
           
                            <div id="nav-menu-header">
                                <div class="major-publishing-actions">

                                        
                                        <div class="alignright actions">
                                            <p class="actions">
              
                                                <span class="img_spacer">&nbsp;
                                                    <img alt="" src="<?php echo esc_url ( CPTURL . "/images/wpspin_light.gif" ) ?>" class="waiting pto_ajax_loading" style="display: none;">
                                                </span>
                                                <a href="javascript:;" class="save-order button-primary"><?php esc_html_e('Update', 'post-types-order') ?></a>
                                            </p>
                                        </div>
                                        
                                        <div class="clear"></div>

                                </div><!-- END .major-publishing-actions -->
                            </div><!-- END #nav-menu-header -->
           
            
                            <div id="post-body"> 
                            
                                <?php
                                    // Run the (limited) query first so we know the real total before printing anything.
                                    ob_start();
                                    $this->list_pages('hide_empty=0&title_li=&post_type=' . $this->CPTO->current_post_type->name );
                                    $sortable_items = ob_get_clean();
                                    
                                    if ( $this->total_found_posts > $this->items_limit ) :
                                ?>
                                    <div class="pto-notice pto-notice--limit">
                                        <p>
                                            <?php
                                                printf(
                                                    /* translators: 1: total number of items found, 2: number of items currently shown/sortable */
                                                    esc_html__( 'This post type contains %1$d items, but for performance reasons, only the first %2$d items (based on the current order) are displayed here. Items beyond this limit cannot be reordered from this screen. Use the pto/interface/query/limit filter to adjust the number of displayed items, or consider the Advanced Post Types Order plugin and its pagination features.', 'post-types-order' ),
                                                    (int) $this->total_found_posts,
                                                    (int) $this->items_limit
                                                );
                                            ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                                
                                <ul id="sortable" class="sortable ui-sortable">
                                
                                    <?php echo $sortable_items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already sanitized with wp_kses_post() in list_pages() ?>
                                    
                                </ul>
                            </div>
                            
                            <div id="nav-menu-footer">
                                <div class="major-publishing-actions">
                                        
                                        <a class="button-primary warning" href="javascript: void(0)" onclick="confirmSubmit()"><?php esc_html_e( "Reset Order", 'post-types-order' ) ?></a>
                                
                                        <div class="alignright actions">
                                            <img alt="" src="<?php echo esc_url ( CPTURL . "/images/wpspin_light.gif" ) ?>" class="waiting pto_ajax_loading" style="display: none;">
                                            <a href="javascript:;" class="save-order button-primary"><?php esc_html_e('Update', 'post-types-order') ?></a>
                                        </div>
                                        
                                        <div class="clear"></div>

                                </div><!-- END .major-publishing-actions -->
                            </div><!-- END #nav-menu-header -->
             
                        </div>
                                       
                        <?php wp_nonce_field( 'interface_sort_nonce', 'interface_sort_nonce' ); ?>
                        
                        <script type="text/javascript">
                        
                            function confirmSubmit()
                                {
                                    var agree=confirm("<?php esc_html_e( "Are you sure you want to reset the order??", 'post-types-order' ) ?>");
                                    if (agree)
                                        {
                                            jQuery('#pto_form_order_reset').submit();   
                                        }
                                        else
                                        return false ;
                                }
                        
                            jQuery(document).ready(function() {
                                jQuery("#sortable").sortable({
                                    'tolerance':'intersect',
                                    'cursor':'pointer',
                                    'items':'li',
                                    'placeholder':'placeholder',
                                    'nested': 'ul'
                                });
                                
                                jQuery("#sortable").disableSelection();
                                jQuery(".save-order").bind( "click", function() {
                                    jQuery(this).parent().find('img').show();
                                    jQuery("html, body").animate({ scrollTop: 0 }, "fast");
                                    
                                    jQuery.post( ajaxurl, { action:'update-custom-type-order', order:jQuery("#sortable").sortable("serialize"), 'interface_sort_nonce' : jQuery('#interface_sort_nonce').val() }, function() {
                                        jQuery("#ajax-response").html('<div class="message updated fade"><p><?php esc_html_e('Items Order Updated', 'post-types-order') ?></p></div>');
                                        jQuery("#ajax-response div").delay(3000).hide("slow");
                                        jQuery('img.pto_ajax_loading').hide();
                                    });
                                });
                            });
                        </script>
                        
                        <form action="" method="post" id="pto_form_order_reset">
                            <input type="hidden" name="pto_order_reset" value="true" />
                            <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'pto-interface-reset' ) ) ?>" />
                        </form>
                        
                        
                    </div>
                    <?php
                }

                
            /**
            * List pages
            * 
            * @param mixed $args
            */
            function list_pages($args = '') 
                {
                    $defaults = array(
                        'depth'             => -1, 
                        'date_format'       => get_option('date_format'),
                        'child_of'          => 0, 
                        'sort_column'       => 'menu_order',
                        'post_status'       =>  'any' 
                    );

                    $r = wp_parse_args( $args, $defaults );
                    extract( $r, EXTR_SKIP );

                    $output = '';
                    
                    // Query pages.
                    $r['hierarchical'] = 0;
                    
                    // Allow the limit itself to be filtered, then keep it on the object
                    // so callers (e.g. sort_page()) can compare it against found_posts.
                    $this->items_limit = (int) apply_filters( 'pto/interface/query/limit', $this->items_limit );
                    
                    $args = array(
                                'sort_column'       =>  'menu_order',
                                'post_type'         =>  $post_type,
                                'posts_per_page'    =>  $this->items_limit,
                                'post_status'       =>  'any',
                                'orderby'            => array(
                                                            'menu_order'    => 'ASC',
                                                            'post_date'     =>  'DESC'
                                                            )
                    );
                    
                    //allow customisation of the query if necesarelly
                    $args   =   apply_filters('pto/interface/query/args', $args ); 
                    
                    $the_query  = new WP_Query( $args );
                    $pages      = $the_query->posts;
                    
                    // found_posts reflects the TOTAL matching rows regardless of posts_per_page,
                    // so we can warn the user even though we only fetched/display $this->items_limit of them.
                    $this->total_found_posts = (int) $the_query->found_posts;

                    if ( !empty($pages) ) 
                        {
                            $output .= $this->walk_tree($pages, $r['depth'], $r);
                        }

                    echo    wp_kses_post    (   $output );
                }
            
            /**
            * Tree walker
            * 
            * @param mixed $pages
            * @param mixed $depth
            * @param mixed $r
            */
            function walk_tree($pages, $depth, $r) 
                {
                    $walker = new Post_Types_Order_Walker;

                    $args = array($pages, $depth, $r);
                    return call_user_func_array(array(&$walker, 'walk'), $args);
                }
            
            
        }

?>