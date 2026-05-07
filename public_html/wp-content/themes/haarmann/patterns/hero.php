<?php
/**
 * Title: Hero
 * Slug: haarmann/hero
 * Categories: haarmann, featured
 * Description: Vollbreites Hero im 16:9-Format mit Barbershop-Bild.
 * Keywords: hero, header, image
 * Block Types: core/cover
 * Viewport Width: 1280
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>","dimRatio":20,"focalPoint":{"x":0.5,"y":0.5},"aspectRatio":"16/9","contentPosition":"center center","isDark":true,"align":"full"} -->
<div class="wp-block-cover alignfull is-light" style="aspect-ratio:16/9">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim-20 has-background-dim"></span>
	<img class="wp-block-cover__image-background" alt="<?php esc_attr_e( 'Barbershop-Atmosphäre', 'haarmann' ); ?>" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>" data-object-fit="cover"/>
	<div class="wp-block-cover__inner-container">
		<!-- wp:paragraph {"align":"center","placeholder":""} -->
		<p class="has-text-align-center"></p>
		<!-- /wp:paragraph -->
	</div>
</div>
<!-- /wp:cover -->
