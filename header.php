<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package limitless-career
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ashley_limitless' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="top-banner">
			AWARD-WINNING CAREER COACH <span class="ashley">ASHLEY STAHL</span> PRESENTS
		</div>
		<div class="site-branding">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php ashley_limitless_image('logo.png'); ?>" alt="bloginfo( 'name' );">
					</a>
				</h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
			<p class="site-description"><?php ashley_limitless_bloginfo(); ?></p>
		</div><!-- .site-branding -->

		<div class="video-container clearfix">

			<div class="banner">

				<div class="container">

					<div class="description">

					</div> <!-- /.description -->

					<div class="video-subcontainer">

					</div> <!-- /.video-container -->

					<div class="description">

					</div> <!-- /.description -->

				</div>

			</div>

		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ashley_limitless' ); ?></button>
			<?php ashley_limitless_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
