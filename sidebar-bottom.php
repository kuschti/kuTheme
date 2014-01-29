<?php
/**
 * @package kuTheme
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-bottom' ) ) : ?>
	<div id="sidebar-bottom" class="widget-area">

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-bottom' ) ) : ?>
		<?php endif; // end sidebar widget area ?>

	</div><!-- #sidebar-bottom .widget-area -->
	<?php endif; ?>
