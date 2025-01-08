<?php
/**
 * Theme Functions
 * Gather all the functions and definitions together in one easy to locate file.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package shass
 */

namespace SHASS;

use GFFormDisplay;

/**
 * The current version of the theme.
 */
if (!defined('SHASS_VERSION')) {
	// Replace the version number of the theme on each release
	define('SHASS_VERSION', '1.0');
}


if(! defined( 'SHASS_THEME_DIR_PATH' ) ) {
	define('SHASS_THEME_DIR_PATH', untrailingslashit( get_template_directory() ));
}

// We stand on the shoulders of giants.

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists( 'theme_setup' ) ) :
function theme_setup() {

	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		*/
	load_theme_textdomain( 'shass', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 9999, 9999 );

	// Support for more image sizes
	add_image_size( 'query-square', 524, 524, true );
	add_image_size( 'block-bg', 1600, 900, true);
	add_image_size( 'sidebar-thumb', 636, 440, true );

	// This theme uses wp_nav_menu() in three locations
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Nav', 'shass' ),
			'secondary' => esc_html__( 'Secondary Nav', 'shass' ),
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

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );
	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
	// Add support for block styles
	add_theme_support( 'wp-block-styles' );
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	//	add_editor_style( 'tinymce.css' );
	// Add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Primary', 'shass' ),
				'slug'  => 'primary',
				'color' => '#ED009B',
			),
			array(
				'name'  => __( 'Secondary', 'shass' ),
				'slug'  => 'secondary',
				'color' => '#000',
			),
			array(
				'name'  => __( 'Gray', 'shass' ),
				'slug'  => 'gray',
				'color' => '#dddDDD',
			),
			array(
				'name'  => __( 'Dark Gray', 'shass' ),
				'slug'  => 'dark-gray',
				'color' => '#595858',
			),
			array(
				'name'  => __( 'Medium Gray', 'shass' ),
				'slug'  => 'medium-gray',
				'color' => '#ADADAD',
			),
			array(
				'name'  => __( 'White', 'shass' ),
				'slug'  => 'white',
				'color' => '#FFF',
			),
			array(
				'name'  => __( 'Text Magenta', 'shass' ),
				'slug'  => 'text-magenta',
				'color' => '#E10093',
			),
		)
	);

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
			'header-text' => false
		)
	);
}
endif;
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );

// Trim down Gutenberg blocks to only what's needed
function allowed_block_types( $allowed_blocks ) {
  return array(
		// We are whitelisting the following:
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/quote',
		'core/image',
		'core/gallery',
		'core/video',
		'core/table',
		'core/code',
		'core/freeform',
		'core/html',
		'core/preformatted',
		'core/pullquote',
		'core/text-columns',
		'core/media-text',
		'core/more',
		'core/separator',
		'core/spacer',
		'core/shortcode',
		'core/rss',
		'core/search',
		'core/embed',
		'core-embed/twitter',
		'core-embed/youtube',
		'core-embed/facebook',
		'core-embed/instagram',
		'core-embed/flickr',
		'core-embed/vimeo',
		'core-embed/scribd',
		'core-embed/slideshare',
		'gravityforms/form',


		// additional blocks here

		'shass/accordion-2col',
		'shass/blocks.php',
		'shass/columns',
		'shass/content-rows-w-sidebars',
		'shass/content-rows-evens',
		'shass/events-selector',
		'shass/faq-accordion',
		'shass/featured-content-w-sidebar',
		'shass/featured-spotlights',
		'shass/home-tabs',
		'shass/jump-links',
		'shass/link-list',
		'shass/mosaic-hero',
		'shass/multi-step-form',
		'shass/nested-list',
		'shass/news-overview',
		'shass/news-block',
		'shass/newsletter-overview',
		'shass/newsletter-signup',
		'shass/numbers-list',
		'shass/page-header',
		'shass/post-cards-w-pagination',
		'shass/post-carousel',
		'shass/quote-block',
		'shass/row-title-content',
		'shass/spotlight-alternator',
		'shass/stats-4up',
		'shass/team-overview',
		'shass/timeline',
		'shass/video',

  );
}
add_filter( 'allowed_block_types_all', __NAMESPACE__ . '\allowed_block_types' );

