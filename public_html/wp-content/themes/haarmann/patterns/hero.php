<?php
/**
 * Title: Hero
 * Slug: haarmann/hero
 * Categories: haarmann, featured
 * Description: Vollbreites Hero mit Barbershop-Bild.
 * Keywords: hero, header, image
 * Block Types: core/cover
 * Viewport Width: 1280
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>","dimRatio":20,"focalPoint":{"x":0.5,"y":0.4},"minHeight":80,"minHeightUnit":"vh","contentPosition":"center center","isDark":true,"align":"full","style":{"color":{}}} -->
<div class="wp-block-cover alignfull is-light" style="min-height:80vh">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim-20 has-background-dim"></span>
	<img class="wp-block-cover__image-background" alt="<?php esc_attr_e( 'Barbershop-Atmosphäre', 'haarmann' ); ?>" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>" style="object-position:50% 40%" data-object-fit="cover" data-object-position="50% 40%"/>
	<div class="wp-block-cover__inner-container">
		<!-- wp:paragraph {"align":"center","placeholder":""} -->
		<p class="has-text-align-center"></p>
		<!-- /wp:paragraph -->
	</div>
</div>
<!-- /wp:cover -->
