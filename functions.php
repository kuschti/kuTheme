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
		wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', false, '1.0');
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
/**
 * Tell WordPress to run meola_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'kuTheme_setup' );

if ( ! function_exists( 'kuTheme_setup' ) ):
/**
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override kuTheme_setup() in a child theme, add your own kuTheme_setup to your child theme's
 * functions.php file.
 */
function kuTheme_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up the Meola theme options page and related code.
	require( get_template_directory() . '/includes/theme-options.php' );


}
endif; // kuTheme_setup


/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/

function meola_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'meola_page_menu_args' );

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/

function meola_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'meola_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/

function meola_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read more &rarr;', 'meola' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and meola_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/

function meola_auto_excerpt_more( $more ) {
	return ' &hellip;' . meola_continue_reading_link();
}
add_filter( 'excerpt_more', 'meola_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*
/* To override this link in a child theme, remove the filter and add your own
/* function tied to the get_the_excerpt filter hook.
/*-----------------------------------------------------------------------------------*/

function meola_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= meola_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'meola_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Remove inline styles printed when the gallery shortcode is used.
/*-----------------------------------------------------------------------------------*/

function meola_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'meola_remove_gallery_css' );


if ( ! function_exists( 'meola_comment' ) ) :
/*-----------------------------------------------------------------------------------*/
/* Comments template waipoua_comment
/*-----------------------------------------------------------------------------------*/

