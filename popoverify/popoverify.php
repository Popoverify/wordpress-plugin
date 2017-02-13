<?php

/**
 * Plugin name: Popoverify
 * Plugin URI: https://github.com/Popoverify/wordpress-plugin
 * Description: <strong>Official plugin for integration with Popoverify</strong> - your inline wiki and an easy way how to improve user experience of your website. It allows you to create context help and connect it to your website with ease.
 * Version: 1.0.0
 * Author: Popoverify Ltd
 * Author URI: https://www.popoverify.com
 * Requires at least: 3.0
 */
if (!defined('ABSPATH')) {
    exit;
}

// define plugin base name
if (!defined('POPOVERIFY_PLUGIN_BASE_NAME')) {
    define('POPOVERIFY_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
}

// after all active plugins are loaded
if (!function_exists('popoverify_after_plugins_loaded')) {

    function popoverify_after_plugins_loaded()
    {
        if (!defined('POPOVERIFY_PLUGIN_WOOCOMMERCE')) {
            $plugins = get_option('active_plugins', array());
            define('POPOVERIFY_PLUGIN_WOOCOMMERCE', in_array('woocommerce/woocommerce.php', $plugins));
        }
    }
    add_action('plugins_loaded', 'popoverify_after_plugins_loaded');
}

// include admin functions
if (is_admin()) {
    include_once(plugin_dir_path(__FILE__) . 'includes/popoverify-admin.php');
}
// include front-end functions
else {
    include_once(plugin_dir_path(__FILE__) . 'includes/popoverify-front-end.php');
}
