<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'mosaic-hero'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'mosaichero_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="head-content"><div class="mosaic-grid">

		<div class="mosaic-grid--title">
			<div>
				<span class="eyebrow-like"><?= $fields['mh_eyebrow'] ?></span>
				<?= $fields['bc_title'] ?>
			</div>

		</div>

		<div class="mosaic-grid--video1 video-tile" data-video-url="<?= $fields['mh_videos'][0]['v_video_url'] ?>">
			<img src="<?= $fields['mh_videos'][0]['v_cover_image']['sizes']['medium_large'] ?>" alt="" width="400" height="140" />
			<span><?= $fields['mh_videos'][0]['v_title'] ?></span>
			<?php getIcon('play-media'); ?>
		</div>

		<a href="<?= $fields['mh_links'][0]['link']['url'] ?>" class="mosaic-grid--link1 link-tile"<?php
			if($fields['mh_links'][0]['link']['target'] == '_blank') : echo ' target="_blank"'; endif;
			?>>
			<span><?= $fields['mh_links'][0]['link']['title'] ?></span>
			<?php getIcon('arrow-northeast'); ?>
		</a>

		<div class="mosaic-grid--video2 video-tile" data-video-url="<?= $fields['mh_videos'][1]['v_video_url'] ?>">
			<img src="<?= $fields['mh_videos'][1]['v_cover_image']['sizes']['medium_large'] ?>" alt="" width="400" height="140" />
			<span><?= $fields['mh_videos'][1]['v_title'] ?></span>
			<?php getIcon('play-media'); ?>
		</div>

		<a href="<?= $fields['mh_links'][1]['link']['url'] ?>" class="mosaic-grid--link2 link-tile"<?php
			if($fields['mh_links'][0]['link']['target'] == '_blank') : echo ' target="_blank"'; endif;
			?>>
			<span><?= $fields['mh_links'][1]['link']['title'] ?></span>
			<?php getIcon('arrow-northeast'); ?>
		</a>

		<?php foreach($fields['mh_images'] as $coun => $img) : ?>
			<div class="mosaic-grid--img<?= $coun + 1 ?> pic-tile">
				<img src="<?= $img['sizes']['medium_large'] ?>" alt="" width="200" height="200" />
			</div>
		<?php endforeach; ?>

	</div></div>

</section>
