<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;



// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'news-overview sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'rowtitlecontent_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__DIR__, 1) . '/block-meta.php');

$feed = simplexml_load_file('https://news.mit.edu/rss/school/humanities-arts-and-social-sciences');

$coun = 0;
$news_links = [];
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

  if($coun < 3) {
  	$news_links[$coun]['title'] = $title;
  	$news_links[$coun]['description'] = $description;
  	$news_links[$coun]['image'] = $image;
  	$news_links[$coun]['link'] = $link;
  	$news_links[$coun]['author'] = $author;
  	$news_links[$coun]['date'] = $date;
  	$coun ++;
  } else break;

}

 //pr($news_links);

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<h2 class="header"><?= cn($fields['bc_title']) ?></h2>
		<?php } ?>

		<?php if(is_data_okay('bc_title', $fields)) { ?>
			<div class="body-content"><?= cn($fields['bc_intro']); // ecn($custom_block_data['content']); ?></div>
		<?php } ?>

		<?php if(is_data_okay('link', $fields)) { ?>
			<?= makeLink($fields['link'], 'button'); ?>
		<?php } ?>
		<div class="news-overview--columns">


			<?php if($news_links) { ?>
			<div class="news-overview--news-cards">
				<?php
					foreach($news_links as $coun => $item) { // pr($item) ?>
						<?php makeCard($item, null, null, 'news-feed'); ?>
					<?php } ?>
			</div>
			<?php } ?>

			<div class="news-overview--news-sidebar">
				<h2 class="header">In the media</h2>

				<div class="news-overview--media-cards">
					<?php

					if(is_data_okay('no_in_the_media_selector', $fields)) {

						$medias = $fields['no_in_the_media_selector'];

						foreach($medias as $coun => $link) {
							$i = $link->ID;
							$flds = get_fields($i);
							// pr(get_fields($link->ID)); ?>

							<a href="<?= $flds['external_link'] ?>" target="_blank">
								<div class="eyebrow"><?= $flds['el_source'] ?></div>
								<h3 class="header"><?= $link->post_title ?></h3>
								<?php getIcon('arrow-northeast'); ?>
							</a>

							<?php
						}

					} ?>

				</div>

				<?php if(is_data_okay('no_in_the_media_link', $fields)) { ?>
					<div><?php makeLink($fields['no_in_the_media_link'], 'icon-link arrow-east') ?></div>
				<?php } ?>

				<?php if(is_data_okay('no_share_a_story', $fields)) { ?>
				<div class="news-overview--share-a-story">
					<h3 class="header"><?= $fields['no_share_a_story']['header'] ?> </h3>
					<div><?= cn($fields['no_share_a_story']['content']) ?></div>
					<?php makeLink($fields['no_share_a_story']['link'], 'icon-link arrow-east'); ?>
				</div>
				<?php } ?>
			</div>
		</div>

	</div>

</section>
