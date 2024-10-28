<?php
if (!defined('ABSPATH')){
    exit;
}

return array(
    array(
        'option_group' => 'attachment-usage-page',
        'option_name' => 'au_auto_sync',
        'args' => array(
            'sanitize_callback_type' => 'radio-whitelist',
        )
    ),
    array(
        'option_group' => 'attachment-usage-page',
        'option_name' => 'au_filter_by_usage',
        'args' => array(
            'sanitize_callback_type' => 'radio-whitelist',
        )
    ),
    array(
        'option_group' => 'attachment-usage-page',
        'option_name' => 'au_color_status',
        'args' => array(
            'sanitize_callback_type' => 'radio-whitelist',
        )
    ),
    array(
        'option_group' => 'attachment-usage-page',
        'option_name' => 'au_display_usage_listview',
        'args' => array(
            'sanitize_callback_type' => 'radio-whitelist',
        )
    )
);