<?php
/*
 * Template Name: Go To First Child
 *
 */

wp_head();

global $post;

$kiddo = get_children([
	'posts_per_page' => 1,
	'order' => 'ASC',
	'post_parent' => $post->ID
	]);

if( $kiddo ) {
	foreach($kiddo as $kid) {
		$id = $kid->ID;
	}

}
?>
<html>
<head>
<meta http-equiv="refresh" content="0; URL=<?= get_the_permalink($id) ?>" />
</head>
</html>

