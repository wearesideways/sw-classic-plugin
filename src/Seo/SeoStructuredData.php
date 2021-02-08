<?php

namespace Sideways\Classic\Seo;

use Closure;

class SeoStructuredData
{
    private SeoService $seo_service;

    public function __construct() {
        $this->seo_service = new SeoService();
    }

    public function run(): void {
        // Filters for Plugin Metabox on Posts/Pages
        add_filter( 'the_seo_framework_inpost_seo_save_defaults', static function( $defaults ) {
            $defaults[SWCLASSIC_POST_SCHEMA_KEY] = '';
            return $defaults;
        } );

        add_filter( 'the_seo_framework_inpost_settings_tabs', function( $default_tabs ) {
            $default_tabs['schema'] = [
                'name'     => __( 'Schema', '_h' ),
                'callback' => Closure::fromCallable( [ $this, 'page_schema_metabox' ] ),
                'dashicon' => 'feedback',
            ];
            return $default_tabs;
        } );

        add_filter( 'the_seo_framework_save_post_meta', static function( $data ) {
            $data[SWCLASSIC_POST_SCHEMA_KEY] = $_POST['autodescription'][SWCLASSIC_POST_SCHEMA_KEY];
            return $data;
        } );

        // Filters for Plugin Settings Page
        add_filter( 'the_seo_framework_default_site_options', static function( array $settings ) {
            $settings[SWCLASSIC_SITE_SCHEMA_KEY] = '';
            return $settings;
        } );

        add_filter( 'the_seo_framework_schema_settings_tabs', function() {
            $custom_tabs['custom_structure'] = [
                'name'     => __( 'Custom Schema Structure', '_sc' ),
                'callback' => Closure::fromCallable( [ $this, 'site_schema_admin_field' ] ),
                'dashicon' => 'feedback',
            ];
            return $custom_tabs;
        } );
    }

    private function page_schema_metabox() {
        ?>
        <div class="tsf-flex-setting tsf-flex">
            <div class="tsf-flex-setting-label tsf-flex">
                <div class="tsf-flex-setting-label-inner-wrap tsf-flex">
                    <label for="autodescription_schema" class="tsf-flex-setting-label-item tsf-flex">
                        <span><strong><?php esc_html_e( 'Schema Markup', 'autodescription' ); ?></strong></span>
                    </label>
                </div>
            </div>
            <div class="tsf-flex-setting-input tsf-flex">
                <textarea class="large-text" name="autodescription[_schema_markup]"
                          id="autodescription_schema" rows="10" cols="4"
                          autocomplete=off><?php echo esc_textarea($this->seo_service->get_post_schema_markup()) ?></textarea>
            </div>
        </div>
        <?php
    }

    private function site_schema_admin_field() {
        ?>
        <p>
            <label for="<?php echo esc_attr(SWCLASSIC_SITE_SCHEMA_KEY) ?>">
                <strong><?php esc_html_e( 'Global Custom Schema Markup', 'autodescription' ); ?></strong>
            </label>
            <textarea name="autodescription-site-settings[<?php echo esc_attr(SWCLASSIC_SITE_SCHEMA_KEY) ?>]"
                      class="large-text" id="<?php echo esc_attr(SWCLASSIC_SITE_SCHEMA_KEY) ?>" rows="10" cols="4"
                      autocomplete=off><?php echo esc_textarea($this->seo_service->get_site_schema_markup()) ?></textarea>
        </p>
        <?php
    }
}