function meola_comment( $comment, $args, $depth ) {
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
					<li class="comment-author"><?php printf( __( '%s', 'meola' ), sprintf( '%s', get_comment_author_link() ) ); ?></li>
					<li class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'meola' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li>
					<li class="comment-time"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s &#64; %2$s', 'meola' ),
						get_comment_date('d.m.y'),
						get_comment_time() );
					?></a></li>
					<li class="comment-edit"><?php edit_comment_link( __( 'Edit', 'meola' ), ' ' );?></li>
				</ul>
					<div class="comment-text">
						<?php comment_text(); ?>

						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'meola' ); ?></p>
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
		<p><?php _e( '<span>Pingback:</span>', 'meola' ); ?> <?php comment_author_link(); ?></p>
		<p><?php edit_comment_link( __('Edit', 'meola'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas
/*-----------------------------------------------------------------------------------*/

function meola_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Widget Area Top', 'meola' ),
		'id' => 'sidebar-top',
		'description' => __( 'Widgets will appear below the header and above the post or page content area.', 'meola' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget' => "</div></aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Widget Area Bottom', 'meola' ),
		'id' => 'sidebar-bottom',
		'description' => __( 'Widgets will appear below the post or page content area and above the footer.', 'meola' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget' => "</div></aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'meola_widgets_init' );


if ( ! function_exists( 'meola_content_nav' ) ) :

/*-----------------------------------------------------------------------------------*/
/* Display navigation to next/previous pages when applicable
/*-----------------------------------------------------------------------------------*/

function meola_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="clearfix">
				<div class="nav-previous"><?php next_posts_link( __( '&laquo; Older entries', 'meola'  ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer entries &raquo;', 'meola' ) ); ?></div>
			</nav><!-- end #nav-below -->
	<?php endif;
}

endif; // meola_content_nav

/*-----------------------------------------------------------------------------------*/
/* Removes the default CSS style from the WP image gallery
/*-----------------------------------------------------------------------------------*/
add_filter('gallery_style', create_function('$a', 'return "
<div class=\'gallery\'>";'));

/*-----------------------------------------------------------------------------------*/
/* Deactives the default CSS styles for the Smart Archives Reloaded plugin
/*-----------------------------------------------------------------------------------*/

add_filter('smart_archives_load_default_styles', '__return_false');


/*-----------------------------------------------------------------------------------*/
/* Meola Shortcodes
/*-----------------------------------------------------------------------------------*/

// Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "meola_remove_wpautop")) {
	function meola_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Multi Columns Shortcodes
/* Don't forget to add "_last" behind the shortcode if it is the last column.
/*-----------------------------------------------------------------------------------*/

// Two Columns
function meola_shortcode_two_columns_one( $atts, $content = null ) {
   return '<div class="two-columns-one">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'meola_shortcode_two_columns_one' );

function meola_shortcode_two_columns_one_last( $atts, $content = null ) {
   return '<div class="two-columns-one last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'meola_shortcode_two_columns_one_last' );

// Three Columns
function meola_shortcode_three_columns_one($atts, $content = null) {
   return '<div class="three-columns-one">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'meola_shortcode_three_columns_one' );

function meola_shortcode_three_columns_one_last($atts, $content = null) {
   return '<div class="three-columns-one last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'meola_shortcode_three_columns_one_last' );

function meola_shortcode_three_columns_two($atts, $content = null) {
   return '<div class="three-columns-two">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'meola_shortcode_three_columns' );

function meola_shortcode_three_columns_two_last($atts, $content = null) {
   return '<div class="three-columns-two last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'meola_shortcode_three_columns_two_last' );

// Four Columns
function meola_shortcode_four_columns_one($atts, $content = null) {
   return '<div class="four-columns-one">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'meola_shortcode_four_columns_one' );

function meola_shortcode_four_columns_one_last($atts, $content = null) {
   return '<div class="four-columns-one last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'meola_shortcode_four_columns_one_last' );

function meola_shortcode_four_columns_two($atts, $content = null) {
   return '<div class="four-columns-two">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'meola_shortcode_four_columns_two' );

function meola_shortcode_four_columns_two_last($atts, $content = null) {
   return '<div class="four-columns-two last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'meola_shortcode_four_columns_two_last' );

function meola_shortcode_four_columns_three($atts, $content = null) {
   return '<div class="four-columns-three">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'meola_shortcode_four_columns_three' );

function meola_shortcode_four_columns_three_last($atts, $content = null) {
   return '<div class="four-columns-three last">' . meola_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'meola_shortcode_four_columns_three_last' );

// Divide Text Shortcode
function meola_shortcode_divider($atts, $content = null) {
   return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'meola_shortcode_divider' );

/*-----------------------------------------------------------------------------------*/
/* Text Highlight and Info Boxes Shortcodes
/*-----------------------------------------------------------------------------------*/

function meola_shortcode_white_box($atts, $content = null) {
   return '<div class="white-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'meola_shortcode_white_box' );

function meola_shortcode_yellow_box($atts, $content = null) {
   return '<div class="yellow-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'meola_shortcode_yellow_box' );

function meola_shortcode_red_box($atts, $content = null) {
   return '<div class="red-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'meola_shortcode_red_box' );

function meola_shortcode_blue_box($atts, $content = null) {
   return '<div class="blue-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'meola_shortcode_blue_box' );

function meola_shortcode_green_box($atts, $content = null) {
   return '<div class="green-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'meola_shortcode_green_box' );

function meola_shortcode_lightgrey_box($atts, $content = null) {
   return '<div class="lightgrey-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'lightgrey_box', 'meola_shortcode_lightgrey_box' );

function meola_shortcode_grey_box($atts, $content = null) {
   return '<div class="grey-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'grey_box', 'meola_shortcode_grey_box' );

function meola_shortcode_dark_box($atts, $content = null) {
   return '<div class="dark-box">' . do_shortcode( meola_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'dark_box', 'meola_shortcode_dark_box' );

/*-----------------------------------------------------------------------------------*/
/* General Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/

function meola_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '#',
    'target' => '',
    'color'	=> '',
    'size'	=> '',
	 'form'	=> '',
	 'style'	=> '',
    ), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

    return $out;
}
add_shortcode('button', 'meola_button');


/*-----------------------------------------------------------------------------------*/
/* Include Meola Flickr Widget
/*-----------------------------------------------------------------------------------*/

class meola_flickr extends WP_Widget {

	function meola_flickr() {
		$widget_ops = array('description' => 'Show your Flickr preview images' , 'meola');

		parent::WP_Widget(false, __('Meola Flickr', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$id = $instance['id'];
		$linktext = $instance['linktext'];
		$linkurl = $instance['linkurl'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

        <div class="flickr_badge_wrapper"><script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=m"></script>
		  <div class="clear"></div>
		  <?php if($linktext == ''){echo '';} else {echo '<div class="flickr-bottom"><a href="'.$linkurl.'" class="flickr-home" target="_blank">'.$linktext.'</a></div>';}?>
		</div><!-- end .flickr_badge_wrapper -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$linktext = esc_attr($instance['linktext']);
		$linkurl = esc_attr($instance['linkurl']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Flickr Profile Link Text:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linktext'); ?>" value="<?php echo $linktext; ?>" class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Flickr Profile URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linkurl'); ?>" value="<?php echo $linkurl; ?>" class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" />
        </p>

       	<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos:','meola'); ?></label>
            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Choose user or group:','meola'); ?></label>
            <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
                <option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'meola'); ?></option>
                <option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'meola'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Show latest or random pictures:','meola'); ?></label>
            <select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
                <option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'meola'); ?></option>
                <option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'meola'); ?></option>
            </select>
        </p>
		<?php
	}
}

register_widget('meola_flickr');

/*-----------------------------------------------------------------------------------*/
/* Include Meola Featured Image Widget
/*-----------------------------------------------------------------------------------*/

class meola_image extends WP_Widget {

	function meola_image() {
		$widget_ops = array('description' => 'Show a featured image' , 'meola');

		parent::WP_Widget(false, __('Meola Featured Image', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$imageurl = $instance['imageurl'];
		$imagewidth = $instance['imagewidth'];
		$imageheight = $instance['imageheight'];
		$imagetitle = $instance['imagetitle'];
		$linkurl = $instance['linkurl'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

			<a href="<?php echo $linkurl; ?>"><img src="<?php echo $imageurl; ?>" alt="<?php echo $imagetitle; ?>"  title="<?php echo $imagetitle; ?>" width="<?php echo $imagewidth; ?>" height="<?php echo $imageheight; ?>" class="meola-featured-image"></a><!-- end .featured-image -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$imageurl = esc_attr($instance['imageurl']);
		$imagewidth = esc_attr($instance['imagewidth']);
		$imageheight = esc_attr($instance['imageheight']);
		$imagetitle = esc_attr($instance['imagetitle']);
		$linkurl = esc_attr($instance['linkurl']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imageurl'); ?>"><?php _e('Image URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $imageurl; ?>" class="widefat" id="<?php echo $this->get_field_id('imageurl'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imagewidth'); ?>"><?php _e('Image Width:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imagewidth'); ?>" value="<?php echo $imagewidth; ?>" class="widefat" id="<?php echo $this->get_field_id('imagewidth'); ?>" />
        </p>

		   <p>
            <label for="<?php echo $this->get_field_id('imageheight'); ?>"><?php _e('Image Height:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageheight'); ?>" value="<?php echo $imageheight; ?>" class="widefat" id="<?php echo $this->get_field_id('imageheight'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imagetitle'); ?>"><?php _e('Image Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imagetitle'); ?>" value="<?php echo $imagetitle; ?>" class="widefat" id="<?php echo $this->get_field_id('imagetitle'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Link URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linkurl'); ?>" value="<?php echo $linkurl; ?>" class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" />
        </p>

		<?php
	}
}

register_widget('meola_image');

/*-----------------------------------------------------------------------------------*/
/* Include Meola About Widget
/*-----------------------------------------------------------------------------------*/

class meola_about extends WP_Widget {

	function meola_about() {
		$widget_ops = array('description' => 'About widget with picture and intro text' , 'meola');

		parent::WP_Widget(false, __('Meola About', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$imageurl = $instance['imageurl'];
		$imagewidth = $instance['imagewidth'];
		$imageheight = $instance['imageheight'];
		$imagecaption = $instance['imagecaption'];
		$abouttext = $instance['abouttext'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

			<div class="about-image-wrap">
			<img src="<?php echo $imageurl; ?>" width="<?php echo $imagewidth; ?>" height="<?php echo $imageheight; ?>" class="about-image">
			<p class="about-image-caption"><?php echo $imagecaption; ?></p>
			</div><!-- end .about-image-wrap -->
			<div class="about-text-wrap">
			<p class="about-text"><?php echo $abouttext; ?></p>
			</div><!-- end .about-text-wrap -->
	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$imageurl = esc_attr($instance['imageurl']);
		$imagewidth = esc_attr($instance['imagewidth']);
		$imageheight = esc_attr($instance['imageheight']);
		$imagecaption = esc_attr($instance['imagecaption']);
		$abouttext = esc_attr($instance['abouttext']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imageurl'); ?>"><?php _e('Image URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $imageurl; ?>" class="widefat" id="<?php echo $this->get_field_id('imageurl'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imagewidth'); ?>"><?php _e('Image Width (only value, no px):','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imagewidth'); ?>" value="<?php echo $imagewidth; ?>" class="widefat" id="<?php echo $this->get_field_id('imagewidth'); ?>" />
        </p>

		   <p>
            <label for="<?php echo $this->get_field_id('imageheight'); ?>"><?php _e('Image Height (only value, no px):','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('imageheight'); ?>" value="<?php echo $imageheight; ?>" class="widefat" id="<?php echo $this->get_field_id('imageheight'); ?>" />
        </p>

		  <p>
            <label for="<?php echo $this->get_field_id('imagecaption'); ?>"><?php _e('Image Caption Text:','meola'); ?></label>
            <textarea name="<?php echo $this->get_field_name('imagecaption'); ?>" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('imagecaption'); ?>"><?php echo( $imagecaption ); ?></textarea>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('abouttext'); ?>"><?php _e('About Text:','meola'); ?></label>
           <textarea name="<?php echo $this->get_field_name('abouttext'); ?>" class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('abouttext'); ?>"><?php echo( $abouttext ); ?></textarea>
        </p>

		<?php
	}
}

register_widget('meola_about');

/*-----------------------------------------------------------------------------------*/
/* Include Meola Video Widget
/*-----------------------------------------------------------------------------------*/

class meola_video extends WP_Widget {

	function meola_video() {
		$widget_ops = array('description' => 'Show a featured video' , 'meola');

		parent::WP_Widget(false, __('Meola Featured Video', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$embedcode = $instance['embedcode'];

		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

        <div class="video_widget">
		  <div class="featured-video"><?php echo $embedcode; ?></div>
		  </div><!-- end .video_widget -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$embedcode = esc_attr($instance['embedcode']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Video embed code:','meola'); ?></label>
				<textarea name="<?php echo $this->get_field_name('embedcode'); ?>" class="widefat" rows="6" id="<?php echo $this->get_field_id('embedcode'); ?>"><?php echo( $embedcode ); ?></textarea>
        </p>

		<?php
	}
}

register_widget('meola_video');


/*-----------------------------------------------------------------------------------*/
/* Include Meola Recent Posts Widget
/*-----------------------------------------------------------------------------------*/

class meola_recentposts extends WP_Widget {

	function meola_recentposts() {
		$widget_ops = array('description' => 'Show 3 recent posts with or without thumbnails' , 'meola');

		parent::WP_Widget(false, __('Meola Recent Posts', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
      $cat = apply_filters('widget_title', $instance['cat']);
		$thumbnail = $instance['thumbnail'];

		echo $before_widget; ?>
		<?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
							<?php
								global $post;
								$meola_post = $post;

								// get the category IDs and place them in an array
								if($cat) {
									$args = 'posts_per_page=' . 3 . '&cat=' . $cat;
								} else {
									$args = 'posts_per_page=' . 3;
								}
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) : setup_postdata($post); ?>
									<li class="recentpost">
											<header class="recentpost-header">
												<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
												<a href="<?php the_permalink(); ?>" class="entry-date"><?php echo get_the_date(); ?></a>
											</header>
											<?php if($thumbnail == true) { ?>
												<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large');?></a>
											<?php } ?>
											<div class="entry-summary">
												<?php the_excerpt(); ?>
											</div>
									</li>
								<?php endforeach; ?>
								<?php $post = $meola_post; ?>
							</ul>
	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$cat = esc_attr($instance['cat']);
		$thumbnail = esc_attr($instance['thumbnail']);
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Category ID numbers (to choose which categories to include):','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('cat'); ?>" value="<?php echo $cat; ?>" class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" />
        </p>

		<p>
          <input id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="1" <?php checked( '1', $thumbnail ); ?>/>
          <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Display thumbnails?','meola'); ?></label>
        </p>


		<?php
	}
}

register_widget('meola_recentposts');

/*-----------------------------------------------------------------------------------*/
/* Including Meola Social Links Widget
/*-----------------------------------------------------------------------------------*/

 class meola_sociallinks extends WP_Widget {

	function meola_sociallinks() {
		$widget_ops = array('description' => 'Link to your social profile sites' , 'meola');

		parent::WP_Widget(false, __('Meola Social Links', 'meola'),$widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$picasa = $instance['picasa'];
		$fivehundredpx = $instance['fivehundredpx'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$dribbble = $instance['dribbble'];
		$ffffound = $instance['ffffound'];
		$pinterest = $instance['pinterest'];
		$mixi = $instance['mixi'];
		$behance = $instance['behance'];
		$deviantart = $instance['deviantart'];
		$squidoo = $instance['squidoo'];
		$slideshare = $instance['slideshare'];
		$lastfm = $instance['lastfm'];
		$grooveshark = $instance['grooveshark'];
		$soundcloud = $instance['soundcloud'];
		$foursquare = $instance['foursquare'];
		$github = $instance['github'];
		$linkedin = $instance['linkedin'];
		$xing = $instance['xing'];
		$wordpress = $instance['wordpress'];
		$tumblr = $instance['tumblr'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];
		$target = $instance['target'];


		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widget-title">'.$title.'</h3>'; ?>

        <ul class="sociallinks">
			<?php
			if($twitter != '' && $target != ''){
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter" target="_blank">Twitter</a></li>';
			} elseif($twitter != '') {
				echo '<li><a href="'.$twitter.'" class="twitter" title="Twitter">Twitter</a></li>';
			}
			?>

			<?php
			if($facebook != '' && $target != ''){
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook" target="_blank">Facebook</a></li>';
			} elseif($facebook != '') {
				echo '<li><a href="'.$facebook.'" class="facebook" title="Facebook">Facebook</a></li>';
			}
			?>

			<?php
			if($googleplus != '' && $target != ''){
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+" target="_blank">Google+</a></li>';
			} elseif($googleplus != '') {
				echo '<li><a href="'.$googleplus.'" class="googleplus" title="Google+">Google+</a></li>';
			}
			?>

			<?php if($flickr != '' && $target != ''){
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr" target="_blank">Flickr</a></li>';
			} elseif($flickr != '') {
				echo '<li><a href="'.$flickr.'" class="flickr" title="Flickr">Flickr</a></li>';
			}
			?>

			<?php if($instagram != '' && $target != ''){
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram" target="_blank">Instagram</a></li>';
			} elseif($instagram != '') {
				echo '<li><a href="'.$instagram.'" class="instagram" title="Instagram">Instagram</a></li>';
			}
			?>

			<?php if($picasa != '' && $target != ''){
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa" target="_blank">Picasa</a></li>';
			} elseif($picasa != '') {
				echo '<li><a href="'.$picasa.'" class="picasa" title="Picasa">Picasa</a></li>';
			}
			?>

			<?php if($fivehundredpx != '' && $target != ''){
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px" target="_blank">500px</a></li>';
			} elseif($fivehundredpx != '') {
				echo '<li><a href="'.$fivehundredpx.'" class="fivehundredpx" title="500px">500px</a></li>';
			}
			?>

			<?php if($youtube != '' && $target != ''){
			echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube" target="_blank">YouTube</a></li>';
			} elseif($youtube != '') {
				echo '<li><a href="'.$youtube.'" class="youtube" title="YouTube">YouTube</a></li>';
			}
			?>

			<?php if($vimeo != '' && $target != ''){
			echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo" target="_blank">Vimeo</a></li>';
			} elseif($vimeo != '') {
				echo '<li><a href="'.$vimeo.'" class="vimeo" title="Vimeo">Vimeo</a></li>';
			}
			?>

			<?php if($dribbble != '' && $target != ''){
			echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble" target="_blank">Dribbble</a></li>';
			} elseif($dribbble != '') {
				echo '<li><a href="'.$dribbble.'" class="dribbble" title="Dribbble">Dribbble</a></li>';
			}
			?>

			<?php if($ffffound != '' && $target != ''){
			echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound" target="_blank">Ffffound</a></li>';
			} elseif($ffffound != '') {
				echo '<li><a href="'.$ffffound.'" class="ffffound" title="Ffffound">Ffffound</a></li>';
			}
			?>

			<?php if($pinterest != '' && $target != ''){
			echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest" target="_blank">Pinterest</a></li>';
			} elseif($pinterest != '') {
				echo '<li><a href="'.$pinterest.'" class="pinterest" title="Pinterest">Pinterest</a></li>';
			}
			?>

			<?php if($mixi != '' && $target != ''){
				echo '<li><a href="'.$mixi.'" class="mixi" title="mixi" target="_blank">mixi</a></li>';
			} elseif($mixi != '') {
				echo '<li><a href="'.$mixi.'" class="mixi" title="mixi">mixi</a></li>';
			}
			?>

			<?php if($behance != '' && $target != ''){
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network" target="_blank">Behance Network</a></li>';
			} elseif($behance != '') {
				echo '<li><a href="'.$behance.'" class="behance" title="Behance Network">Behance Network</a></li>';
			}
			?>

			<?php if($deviantart != '' && $target != ''){
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART" target="_blank">deviantART</a></li>';
			} elseif($deviantart != '') {
				echo '<li><a href="'.$deviantart.'" class="deviantart" title="deviantART">deviantART</a></li>';
			}
			?>

			<?php if($squidoo != '' && $target != ''){
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo" target="_blank">Squidoo</a></li>';
			} elseif($squidoo != '') {
				echo '<li><a href="'.$squidoo.'" class="squidoo" title="Squidoo">Squidoo</a></li>';
			}
			?>

			<?php if($slideshare != '' && $target != ''){
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare" target="_blank">Slideshare</a></li>';
			} elseif($slideshare != '') {
				echo '<li><a href="'.$slideshare.'" class="slideshare" title="Slideshare">Slideshare</a></li>';
			}
			?>

			<?php if($lastfm != '' && $target != ''){
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm" target="_blank">Lastfm</a></li>';
			} elseif($lastfm != '') {
				echo '<li><a href="'.$lastfm.'" class="lastfm" title="Lastfm">Lastfm</a></li>';
			}
			?>

			<?php if($grooveshark != '' && $target != ''){
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark" target="_blank">Grooveshark</a></li>';
			} elseif($grooveshark != '') {
				echo '<li><a href="'.$grooveshark.'" class="grooveshark" title="Grooveshark">Grooveshark</a></li>';
			}
			?>

			<?php if($soundcloud != '' && $target != ''){
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud" target="_blank">Soundcloud</a></li>';
			} elseif($soundcloud != '') {
				echo '<li><a href="'.$soundcloud.'" class="soundcloud" title="Soundcloud">Soundcloud</a></li>';
			}
			?>

			<?php if($foursquare != '' && $target != ''){
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare" target="_blank">Foursquare</a></li>';
			} elseif($foursquare != '') {
				echo '<li><a href="'.$foursquare.'" class="foursquare" title="Foursquare">Foursquare</a></li>';
			}
			?>

			<?php if($github != '' && $target != ''){
				echo '<li><a href="'.$github.'" class="github" title="GitHub" target="_blank">GitHub</a></li>';
			} elseif($github != '') {
				echo '<li><a href="'.$github.'" class="github" title="GitHub">GitHub</a></li>';
			}
			?>

			<?php if($linkedin != '' && $target != ''){
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn" target="_blank">LinkedIn</a></li>';
			} elseif($linkedin != '') {
				echo '<li><a href="'.$linkedin.'" class="linkedin" title="LinkedIn">LinkedIn</a></li>';
			}
			?>

			<?php if($xing != '' && $target != ''){
				echo '<li><a href="'.$xing.'" class="xing" title="Xing" target="_blank">Xing</a></li>';
			} elseif($xing != '') {
				echo '<li><a href="'.$xing.'" class="xing" title="Xing">Xing</a></li>';
			}
			?>

			<?php if($wordpress != '' && $target != ''){
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress" target="_blank">WordPress</a></li>';
			} elseif($wordpress != '') {
				echo '<li><a href="'.$wordpress.'" class="wordpress" title="WordPress">WordPress</a></li>';
			}
			?>

			<?php if($tumblr != '' && $target != ''){
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr" target="_blank">Tumblr</a></li>';
			} elseif($tumblr != '') {
				echo '<li><a href="'.$tumblr.'" class="tumblr" title="Tumblr">Tumblr</a></li>';
			}
			?>

			<?php if($rss != '' && $target != ''){
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed" target="_blank">RSS Feed</a></li>';
			} elseif($rss != '') {
				echo '<li><a href="'.$rss.'" class="rss" title="RSS Feed">RSS Feed</a></li>';
			}
			?>

			<?php if($rsscomments != '' && $target != ''){
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments" target="_blank">RSS Comments</a></li>';
			} elseif($rsscomments != '') {
				echo '<li><a href="'.$rsscomments.'" class="rsscomments" title="RSS Comments">RSS Comments</a></li>';
			}
			?>

		</ul><!-- end .sociallinks -->

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$title = esc_attr($instance['title']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$googleplus = esc_attr($instance['googleplus']);
		$flickr = esc_attr($instance['flickr']);
		$instagram = esc_attr($instance['instagram']);
		$picasa = esc_attr($instance['picasa']);
		$fivehundredpx = esc_attr($instance['fivehundredpx']);
		$youtube = esc_attr($instance['youtube']);
		$vimeo = esc_attr($instance['vimeo']);
		$dribbble = esc_attr($instance['dribbble']);
		$ffffound = esc_attr($instance['ffffound']);
		$pinterest = esc_attr($instance['pinterest']);
		$mixi = esc_attr($instance['mixi']);
		$behance = esc_attr($instance['behance']);
		$deviantart = esc_attr($instance['deviantart']);
		$squidoo = esc_attr($instance['squidoo']);
		$slideshare = esc_attr($instance['slideshare']);
		$lastfm = esc_attr($instance['lastfm']);
		$grooveshark = esc_attr($instance['grooveshark']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$foursquare = esc_attr($instance['foursquare']);
		$github = esc_attr($instance['github']);
		$linkedin = esc_attr($instance['linkedin']);
		$xing = esc_attr($instance['xing']);
		$wordpress = esc_attr($instance['wordpress']);
		$tumblr = esc_attr($instance['tumblr']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);
		$target = esc_attr($instance['target']);

		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
        </p>

		 <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL (e.g. via Instagrid.me):','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('picasa'); ?>"><?php _e('Picasa URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('picasa'); ?>" value="<?php echo $picasa; ?>" class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('fivehundredpx'); ?>"><?php _e('500px URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('fivehundredpx'); ?>" value="<?php echo $fivehundredpx; ?>" class="widefat" id="<?php echo $this->get_field_id('fivehundredpx'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $dribbble; ?>" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('ffffound'); ?>"><?php _e('Ffffound URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('ffffound'); ?>" value="<?php echo $ffffound; ?>" class="widefat" id="<?php echo $this->get_field_id('ffffound'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('mixi'); ?>"><?php _e('mixi URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('mixi'); ?>" value="<?php echo $mixi; ?>" class="widefat" id="<?php echo $this->get_field_id('mixi'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance Network URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $behance; ?>" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" />
        </p>

		 <p>
            <label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('deviantART URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $deviantart; ?>" class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('squidoo'); ?>"><?php _e('Squidoo URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('squidoo'); ?>" value="<?php echo $squidoo; ?>" class="widefat" id="<?php echo $this->get_field_id('squidoo'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('slideshare'); ?>"><?php _e('Slideshare URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('slideshare'); ?>" value="<?php echo $slideshare; ?>" class="widefat" id="<?php echo $this->get_field_id('slideshare'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php _e('Last.fm URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo $lastfm; ?>" class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('grooveshark'); ?>"><?php _e('Grooveshark URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('grooveshark'); ?>" value="<?php echo $grooveshark; ?>" class="widefat" id="<?php echo $this->get_field_id('grooveshark'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('GitHub URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('github'); ?>" value="<?php echo $github; ?>" class="widefat" id="<?php echo $this->get_field_id('github'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php _e('WordPress URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('wordpress'); ?>" value="<?php echo $wordpress; ?>" class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $tumblr; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:','meola'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
        </p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['target'], true ); ?> id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php checked( $target, 'on' ); ?>> <?php _e('Open all links in a new browser tab', 'meola'); ?></input>
		</p>

		<?php
	}
}

register_widget('meola_sociallinks');
