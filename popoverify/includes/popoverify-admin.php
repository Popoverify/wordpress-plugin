<?php

if (!defined('ABSPATH')) {
    exit;
}

// adds submenu to Settings menu
if (!function_exists('popoverify_add_options_page')) {

    function popoverify_add_options_page()
    {
        add_options_page('Popoverify', 'Popoverify', 'manage_options', 'popoverify', 'popoverify_render_options_page');
    }
    add_action('admin_menu', 'popoverify_add_options_page');
}

// registers plugin settings
if (!function_exists('popoverify_register_settings')) {

    function popoverify_register_settings()
    {
        register_setting('popoverify-settings', 'popoverify_app', 'popoverify_sanitize_setting');
        register_setting('popoverify-settings', 'popoverify_zone', 'popoverify_sanitize_setting');
        register_setting('popoverify-settings', 'popoverify_home', 'intval');
        register_setting('popoverify-settings', 'popoverify_posts_archive', 'intval');
        register_setting('popoverify-settings', 'popoverify_posts_detail', 'intval');
        register_setting('popoverify-settings', 'popoverify_categories', 'intval');
        register_setting('popoverify-settings', 'popoverify_pages', 'intval');
    }
    add_action('admin_init', 'popoverify_register_settings');
}

// sanitize input
if (!function_exists('popoverify_sanitize_setting')) {

    function popoverify_sanitize_setting($value)
    {
        return preg_replace('![^a-zA-Z0-9/]+!', '', $value);
    }
}

// plugin options page
if (!function_exists('popoverify_render_options_page')) {

    function popoverify_render_options_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        echo '<div class="wrap">'
        . '<h1><a href="https://www.popoverify.com/ref/1000" target="_blank"><img src="' . plugins_url('popoverify/public/images/logo.png') . '" style="max-width:300px;" /></a></h1>'
        . '<p style="font-size:16px;">Your inline wiki and an easy way how to increase user experiance of your website. Popoverify allows you to <strong>connect glossary of terms directly to your website</strong> as contextual help on mouse over or on touch effect.</p>'
        . '<p style="font-size:16px;">Don\'t have a Popoverify account yet? <a href="https://www.popoverify.com/ref/1000" target="_blank"><strong>Create new account</strong></a> and <strong>try it for FREE</strong>.</p>'
        . '<form method="post" action="options.php">';

        settings_fields('popoverify-settings');
        do_settings_sections('popoverify-settings');

        $zone = get_option('popoverify_zone', 'eu');
        $mode = get_option('popoverify_mode', 'auto');

        echo '<table class="form-table">'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_app">Application ID</label></th>'
        . '<td>'
        . '<input id="popoverify_app" type="text" name="popoverify_app" value="' . esc_attr(get_option('popoverify_app', '')) . '" />'
        . '<p class="description">ID can be found under Applications in your <a href="https://www.popoverify.com/account">Popoverify account</a>.</p>'
        . '</td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_zone">Website zone</label></th>'
        . '<td>'
        . '<select id="popoverify_zone" name="popoverify_zone">'
        . '<option value="af"' . ($zone == 'af' ? ' selected="selected"' : '') . '>Africa</option>'
        . '<option value="as"' . ($zone == 'as' ? ' selected="selected"' : '') . '>Asia</option>'
        . '<option value="eu"' . ($zone == 'eu' ? ' selected="selected"' : '') . '>Europe</option>'
        . '<option value="na"' . ($zone == 'na' ? ' selected="selected"' : '') . '>North America</option>'
        . '<option value="oc"' . ($zone == 'oc' ? ' selected="selected"' : '') . '>Oceania</option>'
        . '<option value="sa"' . ($zone == 'sa' ? ' selected="selected"' : '') . '>South America</option>'
        . '</select>'
        . '<p class="description">The continent on which it is located server that is hosting your website.</p>'
        . '</td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_posts_detail">Parse post detail</label></th>'
        . '<td><label>'
        . '<input type="checkbox" id="popoverify_posts_detail" name="popoverify_posts_detail" value="1"' . (get_option('popoverify_posts_detail') == '1' ? ' checked="checked"' : '') . ' /> '
        . '<span class="description">recommended</span>'
        . '</label></td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_categories">Parse category description</label></th>'
        . '<td><label>'
        . '<input type="checkbox" id="popoverify_categories" name="popoverify_categories" value="1"' . (get_option('popoverify_categories') == '1' ? ' checked="checked"' : '') . ' /> '
        . '<span class="description">recommended</span>'
        . '</label></td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_home">Parse posts in homepage</label></th>'
        . '<td>'
        . '<input type="checkbox" id="popoverify_home" name="popoverify_home" value="1"' . (get_option('popoverify_home') == '1' ? ' checked="checked"' : '') . ' />'
        . '</td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_posts_archive">Parse posts in archive</label></th>'
        . '<td>'
        . '<input type="checkbox" id="popoverify_posts_archive" name="popoverify_posts_archive" value="1"' . (get_option('popoverify_posts_archive') == '1' ? ' checked="checked"' : '') . ' />'
        . '</td>'
        . '</tr>'
        . '<tr valign="top">'
        . '<th scope="row"><label for="popoverify_pages">Parse pages</label></th>'
        . '<td>'
        . '<input type="checkbox" id="popoverify_pages" name="popoverify_pages" value="1"' . (get_option('popoverify_pages') == '1' ? ' checked="checked"' : '') . ' />'
        . '</td>'
        . '</tr>'
        . '</table>' . PHP_EOL;

        submit_button();

        echo '</form>'
        . '</div>';
    }
}
