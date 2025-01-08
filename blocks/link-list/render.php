<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'link-list sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'linklist_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

// pr($fields);
?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_header', $fields)) { ?>
		<h2 class="header"><?= $fields['bc_header'] ?></h2>
		<?php } ?>
		<?php if(is_data_okay('bc_intro', $fields)) { ?>
		<div class="intro">
			<?= $fields['bc_intro']; ?>
		</div>
		<?php } ?>
		<?php if(is_data_okay('bc_links', $fields)) { ?>
			<?php
				makeLinkList($fields['bc_links']);
				?>
		<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
