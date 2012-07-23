<?php
/**
 * Template Name: Full Width
 * Description: A full-width site template
 *
 * @package Meola
 * @since Meola 1.0
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content" class="fullwidth">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- end #content .fullwidth -->

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>