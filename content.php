<?php
/**
 * The default template for displaying content
 *
 * @package Meola
 * @since Meola 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<aside class="entry-details">
		<a href="<?php the_permalink(); ?>" class="entry-date"><?php echo get_the_date(); ?></a>
	</aside><!--end .entry-details -->

	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'meola' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!--end .entry-header -->

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- end .entry-summary -->

	<?php else : ?>
			
	<div class="entry-content clearfix">
		<?php if ( has_post_thumbnail() ): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>
		
		<?php // Show Excerpt via Theme Options
			$options = get_option('meola_theme_options');
			if( $options['show-excerpt'] ) : ?>
				<?php the_excerpt(); ?>
		<?php else : ?>
				<?php the_content( __( 'Read more &rarr;', 'meola' ) ); ?>
		<?php endif; ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'meola' ), 'after' => '</div>' ) ); ?>
	</div><!-- end .entry-content -->

	<?php endif; ?>

	<footer class="entry-meta">
		<ul>
			<li class="entry-cats"><?php the_category(''); ?></li>
			<li class="entry-comments"><?php comments_popup_link( __( '0 comments', 'meola' ), __( '1 comment', 'meola' ), __( '% comments', 'meola' ), 'comments-link', __( 'comments off', 'meola' ) ); ?></li>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit Post &rarr;', 'meola') ); ?></li>
			<?php // Include Share-Btns
				$options = get_option('meola_theme_options');
				if( $options['share-posts'] ) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>
		</ul>
	</footer><!-- end .entry-meta -->

</article><!-- end post -<?php the_ID(); ?> -->