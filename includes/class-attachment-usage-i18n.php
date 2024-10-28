<?php
namespace AttachmentUsage\Includes;

class Attachment_Usage_i18n{

    public function load_plugin_textdomain(){
        load_plugin_textdomain(
                'attachment-usage',
                false,
                dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
