<?php
/**
 * Title: Hero
 * Slug: haarmann/hero
 * Categories: haarmann, featured
 * Description: Vollbreites Hero-Bild — Bild bestimmt die Höhe (16:9 oder was auch immer hochgeladen wird).
 * Keywords: hero, header, image
 * Block Types: core/image
 * Viewport Width: 1280
 */
?>
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","align":"full","className":"section-hero"} -->
<figure class="wp-block-image alignfull size-full section-hero"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Barbershop-Atmosphäre', 'haarmann' ); ?>"/></figure>
<!-- /wp:image -->
