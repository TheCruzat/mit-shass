<?php
/**
 * Custom "non-specific" fixes for our theme
 * This is essentially the junk drawer file - good luck
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

// Hide WP Admin bar for non-admins
function remove_admin_bar() {
	if ( !current_user_can( 'manage_options' ) && !is_admin() ) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', __NAMESPACE__ . '\remove_admin_bar');

// Disable anything author related
add_action( 'template_redirect',
	function() {
		if ( isset( $_GET['author'] ) || is_author() ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
		}
	}, 1 );
/* Remove author links. */
add_filter( 'user_row_actions',
	function( $actions ) {
		if ( isset( $actions['view'] ) )
			unset( $actions['view'] );
		return $actions;
	}, PHP_INT_MAX, 2 );
add_filter( 'author_link', function() { return '#'; }, PHP_INT_MAX );
add_filter( 'the_author_posts_link', '__return_empty_string', PHP_INT_MAX );

// Any resource that has an active external link doesn't get a unique site URL
function deregister_external_resources() {
	if ( is_singular( 'mit_resources' ) ) {
		// Check external_link
		$this_resource_id = get_the_ID();
		$this_resource_external_url = \get_field( 'external_url', $this_resource_id );

		if( $this_resource_external_url != null && strlen( $this_resource_external_url ) > 0 ) {
			wp_redirect( get_permalink( get_page_by_path( 'resources' ) ), 301 );
			exit;
		}
	}
}
add_filter( 'template_redirect', __NAMESPACE__ . '\deregister_external_resources' );

// Nuke GF scripts from orbit if search page, to fix highlighting
add_filter( 'gform_footer_init_scripts_filter', __NAMESPACE__ . '\filter_footer', 10, 3 );
function filter_footer( $form_string, $form, $current_page ){
	if( is_search() ) {
		return false;
	} else {
		return $form_string;
	}
}

// Send non-provost staff back to home page after login
function login_redirect_nonstaff( $url, $query, $user ) {
	$allowed_roles = array( 'editor', 'administrator', 'author', 'contributor' );

	if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
		if( array_intersect( $allowed_roles, $user->roles ) ) {
			return esc_url( admin_url() );
		} else {
			if(	$url == admin_url() ) {
				return esc_url( home_url() );
			}
		}
	}
	return esc_url( $url );
}
add_filter('login_redirect', __NAMESPACE__ . '\login_redirect_nonstaff', 10, 3);

// Add a class to the body to hide direct > p after submission
function gf_hide_after_submission( $entry, $form ) {
	add_filter( 'body_class', function( $classes ) {
	    return array_merge( $classes, array( 'form-submitted' ) );
	} );
}
add_action( 'gform_after_submission', __NAMESPACE__ . '\gf_hide_after_submission', 10, 2 );

// Hide Requests in search from logged out users in global search
// https://stackoverflow.com/questions/39836785/stop-wordpress-search-showing-a-custom-post-type
function hide_requests_from_some_search_results($query){
	/* check is front end main loop content */
	if( is_admin() || !$query->is_main_query() ) return;

	/* check is search result query */
	if( $query->is_search() && !is_user_logged_in() ) {
			$post_type_to_remove = 'mit_requests';
			/* get all searchable post types */
			$searchable_post_types = get_post_types(array('exclude_from_search' => false));

			/* make sure you got the proper results, and that your post type is in the results */
			if(is_array($searchable_post_types) && in_array($post_type_to_remove, $searchable_post_types)){
					/* remove the post type from the array */
					unset( $searchable_post_types[ $post_type_to_remove ] );
					/* set the query to the remaining searchable post types */
					$query->set('post_type', $searchable_post_types);
			}
	} else if( $query->is_search() && !current_user_can( 'view_requests' ) ) {
			$post_type_to_remove = 'mit_requests';
			/* get all searchable post types */
			$searchable_post_types = get_post_types(array('exclude_from_search' => false));

			/* make sure you got the proper results, and that your post type is in the results */
			if(is_array($searchable_post_types) && in_array($post_type_to_remove, $searchable_post_types)){
					/* remove the post type from the array */
					unset( $searchable_post_types[ $post_type_to_remove ] );
					/* set the query to the remaining searchable post types */
					$query->set('post_type', $searchable_post_types);
			}
	}
}
add_action('pre_get_posts', __NAMESPACE__ . '\hide_requests_from_some_search_results');

