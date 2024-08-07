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

<?php get_template_part( 'template-parts/preloader' ); ?>

<div id="page" class="site relative">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'clap' ); ?></a>

	<header id="masthead" class="site-header fixed top-0 container flex items-start justify-between !py-6 z-50 slide-up">
		<div class="site-branding">
			<a href="<?= home_url(); ?>" aria-label="back to hompage" id="header-logo" class="h-10 sm:h-14 w-auto inline-block">
			<?php
				$svg_file = get_template_directory() . '/assets/img/logo.svg';
				if (file_exists($svg_file)) {
					echo file_get_contents($svg_file);
				} else {
					echo '<!-- SVG file not found -->';
				}
			?>
 			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation !mt-0">
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
					'menu_class' => 'text-5xl  font-tele leading-none font-bold text-white flex flex-col gap-y-6 items-center justify-center h-full w-full text-center',
					)); 
					?>
				</div>
			</div>
		</div>