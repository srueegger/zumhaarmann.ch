<?php
/**
 * Title: Anreise / Adresse
 * Slug: haarmann/anreise
 * Categories: haarmann
 * Description: Adress- und Anreise-Sektion mit ÖV- und Park-Hinweisen.
 * Keywords: anreise, adresse, kontakt
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"dark-soft","textColor":"cream","layout":{"type":"constrained","contentSize":"720px"},"className":"section-anreise","metadata":{"name":"Anreise"}} -->
<section class="wp-block-group alignfull section-anreise has-cream-color has-dark-soft-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"textColor":"gold","fontSize":"xx-large","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"anchor":"anreise"} -->
	<h2 id="anreise" class="wp-block-heading has-text-align-center has-gold-color has-text-color has-xx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);letter-spacing:0.12em;text-transform:uppercase"><?php esc_html_e( 'Anreise', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"large","style":{"typography":{"fontWeight":"500"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}}} -->
	<p class="has-text-align-center has-large-font-size" style="margin-bottom:var(--wp--preset--spacing--40);font-weight:500"><?php esc_html_e( 'Im Eisernen Zeit 1, 8057 Zürich', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"fontSize":"medium","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}}} -->
			<h3 class="wp-block-heading has-medium-font-size" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Mit dem ÖV', 'haarmann' ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Tram 7, 8, 11, 14, 15, 17 bis Schaffhauserplatz. Bus 33 hält direkt um die Ecke.', 'haarmann' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"fontSize":"medium","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}}} -->
			<h3 class="wp-block-heading has-medium-font-size" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Mit dem Auto', 'haarmann' ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Parkplätze findest du in der blauen Zone rund um den Schaffhauserplatz sowie im Parkhaus Letzipark.', 'haarmann' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
