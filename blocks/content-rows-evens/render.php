<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'content-rows-evens sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'contentrows_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

// fields['column_ratios']
if(is_data_okay('column_ratios', $fields)) {
	$col_ratio = $fields['column_ratios'];
} else {
	$col_ratio = null;
}

// pr($fields);
?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_title', $fields)) { ?>
		<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>
		<div class="body-content"><?= $fields['bc_intro'] ?></div>
		<?php } ?>

		<ul><?php foreach($fields['rows'] as $row) {
			echo '<li class="content-row body-content col-ratio-'.$col_ratio.'">';
			echo 	'<div class="content-left">';
			if(is_data_okay('left_content', $row)) {
				ecn($row['left_content']);
			}
			echo 	'</div>';
			echo 	'<div class="content-right">';
			if(is_data_okay('right_content', $row)) {
				ecn($row['right_content']);
			}
			echo 	'</div>';
			echo '</li>';
			} ?></ul>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
