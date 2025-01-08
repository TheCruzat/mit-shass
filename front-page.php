<?php
/**
 * Custom Front Page
 *
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

get_header();
?>
<main id="main" class="site-main">
	<div id="content" <?php post_class('page-content page-content--full-width'); ?>>
		<?php
		while ( have_posts() ) : the_post();

			the_content();

		endwhile; // End of the loop.
		?>
	</div>
</main><!-- #main -->
<?php
get_footer();

