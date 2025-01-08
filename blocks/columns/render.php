<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'columns sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'columns_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

$c1 = $fields['column_one'];
$c2 = $fields['column_two'];
if($fields['column_count'] == 3) {
	$c3 = $fields['column_three'];
}

if($fields['column_content_type'] == 'content_sets') {
	$fields['column_ratios'] = '5050';
}

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

		<?php if(is_data_okay('mh_eyebrow', $fields)) { ?>

			<div class="eyebrow"><?= $fields['mh_eyebrow'] ?></div>

			<?php } ?>

		<h2 class="header"><?= str_replace(['<p>','</p>'], "", cn($fields['bc_title'])) ?></h2>

		<?php if(is_data_okay('bc_header', $fields)) { ?>

			<h3 class="header"><?= $fields['bc_header'] ?></h3>

			<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>

				<div class="body-content"><?= $fields['bc_intro'] ?></div>

			<?php } ?>

		<?php if(is_data_okay('link', $fields)) {
				echo '<div class="cta-row">';
				makeLink($fields['link'], 'button');
				echo '</div>';
			} ?>

		<div class="cols-<?= $fields['column_count'] ?> col-ratio-<?= $col_ratio ?>">

			<div class="col">

				<?= $c1['c1_content']; ?>

				<?php if(is_data_okay('c1_link_list', $c1)) { ?>

					<ul><?php foreach($c1['c1_link_list'] as $item) {
						echo '<li>';
						makeColumnLink($item);
						echo '</li>';
					} ?></ul><?php } ?>

				<?php if(is_data_okay('c1_text_list', $c1)) { ?>
					<ul><?php foreach($c1['c1_text_list'] as $item) {
						echo '<li>';
						makeColumnText($item);
						echo '</li>';
					} ?></ul><?php } ?>

				<?php if(is_data_okay('content_sets', $c1)) { ?>
					<?php makeColumnContentSet($c1['content_sets']); } ?>
			</div>

			<div class="col">

				<?= $c2['c2_content'] ?>

				<?php if(is_data_okay('c2_link_list', $c2)) { ?>
					<ul><?php foreach($c2['c2_link_list'] as $item) { 		echo '<li>';
							makeColumnLink($item);
							echo '</li>';
					} ?></ul><?php } ?>

				<?php if(is_data_okay('c2_text_list', $c2)) { ?>
					<ul><?php foreach($c2['c2_text_list'] as $item) { 		echo '<li>';
							makeColumnText($item);
							echo '</li>';
					} ?></ul><?php } ?>

				<?php if(is_data_okay('content_sets', $c2)) { ?>
					<?php makeColumnContentSet($c2['content_sets']); } ?>
			</div>

			<?php if($fields['column_count'] == 3) { ?>

			<div class="col">

				<?= $c3['c3_content'] ?>

				<?php if(is_data_okay('c3_link_list', $c3)) { ?>
				<?php foreach($c3['c3_link_list'] as $item) { 			makeColumnLink($item);
					} ?><?php } ?>

				<?php if(is_data_okay('c3_text_list', $c3)) { ?>
				<?php foreach($c3['c3_text_list'] as $item) { 			makeColumnText($item);
					} ?><?php } ?>

				<?php if(is_data_okay('content_sets', $c3)) { ?>
					<?php makeColumnContentSet($c3['content_sets']); } ?>

			</div>
			<?php } ?>

		</div>

	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
