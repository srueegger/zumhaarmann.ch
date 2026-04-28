<?php
/**
 * Title: Über mich
 * Slug: haarmann/about
 * Categories: haarmann
 * Description: Helle "Über mich"-Sektion mit Foto und Fliesstext.
 * Keywords: about, über mich, portrait
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"white","textColor":"dark","layout":{"type":"constrained"},"className":"section-about","metadata":{"name":"Über mich"}} -->
<section class="wp-block-group alignfull section-about has-dark-color has-white-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"xx-large","fontFamily":"subhead","style":{"typography":{"fontWeight":"500","letterSpacing":"0.02em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"ueber-mich"} -->
	<h2 id="ueber-mich" class="wp-block-heading has-text-align-center has-subhead-font-family has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);font-weight:500;letter-spacing:0.02em"><?php esc_html_e( 'Über mich', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:image {"align":"center","sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"4px"}}} -->
	<figure class="wp-block-image aligncenter size-large has-custom-border"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Matthis Latscha', 'haarmann' ); ?>" style="border-radius:4px"/></figure>
	<!-- /wp:image -->

	<!-- wp:paragraph {"align":"center","fontSize":"medium","style":{"typography":{"lineHeight":"1.7"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<p class="has-text-align-center has-medium-font-size" style="margin-top:var(--wp--preset--spacing--40);line-height:1.7"><?php esc_html_e( 'Mit über zehn Jahren Erfahrung im Handwerk verbinde ich klassische Schnitttechniken mit zeitgenössischen Looks. Echte Leidenschaft, ehrliche Beratung und handwerkliche Präzision für jeden Kopf, der bei mir landet.', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"align":"center","fontSize":"medium","style":{"typography":{"fontStyle":"italic"}}} -->
	<p class="has-text-align-center has-medium-font-size" style="font-style:italic"><?php esc_html_e( '— Matthis Latscha', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
