<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

global $post;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'page-header sideline dimline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'pageheader_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

if(is_data_okay('bc_title', $fields)) {
	$page_title = $fields['bc_title'];
} else {
	$page_title = $post->post_title;
}
if(is_data_okay('bc_eyebrow', $fields)) {
	$eye_b = $fields['bc_eyebrow'];
	if($eye_b['type'] == 'parent') {
		$eye_brow = '<a href="'.get_the_permalink($post->post_parent).'">'.get_the_title($post->post_parent).'</a>';
	} else if($eye_b['label'] != null && $eye_b['label'] != '') {
		$eye_brow = $eye_b['label'];
	}
}
if(is_data_okay('ph_longer_title', $fields)) {
	$custom_block_data['classes'] .= ' longer-title';
}

?>

<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">
	<?php if(is_data_okay('image', $fields)) { ?>
		<div class="page-header--bg" style="background: url(<?= $fields['image']['sizes']['large'] ?>) 50% 50% / cover no-repeat"></div>
	<?php } ?>
	<div class="header-content sideline purple">
	<!-- <div class="block-content"> -->
		<?php if(isset($eye_brow)) { ?>
		<div class="eyebrow"><nav aria-label="you are here"><?= $eye_brow ?></nav></div>
		<?php } ?>
		<h1 class="header"><?= cn($page_title) ?></h1>
	<!-- </div> -->
	</div>
</section>
