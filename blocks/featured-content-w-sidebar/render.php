<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

global $post;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'featured-content-w-sidebar sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'featuredcontentwsidebar_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

if(is_data_okay('fcs_content_type', $fields)) {
	if($fields['fcs_content_type'] == 'person') $custom_block_data['classes'] .= ' featured-spotlight';
}
if(is_data_okay('fcs_orientation', $fields)) {
	if($fields['fcs_orientation'] == 'right') $custom_block_data['classes'] .= ' fcs-reverse';
}
if(is_data_okay('fcs_sidebar_type', $fields)) {
	if($fields['fcs_sidebar_type'] == 'imagemosaic' && ($fields['fcs_sb_image_mosaic']['style'] == 'style2' || $fields['fcs_sb_image_mosaic']['style'] == 'style3')) $custom_block_data['classes'] .= ' fcs-halves vertical-middle';

	if($fields['fcs_sidebar_type'] == 'none') {
		$custom_block_data['classes'] .= ' no-sidebar';
	}
}

if(is_data_okay('bc_copy_size', $fields)) {
	$custom_block_data['classes'] .= ' '.$fields['bc_copy_size'].'-copy';
}

if(is_data_okay('bc_equal_width', $fields)) {
	if($fields['bc_equal_width'] == true) $custom_block_data['classes'] .= ' fcs-halves';
}

?>

