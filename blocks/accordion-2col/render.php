<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'accordion-2col sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'accordion2col_' . str_replace('block_', '', $block['id']);
 	}
}

$accordion_id = 'accordion-'.generateRandomString(20);

include(dirname(__FILE__) . '/../block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<?php } ?>
		<?php if(is_data_okay('a2c_accordion_type', $fields) && is_data_okay('a2c_accordion_rows', $fields)) { ?>
		<div data-accordion-id="<?= $accordion_id; ?>" class="accordion-frame <?= $fields['a2c_accordion_type'] ?>" data-accordion-type="<?= $fields['a2c_accordion_type'] ?>">
		<?php
			$acc_count = count($fields['a2c_accordion_rows']);

			foreach($fields['a2c_accordion_rows'] as $coun => $row) { // pr($row)
				if($coun == round($acc_count / 2)) {
					echo '</ul>';
				}
				if($coun == 0 || $coun == round($acc_count / 2)) {
					echo '<ul class="accordion-column">';
				}
				?>

			<li class="accordion-item">
				<h3 class="header"><button aria-expanded="false" aria-controls="<?= cook_slug($row['header']) ?>-content"><?= $row['header'] ?></button></h3>
				<div id="<?= cook_slug($row['header']) ?>-content" class="accordion-content">
					<div class="accordion-content--padding">
					<?php

						switch($fields['a2c_accordion_type']) {
							case 'links':
								foreach($row['links'] as $link) {
									echo '<span class="link-wrap">';
									makeLink($link['link'], 'icon-link '.getLinkIcon($link['icon']), null, 'title-hack');
									echo '</span>';
								}
							case 'content':
								// pr($row);
								echo '<div class="accordion-item--content body-content">'.$row['content'].'</div>';
								if(is_data_okay('cta_label', $row) && is_data_okay('cta_link', $row)) {
									echo '<div class="accordion-item--meta"><span>'.$row['cta_label'].'</span> '.$row['cta_link'][0]->post_title.'</div>';
								}
								if(is_data_okay('link', $row)) {
									makeLink($row['link'], 'icon-link arrow-northeast');
								}
								break;
						} ?>
					</div>
				</div>
			</li>

			<?php
				if($coun == ($acc_count - 1)) {
					echo '</ul>';
				}
			} ?>
		</div>
	<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>

	<script>
		document.addEventListener("DOMContentLoaded", function(e) {
			const accItems = document.querySelectorAll('[data-accordion-id="<?= $accordion_id; ?>"] .accordion-item');
			accItems.forEach((acc, ndx) => {
				btn = acc.querySelector('.header button');

				acc.querySelector('.header').addEventListener('click', () => {
					if(acc.classList.contains('open-drawer')) {
						acc.classList.remove('open-drawer');
						btn.setAttribute('aria-expanded', false);
					} else {
						const alreadyOpen = document.querySelectorAll('.accordion-item.open-drawer');
						if(alreadyOpen.length > 0) {
							alreadyOpen.forEach((ao, ndx) => {
								ao.classList.remove('open-drawer');
							});
						}
						acc.classList.add('open-drawer');
						btn.setAttribute('aria-expanded', true);
					}
				});
			});
		});
	</script>
</section>
