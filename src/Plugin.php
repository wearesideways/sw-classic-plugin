<?php

namespace Sideways\Classic;

use Sideways\Classic\Users\AdminUsers;

class Plugin
{
    public string $name = 'sw-classic';

    public string $version = '1.0.0';

    public function run(): void
    {
        $adminAssets = new AdminAssets($this);
        $adminAssets->run();

        $adminUsers = new AdminUsers();
        $adminUsers->run();
    }
}
