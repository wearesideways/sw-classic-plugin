<?php
/**
 * Plugin Name: Sideways Classic
 * Description: Sideways Classic functionality
 * Author: Sideways NYC
 * Author URI: http://sideways-nyc.com
 * Version: 1.0.0
 *
 * @package Sideways\Classic
 */

namespace Sideways\Classic;

add_action('plugins_loaded', [ new Plugin(), 'run' ]);
