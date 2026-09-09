<?php

// This is an example of how the popup works
// You can put modal-page inside a repeater or something for multiple pages

// Initialize a custom modal counter
// Make all these variables unique for each different section
global $modal_counter;
if (!isset($modal_counter)) {
    $modal_counter = 0;
}
$modal_counter++; // Increment the counter
$unique_modal_id = 'custom-modal-' . $modal_counter; // Make this class unique for each different section

$modal_page_id = get_field('custom_field'); // modal_page_id should be based on content

?>

<!-- Open the modal to a specific page -->
<div class="modal-link" data-page-target="modal-page-<?php echo $modal_page_id; ?>" data-modal-target="<?php echo $unique_modal_id; ?>"></div>

<!-- The modal -->
<div id="<?php echo $unique_modal_id; ?>" class="custom-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php esc_attr_e( 'Details', 'the-72-fund' ); ?>" inert><!-- Give the modal a second, more specific class to style the content -->
    <div class="modal-block">
        <button class="modal-close" type="button" aria-label="<?php esc_attr_e( 'Close modal', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" /></button>
        <button class="modal-arrow previous-arrow" type="button" aria-label="<?php esc_attr_e( 'Previous item', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-prev.png" alt="" aria-hidden="true" /></button>
        
        <div id="modal-page-<?php echo $modal_page_id; ?>" class="modal-page">
            <!-- Modal page content -->
        </div>

        <button class="modal-arrow next-arrow" type="button" aria-label="<?php esc_attr_e( 'Next item', 'the-72-fund' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/arrow-next.png" alt="" aria-hidden="true" /></button>
    </div>
</div>
