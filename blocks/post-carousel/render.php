<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'post-carousel sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'postcarousel_' . str_replace('block_', '', $block['id']);
 	}
}

$carousel_id = 'carousel-'.generateRandomString(20);

include(dirname(__DIR__, 1) . '/block-meta.php');

if(is_data_okay('pc_source_selector', $fields)) {
	if($fields['pc_source_selector'] == 'people') {
		$custom_block_data['classes'] .= ' people';
	}
}

if(is_data_okay('bc_disable_card_link', $fields) && $fields['bc_disable_card_link'] == 1) {
	$no_link = 1;
} else {
	$no_link = 0;
}

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<h2 class="header"><?= $fields['bc_title'] ?></h2>
		<div class="intro body-content">
			<?= $fields['bc_intro'] ?>

			<?php if( is_data_okay('bc_links', $fields) ) {
				echo '<div class="cta-rack">';
				foreach($fields['bc_links'] as $link) {
					makeLink($link['link'], 'icon-link ' . getLinkIcon($link['icon']));
				}
				echo '</div>';
			} ?>

		</div>

		<div data-carousel-curr="1" data-carousel-id="<?= $carousel_id; ?>" class="carousel-slider"><div class="carousel-rack">

		<?php if(is_data_okay('pc_source_selector', $fields)) {
		$card_count = 0;
		switch($fields['pc_source_selector']) {
			case 'news':

				$feed = simplexml_load_file('https://news.mit.edu/rss/school/humanities-arts-and-social-sciences');

				$coun = 0;
				$post_cards = [];
				$card_count = count($feed->channel->item);
				foreach ($feed->channel->item as $item) {

				  $title = (string) $item->title;

				  $description = (string) $item->description;

				  $link = (string) $item->link;

				  $date = (string) $item->pubDate;

				  $author = $item->children('dc', TRUE)->creator;
				  if(str_contains($author, '|')) {
				  	$author = explode('|', $author)[0];
				  }

				  $image = $item->children('media', TRUE)->content->attributes()->url;

				  if($coun < 10) {
				  	$post_cards[$coun]['title'] = $title;
				  	$post_cards[$coun]['description'] = $description;
				  	$post_cards[$coun]['image'] = $image;
				  	$post_cards[$coun]['link'] = $link;
						$post_cards[$coun]['author'] = $author;
						$post_cards[$coun]['date'] = $date;
				  	$coun ++;
				  } else break;

				}

				foreach($post_cards as $coun => $card) {
					makeCard($card, null, null, 'news-feed');
				}

				break;
			case 'research':

				$feed = simplexml_load_file('https://news.mit.edu/rss/feed');

				$coun = 0;
				$post_cards = [];
				$card_count = count($feed->channel->item);
				foreach ($feed->channel->item as $item) {

				  $title = (string) $item->title;

				  $description = (string) $item->description;

				  $link = (string) $item->link;

				  $date = (string) $item->pubDate;

				  $cats = (array) $item->category;

				  $author = $item->children('dc', TRUE)->creator;
				  if(str_contains($author, '|')) {
				  	$author = explode('|', $author)[0];
				  }

				  $image = $item->children('media', TRUE)->content->attributes()->url;

				  if((in_array('School of Humanities Arts and Social Sciences', $cats) && in_array('Faculty', $cats)) && $coun < 10) {
				  	$post_cards[$coun]['title'] = $title;
				  	$post_cards[$coun]['description'] = $description;
				  	$post_cards[$coun]['image'] = $image;
				  	$post_cards[$coun]['link'] = $link;
					$post_cards[$coun]['author'] = $author;
					$post_cards[$coun]['date'] = $date;
				  	$coun ++;
				  }

				}

				foreach($post_cards as $coun => $card) {
					makeCard($card, null, null, 'research-feed');
				}

				break;
			case 'people':
				if(is_data_okay('pc_people_posts', $fields)) {
					$card_count = count($fields['pc_people_posts']);
					foreach($fields['pc_people_posts'] as $coun => $card) {
						makeCard($card, null, null, 'person-simple', null, $no_link);
					}
				}
				break;
			case 'ext_links':
				if(is_data_okay('pc_ext_links_posts', $fields)) {
					$card_count = count($fields['pc_ext_links_posts']);
					foreach($fields['pc_ext_links_posts'] as $coun => $card) {
						makeCard($card, null, null, 'alumni-news');
						// pr($card);
					}
				}
				break;
		} } ?>
		</div></div>

		<?php if($card_count > 3) { ?>
		<div class="carousel-controls">
			<button data-control-prev aria-label="Previous Item"><?php getIcon('arrow-east') ?></button>
			<button data-control-next aria-label="Next Item"><?php getIcon('arrow-east') ?></button>
		</div>
		<?php } ?>

	</div>
	<script>
		document.addEventListener("DOMContentLoaded", function(e) {

			const caro = document.querySelector('[data-carousel-id="<?= $carousel_id; ?>"]'),
				caroItems = document.querySelectorAll('[data-carousel-id="<?= $carousel_id; ?>"] + .carousel-controls button'),
				caroCount = caro.querySelectorAll('.card').length;
			let caroCurr = 1;
			// console.log(caroItems, "<?= $carousel_id; ?>");

			const caroAdv = () => {
				caroCurr ++;
				if(caroCurr > caroCount) {
					caroCurr = 1;
				}
				caro.setAttribute('data-carousel-curr', caroCurr);
				console.log(caroCurr);
			}
			const caroRev = () => {
				caroCurr --;
				if(caroCurr < 1) {
					caroCurr = caroCount;
				}
				caro.setAttribute('data-carousel-curr', caroCurr);
				console.log(caroCurr);
			}

			caroItems.forEach((btn, ndx) => {
				// console.log(ndx);
				btn.addEventListener('click', () => {
					if(btn.hasAttribute('data-control-prev')) caroRev();
					if(btn.hasAttribute('data-control-next')) caroAdv();
				});
			});

		});
	</script>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>
</section>
