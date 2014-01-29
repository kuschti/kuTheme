<?php
/**
 * @package kuTheme
 */
?>
<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if (gte IE 9) | !(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?php
			wp_title( '&mdash;', true, 'right' );
			bloginfo( 'name' );
		?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="shortcut icon" type="image/ico" href="" />
	<link rel="apple-touch-icon" href="" />

	<script type="text/javascript" src="//use.typekit.net/eua0aki.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<div class="row">
		<div class="columns">

			<header id="header" role="banner" class="row">
				<div id="branding" class="columns large-6">
					<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
				<nav id="main-nav" class="right">
					<ul class="inline-list">
						<li><a href="<?php echo home_url( '/' ); ?>">Blog</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>review">Reviews</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>about">&Uuml;ber mich</a></li>
						<li><a href="<?php echo home_url( '/' ); ?>about/contact">Kontakt</a></li>
					</ul>
				</nav>

			</header>
