<?php

if (!defined('ABSPATH')) {
    exit;
}

// outputs javascript in footer
if (!function_exists('popoverify_footer_script')) {

    function popoverify_footer_script()
    {
        if ($app = get_option('popoverify_app')) {
            echo '<script type="text/javascript">'
            . 'var _ppfy=_ppfy||{};_ppfy.app="' . $app . '";_ppfy.zone="' . get_option('popoverify_zone', 'eu') . '";'
            . '(function(d){var l=d.createElement("script");l.type="text/javascript";l.async=true;l.src="https://cdn.popoverify.com/provider/v1.js";var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(l,s);})(document);'
            . '</script>' . PHP_EOL;
        }
    }
    add_action('wp_footer', 'popoverify_footer_script');
}

// adds class to post wrapper
if (!function_exists('popoverify_add_post_class')) {

    function popoverify_add_post_class($list)
    {
        array_push($list, 'popoverify');
        return $list;
    }
}

// wraps content to popoverify div
if (!function_exists('popoverify_wrap2div')) {

    function popoverify_wrap2div($content)
    {
        return '<div class="popoverify">' . $content . '</div>';
    }
}

// wraps content to popoverify span
if (!function_exists('popoverify_wrap2span')) {

    function popoverify_wrap2span($content)
    {
        return '<span class="popoverify">' . $content . '</span>';
    }
}

// after parse query register filters
if (!function_exists('popoverify_after_parse_query')) {

    function popoverify_after_parse_query($wp_query)
    {
        if (is_home()) {
            if (get_option('popoverify_home')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        } elseif (is_archive()) {
            if (get_option('popoverify_posts_archive')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
            if (is_category() && get_option('popoverify_categories')) {
                add_filter('category_description', 'popoverify_wrap2div');
            }
        } elseif (is_single()) {
            if (get_option('popoverify_posts_detail')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        } elseif (is_page()) {
            if (get_option('popoverify_pages')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        }
        // woocommerce
        /*
          $plugins = get_option('active_plugins', array());
          if (in_array('woocommerce/woocommerce.php', $plugins)) {
          add_filter('product_cat_class', 'popoverify_add_post_class');
          }
          var_dump($wp_query);
          die;
         */
    }
    add_action('parse_query', 'popoverify_after_parse_query');
}
