<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
	<aside id="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'the-72-fund' ); ?>">
		<?php dynamic_sidebar( 'main-sidebar' ); ?>
	</aside>
<?php endif; ?>
