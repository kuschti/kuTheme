<?php
/**
 * The template for displaying 404 error pages.
 *
 * @package Meola
 * @since Meola 1.0
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<article id="post-0" class="page error404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Not Found', 'meola' ); ?></h1>
			</header><!--end .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'meola' ); ?></p>
			</div><!-- end .entry-content -->

			<script type="text/javascript">
				// focus on search field after it has loaded
				document.getElementById('s') && document.getElementById('s').focus();
			</script>
		</article><!-- end #post-0 -->

	</div><!-- end #content -->

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>