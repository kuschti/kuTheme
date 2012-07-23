<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Meola
 * @since Meola 1.0
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

		<nav id="nav-below" class="clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( 'Next Post &rarr;', 'meola' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( '&larr; Previous Post', 'meola' ) ); ?></div>
		</nav><!-- #nav-below -->

	</div><!-- end #content -->

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>