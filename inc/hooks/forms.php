<?php
/**
 * Master file for all "smaller" includes in inc
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

add_filter( 'gform_disable_form_theme_css', '__return_true' );

// Disable printing Gravity Forms js straight after <head> (invalid HTML)
add_filter( 'gform_force_hooks_js_output', '__return_false' );

add_filter( 'gform_required_legend', function( $legend, $form ) {
	return '<span class="gfield_required gfield_required_asterisk">*</span> Indicates required fields';
	//return 'your custom legend here';
}, 10, 2 );


