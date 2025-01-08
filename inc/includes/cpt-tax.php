<?php
/**
 * A technically WordPress-illegal file of custom post types and
 * custom taxonomies to add to this theme. Make sure to take this
 * with you if you're upgrading the theme in the future.
 *
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;


// Add External Links Post Type

function cpt_mit_external_links() {
	$slug = 'external-links';

	// Modify all the i18ized strings here.
	$labels = [
		'menu_name'          => __( 'External Links', 'shass' ),
		'name'               => _x( 'External Links', 'post type general name', 'shass' ),
		'singular_name'      => _x( 'External Link', 'post type singular name', 'shass' ),
		'name_admin_bar'     => _x( 'External Link', 'add new on admin bar', 'shass' ),
		'add_new'            => _x( 'Add New', 'thing', 'shass' ),
		'add_new_item'       => __( 'Add New External Link', 'shass' ),
		'new_item'           => __( 'New External Link', 'shass' ),
		'edit_item'          => __( 'Edit External Link', 'shass' ),
		'view_item'          => __( 'View External Link', 'shass' ),
		'all_items'          => __( 'All External Links', 'shass' ),
		'search_items'       => __( 'Search External Links', 'shass' ),
		'parent_item_colon'  => __( 'Parent External Links:', 'shass' ),
		'not_found'          => __( 'No External Links found.', 'shass' ),
		'not_found_in_trash' => __( 'No External Links found in Trash.', 'shass' ),
		'featured_image' => __( 'Featured Image', 'shass' ),
		'set_featured_image' => __( 'Set Featured Image', 'shass' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'shass' ),
		'use_featured_image' => __( 'Use as External Link Image', 'shass' ),
		'insert_into_item' => __( 'Insert into External Link', 'shass' ),
		'uploaded_to_this_item' => __( 'Uploaded to this External Link', 'shass' ),
		'items_list' => __( 'External Links list', 'shass' ),
		'items_list_navigation' => __( 'External Links list navigation', 'shass' ),
		'filter_items_list' => __( 'Filter External Links list', 'shass' ),
	];

	// Definition of the post type arguments. For full list see:
	// https://developer.wordpress.org/reference/functions/register_post_type/
	$args = [
		'labels'              => $labels,
		'description'         => '',
		'menu_icon'           => 'dashicons-welcome-view-site',
		'public'              => true,
		'publicly_queryable' 	=> true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'supports'            => [ 'title', 'thumbnail', 'excerpt', 'revisions' ],
		'taxonomies'          => [ 'mit_updates_cat' ],
	];

	register_post_type( $slug, $args );
}
add_action( 'init', __NAMESPACE__ . '\cpt_mit_external_links', 0 );


// Add People Post Type

function cpt_mit_people() {
	$slug = 'people';

	// Modify all the i18ized strings here.
	$labels = [
		'menu_name'          => __( 'People', 'shass' ),
		'name'               => _x( 'People', 'post type general name', 'shass' ),
		'singular_name'      => _x( 'Person', 'post type singular name', 'shass' ),
		'name_admin_bar'     => _x( 'People', 'add new on admin bar', 'shass' ),
		'add_new'            => _x( 'Add New', 'thing', 'shass' ),
		'add_new_item'       => __( 'Add New Person', 'shass' ),
		'new_item'           => __( 'New Person', 'shass' ),
		'edit_item'          => __( 'Edit Person', 'shass' ),
		'view_item'          => __( 'View Person', 'shass' ),
		'all_items'          => __( 'All People', 'shass' ),
		'search_items'       => __( 'Search People', 'shass' ),
		'parent_item_colon'  => __( 'Parent People:', 'shass' ),
		'not_found'          => __( 'No people found.', 'shass' ),
		'not_found_in_trash' => __( 'No people found in Trash.', 'shass' ),
		'featured_image' => __( 'Featured Image', 'shass' ),
		'set_featured_image' => __( 'Set Featured Image', 'shass' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'shass' ),
		'use_featured_image' => __( 'Use as Person\'s Image', 'shass' ),
		'insert_into_item' => __( 'Insert into Person', 'shass' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Person', 'shass' ),
		'items_list' => __( 'People list', 'shass' ),
		'items_list_navigation' => __( 'People list navigation', 'shass' ),
		'filter_items_list' => __( 'Filter People list', 'shass' ),
	];

	// Definition of the post type arguments. For full list see:
	// https://developer.wordpress.org/reference/functions/register_post_type/
	$args = [
		'labels'              => $labels,
		'description'         => '',
		'menu_icon'           => 'dashicons-groups',
		'public'              => true,
		'publicly_queryable' 	=> true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
		'taxonomies'          => [ 'mit_updates_cat' ],
	];

	register_post_type( $slug, $args );
}
add_action( 'init', __NAMESPACE__ . '\cpt_mit_people', 0 );


// Add Newsletters Post Type

function cpt_mit_newsletters() {
	$slug = 'newsletters';

	// Modify all the i18ized strings here.
	$labels = [
		'menu_name'          => __( 'Newsletters', 'shass' ),
		'name'               => _x( 'Newsletters', 'post type general name', 'shass' ),
		'singular_name'      => _x( 'Newsletter', 'post type singular name', 'shass' ),
		'name_admin_bar'     => _x( 'Newsletters', 'add new on admin bar', 'shass' ),
		'add_new'            => _x( 'Add New', 'thing', 'shass' ),
		'add_new_item'       => __( 'Add New Newsletter', 'shass' ),
		'new_item'           => __( 'New Newsletter', 'shass' ),
		'edit_item'          => __( 'Edit Newsletter', 'shass' ),
		'view_item'          => __( 'View Newsletter', 'shass' ),
		'all_items'          => __( 'All Newsletters', 'shass' ),
		'search_items'       => __( 'Search Newsletters', 'shass' ),
		'parent_item_colon'  => __( 'Parent Newsletters:', 'shass' ),
		'not_found'          => __( 'No Newsletters found.', 'shass' ),
		'not_found_in_trash' => __( 'No Newsletters found in Trash.', 'shass' ),
		'featured_image' => __( 'Featured Image', 'shass' ),
		'set_featured_image' => __( 'Set Featured Image', 'shass' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'shass' ),
		'use_featured_image' => __( 'Use as Newsletter\'s Image', 'shass' ),
		'insert_into_item' => __( 'Insert into Newsletter', 'shass' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Newsletter', 'shass' ),
		'items_list' => __( 'Newsletters list', 'shass' ),
		'items_list_navigation' => __( 'Newsletters list navigation', 'shass' ),
		'filter_items_list' => __( 'Filter Newsletters list', 'shass' ),
	];

	// Definition of the post type arguments. For full list see:
	// https://developer.wordpress.org/reference/functions/register_post_type/
	$args = [
		'labels'              => $labels,
		'description'         => '',
		'menu_icon'           => 'dashicons-groups',
		'public'              => true,
		'publicly_queryable' 	=> true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'supports'            => [ 'title', 'excerpt', 'thumbnail', 'revisions' ],
	];

	register_post_type( $slug, $args );
}
add_action( 'init', __NAMESPACE__ . '\cpt_mit_newsletters', 0 );


// Add People Taxonomies

function tax_mit_people_category() {
	$slug = 'people-categories';
	// Post types in which the taxonomy should be registered
	$post_types = ['people'];

  // Taxonomy Labels
	$labels = [
		'name'                  => _x( 'Categories', 'Taxonomy plural name', 'shass' ),
		'singular_name'         => _x( 'Category', 'Taxonomy singular name', 'shass' ),
		'search_items'          => __( 'Search Categories (People)', 'shass' ),
		'popular_items'         => __( 'Popular Categories (People)', 'shass' ),
		'all_items'             => __( 'All Categories', 'shass' ),
		'parent_item'           => __( 'Parent Category', 'shass' ),
		'parent_item_colon'     => __( 'Parent Category', 'shass' ),
		'edit_item'             => __( 'Edit Category (People)', 'shass' ),
		'update_item'           => __( 'Update Category (People)', 'shass' ),
		'add_new_item'          => __( 'Add New Category (People)', 'shass' ),
		'new_item_name'         => __( 'New Category', 'shass' ),
		'add_or_remove_items'   => __( 'Add or remove category', 'shass' ),
		'choose_from_most_used' => __( 'Choose from most used categories', 'shass' ),
		'menu_name'             => __( 'Categories', 'shass' ),
	];

	// Taxonomy Arguments
	// https://developer.wordpress.org/reference/functions/register_taxonomy/
	$args = [
		'labels'            => $labels,
		'description'       => 'Categories for People.',
		'public'            => true,
		'show_in_nav_menus' => false,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_tagcloud'     => false,
		'show_ui'           => true,
		'show_in_rest'		=> true,
		'query_var'         => false,
		'rewrite'           => [
			'slug' => $slug,
		],
	];

  register_taxonomy( $slug, $post_types, $args );
}
add_action( 'init', __NAMESPACE__ . '\tax_mit_people_category', 0 );


// Add Ext Link Taxonomies

function tax_mit_ext_link_cat() {
	$slug = 'extlink-categories';
	// Post types in which the taxonomy should be registered
	$post_types = ['external-links'];

  // Taxonomy Labels
	$labels = [
		'name'                  => _x( 'Categories', 'Taxonomy plural name', 'shass' ),
		'singular_name'         => _x( 'Category', 'Taxonomy singular name', 'shass' ),
		'search_items'          => __( 'Search Categories (External Links)', 'shass' ),
		'popular_items'         => __( 'Popular Categories (External Links)', 'shass' ),
		'all_items'             => __( 'All Categories', 'shass' ),
		'parent_item'           => __( 'Parent Category', 'shass' ),
		'parent_item_colon'     => __( 'Parent Category', 'shass' ),
		'edit_item'             => __( 'Edit Category (External Links)', 'shass' ),
		'update_item'           => __( 'Update Category (External Links)', 'shass' ),
		'add_new_item'          => __( 'Add New Category (External Links)', 'shass' ),
		'new_item_name'         => __( 'New Category', 'shass' ),
		'add_or_remove_items'   => __( 'Add or remove Category', 'shass' ),
		'choose_from_most_used' => __( 'Choose from most used Categories', 'shass' ),
		'menu_name'             => __( 'Categories', 'shass' ),
	];

	// Taxonomy Arguments
	// https://developer.wordpress.org/reference/functions/register_taxonomy/
	$args = [
		'labels'            => $labels,
		'description'       => 'Categories for External Links.',
		'public'            => true,
		'show_in_nav_menus' => false,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_tagcloud'     => false,
		'show_ui'           => true,
		'show_in_rest'			=> true,
		'query_var'         => false,
		'rewrite'           => [
			'slug' => $slug,
		],
	];

  register_taxonomy( $slug, $post_types, $args );
}
add_action( 'init', __NAMESPACE__ . '\tax_mit_ext_link_cat', 0 );
