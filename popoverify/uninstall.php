<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('popoverify_app');
delete_option('popoverify_zone');
delete_option('popoverify_home');
delete_option('popoverify_posts_archive');
delete_option('popoverify_posts_detail');
delete_option('popoverify_categories');
delete_option('popoverify_pages');
