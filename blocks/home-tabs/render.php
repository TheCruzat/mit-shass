<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'home-tabs sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'hometabs_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

if(is_data_okay('ht_tab1', $fields) && is_data_okay('ht_tab2', $fields) && is_data_okay('ht_tab3', $fields)) {
	$tab_set = [
			$fields['ht_tab1'],
			$fields['ht_tab2'],
			$fields['ht_tab3']
	];
}

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<div class="tab-set">
		<?php if($tab_set) {
		foreach($tab_set as $coun => $tab) : $cla = "header"; if($coun == 0) $cla .= " sel" ; // pr($tab); ?>
			<div data-tab-index="<?= $coun ?>" class="<?= $cla ?>"><?= $tab['bc_header'] ?></div>
		<?php endforeach; } ?>
		</div>

		<div class="tab-frames">

		<?php // set up Research links tab

			$research_links = get_posts([
				'post_type' => 'external-links',
				'post_count' => 9,
				'tax_query' => [[
					'taxonomy' => 'extlink-categories',
					'field' => 'slug',
					'terms' => 'mit-research',
				]],
			]); 		// pr($research_links);
			?>

		<?php // set up Events tab

			$feed = simplexml_load_file('https://calendar.mit.edu/calendar.xml');

			$coun = 0;
			$events_links = [];
			if($feed) {
				foreach ($feed->channel->item as $item) {

				  $title = (string) $item->title;
				  	$title = explode(':', $title)[1];

				  $description = (string) $item->description;
				  	$description = substr($description,0, strpos($description, "</p>")+4);

				  $link = (string) $item->link;

				  $image = $item->children('media', TRUE)->content->attributes()->url;

				  if($coun < 3) {
				  	$events_links[$coun]['title'] = $title;
				  	$events_links[$coun]['description'] = $description;
				  	$events_links[$coun]['image'] = $image;
				  	$events_links[$coun]['link'] = $link;
				  	$coun ++;
				  } else break;
				}
			}
			?>

		<?php foreach($tab_set as $coun => $tab) :  // pr($tab);
			switch($tab['tab_source']) {
				case 'events':
					$tab_set = $events_links;
					break;
				case 'ext':
					$tab_set = $research_links;
					// pr($tab_set);
					break;
				case 'posts':
					$tab_set = $tab['posts'];
					break;
			}
			?>

			<div class="tab-frame" data-type="<?= $tab['tab_type'] ?>" data-source="<?= $tab['tab_source'] ?>">
				<div class="cols-row">
					<div class="col-8">
						<div class="intro body-content">
							<?= cn($tab['bc_intro']) ?>
						</div>
						<?php makeLink($tab['link'], 'button') ?>
					</div>
				</div>
				<div class="tab-cards">
					<div class="tab-cards--prime">
						<?php makeCard($tab_set[0], null, null, $tab['tab_source']); ?>
					</div>
					<div class="tab-cards--more">
						<?php makeCard($tab_set[1], null, null, $tab['tab_source']); ?>
						<?php makeCard($tab_set[2], null, null, $tab['tab_source']); ?>
						<?php // makeCard(); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<script>
		document.addEventListener("DOMContentLoaded", function(e) {
			const tabSet = document.querySelectorAll('.tab-set > div'),
				tabFrames = document.querySelectorAll('.tab-frame');

				tabSet.forEach((tab, ndx) => {
					tab.addEventListener('click', function() {

						if(!tab.classList.contains('sel')) {
							document.querySelector('.tab-set > div.sel').classList.remove('sel');
							tab.classList.add('sel');
							tabFrames.forEach((frame) => {
								frame.style.display = "none"
							});
							tabFrames[ndx].style.display = "block";
						}

					})
				})
		});
	</script>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
