<?php

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 980; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Call JavaScript Scripts
/*-----------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts','kuTheme_scripts_function');
	function kuTheme_scripts_function() {
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', false, '1.0');
}

/*-----------------------------------------------------------------------------------*/
/* Call Stylesheets
/*-----------------------------------------------------------------------------------*/

function kuTheme_styles_function() {
	// register main stylesheet
  wp_register_style( 'kuTheme-main', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );

  wp_enqueue_style( 'kuTheme-main' );
  wp_enqueue_style( 'kuTheme-medium' );
  wp_enqueue_style( 'kuTheme-large' );
}

add_action('wp_enqueue_scripts','kuTheme_styles_function', 999);


/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers support for various WordPress features.
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'kuTheme_setup' );

if ( ! function_exists( 'kuTheme_setup' ) ):

	function kuTheme_setup() {

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

	}
endif;

/*-----------------------------------------------------------------------------------*/
/* Remove <p> around images
/*-----------------------------------------------------------------------------------*/
function kuTheme_cleanout_ptags_on_images($content) {
	return preg_replace('/<p[^>]*>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\/p>/', '<div class="post-content-image">$1</div>', $content);
}
add_filter('the_content', 'kuTheme_cleanout_ptags_on_images');

/*-----------------------------------------------------------------------------------*/
/* Remove <p> around oEmbeds
/*-----------------------------------------------------------------------------------*/
function kuTheme_cleanout_oembed($html, $url, $attr, $post_id) {
  return '<div class="flex-video widescreen">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'kuTheme_cleanout_oembed', 99, 4);

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/
function kuTheme_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'kuTheme_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/
function kuTheme_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read more &rarr;', 'kuTheme' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and kuTheme_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/
function kuTheme_auto_excerpt_more( $more ) {
	return ' &hellip;' . kuTheme_continue_reading_link();
}
add_filter( 'excerpt_more', 'kuTheme_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*
/* To override this link in a child theme, remove the filter and add your own
/* function tied to the get_the_excerpt filter hook.
/*-----------------------------------------------------------------------------------*/

function kuTheme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= kuTheme_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'kuTheme_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Remove inline styles printed when the gallery shortcode is used.
/*-----------------------------------------------------------------------------------*/

function kuTheme_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'kuTheme_remove_gallery_css' );


if ( ! function_exists( 'kuTheme_comment' ) ) :
/*-----------------------------------------------------------------------------------*/
/* Comments template waipoua_comment
/*-----------------------------------------------------------------------------------*/

function kuTheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 55 ); ?>
			</div>

<div class="comment-content">
				<ul class="comment-meta">
					<li class="comment-author"><?php printf( __( '%s', 'kuTheme' ), sprintf( '%s', get_comment_author_link() ) ); ?></li>
					<li class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'kuTheme' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li>
					<li class="comment-time"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s &#64; %2$s', 'kuTheme' ),
						get_comment_date('d.m.y'),
						get_comment_time() );
					?></a></li>
					<li class="comment-edit"><?php edit_comment_link( __( 'Edit', 'kuTheme' ), ' ' );?></li>
				</ul>
					<div class="comment-text">
						<?php comment_text(); ?>

						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kuTheme' ); ?></p>
						<?php endif; ?>
					</div><!-- end .comment-text -->

			</div><!-- end .comment-content -->

		</article><!-- end .comment -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="pingback">
		<p><?php _e( '<span>Pingback:</span>', 'kuTheme' ); ?> <?php comment_author_link(); ?></p>
		<p><?php edit_comment_link( __('Edit', 'kuTheme'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas
/*-----------------------------------------------------------------------------------*/

function kuTheme_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Widget Area Bottom', 'kuTheme' ),
		'id' => 'sidebar-bottom',
		'description' => __( 'Widgets will appear below the post or page content area and above the footer.', 'kuTheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget' => "</div></aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'kuTheme_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/* Removes the default CSS style from the WP image gallery
/*-----------------------------------------------------------------------------------*/
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));
