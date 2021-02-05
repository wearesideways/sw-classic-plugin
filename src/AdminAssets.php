<?php


namespace Sideways\Classic;

class AdminAssets
{
    private Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function run(): void
    {
        \add_action('admin_enqueue_scripts', \Closure::fromCallable([$this, 'enqueueAssets']));
    }

    private function enqueueAssets(): void
    {
        wp_enqueue_script($this->plugin->name, plugins_url('dist/sw-classic.js', __DIR__), [], $this->plugin->version, true);
        wp_enqueue_style($this->plugin->name, plugins_url('dist/sw-classic.css', __DIR__), [], $this->plugin->version);
    }

}
