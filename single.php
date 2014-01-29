<?php
/**
 * @package kuTheme
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; ?>

		<nav id="nav-below" class="clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( 'Next Post &rarr;', 'kuTheme' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( '&larr; Previous Post', 'kuTheme' ) ); ?></div>
		</nav>

	</div>

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
