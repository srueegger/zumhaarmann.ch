<?php
/**
 * Title: Willkommen
 * Slug: haarmann/welcome
 * Categories: haarmann
 * Description: Dunkle Willkommens-Sektion mit zentriertem Heading und Fliesstext.
 * Keywords: willkommen, intro, welcome
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"dark","textColor":"cream","layout":{"type":"constrained","contentSize":"640px"},"className":"section-willkommen","metadata":{"name":"Willkommen"}} -->
<section class="wp-block-group alignfull section-willkommen has-cream-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"textColor":"gold","fontSize":"xx-large","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"willkommen"} -->
	<h2 id="willkommen" class="wp-block-heading has-text-align-center has-gold-color has-text-color has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);letter-spacing:0.12em;text-transform:uppercase"><?php esc_html_e( 'Willkommen', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"large","style":{"typography":{"lineHeight":"1.55"}}} -->
	<p class="has-text-align-center has-large-font-size" style="line-height:1.55"><?php esc_html_e( 'Vom klassischen Façon zum trendigen Mullet, vom Vollbart zum Schnauzer bis zur klassischen Hot Towel Nassrasur — für jeden ist etwas dabei.', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
