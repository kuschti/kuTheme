<?php
/**
 * Meola Theme Options
 *
 * @package WordPress
 * @subpackage Meola
 * @since Meola 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function meola_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'meola-theme-options', get_template_directory_uri() . '/includes/theme-options.css', false, '2012-07-22' );
	wp_enqueue_script( 'meola-theme-options', get_template_directory_uri() . '/includes/theme-options.js', array( 'farbtastic' ), '2012-07-22' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'meola_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our meola_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, meola_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function meola_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === meola_get_theme_options() )
		add_option( 'meola_theme_options', meola_get_default_theme_options() );

	register_setting(
		'meola_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'meola_theme_options', // Database option, see meola_get_theme_options()
		'meola_theme_options_validate' // The sanitization callback, see meola_theme_options_validate()
	);
}
add_action( 'admin_init', 'meola_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/* 
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function meola_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'meola' ), // Name of page
		__( 'Theme Options', 'meola' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'meola_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Meola
/*-----------------------------------------------------------------------------------*/

function meola_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#36A87D',
		'specialbg_color'   => '#45C496',
		'custom_logo' => '',
		'custom_footertext' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'show-excerpt' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
		'use-slider' => '',
	);

	return apply_filters( 'meola_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Meola
/*-----------------------------------------------------------------------------------*/

function meola_get_theme_options() {
	return get_option( 'meola_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Meola
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'meola' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'meola_options' );
				$options = meola_get_theme_options();
				$default_options = meola_get_default_theme_options();
			?>

			<table class="form-table">

			<h3 style="margin-top:30px;"><?php _e( 'Custom Colors', 'meola' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Color', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'meola' ); ?></span></legend>
							 <input type="text" name="meola_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom link color, the default Link Color is: %s. Do not forget to include the # before the color value.', 'meola' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Background Color', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Background Color', 'meola' ); ?></span></legend>
							 <input type="text" name="meola_theme_options[specialbg_color]" value="<?php echo esc_attr( $options['specialbg_color'] ); ?>" id="specialbg-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom background colors (for special Widgets, Main Navigation & Autor Info). The default Background Color is: %s).', 'meola' ), $default_options['specialbg_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Custom Logo, Post Excerpts and Custom Footer Text', 'meola' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'meola' ); ?></span></legend>
							<input class="regular-text" type="text" name="meola_theme_options[custom_logo]" value="<?php echo esc_attr( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="meola_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'meola'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'meola'); ?></a><?php _e('. Then copy your logo image file URL and insert the URL here.', 'meola'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Post Excerpts', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Post Excerpts', 'meola' ); ?></span></legend>
							<input id="meola_theme_options[show-excerpt]" name="meola_theme_options[show-excerpt]" type="checkbox" value="1" <?php checked( '1', $options['show-excerpt'] ); ?> />
							<label class="description" for="meola_theme_options[show-excerpt]"><?php _e( 'Check this box to show automatic post excerpts in your blog (with this option you will not need the more tag in posts).', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Text', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'meola' ); ?></span></legend>
							<textarea id="meola_theme_options[custom_footertext]" class="small-text" cols="120" rows="3" name="meola_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="meola_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text. Standard HTML is allowed.', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>
				
				</table>
				
				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Favicon and Apple Touch Icon', 'meola' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'meola' ); ?></span></legend>
							<input class="regular-text" type="text" name="meola_theme_options[custom_favicon]" value="<?php echo esc_attr( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="meola_theme_options[custom_favicon]"><?php _e( 'Create a <strong>16x16px</strong> image and generate a .ico favicon using a favicon online generator (e.g. <a href="http://www.faviconr.com/" target="_blank">Faviconr</a>). Now upload your favicon to your themes folder (via FTP) and enter your Favicon URL here (the URL path should be similar to: yourdomain.com/wp-content/themes/meola/favicon.ico).', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Apple Touch Icon', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Apple Touch Icon', 'meola' ); ?></span></legend>
							<input class="regular-text" type="text" name="meola_theme_options[custom_apple_icon]" value="<?php echo esc_attr( $options['custom_apple_icon'] ); ?>" />
						<br/><label class="description" for="meola_theme_options[custom_apple_icon]"><?php _e('Create a <strong>128x128px png</strong> image for your webclip icon. Upload your image using the ', 'meola'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'meola'); ?></a><?php _e('. Now copy the image file URL and insert the URL here.', 'meola'); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Share Buttons', 'meola' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for posts', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for posts', 'meola' ); ?></span></legend>
							<input id="meola_theme_options[share-posts]" name="meola_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="meola_theme_options[share-posts]"><?php _e( 'Check this box to include share buttons (for Twitter, Facebook, Google+) on your blogs front page and on single post pages.', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for single post pages only', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for single post pages only', 'meola' ); ?></span></legend>
							<input id="meola_theme_options[share-singleposts]" name="meola_theme_options[share-singleposts]" type="checkbox" value="1" <?php checked( '1', $options['share-singleposts'] ); ?> />
							<label class="description" for="meola_theme_options[share-singleposts]"><?php _e( 'Check this box to include the share post buttons <strong>only</strong> on single post pages (below the post content).', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for pages', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for pages', 'meola' ); ?></span></legend>
							<input id="meola_theme_options[share-pages]" name="meola_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="meola_theme_options[share-pages]"><?php _e( 'Check this box to also include the share buttons on pages.', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

				</table>

				<table class="form-table">

				<h3 style="margin-top:30px;"><?php _e( 'Responsive Slider', 'meola' ); ?></h3>

				<tr valign="top"><th scope="row"><?php _e( 'Include Responsive Slider', 'meola' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Include Responsive Slider', 'meola' ); ?></span></legend>
							<input id="meola_theme_options[use-slider]" name="meola_theme_options[use-slider]" type="checkbox" value="1" <?php checked( '1', $options['use-slider'] ); ?> />
							<label class="description" for="meola_theme_options[use-slider]"><?php _e( 'Check this box to inlcude the Responsive Slider WordPress-Plugin below the blog title in the header section of your front page(this can either be your blog or a static page, see Settings/Reading).', 'meola' ); ?></label>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function meola_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Main menu background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['specialbg_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['specialbg_color'] ) )
			$output['specialbg_color'] = '#' . strtolower( ltrim( $input['specialbg_color'], '#' ) );

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );

	// checkbox values are either 0 or 1
	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['show-excerpt'] ) )
		$input['show-excerpt'] = null;
	$input['show-excerpt'] = ( $input['show-excerpt'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['use-slider'] ) )
		$input['use-slider'] = null;
	$input['use-slider'] = ( $input['use-slider'] == 1 ? 1 : 0 );

	return $input;
}


/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function meola_print_link_color_style() {
	$options = meola_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = meola_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a,
.entry-header h2.entry-title a:hover,
.widget-area .widget_meola_recentposts h3.entry-title a:hover,
.widget-area .widget_twitter h3.widget-title a:hover {
	color:<?php echo $link_color; ?>;
}
.entry-meta a.share-btn,
input#submit, 
input.wpcf7-submit,
.widget_search input#searchsubmit,
.format-link .entry-content a.link,
.flickr_badge_wrapper a img:hover,
.flickr_badge_wrapper .flickr-bottom a,
.jetpack_subscription_widget form#subscribe-blog input[type="submit"],
#site-info a.top,
.wp-pagenavi a.page,
.wp-pagenavi a.nextpostslink,
.wp-pagenavi a.previouspostslink,
.wp-pagenavi a.first,
.wp-pagenavi a.last {
	background:<?php echo $link_color; ?>;
}
</style>
<?php
}
add_action( 'wp_head', 'meola_print_link_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Main menu background color.
/* 
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function meola_print_specialbg_color_style() {
	$options = meola_get_theme_options();
	$specialbg_color = $options['specialbg_color'];

	$default_options = meola_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['specialbg_color'] == $specialbg_color )
		return;
?>
<style type="text/css">
#site-nav-wrap,
.widget-area .widget_meola_sociallinks,
.widget-area .widget_meola_about,
.single-post .author-info {
	background:<?php echo $specialbg_color; ?>;
}
</style>
<?php
}
add_action( 'wp_head', 'meola_print_specialbg_color_style' );

