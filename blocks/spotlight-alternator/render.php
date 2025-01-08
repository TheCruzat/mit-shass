<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'spotlight-alternator sideline'; // Declare first classes

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'spotlightalternator_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

?>
<section id="<?= $custom_block_data['block_id'] ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<h2 class="lead header"><?= $fields['bc_title'] ?></h2>
		<p class="eyebrow"><?= $fields['bc_eyebrow']['label'] ?></p>
		<h2 class="header"><?= $fields['bc_header'] ?></h2>

		<?php if(is_data_okay('link', $fields)) { ?>
			<div class="spotlight-alternator--lead-link">
			<?php makeLink($fields['link'], 'icon-link arrow-east'); ?>
			</div>
		<?php } ?>

		<?php if(is_data_okay('sa_spotlight_selector', $fields)) { ?>
			<div class="spotlight-alternator--cards">
				<?php foreach($fields['sa_spotlight_selector'] as $card) {
					makeCard($card, null, null, 'site');
					} ?>
			</div>
		<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>

</section>
