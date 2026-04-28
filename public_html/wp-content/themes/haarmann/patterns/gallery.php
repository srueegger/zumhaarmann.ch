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
	<!-- wp:heading {"textAlign":"center","level":2,"textColor":"gold","fontSize":"xx-large","fontFamily":"subhead","style":{"typography":{"fontWeight":"500","letterSpacing":"0.02em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"galerie"} -->
	<h2 id="galerie" class="wp-block-heading has-text-align-center has-gold-color has-text-color has-subhead-font-family has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);font-weight:500;letter-spacing:0.02em"><?php esc_html_e( 'Galerie', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:gallery {"columns":3,"linkTo":"none","sizeSlug":"medium","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20","top":"var:preset|spacing|20"}}}} -->
	<figure class="wp-block-gallery alignwide has-nested-images columns-3 is-cropped">
		<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
		<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/gallery-1.jpg' ) ); ?>" alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
		<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/gallery-2.jpg' ) ); ?>" alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
		<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/gallery-3.jpg' ) ); ?>" alt=""/></figure>
		<!-- /wp:image -->
	</figure>
	<!-- /wp:gallery -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="https://www.instagram.com/zumhaarmann" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Mehr auf Instagram', 'haarmann' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
