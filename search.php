<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package shass
 */

namespace SHASS;

// we'll need this
use WP_Query;

// get the current full url
$search_url = $_SERVER['REQUEST_URI'];

// site top
get_header();
?>

<div class="block-content sideline search-page">

	<?php

	global $wp_query;

	if ( $wp_query->have_posts() ) {
			$results_top = $wp_query->post_count;
			if($results_top == 0) {
				$results_top = 'No results';
			} else if($results_top == 1) {
				$results_top .= ' result';
			} else if($results_top > 1) {
				$results_top .= ' results';
			}
	        _e("<h2 class='header'>".$results_top." for: <span>".get_query_var('s')."</span></h2>");
	        while ( $wp_query->have_posts() ) {
	           	$wp_query->the_post();
	           	$flds = get_fields($post->ID);

	           	// pr($flds);

	           	switch( get_post_type() ) {
	           		case "page":
	           			$link = get_the_permalink();
	           			$excerpt = $post->post_excerpt;
	           			break;
	           		case "people":
	           			$link = get_the_permalink();

	           			if(is_data_okay('person_description', $flds)) {
	           				$excerpt = $flds['person_description'];
	           			} else if(is_data_okay('person_brief', $flds)) {
	           				$excerpt = $flds['person_brief'];
	           			} else {
	           				$excerpt = $post->post_excerpt;
	           			}

	           			$excerpt = trunc($excerpt);

	           			break;
	           		case "external-links":
	           			$link = get_field('external_link', get_the_ID()) . '" target="_blank';
	           			$excerpt = $post->post_excerpt;
	           			break;
	           		}

	            ?>

                <a class="listing-card" href="<?= $link ?>">
                	<h3 class="header"><?php the_title(); ?></h3>
                	<?= $excerpt ?>
                </a>

                <?php
	        }
	    }else{
	?>
	        <h2 class="header">No results for <span><?= get_query_var('s') ?></span></h2>
	        <div class="alert alert-info">
	          <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
	        </div>
	<?php } ?>

</div>

<?php
get_footer();
