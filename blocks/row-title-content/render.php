<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'row-title-content sideline'; // Declare first classes
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

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content"><div class="sideline purple">

		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= cn($fields['bc_title']) ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>
			<div class="body-content"><?= $fields['bc_intro']; // ecn($custom_block_data['content']); ?></div>
		<?php } ?>
	</div></div>

</section>
