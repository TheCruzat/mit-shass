<?php
/**
 * Custom functions for our theme
 * Any and all functions for theme files, island of misfit functions
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;


/**
 * Echoes paginated nav links for archives, etc.
 * https://codex.wordpress.org/Function_Reference/paginate_links
 * https://allisontarr.com/2021/07/28/accessible-wordpress-pagination-with-numbers/
 *
 * @param [bool] $has_arrows, Output arrows or nay
 * @param [array] $block_data
 */
function numeric_nav( $has_arrows, $block_data ) {
	if( is_singular() && !$block_data ) {
			return;
	}

	$big = 999999999; // need an unlikely integer
	$translated = __( 'Page', 'provosto' ); // Supply translatable string
	// Default args for paginate_links, make it output a ul with numbered links
	$default_args = array(
		'type' => 'list',
		'format' => '?paged=%#%',
		'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>',
	);
	$merge_args = array();

	if( $block_data ) {
		$page_type = 'Updates';
		$max_page_num = intval( $block_data['max_pages'] );
		$current_page_num = intval( $block_data['current_page'] );

		$merge_args['base'] = get_permalink( get_page_by_path( 'updates' ) ) . '?paged=%#%#updates_archive';
		$merge_args['current'] = $current_page_num;
	} else {
		global $wp_query;

		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 )
				return;

		$current_page_num = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max_page_num = intval( $wp_query->max_num_pages );

		if( is_archive() ) {
			$page_type = 'Archive';
		} else {
			$page_type = 'Posts';
		}

		$merge_args['base'] = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
		$merge_args['current'] = max( 1, get_query_var('paged') );
	}
	$merge_args['total'] = $max_page_num;

	if( !$has_arrows ) {
		$merge_args['prev_next'] = false;
	}

	if( $current_page_num == 1 ){
		$merge_args['end_size'] = 3;
	} else if( $current_page_num >= 2 && $max_page_num > ($current_page_num - 4)) {
		$merge_args['mid_size'] = 1;
		$merge_args['end_size'] = 3;
	} else {
		$merge_args['mid_size'] = 1;
		$merge_args['end_size'] = 2;
	}

	$args = array_merge( $default_args, $merge_args );
	$pagination = '<nav id="paginated_nav" class="page-navigation nav-paginated" role="navigation" aria-label="'.$page_type.' paginated navigation">' . paginate_links( $args ) . '</nav>';

	// Update ul with correct class
	$pagination = str_replace( '<ul class="page-numbers">', '<ul class="page-numbers nav-paginated__list">', $pagination );
	// Update li with classes for JS
	$pagination = str_replace( '<li>', '<li class="nav-paginated__item">', $pagination );
	// Update a with classes for JS
	$pagination = str_replace( '<a class="page-numbers"', '<a class="page-link nav-paginated__link"', $pagination );

	echo $pagination;
}

/**
 * Takes in the excerpt, trims it to a certain character count by the word
 * If longer than the desired length, returns as is.
 *
 * @param [string] $string, Excerpt string
 * @param [int] $desired_char_count, Length you want string to be
 * @return $new_string, New trimmed excerpt
 */
function trim_the_excerpt( $string, $desired_char_count ) {
	if ( strlen( $string ) > $desired_char_count ) {
			$new_string = wordwrap( $string, $desired_char_count );
			$new_string = substr( $new_string, 0, strpos($new_string, "\n") );
			return $new_string . '...';
	} else {
		return $string;
	}
}

/**
 * Outputs the "vanilla" search away from the filters for AJAX search
 *
 * @return [string] $search_form, to echo or store
 */
