<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

use WP_Query;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'news-overview newsletter sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'rowtitlecontent_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

$blockQuery = new WP_Query([
	'post_type' => 'newsletters',
	'posts_per_page' => 5
]);

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= cn($fields['bc_title']) ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>
			<div class="body-content"><?= cn($fields['bc_intro']); // ecn($custom_block_data['content']); ?></div>
		<?php } ?>

		<?php if(is_data_okay('link', $fields)) { ?>
			<?= makeLink($fields['link'], 'button'); ?>
		<?php } ?>
		<div class="news-overview--columns">


			<?php if($blockQuery->have_posts() ) { ?>
			<div class="news-overview--news-cards">
				<?php while($blockQuery->have_posts()) {
					$blockQuery->the_post();
					$i = get_the_ID();
					$hold = [];
					$hold['title'] = get_the_title();
					$hold['description'] = get_the_excerpt();
					$hold['image'] = get_the_post_thumbnail_url($i, 'medium_large');
					$hold['link'] = get_field('nl_link', $i);
					$hold['eyebrow'] = get_field('eyebrow', $i);

					makeCard($hold, null, null, get_post_type());

				}

				echo '<div class="post-cards-pagination">';
				$big_ol_biggums = 999999999; // need an unlikely integer
				 echo paginate_links( array(
				    'base' => str_replace( $big_ol_biggums, '%#%', get_pagenum_link( $big_ol_biggums ) ),
				    'format' => '?paged=%#%',
				    'current' => max( 1, get_query_var('paged') ),
				    'total' => $blockQuery->max_num_pages
				) );
				echo '</div>';

				?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php } ?>

			<div class="news-overview--news-sidebar">

				<?php $rout = get_field('newsletter_group', 'Options'); ?>

				<div class="news-overview--share-a-story">
					<h3 class="header">Get Our Newsletter</h3>
					<div class="newsletter-signup"><?php // pr($rout); ?>
					<?= $rout['form_embed'] ?> </div>
				</div>

				<?php if(is_data_okay('no_share_a_story', $fields)) { ?>
				<div class="news-overview--share-a-story">
					<h3 class="header"><?= $fields['no_share_a_story']['header'] ?> </h3>
					<div><?= cn($fields['no_share_a_story']['content']) ?></div>
					<?php makeLink($fields['no_share_a_story']['link'], 'icon-link arrow-east'); ?>
				</div>
				<?php } ?>
			</div>
		</div>

	</div>

</section>
