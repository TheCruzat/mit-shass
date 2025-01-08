<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'numbers-list sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'numberslist_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>

		<?php if(is_data_okay('nl_columns', $fields)) { ?>
			<div class="numbers-list--columns">
			<?php foreach($fields['nl_columns'] as $col) {
				echo '<div>';
				if(is_data_okay('header', $col)) {
					echo '<h3 class="header">'.$col['header'].'</h3>';
				}
				if(is_data_okay('items', $col)) {
					echo '<ul>';
						foreach($col['items'] as $item) {
							if( is_data_okay('label', $item) && is_data_okay('number', $item) ) {
								echo '<li>'.$item['label'].': <span>'.$item['number'].'</span></li>';
							}
						}
					echo '</ul>';
				}
				echo '</div>';
			} ?>
			</div>
		<?php } ?>

	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