function vanilla_search() {
	$search_form = '<form role="search" class="search-form search-w has-w" method="get" action="' . esc_url( home_url( '/' ) ) . '" data-rlv="none">';
	$search_form .= '<label class="search-label">';
	if( is_search() ) {
		$search_form .= '<span class="screen-reader-text">Search again for</span>';
	} else {
		$search_form .= '<span class="screen-reader-text">Search for</span>';
	}
	$search_form .= '<input type="search" class="search-field" placeholder="What are you looking for?" value="';
	if( is_search() ) {
		$search_form .= get_search_query();
	}
	$search_form .= '" name="s"></label></form>';

	return $search_form;
}

/**
 * Outputs a ul menu for an array of links from ACF
 * @param [array] $links
 * @param [string] $location_prefix
 * @return void
 */
function acf_menuify($links, $location_prefix) {
	// Check if array empty, if so, return immediately
	if( empty($links) ) {
		return;
	}
	// Output menu
	echo '<ul class="'. esc_html( $location_prefix ) .'-menu acf-links">';
	// Run through array of links as link
	// Array should have at least 'external_link_url', 'link_text' per link
	foreach($links as $link) {

		// Check if external link is set, if so - make url
		if (array_key_exists( 'external_link_url', $link )) {
			if( $link['external_link_url'] != NULL && !empty( $link['external_link_url'] )) {
				$link['url'] = $link['external_link_url'];
			}
		}

		// Check if page link is set, if so - make url
		if(array_key_exists( 'page_link', $link )) {
			if( $link['page_link'] != NULL && !empty( $link['page_link'] )) {
				$link['url'] = $link['page_link'];
			}
		}

		// In the unlikely event url is empty, make it # for safety's sake
		if( empty($link['url']) ) {
			$link['url'] = '#';
		}

		// Echo li with link
		echo '<li class="'.esc_html( $location_prefix ).'-menu__item"><a href="'.esc_url( $link['url'] ).'" class="'.esc_html( $location_prefix ).'-menu__link">'.esc_html($link['link_text']).'</a></li>';
	}
	echo '</ul>';
}

function set_custom_block_advanced_settings($block_settings, $adv_settings) {
	if( empty( $block_settings ) || empty( $adv_settings ) ) {
		return; // Incorrect block data, no dice
	}

	/*var_dump($block_settings);
	echo '<br><br><br>';
	var_dump($adv_settings);*/

	// Check for custom ID
	if( $adv_settings['custom_id'] ) {
		$block_settings['block_id'] = esc_html( $adv_settings['custom_id'] );
	}

	// Check for custom classes
	if( $adv_settings['custom_classes'] && !empty( $adv_settings['custom_classes'] ) ) {
		$block_settings['classes'] .= ' ' . esc_html( $adv_settings['custom_classes'] );
	}

	if( array_key_exists('bottom_margin', $adv_settings ) && array_key_exists('bottom_padding', $adv_settings ) ) {
		// Set classes for custom margins / padding
		$spacing_map = array(
			'ignore' => '',
			'none' => '0',
			'sm' => 'sm',
			'md' => 'md',
			'lg' => 'lg',
			'xl' => 'xl',
			'xxl' => 'xxl',
			'huge' => 'huge',
		);

		// Margins
		if( $adv_settings['top_margin'] == 'ignore' && $adv_settings['bottom_margin'] == 'ignore' ) { // Both no class
			$spacing_map_key = $adv_settings['top_margin'];
			$block_settings['classes'] .= $spacing_map[$spacing_map_key];
		} else if( $adv_settings['top_margin'] == $adv_settings['bottom_margin'] ) { // Equal values, only need one class
			$spacing_map_key = $adv_settings['top_margin'];
			$block_settings['classes'] .= ' m-' . $spacing_map[$spacing_map_key];
		} else if( $adv_settings['top_margin'] != 'ignore' && $adv_settings['bottom_margin'] != 'ignore' ) { // Neither are no padding, need two classes
			$spacing_map_key_top = $adv_settings['top_margin'];
			$spacing_map_key_btm = $adv_settings['bottom_margin'];
			$block_settings['classes'] .= ' m-'.$spacing_map[$spacing_map_key_top].'-t m-'.$spacing_map[$spacing_map_key_btm].'-b';
		} else {
			if( $adv_settings['top_margin'] != 'ignore' ) {
				$spacing_map_key = $adv_settings['top_margin'];
				$block_settings['classes'] .= ' m-'.$spacing_map[$spacing_map_key].'-t';
			}
			if( $adv_settings['bottom_margin'] != 'ignore' ) {
				$spacing_map_key = $adv_settings['bottom_margin'];
				$block_settings['classes'] .= ' m-'.$spacing_map[$spacing_map_key].'-b';
			}
		}

		// Padding
		if( $adv_settings['top_padding'] == 'ignore' && $adv_settings['bottom_padding'] == 'ignore' ) { // Both no paddings
			$spacing_map_key = $adv_settings['top_padding'];
			$block_settings['classes'] .= $spacing_map[$spacing_map_key];
		} else if( $adv_settings['top_padding'] == $adv_settings['bottom_padding'] ) { // Equal values, only need one class
			$spacing_map_key = $adv_settings['top_padding'];
			$block_settings['classes'] .= ' p-' . $spacing_map[$spacing_map_key];
		} else if( $adv_settings['top_padding'] != 'ignore' && $adv_settings['bottom_padding'] != 'ignore' ) { // Neither are no padding, need two classes
			$spacing_map_key_top = $adv_settings['top_padding'];
			$spacing_map_key_btm = $adv_settings['bottom_padding'];
			$block_settings['classes'] .= ' p-'.$spacing_map[$spacing_map_key_top].'-t p-'.$spacing_map[$spacing_map_key_btm].'-b';
		} else {
			if( $adv_settings['top_padding'] != 'ignore' ) {
				$spacing_map_key = $adv_settings['top_padding'];
				$block_settings['classes'] .= ' p-'.$spacing_map[$spacing_map_key].'-t';
			}
			if( $adv_settings['bottom_padding'] != 'ignore' ) {
				$spacing_map_key = $adv_settings['bottom_padding'];
				$block_settings['classes'] .= ' p-'.$spacing_map[$spacing_map_key].'-b';
			}
		}
	}

	return $block_settings;
}