/**
 * Enqueue scripts and styles.
 */
function enqueue_styles_and_scripts() {
	// Styles
	wp_enqueue_style( 'typekit-fonts', 'https://use.typekit.net/ryk0kfm.css', array(), SHASS_VERSION );
	//  wp_enqueue_style( 'shass-style', get_stylesheet_directory_uri() . '/global.min.css', array(), SHASS_VERSION );
	wp_enqueue_style( 'shass-style', get_stylesheet_directory_uri() . '/assets/css/main.min.css', array(), (rand(1,1000)/1000) );
	wp_style_add_data( 'shass-style', 'rtl', 'replace' );

	// Scripts
	wp_enqueue_script( 'shass-js', get_template_directory_uri() . '/assets/js/scripts.min.js', array(), (rand(1,1000)/1000), true );

	/*
	wp_register_script( 'shass-ajax', '',);
	wp_enqueue_script( 'shass-ajax' );
	wp_add_inline_script( 'shass-ajax', 'const frontend_ajax_object = ' . json_encode( array(
			'adminAJAXURL' => admin_url( 'admin-ajax.php' ),
			'nonce' =>  wp_create_nonce( 'updates_ajax' ),
	) ), 'before' ); */
} // not yet...
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles_and_scripts' );

function custom_admin_styles() {
	wp_enqueue_style( 'typekit-fonts', 'https://use.typekit.net/ryk0kfm.css', array(), SHASS_VERSION );

	wp_register_style( 'mit_ir_wp_admin_css', get_template_directory_uri() . '/admin.css', false, SHASS_VERSION );
	wp_enqueue_style( 'mit_ir_wp_admin_css' );
} // not yet...
// add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\custom_admin_styles' );

function dequeue_styles_and_scripts() {
	// Remove Styles
	//wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'relevanssi-live-search' );
} // not yet...
// add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\dequeue_styles_and_scripts', 11 );


 /**
 * ALL OTHER THEME FUNCTIONALITY MUST BE BROKEN OUT INTO OTHER FILES
 * ADD A COMMENT TO EXPLAIN WHAT IT IS OR WHY IT EXISTS FOR FUTURE JOEY
 *
 * "Teddy Roosevelt gave an entire speech once with a bullet lodged in his chest.
 *  Some things are a matter of duty." - Corrado John Soprano, Jr.
 *
 * THEME FUNCTIONALITY INCLUDES AS FOLLOWS:
 */

foreach([

	// Include master file of custom fixes and upgrades and minor, non-specific fixes,
	// like adding a login logo or accessibility fixes
	'/inc/includes.php',

	// Nav Walkers for Main Menu and Social Menus
	// For Added Functionality/Accessibility
	// '/inc/includes/nav-walker.php',

	// NON-BLOCK Advanced Custom Fields Code
	// For Settings, Etc.
	// '/inc/includes/acf.php'
] as $file) {
	require get_theme_file_path($file);
}

/**
 * Custom Gutenberg blocks for the theme
 * from Advanced Custom Fields
 */
require get_template_directory() . '/blocks/blocks.php';


add_filter( 'gform_progress_steps_1', function( $progress_bar, $form, $confirmation_message ) {

		$current_page = GFFormDisplay::get_current_page( $form['id'] );

    $progress_bar = '<div class="multi-step-form--indicator active-step-'.$current_page.'">
        <span>Step 1</span>
        <span>Step 2</span>
        <span>Step 3</span>
    </div>';

    return $progress_bar;

}, 10, 3 );

add_filter( 'gform_required_legend', function( $legend, $form ) {
    return '';
}, 10, 2 );


