<?php
/**
 * @package kuTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<header class="post-header text-center">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="post-content clearfix">
		<?php the_content(); ?>
	</div>

	<footer class="post-meta">
	</footer>

</article>
