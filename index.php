<?php
/**
 * The main template file.
 *
 * @package Meola
 * @since Meola 1.0
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; // end of the loop. ?>

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php meola_content_nav( 'nav-below' ); ?>	
		<?php endif; ?>

	</div><!-- end #content -->

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>