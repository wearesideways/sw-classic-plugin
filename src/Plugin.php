<?php

namespace Sideways\Classic;

use Sideways\Classic\Seo\SeoStructuredData;

class Plugin
{
    public string $name = 'sw-classic';

    public string $version = '1.0.0';

    public function run(): void
    {
        $adminAssets = new AdminAssets($this);
        $adminAssets->run();

        $seoPluginMods = new SeoStructuredData();
        $seoPluginMods->run();
    }
}
