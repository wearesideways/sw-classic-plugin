<?php

namespace Sideways\Classic\Seo;

use function the_seo_framework;

define( 'SWCLASSIC_SITE_SCHEMA_KEY', 'sc_site_custom_schema' );
define( 'SWCLASSIC_POST_SCHEMA_KEY', '_schema_markup' );

class SeoService {

    public function get_site_schema_markup(): ?string {
        if ( !defined( 'THE_SEO_FRAMEWORK_PRESENT' ) || !THE_SEO_FRAMEWORK_PRESENT ) return null;
        return the_seo_framework()->get_option( SWCLASSIC_SITE_SCHEMA_KEY, false );
    }

    public function get_post_schema_markup( int $post_id = 0 ): ?string {
        if ( !defined( 'THE_SEO_FRAMEWORK_PRESENT' ) || !THE_SEO_FRAMEWORK_PRESENT ) return null;
        return the_seo_framework()->get_post_meta_item( SWCLASSIC_POST_SCHEMA_KEY, $post_id, false );
    }
}