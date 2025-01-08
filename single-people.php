<?php
/**
 * Person Single
 *
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

get_header();
$fields = get_fields();

$term = get_the_terms($post, 'people-categories');
$back = get_field('taxonomy_listing_page', $term[0]);

?>
<main id="main" class="site-main">
	<?php if($back) { ?>
	<div class="single-header sideline purple">
		<div class="block-content">
			<a href="<?= get_permalink($back[0]->ID) ?>" class="icon-link arrow-west"><?= $back[0]->post_title; ?></a>
		</div>
	</div>
	<?php } ?>
	<div id="content" <?php post_class('page-content page-content--full-width sideline'); ?>>
		<div class="block-content">
		<?php

		echo '<h1 class="page-title header">' . get_the_title() . '</h1>';
		echo '<div>'.cn($fields['person_role']).'</div>';

		while ( have_posts() ) : the_post();
		echo '<div class="content-frame">';
			the_post_thumbnail('medium_large');

		echo '<div class="single-content body-content">';
			the_content();
		echo '</div>';
		echo '</div>';
		endwhile; // End of the loop.
		?>

		<?php if($back) { ?>
		<a href="<?= get_permalink($back[0]->ID) ?>" class="icon-link arrow-east">Explore other <?= $term[0]->name ?> Spotlights</a>
		<?php } ?>

		</div>
	</div>
</main>
<?php
get_footer();
