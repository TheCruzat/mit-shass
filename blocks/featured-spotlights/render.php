<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;



// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'featured-spotlights sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'featuredspotlights_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

if(is_data_okay('bc_disable_card_link', $fields) && $fields['bc_disable_card_link'] == 1) {
	$no_link = 1;
} else {
	$no_link = 0;
}

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="featured-spotlights--bg" style="background: url(<?= $fields['fs_bg']['sizes']['large'] ?>) 85% 50% no-repeat; background-size: cover;"></div>

	<div class="block-content">
		<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<div class="featured-spotlights--content body-content">
			<?= cn($fields['bc_intro']); ?>
		</div>

		<?php if(is_data_okay('person_selector', $fields) && is_data_okay('links', $fields)) { ?>
		<div class="featured-spotlights--row">
			<div>
				<?php makeCard($fields['person_selector'][0], null, null, null, 'Meet ', $no_link); ?>
				<?php makeLink($fields['links'][0]['link'], 'button'); ?>
			</div>
			<div>
				<?php makeCard($fields['person_selector'][1], null, null, null, 'Meet ', $no_link); ?>
				<?php makeLink($fields['links'][1]['link'], 'button'); ?>
			</div>
			<div>
				<?php makeCard($fields['person_selector'][2], null, null, null, 'Meet ', $no_link); ?>
				<?php makeLink($fields['links'][2]['link'], 'button'); ?>
			</div>
		</div>
		<?php } ?>
	</div>

</section>
