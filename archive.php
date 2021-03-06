<?php
/**
 * @package kuTheme
 */

get_header(); ?>

<?php get_sidebar('top'); ?>

	<div id="content">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title">
					<?php
							if ( is_category() ) {
								printf( __( 'Posts in Category &lsquo;%s&rsquo;', 'kuTheme' ), '<span>' . single_cat_title( '', false ) . '</span>' );

							} elseif ( is_tag() ) {
								printf( __( 'Posts Tagged &lsquo;%s&rsquo;', 'kuTheme' ), '<span>' . single_tag_title( '', false ) . '</span>' );

							} elseif ( is_author() ) {
								the_post();
								printf( __( 'All Posts by %s', 'kuTheme' ), '<span><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
								rewind_posts();

							} elseif ( is_day() ) {
								printf( __( 'Daily Archives: %s', 'kuTheme' ), '<span>' . get_the_date() . '</span>' );

							} elseif ( is_month() ) {
								printf( __( 'Monthly Archives: %s', 'kuTheme' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

							} elseif ( is_year() ) {
								printf( __( 'Yearly Archives: %s', 'kuTheme' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

							} else {
								_e( 'Archives', 'kuTheme' );
							}
						?>
				</h2>
				<?php
						if ( is_category() ) {
							// show an optional category description
							$category_description = category_description();
							if ( ! empty( $category_description ) )
								echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

						} elseif ( is_tag() ) {
							// show an optional tag description
							$tag_description = tag_description();
							if ( ! empty( $tag_description ) )
								echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
						}
					?>
			</header>

			<?php rewind_posts(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile;?>

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

		<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'kuTheme' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kuTheme' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>

		<?php endif; ?>

	</div>

<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
