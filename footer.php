<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #primary div and all content after.
 *
 * @package shass
 * @since 0.0.1
 */

namespace SHASS;

$ftr = array(); // Store all values in an array for this file
$ftr['classes'] = 'site-footer dark sideline'; // Declare footer classes
$ftr['switch'] = \get_field('hide_signup');

$socials = get_field('social_links', 'Options');

if(!$ftr['switch']) require get_template_directory() . '/blocks/newsletter-signup/render.php'; ?>

	</div>
	<footer id="colophon" class="<?php echo $ftr['classes']; ?>">
		<div class="site-footer__contain">
			<div class="site-footer__top">
				<div class="site-footer--info">
					<div class="site-footer--logo">
						<a href="<?php echo esc_url( home_url() ); ?>" class="ftr-logo__link"><span class="screen-reader-text">MIT Office of the Provost</span><?php include "assets/logos/shass-logo.svg" ?></a>
					</div>
					<div class="site-footer--address">
						<strong>Massachusetts Institute of Technology</strong><br>
						77 Massachusetts Avenue, Building 4-240<br>
						Cambridge, MA 02139<br>
						<a href="mailto:shass-info@mit.edu">shass-info@mit.edu</a>

						<?php /*echo wp_kses_post($ftr['info']); */?>
					</div>
				</div>
				<div class="site-footer--nav">
					<?php	if ( has_nav_menu( 'secondary' ) ) : ?>
					<nav class="site-footer--menu" aria-label="Site Navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'secondary',
								// 'menu_id'        => 'footer-menu',
								'menu_class'     => 'footer-menu-items wp-menu',
								'container' 		 => false,
								'depth'					 => 1
							)
						);
						?>
					</nav>
					<?php endif; ?>
				</div>

				<?php if($socials) { ?>
				<div class="site-footer--social">
					<?php foreach($socials as $coun => $link) { // pr($link); ?>
						<a href="<?= $link['url'] ?>" target="_blank"><?php getIcon($link['icon']); ?></a>
					<?php } ?>
				</div>
				<?php }/**/ ?>
			</div>
			<div class="site-footer__bottom-line">
				<div class="solum-copy"><a href="https://accessibility.mit.edu" target="_blank">Accessibility</a></div>
				<div class="solum-copy"><span class="copyright">&copy; <?php echo date("Y"); ?> <?php echo 'MIT'; ?></span></div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div id="lb"></div>

<?php wp_footer(); ?>
</body>
</html>
