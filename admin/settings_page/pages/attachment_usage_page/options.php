<?php
if (!defined('ABSPATH')){
    exit;
}

return array(
    'page_title' => 'Attachment Usage',
    'menu_title' => __('Attachment Usage Settings', 'attachment-usage'),
    'capability' => 'manage_options',
    'menu_slug' => 'attachment-usage-page',
    'callback' => '',
    'keys' => array('page_title', 'menu_title', 'menu_slug'),
    'is_top_page' => FALSE,
    'parent_slug' => 'upload.php'
);
