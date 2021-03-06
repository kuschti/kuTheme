<?php
/**
 * @package kuTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header text-center">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kuTheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<time datetime="<?php the_date('Y-m-d h:i:s'); ?>" pubdate><?php echo get_the_date(); ?></time>
		</a>
	</header>

	<div class="post-content">
		<?php the_content( __( 'Read more &rarr;', 'kuTheme' ) ); ?>
	</div>

	<footer class="post-meta">
		<ul>
			<li class="entry-cats"><?php the_category(''); ?></li>
			<li class="entry-comments"><?php comments_popup_link( __( '0 comments', 'kuTheme' ), __( '1 comment', 'kuTheme' ), __( '% comments', 'kuTheme' ), 'comments-link', __( 'comments off', 'kuTheme' ) ); ?></li>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit Post &rarr;', 'kuTheme') ); ?></li>
		</ul>
	</footer>

</article>
