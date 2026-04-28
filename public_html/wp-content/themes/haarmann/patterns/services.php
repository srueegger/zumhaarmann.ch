<?php
/**
 * Title: Services / Preisliste
 * Slug: haarmann/services
 * Categories: haarmann
 * Description: Preisliste mit drei Gruppen (Haare, Bart, Kombi) und goldenen Trennlinien.
 * Keywords: services, preise, preisliste
 */
?>
<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"dark","textColor":"cream","layout":{"type":"constrained","contentSize":"560px"},"className":"section-services","metadata":{"name":"Services"}} -->
<section class="wp-block-group alignfull section-services has-cream-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"textAlign":"center","level":2,"textColor":"gold","fontSize":"xx-large","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em"}},"anchor":"services"} -->
	<h2 id="services" class="wp-block-heading has-text-align-center has-gold-color has-text-color has-xx-large-font-size" style="letter-spacing:0.12em;text-transform:uppercase"><?php esc_html_e( 'Services', 'haarmann' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}},"className":"price-list price-list--haare","layout":{"type":"constrained"}} -->
	<div class="wp-block-group price-list price-list--haare">
		<!-- wp:heading {"level":3,"textColor":"cream","fontSize":"medium","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} -->
		<h3 class="wp-block-heading has-cream-color has-text-color has-medium-font-size" style="margin-bottom:var(--wp--preset--spacing--20);font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Haare', 'haarmann' ); ?></h3>
		<!-- /wp:heading -->

		<?php
		$haare = array(
			array( 'Haarschnitt', 73 ),
			array( 'Maschinen Haarschnitt', 47 ),
			array( 'Seiten auffrischen', 47 ),
			array( 'Kopfrasur', 73 ),
		);
		foreach ( $haare as $row ) :
			[ $name, $price ] = $row;
		?>
		<!-- wp:group {"className":"price-list__row","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"bottom":{"color":"var:preset|color|gold","width":"1px"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
		<div class="wp-block-group price-list__row" style="border-bottom-color:var(--wp--preset--color--gold);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">
			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo esc_html( $name ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo (int) $price; ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}},"className":"price-list price-list--bart","layout":{"type":"constrained"}} -->
	<div class="wp-block-group price-list price-list--bart">
		<!-- wp:heading {"level":3,"textColor":"cream","fontSize":"medium","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} -->
		<h3 class="wp-block-heading has-cream-color has-text-color has-medium-font-size" style="margin-bottom:var(--wp--preset--spacing--20);font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Bart', 'haarmann' ); ?></h3>
		<!-- /wp:heading -->

		<?php
		$bart = array(
			array( 'Bartschnitt', 55 ),
			array( 'Nassrasur (inkl. Schnauz)', 73 ),
		);
		foreach ( $bart as $row ) :
			[ $name, $price ] = $row;
		?>
		<!-- wp:group {"className":"price-list__row","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"bottom":{"color":"var:preset|color|gold","width":"1px"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
		<div class="wp-block-group price-list__row" style="border-bottom-color:var(--wp--preset--color--gold);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">
			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo esc_html( $name ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo (int) $price; ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}},"className":"price-list price-list--kombi","layout":{"type":"constrained"}} -->
	<div class="wp-block-group price-list price-list--kombi">
		<!-- wp:heading {"level":3,"textColor":"cream","fontSize":"medium","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} -->
		<h3 class="wp-block-heading has-cream-color has-text-color has-medium-font-size" style="margin-bottom:var(--wp--preset--spacing--20);font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Kombinationen', 'haarmann' ); ?></h3>
		<!-- /wp:heading -->

		<?php
		$kombi = array(
			array( 'Haarschnitt & Bart', 108 ),
			array( 'Maschinen Haarschnitt & Bart', 88 ),
			array( 'Seiten auffrischen & Bart', 88 ),
			array( 'Kopfrasur & Bart', 108 ),
		);
		foreach ( $kombi as $row ) :
			[ $name, $price ] = $row;
		?>
		<!-- wp:group {"className":"price-list__row","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"bottom":{"color":"var:preset|color|gold","width":"1px"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
		<div class="wp-block-group price-list__row" style="border-bottom-color:var(--wp--preset--color--gold);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">
			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo esc_html( $name ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
			<p class="has-large-font-size" style="margin-top:0;margin-bottom:0"><?php echo (int) $price; ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"align":"center","fontSize":"small","style":{"typography":{"fontStyle":"italic"},"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
	<p class="has-text-align-center has-small-font-size" style="margin-top:var(--wp--preset--spacing--30);font-style:italic"><?php esc_html_e( 'Alle Preise in CHF inkl. MwSt.', 'haarmann' ); ?></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
