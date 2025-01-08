<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

global $post;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'video sideline dimline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'video_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

?>
<?php if(is_data_okay('v_video_url', $fields)) { ?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>" data-video-url="<?= $fields['v_video_url'] ?>">
	<div class="face-plate"><?php getIcon('play-media') ?></div>
	<?php if(is_data_okay('v_cover_image', $fields)) { ?>
		<div class="video--cover" style="background: url(<?= $fields['v_cover_image']['sizes']['large'] ?>) 50% 50% / cover no-repeat"></div>
	<?php } ?>
	<div class="block-content sideline purple">
	<!-- <div class="block-content"> -->

		<?php if(is_data_okay('v_title', $fields)) { ?>
			<h3 class="header"><?= str_replace(['<p>', '</p>'], '', cn($fields['v_title'])) ?></h3>
		<?php } ?>

		<?php if(is_data_okay('v_subtitle', $fields)) { ?>
			<?php ecn($fields['v_subtitle']) ?>
		<?php } ?>
	<!-- </div> -->
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
<?php } ?>
