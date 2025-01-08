<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'timeline sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'timeline_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>

		<?php if(is_data_okay('tl_items', $fields)) { ?>
		<div class="timeline-rows">
			<?php foreach($fields['tl_items'] as $coun => $group) {

				if(is_data_okay('year', $group)) {
					echo '<div class="timeline-row">
							<div>'.$group['year'].'</div>
							<ul>';
					if(is_data_okay('year', $group)) {
						foreach($group['year_items'] as $item) {
							if(is_data_okay('name', $item)) {
								if(is_data_okay('detail', $item)) {
									$item_detail = ', ' . $item['detail'];
								} else {
									$item_detail = '';
								}
								$linx = '';
								$l1 = $item['link_1'];
								$l2 = $item['link_2'];
								echo '<li><span>'.$item['name'].'</span>'.str_replace(['<p>','</p>'], '', $item_detail);
								if(is_data_okay('title', $l1) && is_data_okay('url', $l1)) {
									echo ', ';
									makeLink($item['link_1']);
								}
								if(is_data_okay('title', $l2) && is_data_okay('url', $l2)) {
									echo ', '.$link_str;
									makeLink($item['link_2']);
								}
								echo '</li>';
							}
						}
					}
					echo '	</ul>
						  </div>';
				}
			} ?>
		</div>
		<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
