<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;



// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'quote-block sideline'; // Declare first classes

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'video_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

// pr($fields);

if(is_data_okay('qb_orientation', $fields)) {
	if($fields['qb_orientation'] == 'left') {
		$custom_block_data['classes'] .= ' quote-left';
	}
}

?>
<section id="<?= $custom_block_data['block_id'] ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">
	<?php if(is_data_okay('qb_image', $fields)) { ?>
		<img class="quote-block--bg" src="<?= $fields['qb_image']['sizes']['1536x1536'] ?>" alt="" />
	<?php } ?>

	<?php if(is_data_okay('qb_name', $fields) && is_data_okay('qb_quote', $fields) && is_data_okay('qb_role', $fields)) { ?>
		<div class="block-content sideline">
			<?php getIcon('quote'); ?>
			<div class="quote-block--quote header"><?= $fields['qb_quote'] ?>”</div>
			<div class="quote-block--meta">
				<div class="quote-block--name"><?= $fields['qb_name'] ?></div>
				<div class="quote-block--role"><?= str_replace(['<p>', '</p>'], '', cn($fields['qb_role'])) ?></div>
			</div>
		</div>
	<?php } ?>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
