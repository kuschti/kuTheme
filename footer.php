<?php
/**
 * @package kuTheme
 */
?>
			<footer id="footer" role="contentinfo" class="row">

				<div id="site-info" class="columns large-4">
					<small>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?></small>
				</div>
				<nav id="footer-nav" class="columns large-8">
					<ul class="inline-list">
						<li><a href="<?php echo home_url( '/' ); ?>type/image/">Bilder</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/gallery/">Gallerie</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/video/">Videos</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/link/">Links</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/aside/">Kurzmitteilungen</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/quote/">Zitate</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>type/status/">Status</a></li>
					</ul>
				</nav>
			</footer>

		</div>
	</div>

	<?php wp_footer(); ?>
	<?php
		if ( function_exists( 'yoast_analytics' ) ) {
  		yoast_analytics();
		}
	?>
	<?php
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	?>

</body>
</html>
