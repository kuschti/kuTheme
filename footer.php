 <?php
/**
 * The template for displaying the footer.
 *
 * @package Meola
 * @since Meola 1.0
 */
?>

	<footer id="footer" class="clearfix">

		<div id="site-info">
			<?php
				$options = get_option('meola_theme_options');
				if($options['custom_footertext'] != '' ){
					echo stripslashes($options['custom_footertext']);
			} else { ?>
			<ul class="credit">
				<li>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?></li>
				<li><?php _e('Proudly powered by', 'meola') ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'meola' ) ); ?>" ><?php _e('WordPress', 'meola') ?></a></li>
				<li><?php printf( __( 'Theme: %1$s by %2$s', 'meola' ), 'Meola', '<a href="http://www.elmastudio.de/wordpress-themes/">Elmastudio</a>' ); ?></li>
			</ul><!-- end .credit -->
			<?php } ?>

			<?php if (has_nav_menu( 'optional' ) ) {
				wp_nav_menu( array('theme_location' => 'optional', 'container' => 'nav' , 'container_class' => 'footer-nav', 'depth' => 1 ));} 
			?>
			<a href="#site-nav-wrap" class="top"><?php _e('Top', 'meola') ?></a>
		</div><!-- end #site-info -->

	</footer><!-- end #footer -->

<?php // Includes Twitter, Facebook and Google+ button code if the share post option is active.
	$options = get_option('meola_theme_options');
	if($options['share-singleposts'] or $options['share-posts'] or $options['share-pages']) : ?>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php _e('en_US', 'meola') ?>/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>