<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

// INIT Grab fields
$footer_hat = array(); // Store all values in an array for the block
$footer_hat['classes'] = 'newsletter-signup sideline dimline'; // Declare first classes
$footer_hat['fields'] = \get_field('newsletter_group', 'Options');

?>
<section class="<?php echo esc_html( $footer_hat['classes'] ); ?>">

	<img class="newsletter-signup-bg" src="<?= $footer_hat['fields']['image']['sizes']['large'] ?>" alt="" />

	<div class="block-content">
		<div>
			<?php if(is_data_okay('newsletter_group_bc_title', $footer_hat['fields'])) { ?>
				<h2 class="header"><?= $footer_hat['fields']['newsletter_group_bc_title'] ?></h2>
			<?php } ?>

			<?php if(is_data_okay('newsletter_group_bc_intro', $footer_hat['fields'])) { ?>
			<div class="newsletter-content">
				<?= $footer_hat['fields']['newsletter_group_bc_intro'] ?>
			</div>
			<?php } ?>

			<?php if(is_data_okay('newsletter_group_link', $footer_hat['fields'])) { ?>
			<div class="newsletter-cta">
				<?= makeLink($footer_hat['fields']['newsletter_group_link'], 'icon-link arrow-east') ?>
			</div>
			<?php } ?>
		</div>

<div id="mc_embed_shell">
	<div id="mc_embed_signup">
    <form action="https://mit.us1.list-manage.com/subscribe/post?u=9be039b955f2b6393bc7798d7&amp;id=d5bbe51b53&amp;f_id=00ccc2e1f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_self" novalidate="">
      <div id="mc_embed_signup_scroll">

        <div class="mc-field-group">
        	<label for="mce-MMERGE4">
        		<span>Name</span>
        		<input type="text" name="MMERGE4" class=" text" id="mce-MMERGE4" value="">
        	</label>
        </div>

        <div class="mc-field-group" style="margin-bottom: 2.5rem">
        	<label for="mce-EMAIL">
        		<span class="asterisk">Email Address *</span>
        		<input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value="">
        	</label>
        </div>

        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display: none;"></div>
            <div class="response" id="mce-success-response" style="display: none;"></div>
        </div>

        <div aria-hidden="true" style="position: absolute; left: -5000px;">
        	<input type="text" name="b_9be039b955f2b6393bc7798d7_d5bbe51b53" tabindex="-1" value="">
        </div>

        <div class="clear" style="margin-bottom: 1.5rem">
        	<input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Sign Up for the SHASS Newsletter">
      	</div>

        <div class="indicates-required">
        	<span class="asterisk">*</span> indicates required
        </div>
    </div>
</form>
</div>
</div>

	</div>

</section>
