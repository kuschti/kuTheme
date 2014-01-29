<?php
/**
 * @package kuTheme
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h2 class="page-title"><?php echo $wp_query->found_posts; ?> <?php printf( __( 'Search Results for &lsquo;%s&rsquo;', 'kuTheme' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		</header>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php	get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php kuTheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

			<article id="post-0" class="page no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'kuTheme' ); ?></h1>
				</header>
				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'kuTheme' ); ?></p>
				</div>
			</article>

		<?php endif; ?>

	</div>

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