// Remove dash widgets outside of purview
function remove_dashboard_meta() {
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
}
add_action('admin_init', __NAMESPACE__ . '\remove_dashboard_meta');

// Add new dashboard widgets
function add_dashboard_widgets() {
	$user = wp_get_current_user();
	$allowed_roles = array( 'editor', 'administrator', 'author' );

	if( array_intersect( $allowed_roles, $user->roles ) ) {
		add_meta_box( 'dashboard_media_rss', 'MIT News - Provost In The Media', __NAMESPACE__ . '\add_media_rss_widget', 'dashboard', 'side' );
		add_meta_box( 'dashboard_provost_rss', 'MIT News - Provost Tag', __NAMESPACE__ . '\add_provost_rss_widget', 'dashboard', 'side' );
		add_meta_box( 'dashboard_help', 'Quick Actions Menu', __NAMESPACE__ . '\add_help_widget', 'dashboard', 'side', 'high' );
	}
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\add_dashboard_widgets' );

function add_media_rss_widget() {
	$rss_feed_url = esc_url( 'https://news.mit.edu/rss-in-the-media/topic/provost' );

	echo '<div class="mit-rss rss-in-the-media">'; // Open up
	$xml = simplexml_load_file($rss_feed_url);

	$feed_count = 1;
	$feed_max = 4;

	echo '<ul class="rss-feed">';
	foreach($xml->channel->item as $rss_item) {
		if( $feed_count <= $feed_max ) {
			echo '<li class="rss-item">';
			echo '<a href="'.$rss_item->link.'"><h3 class="rss-title">'. wp_kses_post( $rss_item->title ) .'</h3></a>';
			echo '<p class="rss-text">'.wp_kses_post( $rss_item->description ).'</p>';
			echo '<span class="rss-date">Publication Date: '. wp_kses_post( $rss_item->pubDate ).'</span>';
			echo '<a href="'.esc_url( $rss_item->link ).'" class="rss-link">Link</a>';
			echo '</li>';
			$feed_count++;
		} else {
			break;
		}
	}
	echo '</ul>';

	echo '</div>'; // Close it up
}

function add_help_widget() {
	$pages_url = admin_url( 'edit.php?post_type=page' );
	$update_url = admin_url( 'post-new.php?post_type=mit_updates' );
	$resource_url = admin_url( 'post-new.php?post_type=mit_resources' );
	$update_url = admin_url( 'post-new.php?post_type=mit_updates' );
	$person_url = admin_url( 'post-new.php?post_type=mit_people' );

	$requests_url = admin_url('edit.php?post_type=mit_requests');
	$forms_url = admin_url( 'admin.php?page=gf_edit_forms' );
	$search_url = admin_url('admin.php?page=acf-options-search-settings');
	$footer_url = admin_url( 'admin.php?page=acf-options-footer' );

	$menus_url = admin_url( 'nav-menus.php' );
	$sa_url = admin_url( 'index.php?page=relevanssi%2Frelevanssi.php' );
	$help_url = admin_url( 'admin.php?page=centric-park-help-docs' );

	// Admin buttons should be Manage Pages, Add Update, Add Resource, Add Person,
	// Manage Requests, Manage Forms, Popular Search Terms, Edit Footer, and finally, Get Help
?>
	<div class="mit-buttons">
		<a href="<?php echo esc_url( $pages_url ); ?>" class="button button-primary mit-help-button">Manage Pages</a>
		<a href="<?php echo esc_url( $update_url ); ?>" class="button button-primary mit-help-button alt-color">Add Update</a>
		<a href="<?php echo esc_url( $resource_url ); ?>" class="button button-primary mit-help-button">Add Resource</a>
		<a href="<?php echo esc_url( $person_url ); ?>" class="button button-primary mit-help-button alt-color">Add Person</a>

		<a href="<?php echo esc_url( $requests_url ); ?>" class="button button-primary mit-help-button">Manage Requests</a>
		<a href="<?php echo esc_url( $forms_url ); ?>" class="button button-primary mit-help-button alt-color">Manage Forms</a>
		<a href="<?php echo esc_url( $footer_url ); ?>" class="button button-primary mit-help-button">Edit Footer</a>
		<a href="<?php echo esc_url( $search_url ); ?>" class="button button-primary mit-help-button alt-color">Popular Search Terms</a>

		<a href="<?php echo esc_url( $sa_url ); ?>" class="button button-primary mit-help-button solo-button">Search Analytics</a>
		<a href="<?php echo esc_url( $menus_url ); ?>" class="button button-primary mit-help-button alt-color solo-button">Manage Menus</a>
		<a href="<?php echo esc_url( $help_url ); ?>" class="button button-primary mit-help-button help-color solo-button">Go to Help Docs</a>
	</div>

<?php }

// Remove old jQuery video for HTML5
function deregister_media_elements(){
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );
	wp_deregister_script('mediaelement');
	wp_deregister_style('mediaelement');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\deregister_media_elements');

// https://wordpress.stackexchange.com/questions/7090/stop-wordpress-wrapping-images-in-a-p-tag
// Thank you, Fublo Ltd
function filter_ptags_on_images($content) {
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', __NAMESPACE__ . '\filter_ptags_on_images');


// Rewrites people permalinks correctly
function adjust_people_permalinks( $permalink, $post ){
    $post_type = get_post_type($post);
    if( $post_type === 'mit_people' ) {
			$permalink = esc_url( get_permalink( get_page_by_path( 'people' ) ) );
			$permalink .= '#' . get_post_field( 'post_name',  $post->ID ); // append slug to URL
    }
    return $permalink;
}
add_filter( 'post_type_link', __NAMESPACE__ . '\adjust_people_permalinks', 10, 2 );


// Remove placeholders from search results
add_filter( 'relevanssi_do_not_index', __NAMESPACE__ . '\rlv_no_placeholders', 10, 2 );
function rlv_no_placeholders( $block, $post_id ) {
	$id_post_type = get_post_type( $post_id );
  $is_placeholder = \get_field( 'placeholder', $post_id );
  if ( $id_post_type === 'mit_people' && $is_placeholder ) {
    $block = 'No placeholders, plz.';
  }
  return $block;
}


function custom_logo_id_fix() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$html = sprintf( '<a href="%1$s" id="site_logo_link" class="custom-logo-link" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'site-logo',
            ) )
        );
	return $html;
}
add_filter( 'get_custom_logo', __NAMESPACE__ . '\custom_logo_id_fix' );

