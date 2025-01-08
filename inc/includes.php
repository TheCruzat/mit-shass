<?php
/**
 * Master file for all "smaller" includes in inc
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

foreach([
	'/inc/includes/cpt-tax.php',
	'/inc/custom-fixes.php',
	'/inc/functions/custom-func.php',
	'/inc/includes/ajax.php',
	'/inc/hooks/forms.php'
] as $file) {
	if( file_exists( get_theme_file_path( $file ) ) ) {
		require get_theme_file_path($file);
	}
}


