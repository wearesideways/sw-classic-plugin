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
        \add_filter('script_loader_tag', \Closure::fromCallable([$this, 'addScriptModuleAttribute']), 10, 3);
    }

    private function enqueueAssets(): void
    {
        wp_enqueue_script($this->plugin->name, plugins_url('assets/sw-classic.js', __DIR__), [], $this->plugin->version, true);
        wp_enqueue_style($this->plugin->name, plugins_url('assets/sw-classic.css', __DIR__), [], $this->plugin->version);
    }

    private function addScriptModuleAttribute(string $tag, string $handle, string $src): string
    {
        if ($handle === $this->plugin->name) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }
}