function output_jump_menu( $sections ) {
	$section_counter = 1;
	$output = '';

	if( !empty( $sections ) ) {
		$output .= '<span class="jump-title">Jump To</span>';
		$output .= '<ul class="jump-menu-items">';
		foreach( $sections as $section ) {
			if( $section->slug ) {
				$number_string = str_pad($section_counter, 2, '0', STR_PAD_LEFT);
				$output .= '<li data-target="'.esc_attr( $section->slug ).'" class="jump-menu-item"><a href="#'.esc_attr( $section->slug ).'" role="link" class="jump-menu-link"><span class="jump-num">'.$number_string.'. </span>'.esc_html( $section->name ).'</a></li>';
				$section_counter++;
			}
		}
		$output .= '</ul>';
	}

	return $output;
}

function get_main_category( $post_id, $post_type ) {
	$main_cat = array(); // init, gonna fill this up

	// Let's figure out the tax
	if ( 'post' == $post_type ) {
		$categories = get_the_category( $post_id );
		if ( ! empty( $categories ) ) {
			$main_cat['slug'] = $categories[0]->slug;
			$main_cat['name'] = $categories[0]->name;
			$main_cat['id']		= $categories[0]->term_id;
			$main_cat['url']  = get_category_link( $main_cat['id'] );
		}
	}

	return $main_cat;
}

// Make sure the ACF data is in the array and validish before using it
function is_data_okay( $key, $data ) {
	if ( ! isset( $data ) ) { // RUN THE GAUNTLET
		return false;
	}
	if ( ! is_array( $data ) ) {
		return false;
	}
	if ( ! array_key_exists( $key, $data ) ) {
		return false;
	}
	if ( ! $data[ $key ] ) {
		return false;
	}
	return true;
}

