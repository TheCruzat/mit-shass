<?php
/**
 * All of the theme's AJAX-related functions.
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

function search_updates() {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'updates_ajax' ) ) {
		die( __( 'Security check failed!', 'mit-ir' ) );
	} else {
		$search_term = $_POST['search'];
		$filters = $_POST['filters'];

		$search_args = array( 's' => $search_term, 'post_type' => 'mit_updates', 'no_found_rows' => true, 'update_post_meta_cache' => false, 'update_post_term_cache' => false, 'fields' => 'ids' );

		// Check for filters
		if( $filters ) {
			$listOFilters = explode(',', $filters );
			$search_args['tax_query'] = array(
				array(
					'taxonomy' => 'mit_updates_cat',
					'field' => 'slug',
					'terms' => $listOFilters,
				),
			);
		}

		// Because this is namespaced, we're going to use a \ in front of WP_Query to tell PHP
		// that WP_Query is in the global namespace and not in ProvostO
		$s_query = new \WP_Query();
		$s_query->parse_query( $search_args );
		\relevanssi_do_query( $s_query );

		// Search run, return results as query as result to dump into container
		if ( count( $s_query->posts ) < 1 ) {
			echo \get_field('updates_search_none', 'option');
		} else {
			$results_args = array(
				'posts_per_page' => -1,
				'ignore_sticky_posts' => true,
				'post_type' => 'mit_updates',
				'post__in' => $s_query->posts,
			);

			$ajax_query = new \WP_Query( $results_args );
			$response = '';

			if( $ajax_query->have_posts() ) {
				while( $ajax_query->have_posts() ) : $ajax_query->the_post();
					$response .= get_template_part('templates/updates/update', 'card');
				endwhile;
			}

			echo $response;
		}
	}
  exit;
}
add_action('wp_ajax_search_updates', __NAMESPACE__ . '\search_updates');
add_action('wp_ajax_nopriv_search_updates', __NAMESPACE__ . '\search_updates');

function filter_updates() {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'updates_ajax' ) ) {
		die( __( 'Security check failed!', 'mit-ir' ) );
	} else {
		$cat = $_POST['filter'];

		$filter_args = array(
			'post_type' => 'mit_updates',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'mit_updates_cat',
					'field' => 'slug',
					'terms' => $cat,
				),
			),
		);

		// Because this is namespaced, we're going to use a \ in front of WP_Query to tell PHP
		// that WP_Query is in the global namespace and not in ProvostO
		$f_query = new \WP_Query( $filter_args );

		// Return results as query as result to dump into container
		$response = '';

		if( $f_query->have_posts() ) {
			while( $f_query->have_posts() ) : $f_query->the_post();
				$response .= get_template_part('templates/updates/update', 'card');
			endwhile;
		} else {
			$response = 'No updates found.';
		}

		echo $response;
	}
  exit;
}
add_action('wp_ajax_filter_updates', __NAMESPACE__ . '\filter_updates');
add_action('wp_ajax_nopriv_filter_updates', __NAMESPACE__ . '\filter_updates');
