<?php
/**
 * clap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package clap
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function clap_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on clap, use a find and replace
		* to change 'clap' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'clap', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'clap' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'clap_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'clap_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function clap_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'clap_content_width', 640 );
}
add_action( 'after_setup_theme', 'clap_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function clap_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'clap' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'clap' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'clap_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function clap_scripts() {
    wp_enqueue_style('clap-style', get_template_directory_uri() . '/style.css', '', _S_VERSION);
    wp_enqueue_script('clap-app-js', get_template_directory_uri() . '/scripts/site/app.min.js', array(), _S_VERSION, true);

    // Gsap Files
    wp_enqueue_script('gsap-js', get_template_directory_uri() . '/scripts/lib/gsap.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('scrollTrigger-js', get_template_directory_uri() . '/scripts/lib/ScrollTrigger.min.js', array('gsap-js'), _S_VERSION, true);
    wp_enqueue_script('gsap-config-js', get_template_directory_uri() . '/scripts/site/gsap-config.min.js', array('gsap-js', 'scrollTrigger-js'), _S_VERSION, true);

    // Like functionality
    wp_enqueue_script('like-script', get_template_directory_uri() . '/scripts/site/like.min.js', array('jquery'), null, true);
    wp_localize_script('like-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('like_post_nonce')
    ));

    // Fullpage js
    wp_enqueue_style('fullpage-css', get_template_directory_uri() . '/assets/css/fullpage.css', '', _S_VERSION);
    wp_enqueue_script('fullpage-js', get_template_directory_uri() . '/scripts/lib/fullpage.min.js', array(), _S_VERSION, true);


    // Retrieve ACF fields
    $map_zoom_level = get_field('map_zoom_level', 'option');
    $map_latitude = get_field('map_latitude', 'option');
    $map_longitude = get_field('map_longitude', 'option');
    $map_icon = get_field('map_icon', 'option');
    $google_maps_api_key = get_field('google_maps_api_key', 'option');

    // Google Maps API
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key . '&callback=initMap', array(), null, true);

    // Custom Maps JS
    wp_enqueue_script('custom-maps', get_template_directory_uri() . '/scripts/site/custom-maps.min.js', array('google-maps'), null, true);

	  // Localize the script with the ACF field values
	  $localization_array = array(
        'zoomLevel' => $map_zoom_level,
        'latitude' => $map_latitude,
        'longitude' => $map_longitude,
        'mapIcon' => $map_icon['url'], // Assuming the ACF field returns an array with URL
        'googleMapsApiKey' => $google_maps_api_key,
        'templateDirectoryUri' => get_template_directory_uri()
    );
    wp_localize_script('custom-maps', 'wpVars', $localization_array);
}
add_action('wp_enqueue_scripts', 'clap_scripts');

// Add async and defer attributes to the Google Maps API script
function add_async_defer_attributes($tag, $handle) {
    if ('google-maps' === $handle) {
        return str_replace(' src', ' async defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_async_defer_attributes', 10, 2);



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



// ADD ACF OPTIONS PAGE
if( function_exists('acf_set_options_page_title') )
{
    acf_add_options_page('Theme Options');
	acf_add_options_page('Map Options');
}


/**
 * Allow svgs
 */
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  
  add_filter('upload_mimes', 'cc_mime_types');


  /**
 * ACF fields
 */
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    

    // update path
    $path = ABSPATH . '../develop/acf-json';

    // return
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);
    
    
    // append path
    $paths[] = ABSPATH . '../develop/acf-json';
    $paths[] = get_template_directory() . '/acf-json';
    
    
    // return
    return $paths;
    
}

/* Make styles available in the block editor */
function mytheme_enqueue_block_editor_assets() {
	wp_enqueue_style('barkbites-block-editor-style', get_template_directory_uri() . '/style.css', '', _S_VERSION);
}
add_action( 'enqueue_block_editor_assets', 'mytheme_enqueue_block_editor_assets' );

/**
 * Register ACF Blocks
 */
function mytheme_register_all_blocks() {
    $block_directories = glob(get_template_directory() . "/blocks/*", GLOB_ONLYDIR);

    foreach ($block_directories as $block) {
        register_block_type($block);
    }
}
add_action('init', 'mytheme_register_all_blocks');


// Register Custom Post Type Projects
function register_projects_post_type() {

    $labels = array(
        'name'                  => _x( 'Projects', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'textdomain' ),
        'menu_name'             => __( 'Projects', 'textdomain' ),
        'name_admin_bar'        => __( 'Project', 'textdomain' ),
        'archives'              => __( 'Project Archives', 'textdomain' ),
        'attributes'            => __( 'Project Attributes', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Project:', 'textdomain' ),
        'all_items'             => __( 'All Projects', 'textdomain' ),
        'add_new_item'          => __( 'Add New Project', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'new_item'              => __( 'New Project', 'textdomain' ),
        'edit_item'             => __( 'Edit Project', 'textdomain' ),
        'update_item'           => __( 'Update Project', 'textdomain' ),
        'view_item'             => __( 'View Project', 'textdomain' ),
        'view_items'            => __( 'View Projects', 'textdomain' ),
        'search_items'          => __( 'Search Project', 'textdomain' ),
        'not_found'             => __( 'Not found', 'textdomain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'textdomain' ),
        'featured_image'        => __( 'Featured Image', 'textdomain' ),
        'set_featured_image'    => __( 'Set featured image', 'textdomain' ),
        'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
        'use_featured_image'    => __( 'Use as featured image', 'textdomain' ),
        'insert_into_item'      => __( 'Insert into project', 'textdomain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this project', 'textdomain' ),
        'items_list'            => __( 'Projects list', 'textdomain' ),
        'items_list_navigation' => __( 'Projects list navigation', 'textdomain' ),
        'filter_items_list'     => __( 'Filter projects list', 'textdomain' ),
    );
    $args = array(
        'label'                 => __( 'Project', 'textdomain' ),
        'description'           => __( 'A custom post type for projects', 'textdomain' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ), // Only title is supported
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
		'menu_icon'             => 'dashicons-video-alt2',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable block editor support
    );
    register_post_type( 'project', $args );

}
add_action( 'init', 'register_projects_post_type', 0 );


// Handle liking a post
function handle_like_post() {
    check_ajax_referer('like_post_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $likes = get_field('number_of_likes', $post_id);
    $likes = $likes ? $likes + 1 : 1;
    update_field('number_of_likes', $likes, $post_id);

    wp_send_json_success(array('new_likes' => $likes));
}
add_action('wp_ajax_like_post', 'handle_like_post');
add_action('wp_ajax_nopriv_like_post', 'handle_like_post');

// Handle unliking a post
function handle_unlike_post() {
    check_ajax_referer('like_post_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $likes = get_field('number_of_likes', $post_id);
    $likes = $likes ? $likes - 1 : 0;
    if ($likes < 0) $likes = 0; // Ensure likes don't go negative
    update_field('number_of_likes', $likes, $post_id);

    wp_send_json_success(array('new_likes' => $likes));
}
add_action('wp_ajax_unlike_post', 'handle_unlike_post');
add_action('wp_ajax_nopriv_unlike_post', 'handle_unlike_post');



/* Register Menus */
function clap_register_nav_menus() {
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu', 'clap'), // 'header-menu' is the location slug, and 'Header Menu' is the description.
            'footer-menu' => __('Footer Menu', 'clap')  // Register multiple menus by adding more key-value pairs.
        )
    );
}
add_action('init', 'clap_register_nav_menus');


