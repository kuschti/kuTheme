<?php
/**
 * @package kuTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<header class="post-header text-center">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kuTheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<time datetime="<?php the_date('Y-m-d h:i:s'); ?>" pubdate><?php echo get_the_date(); ?></time>
	</header>

	<?php if ( is_archive() || is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php else : ?>

	<div class="post-content">
		<?php if ( has_post_thumbnail() ): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>

		<?php the_content( __( 'Read more &rarr;', 'kuTheme' ) ); ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'kuTheme' ), 'after' => '</div>' ) ); ?>
	</div>

	<?php endif; ?>

	<footer class="post-meta">
		<ul>
			<li class="entry-cats"><?php the_category(''); ?></li>
			<li class="entry-comments"><?php comments_popup_link( __( '0 comments', 'kuTheme' ), __( '1 comment', 'kuTheme' ), __( '% comments', 'kuTheme' ), 'comments-link', __( 'comments off', 'kuTheme' ) ); ?></li>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit Post &rarr;', 'kuTheme') ); ?></li>
		</ul>
	</footer>

</article>
