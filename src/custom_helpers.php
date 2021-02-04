<?php

// All functions should be prefixed with "sc_"

function sc_get_site_schema_markup(): ?string {
    $seoService = new Sideways\Classic\Seo\SeoService();
    return $seoService->get_site_schema_markup();
}

function sc_get_post_schema_markup(int $post_id = 0 ): ?string {
    $seoService = new Sideways\Classic\Seo\SeoService();
    return $seoService->get_post_schema_markup();
}