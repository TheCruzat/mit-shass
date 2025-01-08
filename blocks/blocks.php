<?php
/**
 * All of the custom Gutenberg blocks made by ACF
 *
 * @package shass
 */
namespace SHASS;

/**
 * Load Blocks
 */
function load_custom_blocks() {

	register_block_type( get_template_directory() . '/blocks/accordion-2col/block.json' );
	register_block_type( get_template_directory() . '/blocks/columns/block.json' );
	register_block_type( get_template_directory() . '/blocks/content-rows-w-sidebars/block.json' );
	register_block_type( get_template_directory() . '/blocks/content-rows-evens/block.json' );
	register_block_type( get_template_directory() . '/blocks/events-selector/block.json' );
	register_block_type( get_template_directory() . '/blocks/faq-accordion/block.json' );
	register_block_type( get_template_directory() . '/blocks/featured-content-w-sidebar/block.json' );
	register_block_type( get_template_directory() . '/blocks/featured-spotlights/block.json' );
	register_block_type( get_template_directory() . '/blocks/home-tabs/block.json' );
	register_block_type( get_template_directory() . '/blocks/jump-links/block.json' );
	register_block_type( get_template_directory() . '/blocks/link-list/block.json' );
	register_block_type( get_template_directory() . '/blocks/mosaic-hero/block.json' );
	register_block_type( get_template_directory() . '/blocks/multi-step-form/block.json' );
	register_block_type( get_template_directory() . '/blocks/news-overview/block.json' );
	register_block_type( get_template_directory() . '/blocks/news-block/block.json' );
	register_block_type( get_template_directory() . '/blocks/newsletter-overview/block.json' );
	register_block_type( get_template_directory() . '/blocks/newsletter-signup/block.json' );
	register_block_type( get_template_directory() . '/blocks/numbers-list/block.json' );
	register_block_type( get_template_directory() . '/blocks/page-header/block.json' );
	register_block_type( get_template_directory() . '/blocks/post-cards-w-pagination/block.json' );
	register_block_type( get_template_directory() . '/blocks/post-carousel/block.json' );
	register_block_type( get_template_directory() . '/blocks/quote-block/block.json' );
	register_block_type( get_template_directory() . '/blocks/row-title-content/block.json' );
	register_block_type( get_template_directory() . '/blocks/spotlight-alternator/block.json' );
	register_block_type( get_template_directory() . '/blocks/stats-4up/block.json' );
	register_block_type( get_template_directory() . '/blocks/team-overview/block.json' );
	register_block_type( get_template_directory() . '/blocks/timeline/block.json' );
	register_block_type( get_template_directory() . '/blocks/video/block.json' );

}
add_action( 'init', __NAMESPACE__ . '\load_custom_blocks' );

/**
 * Create custom block category for ACF blocks
 */
function custom_block_categories( $block_categories, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
			array_push(
					$block_categories,
					array(
							'slug'  => 'shass_page_blocks',
							'title' => __( 'SHASS Page Blocks', 'mit-ir' ),
							'icon'  => 'text-page',
					),
			);
	}
	return $block_categories;
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\custom_block_categories', 10, 2 );
