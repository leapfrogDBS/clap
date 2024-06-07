<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package clap
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'clap' ); ?></a>

	<header id="masthead" class="site-header fixed top-0 z-20 container flex items-center justify-between py-6 z-50">
		<div class="site-branding">
			<a href="<?= home_url(); ?>" aria-label="back to hompage">
				<img src="<?= get_template_directory_uri(); ?>/assets/img/logo.svg" class="h-14 w-auto" alt="website logo"/>
			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div id="hamburger" data-navtoggle class="z-50 cursor-pointer">
				<svg viewBox="0 0 100 80" width="40" height="40">
					<rect id="top-line" width="100" height="12" fill="white"></rect>
					<rect id="middle-line"  x="25" y="30" width="75" height="12" fill="white"></rect>
					<rect id="bottom-line" x="45" y="60" width="55" height="12" fill="white"></rect>
				</svg>
			</div>
		</nav><!-- #site-navigation -->



	</header><!-- #masthead -->




	<div id="curtain-menu" class="curtain-menu invisible fixed inset-0 z-40 opacity-0 transition-[opacity,visibility] duration-300">
			<div class="curtain-menu-content absolute top-0 right-0 h-full w-full bg-black text-white grid place-items-center transition-transform duration-300 ease-in-out translate-x-full">
				<div>
					<?php
					// Get the main WordPress menu
					wp_nav_menu(array(
					'theme_location' => 'header-menu',
					'menu_id'        => 'header-menu',
					'menu_class' => 'text-lg leading-none font-bold text-white flex flex-col gap-y-4 items-center justify-center h-full w-full text-center',
					)); 
					?>
				</div>
			</div>
		</div>