function debug_dump( $debug_var ) {
	echo '<pre class="debug-dump">';
	var_dump( $debug_var ); // I'm not above this ~jh
	echo '</pre>';
}

function pr($q) {
	echo '<pre>';
	print_r($q);
	echo '</pre>'; // I'm not either ~dc
}

function trunc($q, $lim = 25) {
   $q_set = explode(' ',$q);
   if(count($q_set) > $lim && $lim > 0)
      $q = implode(' ',array_slice($q_set, 0, $lim)).'...';
   return $q;
}

function create_anchor( $title ) {
	$title = preg_replace( '/[^A-Za-z0-9 ]/', '', $title ); // remove non-alphanumeric
	$title = preg_replace( '!\s+!', ' ', $title );; // remove multiple spaces
	$anchor = strtolower( str_replace( ' ', '_', esc_html( $title ) ) ); // convert to anchor slug
	return $anchor;
}


// let's have that slug then Daniel
function cook_slug($str) {
  $str = strtolower(trim($str));
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  rtrim($str, '-');
  return $str;
}

// strip everything out of number (for phone)
function nu($i) {
    return preg_replace("/[^0-9]/", "", $i);
}

// shorthand content filters
function cn($i) {
	return apply_filters('the_content', $i);
}
// shorthand again to include echo call
function ecn($i) { echo cn($i); }


function pid() {
	global $post;
	return $post->ID;
}

function wp_nav_menu_no_ul()
{
    $options = array(
        'echo' => false,
        'container' => false,
        'theme_location' => 'primary',
        'fallback_cb'=> 'default_page_menu'
    );

    $menu = wp_nav_menu($options);
    echo preg_replace(array(
        '#^<ul[^>]*>#',
        '#</ul>$#'
    ), '', $menu);

}

function default_page_menu() {
   wp_list_pages('title_li=');
}


// Function to change "posts" to "news" in the admin side menu
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News Articles';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'Tags';
    echo '';
}
add_action( 'admin_menu', __NAMESPACE__ . '\change_post_menu_label' );
// Function to change post object labels to "news"
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News Articles';
    $labels->singular_name = 'News Article';
    $labels->add_new = 'Add News Article';
    $labels->add_new_item = 'Add News Article';
    $labels->edit_item = 'Edit News Article';
    $labels->new_item = 'News Article';
    $labels->view_item = 'View News Article';
    $labels->search_items = 'Search News Articles';
    $labels->not_found = 'No News Articles found';
    $labels->not_found_in_trash = 'No News Articles found in Trash';
}
add_action( 'init', __NAMESPACE__ . '\change_post_object_label' );

// call_user_func_array([new $this->controller, $this->action], array $args);



// Get icon in correct relative directory as SVG element
function getIcon($name) { include( dirname(__DIR__, 2) .'/assets/icons/'.$name.'.svg'); }

// Return icon in correct relative directory as path string
function returnIcon($name) { return dirname(__DIR__, 2) .'/assets/icons/'.$name.'.svg'; }

// Create link with ACF link structure
function makeLink($q, $classes = null, $attrs = null, $titlehack = null) {
	if($q != null && ($q['title'] != null || $titlehack == 'title-hack') && $q['url'] != null) {
		$cla = $atr = '';
		if($classes != null) {
			$cla = ' class="'.$classes.'"';
		}
		if($attrs != null) {
			$atr = ' '.$attrs;
		}
		if($q['target'] == '_blank') {
			$targ = ' target="_blank"';
		} else { $targ = ''; }
		echo '<a href="'.$q['url'].'"'.$cla.$atr.$targ.'>'.$q['title'].'</a>';
	}
}

// Determine icon based on link icon value
function getLinkIcon($q) {
			$icon = '';
			switch($q) {
				case 'site': $icon = "arrow-east"; 			break;
				case 'ext':  $icon = "arrow-northeast"; break;
				case 'dl': 	 $icon = "arrow-download"; 	break;
			}
			return $icon;
}

