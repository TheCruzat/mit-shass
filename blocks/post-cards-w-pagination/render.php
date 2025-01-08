<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

use WP_Query;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'post-cards-w-pagination sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'postcards_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

if(is_data_okay('bc_disable_card_link', $fields) && $fields['bc_disable_card_link'] == 1) {
	$no_link = true;
} else {
	$no_link = null;
}
?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<div class="top-head">

		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>
			<div class="intro body-content"><?= $fields['bc_intro'] ?></div>
		<?php } ?>

		</div>

		<?php // pr($fields);

			$t_slug = '';

			$typo = $fields['post_type'];
			if($typo == 'external') {
				$typo .= '-links';
			}

			$args = [
				'post_type' => $typo,
				'posts_per_page' => 9,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			];

			$terms = [];

			if(is_data_okay('cat_people', $fields)) {
				$b_field = 'cat_people';
				$b_tax = 'people-categories'; 				}

			if(is_data_okay('cat_ext', $fields)) {
				$b_field = 'cat_ext';
				$b_tax = 'extlink-categories'; 				}

			if(is_data_okay('cat_news', $fields)) {
				$b_field = 'cat_news';
				$b_tax = 'categories'; 								}

			if($b_field && $b_tax) {

				foreach($fields[$b_field] as $coun => $cat) {
					// $coun .= $addup;
					$terms[$coun] = [
						'taxonomy' => $b_tax,
						'field' => 'id',
						'terms' => $cat
					];
				}

				$t_slug = get_term($fields[$b_field][0], $b_tax)->slug;

			}

			$args['tax_query'] = $terms;

			$blockQuery = new WP_Query($args);

			if( $blockQuery->have_posts() ) {
				echo '<div class="post-cards">';
				while ( $blockQuery->have_posts() ) { $blockQuery->the_post();
					$i = get_the_ID();
					$l = get_the_permalink();
					$flds = get_fields($i);
					$type = get_post_type();

					if(is_data_okay('external_link', $flds) && checkType('external-links')) {
						// $flds['external_link']

						$l = $flds['external_link'] . '" target="_blank';

						// pr($flds);
					}

					if($no_link) {
						$href = '';
					} else {
						$href = ' href="'.$l.'"';
					}

					echo '<div class="card '.$t_slug.'">';

						if(has_post_thumbnail()) {
							echo '<a class="card-image-frame"'.$href.'>';
								the_post_thumbnail('medium_large');
							echo '</a>';
						}
						echo '<div class="card-content-frame">';

							echo '<a'.$href.'>';

							if(is_data_okay('el_source', $flds) && checkType('external-links')) {
								echo '<div class="eyebrow">'.$flds['el_source'].'</div>';
								echo '<p style="margin-bottom: 0.75rem"><strong>'.get_the_date().'</strong></p>';
							}

							if(!checkType('external-links')) {
								echo '<h3>' . get_the_title() . '</h3>';
							}

							if(is_data_okay('person_role', $flds) && checkType('people')) {
								echo '<div class="person-role">'.str_replace(['<p>','</p>'], '', cn($flds['person_role'])).'</div>';
							}
							if(is_data_okay('person_brief', $flds) && checkType('people')) {
								echo '<div class="person-brief">'.$flds['person_brief'].'</div>';
							}

							if(checkType('external-links')) {
								echo get_the_excerpt();
							}

							echo '</a>';

							if(is_data_okay('person_links', $flds) && checkType('people')) {
									echo '<div class="person-links">';
								foreach($flds['person_links'] as $link) {
									makeLink($link['link']);
								}
									echo '</div>';
							}

							if($t_slug == 'senior-gallery') {
								getIcon('arrow-east');
							}

							if($t_slug == 'in-the-media') {
								getIcon('arrow-northeast');
							}

						echo '</div>';

					echo '</div>';
				}
				echo '</div>';

				echo '<div class="post-cards-pagination">';
				$big_ol_biggums = 999999999; // need an unlikely integer
				 echo paginate_links( array(
				    'base' => str_replace( $big_ol_biggums, '%#%', get_pagenum_link( $big_ol_biggums ) ),
				    'format' => '?paged=%#%',
				    'current' => max( 1, get_query_var('paged') ),
				    'total' => $blockQuery->max_num_pages
				) );
				echo '</div>';
			}

			?>


		<?php wp_reset_postdata(); ?>




	</div>
	<script>
		document.addEventListener("DOMContentLoaded", function(e) {



		});
	</script>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
