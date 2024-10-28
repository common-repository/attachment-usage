<?php
namespace AttachmentUsage;
use AttachmentUsage\Includes\Attachment_Usage;
use AttachmentUsage\Includes\Attachment_Usage_Activator;
use AttachmentUsage\Includes\Attachment_Usage_Deactivator;

/*
 * Plugin Name:       Attachment Usage
 * Plugin URI:        https://wordpress.org/plugins/attachment-usage/
 * Description:       Find your attachment/media files used by different locations (posts, pages, widgets, galleries etc.) on your website.
 * Version:           1.2
 * Author:            Konstantin Kröpfl
 * Author URI:        https://profiles.wordpress.org/konstk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       attachment-usage
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP:      7.0
 */

if(!defined('WPINC')){
    die;
}
define('ATTACHMENT_USAGE_VERSION', '1.2');

function activate_attachment_usage($networkwide){
    require_once plugin_dir_path(__FILE__) . 'includes/class-attachment-usage-activator.php';
    global $wpdb;
    if(function_exists('is_multisite') && is_multisite()){
        // check if it is a network activation - if so, run the activation function for each blog id
        if($networkwide) {
            $old_blog = $wpdb->blogid;
            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
            foreach($blogids as $blog_id){
                switch_to_blog($blog_id);
                Attachment_Usage_Activator::activate();
                restore_current_blog();
            }
            switch_to_blog($old_blog);
            return;
        }
    }
    Attachment_Usage_Activator::activate();
}

function deactivate_attachment_usage($networkwide) {
    require_once plugin_dir_path(__FILE__) . 'includes/class-attachment-usage-deactivator.php';
    global $wpdb;
    if (function_exists('is_multisite') && is_multisite()) {
        // check if it is a network activation - if so, run the activation function for each blog id
        if ($networkwide) {
            $old_blog = $wpdb->blogid;
            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
            foreach($blogids as $blog_id){
                switch_to_blog($blog_id);
                Attachment_Usage_Deactivator::deactivate();
                restore_current_blog();
            }
            switch_to_blog($old_blog);
            return;
        }
    }
    Attachment_Usage_Deactivator::deactivate();
}

register_activation_hook(__FILE__, __NAMESPACE__ . '\activate_attachment_usage');
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivate_attachment_usage');
add_action('wpmu_new_blog', __NAMESPACE__ . '\activate_attachment_usage');

function run_attachment_usage(){
    require plugin_dir_path(__FILE__) . 'includes/class-attachment-usage.php';
    $plugin = new Attachment_Usage();
    $plugin->run();
}
run_attachment_usage();