// Let's have a list of links then Daniel
function makeLinkList($feed, $class = null) {
	if($feed != null) {
		if($class != null) {
			$cla = ' '.$class;
		} else {
			$cla = '';
		}
		echo '<ul class="link-list'.$cla.'">';
		foreach($feed as $item) { // pr($item)
			$targ = ''; // ' target="_blank"';
			if($item['icon'] == 'ext') {
				$targ = ' target="_blank"';
			}
			echo '<li>';
			makeLink($item['link'], 'icon-link '.getLinkIcon($item['icon']));
			echo '</li>';
		};
		echo '</ul>';
	}
}

// If no other image for a post, use this'n
$card_default_img = \get_field('default_card_image', 'Options')['sizes']['large'];

// Make a card, any card
function makeCard($q = null, $classes = null, $cta_label = null, $card_source = null, $prefix = null, $no_link = null) {
	global $card_default_img;
	$cla = $targ = '';
	$targ2 = ' target="_blank"';
	if($classes) $cla = ' '.$classes;
	$link_icon = 'arrow-east';

	// Featured Spotlight Cards
	if($q != null && is_object($q) && $q->post_type == 'people') {
		$cla .= ' spotlight';
		$title = $q->post_title;
		if($prefix) {
			$title = $prefix.$title;
		}
		$person_role = \get_field('person_role', $q->ID);
		$person_brief = \get_field('person_brief', $q->ID);
		$brief = $person_brief;
		$image = get_the_post_thumbnail_url($q->ID, 'sidebar_thumb');
		// pr($image);
		$link = get_the_permalink($q->ID);
		if($card_source == 'person-simple') {
			$cla .= ' person-simple';
			$brief = '';
		}

	// SHASS site Cards
	} else if($q != null && $card_source == 'posts') {
		$title = $q->post_title;
		$brief = $q->post_excerpt;
		$image = get_the_post_thumbnail_url($q->ID, 'sidebar_thumb');
		$link = get_the_permalink($q->ID);

		if($q->post_type == 'external-links') {
			$link = get_field('external_link', $q->ID) . '" target="_blank';
		}

	// External Links Cards
	} else if($q != null && is_object($q) && $card_source == 'ext') {
		$title = $q->post_title;
		$brief = $q->post_excerpt;
		$image = get_the_post_thumbnail_url($q, 'sidebar_thumb');
		$link = \get_field('external_link', $q->ID);
		$targ = $targ2;

	// Events Cards
	} else if($q != null && is_array($q) && $card_source == 'events') {
		$title = $q['title'];
		$brief = $q['description'];
		$image = $q['image'];
		$link = $q['link'];
		$targ = $targ2;

	// Newsletter Overview Cards
	} else if($q != null && is_array($q) && $card_source == ('newsletters') ) {
		$title = $q['title'];
		$brief = $q['description'];
		$image = $q['image'];
		$link = $q['link'];
		$eyebrow = $q['eyebrow'];
		$targ = $targ2;

	// News Feed Cards
	} else if($q != null && is_array($q) && $card_source == ('news-feed' || 'research-feed')) {
		$title = $q['title'];
		$brief = $q['description'];
		$image = $q['image'];
		$link = $q['link'];
		$author = $q['author'];
		$date = date_format(date_create($q['date']), "F j, Y");
		$targ = $targ2;
		$link_icon = 'arrow-northeast';

	// Alumni News Cards
	} else if($q != null && is_object($q) && $card_source == 'alumni-news') {
		$title = $q->post_title; // ['title'];
		$brief = $q->post_excerpt; // ['description'];
		$image = get_the_post_thumbnail_url($q, 'sidebar_thumb');
		$link = get_field('external_link', $q->ID); // $q['link'];
		$link_icon = 'arrow-northeast';
		// $author = $q['author'];
		// $date = date_format(date_create($q['date']), "F j, Y");
		$targ = $targ2;

		// pr($q);


	// FPO filler Card
	} else {
		$title = 'Lorem Ipsum Dolor Sit Ameta';
		$brief = 'Eget est lorem ipsum dolor sit. Nunc scelerisque viverra mauris in aliquam. Non odio euismod lacinia at. Est lorem ipsum dolor.';
		$image = 'https://placehold.co/750x500';
	}

	if(!isset($link)) {
		$link = '#';
	}

	// If no Image, default that jawn
	if(!isset($image) || !$image) {
		$image = $card_default_img;
	}

	// echo $no_link;

	if($no_link) {
		$href = '';
	} else {
		$href = ' href="'.$link.'"';
	}
	?>

	<a class="card<?= $cla ?>" <?= $href ?><?= $targ ?>>
		<img class="card-image" src="<?= $image; ?>" />
		<div class="card-frame">

			<div class="title-leads-set">
				<div>
					<h3 class="header"><?= $title ?></h3>
					<?php if($q != null && is_object($q) && isset($person_role) && $q->post_type == 'people') {
						echo '<div class="sub-header">';
						ecn($person_role);
						echo '</div>';
					} ?>
				</div>

				<?php if($q == 'meta' || ($q != null && is_object($q) && $q->post_type == 'news') || ($q != null && is_array($q) && $card_source == 'news-feed')) : ?>
				<div class="card-meta">
					<div class="date"><?= $date ?></div>
					<div class="author"><?= $author; ?></div>
				</div>
				<?php endif; ?>
			</div>


			<div class="card-content">
				<?= cn($brief); ?>
			</div>
			<?php if(!$no_link) { ?>
			<span class="card-cta-label"><span>Read more</span><?php getIcon($link_icon); ?></span>
			<?php } ?>
		</div>
	</a>
	<?php
}

