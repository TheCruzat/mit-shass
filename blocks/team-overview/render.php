<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'team-overview sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'teamoverview_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_intro', $fields)) { ?>
			<div class="intro body-content">
			<?= $fields['bc_intro'] ?>
			</div>
		<?php } ?>

		<div class="team-cards">

		<?php if(is_data_okay('to_team_selector', $fields)) { ?>
			<?php foreach($fields['to_team_selector'] as $card) {
				$image = get_the_post_thumbnail_url($card, 'sidebar-thumb');
				$cfields = get_fields($card);
				// makeCard($card)
				?>
				<div class="team-card">
					<?php if($image) { ?>
						<!-- <a href="<?= get_permalink($card->id) ?>"> -->
							<img src="<?= $image ?>" alt="" />
						<!-- </a> -->
					<?php } ?>
					<div class="team-card--padding">
						<h3 class="header"><?= $card->post_title ?></h3>
						<?php if(is_data_okay('person_role', $cfields)) { ?>
							<div><?= $cfields['person_role']; ?></div>
						<?php } ?>
					</div>
					<hr />
					<div class="team-card--padding">
					<?php if(is_data_okay('person_email', $cfields)) { ?>
						<div><a class="inline-icon-link" href="mailto:<?= $cfields['person_email'] ?>"><?php getIcon('email') ?><span><?= $cfields['person_email']; ?></span></a></div>
					<?php } ?>
					<?php if(is_data_okay('person_phone', $cfields)) { ?>
						<div><a class="inline-icon-link" href="tel:<?= $cfields['person_phone'] ?>"><?php getIcon('phone') ?><span><?= $cfields['person_phone']; ?></span></a></div>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		</div>

	</div>
	<?php // $block['metadata']['name']  ?>
	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
