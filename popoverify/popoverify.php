<?php

/**
 * Plugin name: Popoverify
 * Plugin URI: https://github.com/Popoverify/wordpress-plugin
 * Description: <strong>Official plugin for integration with Popoverify</strong> - your inline wiki and an easy way how to improve user experience of your website which allows you to connect glossary of terms directly to your website as contextual help on mouse over or on touch effect.
 * Version: 1.0.0
 * Author: Popoverify Ltd
 * Author URI: https://www.popoverify.com
 * Requires at least: 3.0
 */
if (!defined('ABSPATH')) {
    exit;
}

define('POPOVERIFY_PLUGIN_BASE_NAME', plugin_basename(__FILE__));

// include admin functions
if (is_admin()) {
    include_once(plugin_dir_path(__FILE__) . 'includes/popoverify-admin.php');
}
// include front-end functions
else {
    include_once(plugin_dir_path(__FILE__) . 'includes/popoverify-front-end.php');
}
