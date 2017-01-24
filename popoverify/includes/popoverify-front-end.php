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

// prints starting div for popoverify
if (!function_exists('popoverify_print_div_start')) {

    function popoverify_print_div_start()
    {
        echo '<div class="popoverify">' . PHP_EOL;
    }
}

// prints ending div for popoverify
if (!function_exists('popoverify_print_div_end')) {

    function popoverify_print_div_end()
    {
        echo '</div>' . PHP_EOL;
    }
}

// after parse query register filters
if (!function_exists('popoverify_after_wp')) {

    function popoverify_after_wp($wp_query)
    {
        if (defined('POPOVERIFY_PLUGIN_WOOCOMMERCE') && POPOVERIFY_PLUGIN_WOOCOMMERCE == true) {
            $is_woo = true;
        } else {
            $is_woo = false;
        }

        if (is_home()) {
            if (get_option('popoverify_home')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        } elseif (is_archive()) {
            if ($is_woo && function_exists('is_product_category') && is_product_category()) {
                if (get_option('popoverify_woo_category')) {
                    add_action('woocommerce_archive_description', 'popoverify_print_div_start', 9);
                    add_action('woocommerce_archive_description', 'popoverify_print_div_end', 11);
                }
            } else {
                if (get_option('popoverify_posts_archive')) {
                    add_filter('post_class', 'popoverify_add_post_class');
                }
                if (is_category() && get_option('popoverify_categories')) {
                    add_filter('category_description', 'popoverify_wrap2div');
                }
            }
        } elseif (is_single()) {
            if ($is_woo && function_exists('is_product') && is_product()) {
                if (get_option('popoverify_woo_product')) {
                    add_action('woocommerce_after_single_product_summary', 'popoverify_print_div_start', 9);
                    add_action('woocommerce_after_single_product_summary', 'popoverify_print_div_end', 11);
                }
            } elseif (get_option('popoverify_posts_detail')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        } elseif (is_page()) {
            if ($is_woo && function_exists('is_cart') && is_cart()) {

            } elseif ($is_woo && function_exists('is_checkout') && is_checkout()) {

            } elseif ($is_woo && function_exists('is_account_page') && is_account_page()) {

            } elseif (get_option('popoverify_pages')) {
                add_filter('post_class', 'popoverify_add_post_class');
            }
        }
    }
    add_action('wp', 'popoverify_after_wp');
}
