<?php
/**
 * @package kuTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<header class="post-header text-center">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<time datetime="<?php the_date('Y-m-d h:i:s'); ?>" pubdate><?php echo get_the_date(); ?></time>
	</header>

	<div class="post-content clearfix">
		<?php if ( has_post_thumbnail() && get_post_format() ): ?>
			<?php else: ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'kuTheme' ), 'after' => '</div>' ) ); ?>
	</div>

	<footer class="post-meta">
		<ul>
			<li class="entry-cats"><span><?php _e('Posted in:', 'kuTheme') ?></span> <?php the_category( ', ' ); ?></li>
			<?php $tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ): ?>
			<li class="entry-tags"><span><?php _e('Tagged:', 'kuTheme') ?></span> <?php the_tags( '', ', ', '' ); ?></li>
			<?php endif; ?>

			<?php if (function_exists('sayfa_sayac')) : ?>
				<?php sayfa_sayac(1, 0, 1, 1, 0, '<li>', '',' &mdash; ', '', '</li>') ; ?>
			<?php endif; ?>
		</ul>
	</footer>

</article>
