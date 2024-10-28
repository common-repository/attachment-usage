<?php
namespace AttachmentUsage\Includes;

class Attachment_Usage_Activator {

    public static function activate() {
        add_option('au_auto_sync', 'yes');
        add_option('au_filter_by_usage', 'yes');
        add_option('au_color_status', 'yes');
        add_option('au_display_usage_listview', 'yes');
        add_option('au_is_rating_dismissed', FALSE);
        add_option('au_attachment_usage_found', array('found' => array(), 'not-found' => array()));
    }
}
