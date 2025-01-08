<?php
/**
 * The header for our theme, covering everything from the doctype to the header
 * Keep all site content in individual pages - this is only for the header
 *
 * This is the template that displays all of the <head> section, along with the site logo and nav
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

$anchor_count = 0;
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">

<?php /**/ // favicon goodies for later ?>

<?php $favi = get_field('favicon', 'option'); if($favi !== null) : ?>
<?php if($favi['favicon_apple']) : ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url ( $favi['favicon_apple'] ); ?>">
<?php endif; ?>
<?php if($favi['favicon_512']) : ?>
	<link rel="icon" type="image/png" sizes="512x512" href="<?php echo esc_url ( $favi['favicon_512'] ); ?>">
<?php endif; ?>
<?php if($favi['favicon_192']) : ?>
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url ( $favi['favicon_192'] ); ?>">
<?php endif; ?>
<?php if($favi['favicon_32']) : ?>
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url ( $favi['favicon_32'] ); ?>">
<?php endif; ?>
<?php if($favi['favicon_16']) : ?>
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url ( $favi['favicon_16'] ); ?>">
<?php endif; ?>
	<link rel="manifest" href="<?php echo esc_url ( get_site_url() ); ?>/site.webmanifest">
	<link rel="mask-icon" href="<?php echo esc_url ( get_site_url() ); ?>/safari-pinned-tab.svg" color="#ed009b">
<?php if($favi['favicon_ico']) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url ( $favi['favicon_ico'] ); ?>">
<?php endif; ?>
<?php if($favi['favicon_svg']) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url ( $favi['favicon_svg'] ); ?>">
<?php endif; ?>
<?php endif; ?>

	<meta name="theme-color" content="#dddddd">

<?php // Google Tag Manager (GTM) scripts
	$ids = [
		'UA-8593859-1',
		'G-4L1GGQTKLS',
		];

	foreach($ids as $id) {
		echo '
	<script async="" src="https://www.googletagmanager.com/gtag/js?id='.$id.'"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag(\'js\', new Date());

	  gtag(\'config\', \''.$id.'\');
	</script>
		';

	} ?>

<?php wp_head();

	$search_name_check = get_queried_object_id(); ?>

</head>


<body <?php body_class( 'no-js' ); ?>>

	<?php // Google Tag Manager (GTM) noscript

		echo '<noscript>';
		foreach($ids as $id) {
			echo '
		<iframe src="https://www.googletagmanager.com/ns.html?id='.$id.'" height="0" width="0" style="display: none; visibility: hidden;"></iframe>';
		}
		echo '
	</noscript>
	';
		?>

<a class="skip-link screen-reader-text js-trigger" href="#content"><?php echo esc_html( 'Skip to Content &#9207;' ); ?></a>

<div id="page" class="site">
<header id="masthead" class="site-header">
	<div class="site-header__contain">

			<a href="/" class="site-logo" title="MIT School of the Humanities, Arts and Social Sciences" rel="home">
				<?php include "assets/logos/shass-logo.svg" ?>
			</a>

		<div class="main-navigation">

			<?php	if ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e('Site Navigation', 'shass'); ?>">

				<?php // let's whip up an accessible menu

					$navcore = wp_get_nav_menu_items(2);		// get menu items
					$nav_parents = [];											// array for parent items
					$nav_children = [];											// array for child items

					foreach($navcore as $nav) :							// item sort, parent = 0 indicates top level navigation
						if($nav->menu_item_parent == 0) {
							array_push($nav_parents, ['id' => $nav->ID, 'page_id' => $nav->object_id, 'title' => $nav->title, 'slug' => $nav->post_name]);
						} else {
							array_push($nav_children, ['id' => $nav->ID, 'page_id' => $nav->object_id, 'title' => $nav->title, 'parent' => $nav->menu_item_parent]);
						}
					endforeach;

					echo '<ul id="menu-primary-nav" class="menu">';
					foreach($nav_parents as $pnav) : 											// loop 1, iterate parents

						$class = 'menu-item-has-children';
						if(!is_search() && $post->post_parent == $pnav['page_id']) $class .= ' current-page-ancestor';

						?><li class="<?= $class ?>">
							<button type="button" aria-label="<?= $pnav['title'] ?> menu" aria-expanded="false" aria-controls="<?= $pnav['slug'] ?>-menu"><?= $pnav['title'] ?></button>
							<ul id="<?= $pnav['slug'] ?>-menu" class="sub-menu"><?php
								foreach($nav_children as $cnav) :								// loop 2, iterate children
									if($cnav['parent'] == $pnav['id']) echo '
										<li>
											<a href="'.get_permalink($cnav['page_id']).'">
												'.$cnav['title'].'
											</a>
										</li>';
								endforeach;
							?></ul>
							</li><?php
					endforeach;
					echo '</ul>';							// menu is cooked, plated and served ?>

			</nav>
			<?php endif; ?>

		</div>

		<div class="menu-utility">
			<button class="menu-search" aria-expanded="false" aria-haspopup="true" aria-controls="primary-menu" type="button" aria-label="Open Site Search">
				<svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M24.9655 12.5628C28.3826 15.9799 28.3826 21.5201 24.9655 24.9372C21.5484 28.3543 16.0082 28.3543 12.5911 24.9372C9.17404 21.5201 9.17404 15.9799 12.5911 12.5628C16.0082 9.14573 21.5484 9.14573 24.9655 12.5628ZM27.7933 25.4824C31.0925 21.0762 30.7391 14.8009 26.7333 10.795C22.3399 6.40165 15.2168 6.40165 10.8234 10.795C6.42996 15.1884 6.42996 22.3116 10.8234 26.705C15.0059 30.8875 21.6625 31.0882 26.0825 27.3071L30.9324 32.157L32.7002 30.3892L27.7933 25.4824Z" fill="#0D0009"/>
				</svg>
				<span></span>
				<span></span>
			</button>

			<button id="main-navigation-toggle" class="menu-toggle mobile-menu" aria-expanded="false" aria-haspopup="true" aria-controls="primary-menu" type="button" aria-label="Open Main Menu">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>

	<div class="site-header__search-sleeve">
		<div class="site-header__search">

		<?php // <div class="site-header__contain"> ?>
			<form role="search" class="input-row" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input class="input-field" placeholder="Search MIT SHASS" aria-label="" type="search" value="<?php if( is_search() ) { echo get_search_query(); } ?>" name="s" />
				<input type="hidden" value="1" name="sentence" />
				<!-- <input type="hidden" value="['page', 'people', 'external-links']" name="post_type" /> -->
				<input class="button" type="submit" value="Search" />
			</form>
		<?php // </div> ?>

		</div>
	</div>

</header>
