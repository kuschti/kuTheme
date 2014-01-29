<?php
/**
 * @package kuTheme
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-top' ) ) : ?>
	<div id="sidebar-top" class="widget-area">

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-top' ) ) : ?>
		<?php endif; // end sidebar widget area ?>

	</div><!-- #sidebar-top .widget-area -->
	<?php endif; ?>
