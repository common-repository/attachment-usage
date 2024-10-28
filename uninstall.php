<?php
if (!defined('WP_UNINSTALL_PLUGIN')){
    exit;
}

$settings = array(
    'au_auto_sync',
    'au_filter_by_usage',
    'au_color_status',
    'au_attachment_usage_found',
    'au_is_rating_dismissed',
    'au_display_usage_listview'
);

function uninstall($settings) {
    global $wpdb;
    $field = 'attachment';
    $sql = $wpdb->prepare("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type=%s", $field);
    $attachments = $wpdb->get_results($sql);
    
    foreach($attachments as $attachment){
        delete_post_meta($attachment->ID, 'au_attachment_item_usage');
    }
    foreach($settings as $setting){
        delete_option($setting);
    }
}

if (function_exists('is_multisite') && is_multisite()) {
    global $wpdb;
    $old_blog = $wpdb->blogid;
    $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    
    foreach($blogids as $blog_id){
        switch_to_blog($blog_id);
        uninstall($settings);
        restore_current_blog();
    }
}else{
    uninstall($settings);
}