<div class="social-icons">

	<?php
	// check if the flexible content field has rows of data
	if(have_rows('social_media', 'options')):
	    // loop through the rows of data
	    while(have_rows('social_media', 'options')): the_row();

			get_template_part( 'template-parts/modules/module', 'social_links' );

		endwhile; // END while_have_rows (flexible content)
	
	else:

	    // no layouts found

	endif; ?><!-- END if_have_rows (flexible content) -->
	
</div>