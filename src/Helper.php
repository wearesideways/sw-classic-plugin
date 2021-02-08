<?php

namespace Sideways\Classic;

use Sideways\Classic\Seo\SeoService;

class Helper
{
    function getSiteSchemaMarkup(): ?string
    {
        $seoService = new SeoService();
        return $seoService->getSiteSchemaMarkup();
    }

    function getPostSchemaMarkup(int $postId = 0): ?string
    {
        $seoService = new SeoService();
        return $seoService->getPostSchemaMarkup($postId);
    }
}