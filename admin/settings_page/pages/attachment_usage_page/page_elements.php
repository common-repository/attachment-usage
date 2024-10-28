<?php
if (!defined('ABSPATH')){
    exit;
}

return array(
    'section' => array(
        array(
            'id' => 'attachment_usage_info',
            'title' => 'Information',
            'callback' => '',
            'page' => 'attachment-usage-page',
            'data' => array(
                "description" =>  sprintf(
                    __('On this page you can modify the appearance and the way'
                    . ' how the plugin does the lookup. The relevant pages (media upload pages) are referred as:<br> '
                    . '<a href="%1$s" target="_blank">Media Grid</a> & <a href="%2$s" target="_blank">Media List</a>', 'attachment-usage')
                    , admin_url('upload.php?mode=grid'), admin_url('upload.php?mode=list')
                )
            ),
            'keys' => array('title', 'id', 'page')
        ),
        array(
            'id' => 'attachment_usage_general',
            'title' => __('General Settings', 'attachment-usage'),
            'callback' => '',
            'page' => 'attachment-usage-page',
            'data' => array(
                "description" => __('This section provides general settings, which impacts only the'
                    . ' appearance of the usage status.'
                    , 'attachment-usage'
                )
            ),
            'keys' => array('title', 'id', 'page')
        ),
        array(
            'id' => 'attachment_usage_performance',
            'title' => __('Performance Settings', 'attachment-usage'),
            'callback' => '',
            'page' => 'attachment-usage-page',
            'data' => array(
                "description" => __('This section provides settings for performance, which might have'
                    . ' a significant impact on the loading time of the media upload pages.</br>'
                    . ' If you have a rather small site (little number of pages, a few attachments)'
                    . ' you will not notice a huge difference by switching between the options.'
                    , 'attachment-usage'
                )
            ),
            'keys' => array('id', 'title', 'page')
        )
    ),
    'field' => array(
        array(
            'id' => 'au_color_status',
            'type' => 'radio',
            'title' => __('Display Attachment Usage Color', 'attachment-usage'),
            'calback' => '',
            'page' => 'attachment-usage-page',
            'section' => 'attachment_usage_general',
            'option_name' => 'au_color_status',
            'data' => array(
                'description' => __('By enabling this option, the media grid items '
                    . 'will have a colored border depending on their usage. '
                    . 'Red implies nothing found, whereas green shows an usage'
                    , 'attachment-usage'
                )
            ),
            'group' => array(
                0 => array('id' => 'au_color_status_yes', 'value' => 'yes', 'title' => __('Display color', 'attachment-usage')),
                1 => array('id' => 'au_color_status_no', 'value' => 'no', 'title' => __('Hide color', 'attachment-usage')),
                ),
            'is_required' => TRUE,
            'default_value' => 'yes'
        ),
        array(
            'id' => 'au_filter_by_usage',
            'type' => 'radio',
            'title' => __('Filter attachment list by usage', 'attachment-usage'),
            'calback' => '',
            'page' => 'attachment-usage-page',
            'section' => 'attachment_usage_performance',
            'option_name' => 'au_filter_by_usage',
            'data' => array(
                'description' => __('By enabling this option, the media list view '
                    . 'will contain a sortable column, which allows to sort the attachments'
                    . ' by their usage status (found/not-found). This can be helpful to'
                    . ' get an overview about not used attachments.</br>'
                    . ' Furthermore it is important to note that by enabling this option'
                    . ' the process of saving the relevant information changes and this'
                    . ' can lead to longer loading times on the media upload pages depending on the overall amount'
                    . ' of attachments and size of the website.'
                    , 'attachment-usage'
                )
            ),
            'group' => array(
                0 => array('id' => 'au_filter_by_usage_yes', 'value' => 'yes', 'title' => __('Make media column sortable', 'attachment-usage')),
                1 => array('id' => 'au_filter_by_usage_no', 'value' => 'no', 'title' => __('Do not make media column sortable', 'attachment-usage')),
                ),
            'is_required' => TRUE,
            'default_value' => 'yes'
        ),
        array(
            'id' => 'au_auto_sync',
            'type' => 'radio',
            'title' => __('Sync Attachment Usage on media upload site', 'attachment-usage'),
            'calback' => '',
            'page' => 'attachment-usage-page',
            'section' => 'attachment_usage_performance',
            'option_name' => 'au_auto_sync',
            'data' => array(
                'description' => __('By enabling this option, the attachment relevant data'
                    . ' will be fetched as soon as the media upload pages is opened.'
                    . ' By disabling this option, a button on the page will trigger the lookup process'
                    . ' when clicked.'
                    , 'attachment-usage'
                )
            ),
            'group' => array(
                0 => array('id' => 'au_auto_sync_yes', 'value' => 'yes', 'title' => __('Auto-sync attachments usage on page visit', 'attachment-usage')),
                1 => array('id' => 'au_auto_sync_no', 'value' => 'no', 'title' => __('Do not auto-sync attachments usage', 'attachment-usage')),
                ),
            'is_required' => TRUE,
            'default_value' => 'yes'
        ),
        array(
            'id' => 'au_display_usage_listview',
            'type' => 'radio',
            'title' => __('Display Attachment Usage in List View', 'attachment-usage'),
            'calback' => '',
            'page' => 'attachment-usage-page',
            'section' => 'attachment_usage_general',
            'option_name' => 'au_display_usage_listview',
            'data' => array(
                'description' => __('By enabling this option, the usage of the attachment'
                    . ' will be displayed in a separate column in the media list view.'
                    , 'attachment-usage'
                )
            ),
            'group' => array(
                0 => array('id' => 'au_display_usage_listview_yes', 'value' => 'yes', 'title' => __('Display attachment usage in list view', 'attachment-usage')),
                1 => array('id' => 'au_display_usage_listview_no', 'value' => 'no', 'title' => __('Do not display attachment usage in list view', 'attachment-usage')),
                ),
            'is_required' => TRUE,
            'default_value' => 'yes'
        )
    )
);