function dropAnchor($coun, $id) {
	if ($coun < 10) $coun = '0' . $coun;
	echo '<div aria-hidden="true" class="section-anchor"><div class="section-anchor--text"><span>'.$coun.'.</span> '. $id .'</div></div>';
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function checkType($q) {
	if (get_post_type() == $q) {
		return true;
	}
}

function cookColumnMeta($q) {
	return str_replace(', ', '</span><span class="meta-spacer"></span><span>', $q);
}

function makeColumnLink($item) {
	echo '<div class="column-link-meta">';
	makeLink($item['link'], 'icon-link arrow-northeast');
	echo '<div class="link-meta"><span>'.cookColumnMeta($item['meta']).'</span></div>';
	echo '</div>';
}

function makeColumnText($item) {
	// echo '<div>';
	ecn($item['content']);
	// echo '</div>';
}

function makeColumnContentSet($set) {
	foreach($set as $item) {
		echo '<div class="column-content-set body-content">';
		if(is_data_okay('header', $item)) {
			echo '<h3 class="header">' . $item['header'] . '</h3>';
		}
		if(is_data_okay('flags', $item)) {
			echo '<div class="column-content-flags">';
			foreach($item['flags'] as $flag) {
				echo '<span>'.$flag['flag'].'</span>';
			}
			echo '</div>';
		}
		if(is_data_okay('brief', $item)) {
			echo '<div class="brief">' . $item['brief'] . '</div>';
		}
		if(is_data_okay('calendar_notice', $item)) {
			echo '<div class="calendar-notice">' . $item['calendar_notice'] . '</div>';
		}
		if(is_data_okay('link', $item)) {
			if($item['link']['target'] == '_blank') {
				$arrow = 'arrow-northeast';
			} else {
				$arrow = 'arrow-east';
			}
			makeLink($item['link'], 'icon-link '.$arrow);
		}
		if(is_data_okay('link2', $item)) {
			makeLink($item['link2'], 'icon-link arrow-east');
		}
		echo '</div>';
	}
}

add_shortcode('meta-separator', function() {
	return '</span><span class="meta-spacer"></span><span>';
});
