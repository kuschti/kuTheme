<?php
/**
 * @package kuTheme
 */

get_header(); ?>

	<main id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php
			$next = get_next_posts_link();
			$prev = get_previous_posts_link();
			?>
			<?php if ( $next || $prev ): ?>
			<nav class="pagination row">
        <?php if ( $next ): ?>
          <a href='<?php echo next_posts( false, 0 ); ?>' class='button'> <?php _e( 'Older Entries', 'kuTheme' ) ?> </a>
        <?php endif; ?>
        <?php if ( $prev ): ?>
          <a href='<?php echo previous_posts( false, 0 ); ?>' class='button'> <?php _e( 'Newer Entries', 'kuTheme' ) ?> </a>
        <?php endif; ?>
			</nav>
		<?php endif; ?>

	</main>

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
