<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;



// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'stats-4up sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'stats4up_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<div class="stats-4up--head">

			<?php if(is_data_okay('bc_title', $fields)) { ?>
				<h2 class="header"><?= str_replace(['<p>', '</p>'], '', cn($fields['bc_title'])) ?></h2>
			<?php } ?>

			<?php if(is_data_okay('bc_intro', $fields)) { ?>
			<div class="stats-4up--content body-content">
				<?= cn($fields['bc_intro']); ?>
			</div>
			<?php } ?>
		</div>

		<?php if(is_data_okay('s4u_stats', $fields)) { ?>
		<ul class="stats-4up--cards">
			<?php foreach($fields['s4u_stats'] as $coun => $card) {
				// pr($card);
				if(is_data_okay('link', $card) && is_data_okay('number', $card) && is_data_okay('bc_header', $card) && is_data_okay('bc_intro', $card) ) {
				$str = '<li><a href="'.$card['link']['url'].'">
					<h3 class="header"><span>'.$card['number'].'</span>'.$card["bc_header"].'</h3>
					<div>'.cn($card['bc_intro']).'</div>
					<span class="icon-link arrow-east">'.$card['link']['title'].'</span>
				</a></li>';
				// return $str;
				echo $str;
				}
			} ?>
		</ul>
		<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>

</section>