<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">
	<div></div>
	<div class="block-content">

			<?php if(is_data_okay('fcs_content_type', $fields) && $fields['fcs_content_type'] == 'person') {
					if(is_data_okay('bc_title', $fields)) {
						echo '<div class="featured-content-w-sidebar--content">';
						echo '<h2 class="header title">'.$fields['bc_title'].'</h2>';
						echo '</div>';
					}
				} ?>

			<div class="featured-content-w-sidebar--frame">

			<div class="featured-content-w-sidebar--content">
			<?php
			if(is_data_okay('fcs_content_type', $fields)) {
				switch( $fields['fcs_content_type'] ) {
					case 'content':
						if(is_data_okay('bc_title', $fields)) {
							echo '<h2 class="header title">'.$fields['bc_title'].'</h2>';
						}
						if(is_data_okay('bc_header', $fields)) {
							echo '<h3 class="header">'.$fields['bc_header'].'</h3>';
						}
						if(is_data_okay('fcs_content', $fields)) {
							echo '<div class="body-content">';
							ecn($fields['fcs_content']);
							if(is_data_okay('bc_links', $fields)) {
								echo '<div>';
								foreach($fields['bc_links'] as $coun => $link) {
									if($fields['bc_link_style'] == 'button') {
										echo '<div><a class="button" href="'.$link['link']['url'].'">'.$link['link']['title'].'</a></div>';
									} else {
										echo '<div>';
										makeLink($link['link'], 'icon-link arrow-east');
										echo '</div>';
									}
								}
								echo '</div>';
							}
							echo '</div>';
						}
						break;
					case 'person':
						if(is_data_okay('fcs_featured_spotlight', $fields)) {
							$spotlight = $fields['fcs_featured_spotlight'];
						}

						if($spotlight) {
							$flds = get_fields($spotlight->ID);

							echo '<div class="title-leads-content"><div class="title-leads-set">';

							echo '<h3 class="header">'.$spotlight->post_title.'</h3>';
							if(is_data_okay('bc_eyebrow_text', $fields)) {
								echo '<div class="eyebrow purple">'.$fields['bc_eyebrow_text'].'</div>';
							}

							echo '</div>';

							// pr($flds);
							if(is_data_okay('bc_title', $flds)) {
								echo '<h4 class="header">'.$flds['bc_title'].'</h4>';
							}
							echo '</div>';

							if(is_data_okay('person_role', $flds)) {
								echo '<div>'.cn($flds['person_role']).'</div>';
							}
							echo '<div class="body-content">'.cn($flds['person_description']).'</div>';

							if(is_data_okay('bc_links', $fields)) {
								foreach($fields['bc_links'] as $coun => $link) {

									if($link['icon']) {
										$i_icon = getLinkIcon($link['icon']);
									} else {
										$i_icon = 'arrow-east';
									}
									makeLink($link['link'], 'icon-link '.$i_icon);
									// makeLink($link['link'], 'icon-link arrow-east');
								}
							} else {
								$link = [
									'url' => get_permalink($spotlight->ID),
									'title' => 'Read more',
									'target' => null
								];
								makeLink($link, 'icon-link arrow-east');
							}

						}

						break;
				}
			} ?>
			</div>

			<?php if( (is_data_okay('fcs_sidebar_type', $fields) && $fields['fcs_content_type'] !== 'none') || !is_data_okay('fcs_sidebar_type', $fields)) {  ?>
			<div class="featured-content-w-sidebar--sidebar<?php
				if(is_data_okay('fcs_sidebar_type', $fields)) {
					echo ' '. $fields['fcs_sidebar_type'];
				} else {
					echo ' '. $fields['fcs_content_type'];
				}
				?>">

				<?php if(is_data_okay('fcs_content_type', $fields) ) {
				switch( $fields['fcs_content_type'] ) {
				case 'content':
				  if(is_data_okay('fcs_sidebar_type', $fields)) {
						// sidebar header
						if(is_data_okay('fcs_sb_header', $fields)) {
							$cla = $fields['fcs_sb_header_style'];
							if(is_data_okay('fcs_sb_header_underline', $fields) && $fields['fcs_sb_header_underline'] == 'underline') {
								$cla .= ' ' . $fields['fcs_sb_header_underline'];
							}
							echo '<h3 class="'.$cla.'">'.$fields['fcs_sb_header'].'</h3>';
						}

						// actions based on sidebar type
						switch($fields['fcs_sidebar_type']) :

							// type: content
							case 'content':
								ecn($fields['fcs_sb_content']);
								break;

							// type: sets
							case 'sets':
								if(is_data_okay('fcs_sb_content_sets', $fields)) {
									foreach($fields['fcs_sb_content_sets'] as $coun => $set) {
										if(isset($set['link']['title']) && isset($set['link']['url'])) {
											$bn = '<div><a class="icon-link arrow-east" href="'.$set['link']['url'].'">'.$set['link']['title'].'</a></div>';
										} else {
											$bn = '';
										}
										echo '<div class="sidebar-content-set">';
										echo '<h4 class="header">'.$set['bc_header'].'</h4>';
										echo '<div class="set-content">' . $set['bc_intro'] . '</div>';
										echo $bn;
										echo '</div>';
									};
								};
								break;

							// type: image
							case 'image': // pr($fields);
									$image_class = 'small-round-frame sidebar-image';
									$image_style = $fields['fcs_sb_image']['image_style'];
									if($image_style == 'full') $image_class .= ' full-bleed';
									echo '<img class="'.$image_class.'" src="'.$fields['fcs_sb_image']['image']['sizes']['sidebar-thumb'].'" alt="" />';
									if(is_data_okay('caption', $fields['fcs_sb_image'])) {
										echo '<div class="img-caption">'.cn($fields['fcs_sb_image']['caption']).'</div>';
									}
									if(is_data_okay('link', $fields['fcs_sb_image'])) {

										makeLink($fields['fcs_sb_image']['link']);
									}
								break;

							// type: image mosaic
							case 'imagemosaic':
									$mosaic = $fields['fcs_sb_image_mosaic'];
									echo '<div class="mosaic '.$mosaic['style'].'">';
									foreach($mosaic['images'] as $coun => $img) {
										echo '<img src="'.$img['sizes']['medium_large'].'" alt="" />';
									}
									echo '</div>';
									if(is_data_okay('caption', $mosaic)) {
										echo '<div class="img-caption">'.cn($mosaic['caption']).'</div>'; //
									}
									if(is_data_okay('bc_links', $mosaic)) {
											makeLinkList($mosaic['bc_links']);
									}
								break;

							// type: link tiles
							case 'linktiles':
									foreach($fields['fcs_sb_link_tiles'] as $tile) {

										$url = '#';

										echo '<a href="'.$url.'">
											<img class="small-round-frame" src="'.$tile['image']['sizes']['medium'].'" />
											<div>
												<div class="title-leads-set">
													<h3 class="header">'.$tile['header'].'</h3>
													<div class="eyebrow">'.$tile['eyebrow'].'</div>
												</div>
												<div>'.$tile['content'].'</div>
											</div>
										</a>';
									};
								break;

							// type: link list
							case 'linklist':
									makeLinkList($fields['fcs_sb_link_list']['bc_links'], 'link-list');
								break;

							// type: video
							case 'video':
									echo '<div data-video-url="'.$fields['fcs_sb_video']['v_video_url'].'"><img src="'.$fields['fcs_sb_video']['v_cover_image']['sizes']['sidebar-thumb'].'" alt="" /><div class="face-plate">';
									getIcon('play-media');
									echo '</div></div>';
								break;
							endswitch;
					}
					break;
				case 'person':

					if(is_data_okay('fcs_featured_spotlight', $fields)) {
						$spotlight = $fields['fcs_featured_spotlight'];
					}
					$image = get_the_post_thumbnail_url($spotlight->ID, 'sidebar-thumb');
					echo '<img class="spotlight-photo small-round-frame" src="'.$image.'" alt="" />';
					//
					break;
				} } ?></div>
			<?php } ?>
		</div>
	</div>

	<?php if($show_anchor) dropAnchor($anchor_count, $fields['bc_section_anchor']['label']); ?>

</section>