// I'm going to cheat this, because I am tired
add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\special_nav_class', 10, 3 );
function special_nav_class( $classes, $menu_item, $args ) {
    if ( 'primary' === $args->theme_location ) {
			if ( get_post_type( get_the_ID() ) == 'mit_requests' ) {
				if( strtolower( $menu_item->title ) == 'requests' ) {
					$classes[] = 'current-page-ancestor';
				}
			}
			if ( get_post_type( get_the_ID() ) == 'mit_resources' ) {
				if( strtolower( $menu_item->title ) == 'resources' ) {
					$classes[] = 'current-page-ancestor';
				}
			}
			if ( get_post_type( get_the_ID() ) == 'mit_people' ) {
				if( strtolower( $menu_item->title ) == 'people' ) {
					$classes[] = 'current-page-ancestor';
				}
			}
			if ( get_post_type( get_the_ID() ) == 'mit_updates' ) {
				if( strtolower( $menu_item->title ) == 'updates' ) {
					$classes[] = 'current-page-ancestor';
				}
			}
    }

    return $classes;
}

// Increase the number of search results per search.php page
function increase_search_results() {
	if ( is_search() && !is_admin() ) {
		set_query_var('posts_per_archive_page', 88);
	}
}
add_filter('pre_get_posts', __NAMESPACE__ . '\increase_search_results' );

function hide_them_posts() {
	// Remove Posts from the backend, as we won't be needing those
	remove_menu_page('edit.php');
}
// add_action( 'admin_init', __NAMESPACE__ . '\hide_them_posts' );

// Hide comments in WP Admin, as they are disabled globally
function remove_comments(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\remove_comments' );

// Add login link to footer menu

function solum_login_logout_link( $items, $args ) {
	if( $args->theme_location == 'solum' ) {
		$loginoutlink = wp_loginout( 'index.php', false );
		$items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-mit">'. $loginoutlink .'</li>';
		return $items;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\solum_login_logout_link', 10, 2 );
