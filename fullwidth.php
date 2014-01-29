<?php
/**
 * Template Name: Full Width
 * Description: A full-width site template
 *
 * @package kuTheme
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content" class="fullwidth">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>
			<?php comments_template( '', true ); ?>

		<?php endwhile; ?>

	</div>

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
