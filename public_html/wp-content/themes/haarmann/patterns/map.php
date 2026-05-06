<?php
/**
 * Title: Karte
 * Slug: haarmann/map
 * Categories: haarmann
 * Description: Vollbreite Google-Maps-Einbettung (dunkel gestylt) für die Studio-Adresse. API-Key, Adresse und Koordinaten kommen aus wp_options bzw. der Konstante HAARMANN_GMAPS_API_KEY.
 * Keywords: karte, map, google maps, standort
 */

$api_key   = haarmann_get_gmaps_api_key();
$address   = haarmann_get_gmaps_address();
$query     = rawurlencode( $address );
$maps_link = 'https://maps.google.com/?q=' . $query;
?>
<!-- wp:group {"tagName":"section","align":"full","backgroundColor":"dark","className":"section-map","metadata":{"name":"Karte"}} -->
<section class="wp-block-group alignfull section-map has-dark-background-color has-background">
	<?php if ( $api_key ) : ?>
	<!-- wp:html -->
	<div id="haarmann-map" class="haarmann-map" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Karte: %s', 'haarmann' ), $address ) ); ?>"></div>
	<!-- /wp:html -->
	<?php else : ?>
	<!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
	<p class="has-text-align-center" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><a href="<?php echo esc_url( $maps_link ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Auf Google Maps öffnen', 'haarmann' ); ?></a></p>
	<!-- /wp:paragraph -->
	<?php endif; ?>
</section>
<!-- /wp:group -->
