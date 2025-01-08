<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;


// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'multi-step-form sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'multistepform_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

// pr($fields);
?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">

		<?php

		if(is_data_okay('msf_form_shortcode', $fields)) {
			ecn($fields['msf_form_shortcode']);
		}

		?>

	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function(e) {

			document.querySelector('#gform_next_button_1_5').setAttribute('value', 'Step 2. Proposal information');
			document.querySelector('#gform_next_button_1_7').setAttribute('value', 'Step 3. Budget information');
			document.querySelector('#gform_submit_button_1').setAttribute('value', 'Submit application');

		});
	</script>
</section>
