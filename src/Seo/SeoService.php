<?php

namespace Sideways\Classic\Seo;

use function the_seo_framework;

define( 'SWCLASSIC_SITE_SCHEMA_KEY', 'sc_site_custom_schema' );
define( 'SWCLASSIC_POST_SCHEMA_KEY', '_schema_markup' );

class SeoService {

    public function getSiteSchemaMarkup(): ?string {
        if ( !defined( 'THE_SEO_FRAMEWORK_PRESENT' ) || !THE_SEO_FRAMEWORK_PRESENT ) return null;
        return the_seo_framework()->get_option( SWCLASSIC_SITE_SCHEMA_KEY, false );
    }

    /**
     * $postId param is used to fetch the schema from a specific post,
     * if none is sent then the `get_post_meta_item` will internally use
     * WP functions to get the current post ID
     *
     * @param int $postId
     * @return string|null
     */
    public function getPostSchemaMarkup( int $postId = 0 ): ?string {
        if ( !defined( 'THE_SEO_FRAMEWORK_PRESENT' ) || !THE_SEO_FRAMEWORK_PRESENT ) return null;
        return the_seo_framework()->get_post_meta_item( SWCLASSIC_POST_SCHEMA_KEY, $postId, false );
    }
}