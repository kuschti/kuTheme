<?php
/**
 * The template for displaying content in the single.php template
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
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!--end .entry-header -->

	<div class="entry-content clearfix">
		<?php if ( has_post_thumbnail() && get_post_format() ): ?>
			<?php else: ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>
		<?php the_content(); ?>	
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'meola' ), 'after' => '</div>' ) ); ?>
	</div><!-- end .entry-content -->

	<footer class="entry-meta">
		<ul>
			<li class="entry-cats"><span><?php _e('Posted in:', 'meola') ?></span> <?php the_category( ', ' ); ?></li>
			<?php $tags_list = get_the_tag_list( '', ', ' ); 
				if ( $tags_list ): ?>	
			<li class="entry-tags"><span><?php _e('Tagged:', 'meola') ?></span> <?php the_tags( '', ', ', '' ); ?></li>
			<?php endif; ?>
			<?php // Include Share-Btns on single posts page
				$options = get_option('meola_theme_options');
				if($options['share-singleposts'] or $options['share-posts']) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>
		</ul>
	</footer><!-- end .entry-meta -->
	
	<?php if ( get_post_format() ) : // Show author bio only for standard post format posts ?>	
	<?php else: ?>
		<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
		<div class="author-info">
				<div class="author-description">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'meola_author_bio_avatar_size', 80 ) ); ?>
					<h3><?php printf( __( 'Posted by %s', 'meola' ), "<a href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='author'>" . get_the_author() . "</a>" ); ?></h3>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- end .author-description -->			
			</div><!-- end .author-info -->
		<?php endif; ?>
	<?php endif; ?>

</article><!-- end .post-<?php the_ID(); ?> -->