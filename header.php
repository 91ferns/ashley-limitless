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
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,700italic' rel='stylesheet' type='text/css'>

<meta property="og:title"
content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>"/>
<meta property="og:url"
content="<?php echo site_url(); ?>" />
<meta property="og:description" content="After years of perfecting my craft and helping hundreds of people make positive career changes, negotiate raises and promotions and land their dreams jobs, I have A LOT of knowledge and experience to share." />
<meta property="og:image"
content="<?php ashley_limitless_image('og-image.jpg'); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ashley_limitless' ); ?></a>

	<header id="masthead" class="site-header clearfix" role="banner">
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
						<img src="<?php ashley_limitless_image('as-seen-in-left.png'); ?>">
					</div> <!-- /.description -->

					<div class="video-subcontainer">
						<figure style="cursor: pointer;">
							<div id="ashley-video">
								<img src="<?php ashley_limitless_image('video.png'); ?>">
							</div>
						</figure>
					</div> <!-- /.video-container -->

					<div class="description">
						<img src="<?php ashley_limitless_image('as-seen-in-right.png'); ?>">
					</div> <!-- /.description -->

				</div>

			</div> <!-- /.banner -->

		</div> <!-- /.video-container -->

		<div id="introduction">

			<div class="container">

				<div class="half-wrapper">
					<p>There’s nothing worse than…</p>

					<ul class="elipsis">
						<li>pouring your heart and soul into a job application – and getting crickets in reply. </li>

						<li>feeling stuck in networking conversations – knowing the untapped resources that you could use if only you knew HOW.</li>

						<li>losing hope that you’ll ever land that dream job – or make the income you deserve.</li>

					</ul>

					<p class="ashley">If you’ve struggled with these challenges, you’re not alone.</p>

				</div>

			</div> <!-- /.container -->

		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<?php ashley_limitless_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
