<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;



// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'jump-links sideline'; // Declare first classes

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'jumplinks_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

$has_quote = null;

if(is_data_okay('jl_quote', $fields)) {
	if( is_data_okay('qb_quote', $fields['jl_quote']) && is_data_okay('qb_name', $fields['jl_quote']) ) {
		$quo = $fields['jl_quote'];
		$has_quote = true;
		$custom_block_data['classes'] .= ' has-quote';
	}
}

?>
<section class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">

	<div class="block-content">
		<div class="jump-links--row">
		<?php
		if(is_data_okay('jl_label', $fields)) {
			echo '<span>'.$fields['jl_label'].'</span>';
		}
		if(is_data_okay('jl_links', $fields)) {
			foreach($fields['jl_links'] as $coun => $link) {
				if($coun == 0) $cla = ' class="sel"'; else $cla = '';
				echo '<a'.$cla.' href="#'.$link['target'].'"><span>'.('0'.($coun + 1)).'.</span>'.$link['label'].'</a>';
			}
		} ?>
		</div>

		<?php if( $has_quote ) { ?>
		<div class="jump-links--quote">
			<?php getIcon('quote'); ?>
			<div class="header"><?= $quo['qb_quote']; ?>”</div>
			<div class="quote-block--meta"><?= $quo['qb_name']; ?></div>
		</div>
		<?php } ?>

	</div>

</section>
