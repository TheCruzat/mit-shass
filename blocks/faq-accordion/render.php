<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'faq-accordion sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'faqaccordion_' . str_replace('block_', '', $block['id']);
 	}
}

$accordion_id = 'accordion-'.generateRandomString(20);

include(dirname(__FILE__) . '/../block-meta.php');

//
?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<div class="faq-head">

			<?php if(is_data_okay('bc_title', $fields)) { ?>
				<h2 class="header"><?= $fields['bc_title'] ?></h2>
			<?php } ?>

			<?php if(is_data_okay('bc_header', $fields)) { ?>
				<h3 class="header"><?= $fields['bc_header'] ?></h3>
			<?php } ?>

			<?php if(is_data_okay('bc_intro', $fields)) { ?>
				<div class="intro body-content"><?= $fields['bc_intro'] ?></div>
			<?php } ?>

			<?php if(is_data_okay('link', $fields)) { ?>
				<div class="cta"><?php makeLink($fields['link'], 'icon-link arrow-northeast'); ?></div>
			<?php } ?>

		</div>

		<div class="faq-expand-all">
			<button class="eyebrow open-all"><span>Expand All</span> <?php getIcon('chevron-south') ?></button>
		</div>

		<?php if(is_data_okay('fa_question_sets', $fields)) { ?>
		<div data-accordion-id="<?= $accordion_id; ?>" class="accordion-frame">
		<?php foreach($fields['fa_question_sets'] as $set) {
				if(is_data_okay('question', $set) && is_data_okay('answer', $set)) {
					echo '<div class="faq-acc-set">';
					echo 	'<div class="faq-acc-question header"><button aria-expanded="false" aria-controls="' . cook_slug($set['question']) . '-answer">' . $set['question'] . '</button></div>';
					echo 	'<div class="faq-acc-answer body-content" id="' . cook_slug($set['question']) . '-answer">' . $set['answer'] . '</div>';
					echo 	'<span class="faq-acc-trigger" aria-hidden="true"><span></span><span></span></span>';
					echo '</div>';
				}
			} ?>
		</div>
		<?php } ?>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>

	<script>

		function checkAcc(acc) {
			btn = acc.querySelector('button');
			if(acc.classList.contains('open-drawer')) {
				acc.classList.remove('open-drawer');
				btn.setAttribute('aria-expanded', false);
			} else {
				acc.classList.add('open-drawer');
				btn.setAttribute('aria-expanded', true);
			}
			console.log(btn);
		}

		document.addEventListener("DOMContentLoaded", function(e) {
			const accItems = document.querySelectorAll('[data-accordion-id="<?= $accordion_id; ?>"] .faq-acc-set');
			accItems.forEach((acc, ndx) => {
				acc.querySelector('.faq-acc-trigger').addEventListener('click', () => { checkAcc(acc); });
				acc.querySelector('.faq-acc-question').addEventListener('click', () => { checkAcc(acc); });
			}); /**/

			const button = document.querySelector('.open-all');
			button.addEventListener('click', () => {
				accItems.forEach((acc, ndx) => {
					if(!acc.classList.contains('open-drawer')) {
						acc.classList.add('open-drawer');
						button.classList.add('all-are-open');
						button.querySelector('span').innerHTML = 'Collapse All';
					} else {
						acc.classList.remove('open-drawer');
						button.classList.remove('all-are-open');
						button.querySelector('span').innerHTML = 'Expand All';
					}
				});
			});
		});
	</script>
</section>
