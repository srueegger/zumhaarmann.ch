<?php
/**
 * Title: Galerie (Instagram)
 * Slug: haarmann/gallery
 * Categories: haarmann
 * Description: Galerie-Sektion mit Foto-Grid und Instagram-Link.
 * Keywords: galerie, gallery, instagram
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"dark","textColor":"cream","layout":{"type":"constrained"},"className":"section-gallery","metadata":{"name":"Galerie"}} -->
<section class="wp-block-group alignfull section-gallery has-cream-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"textColor":"gold","fontSize":"xx-large","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.06em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"galerie"} -->
	<h2 id="galerie" class="wp-block-heading has-text-align-center has-gold-color has-text-color has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);letter-spacing:0.06em;text-transform:uppercase"><?php esc_html_e( 'Galerie', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<!-- Elfsight Instagram Feed | Zum Haarmann -->
	<script src="https://elfsightcdn.com/platform.js" async></script>
	<div class="elfsight-app-d22037c2-f34c-47f1-9ae5-cc92d4be9cb8" data-elfsight-app-lazy></div>
	<!-- /wp:html -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="https://www.instagram.com/zumhaarmann" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Mehr auf Instagram', 'haarmann' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
