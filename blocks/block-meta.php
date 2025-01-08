<?php

global $anchor_count;

$custom_block_data['fields'] = $fields = \get_fields();
$custom_block_data['classes'] .= " block-vert-spacer";

if($fields) {

	// print_r($fields);

	if(array_key_exists('bc_section_anchor', $fields) && $fields['bc_section_anchor']['switch'] == true && !empty( $block['metadata']['name'] ) && $block['metadata']['name'] !== null) {
		$custom_block_data['classes'] .= " has-section-anchor";
		$show_anchor = true;
		$anchor_count += 1;
	} else {
		$show_anchor = false;
	}

	if(array_key_exists('bc_padding', $fields)) {
		switch($fields['bc_padding']['padding_top']) {
			case "half":
				$custom_block_data['classes'] .= ' pad-top-half';
				break;
			case "none";
				$custom_block_data['classes'] .= ' pad-top-none';
				break;
		}
		switch($fields['bc_padding']['padding_bottom']) {
			case "half":
				$custom_block_data['classes'] .= ' pad-bottom-half';
				break;
			case "none";
				$custom_block_data['classes'] .= ' pad-bottom-none';
				break;
		}
	}

	if(array_key_exists('bc_topline', $fields) && $fields['bc_topline'] != 'none') {
		$custom_block_data['classes'] .= " topline topline-".$fields['bc_topline'];
	}
}
