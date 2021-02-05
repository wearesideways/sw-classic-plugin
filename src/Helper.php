<?php

namespace Sideways\Classic;

class Helper
{
    function getSiteSchemaMarkup(): ?string
    {
        $seoService = new Seo\SeoService();
        return $seoService->getSiteSchemaMarkup();
    }

    function getPostSchemaMarkup(int $postId = 0): ?string
    {
        $seoService = new Seo\SeoService();
        return $seoService->getPostSchemaMarkup($postId);
    }
}