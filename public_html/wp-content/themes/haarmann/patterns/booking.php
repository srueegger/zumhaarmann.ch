<?php
/**
 * Title: Termin vereinbaren
 * Slug: haarmann/booking
 * Categories: haarmann
 * Description: Beige Buchungs-Sektion mit zwei Buttons (online und telefonisch).
 * Keywords: termin, buchen, booking
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"beige","textColor":"dark","layout":{"type":"constrained","contentSize":"640px"},"className":"section-booking","metadata":{"name":"Termin vereinbaren"}} -->
<section class="wp-block-group alignfull section-booking has-dark-color has-beige-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"xx-large","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"termin"} -->
	<h2 id="termin" class="wp-block-heading has-text-align-center has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);letter-spacing:0.12em;text-transform:uppercase"><?php esc_html_e( 'Termin vereinbaren', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"large","style":{"typography":{"lineHeight":"1.55"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}}} -->
	<p class="has-text-align-center has-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);line-height:1.55"><?php esc_html_e( 'Hier findest du meine Buchungsplattform und meine aktuellen freien Termine. Wähle einfach deinen Wunschtermin aus.', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"width":50} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-50"><a class="wp-block-button__link wp-element-button" href="https://booksy.com/de-de/" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Online buchen', 'haarmann' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"width":50} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-50"><a class="wp-block-button__link wp-element-button" href="tel:+41000000000"><?php esc_html_e( 'Telefonisch buchen', 'haarmann' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
