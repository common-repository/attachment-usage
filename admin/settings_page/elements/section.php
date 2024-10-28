<?php
namespace AttachmentUsage\SettingsLib\Elements;
use AttachmentUsage\SettingsLib\Elements\Basic_Element;

class Section extends Basic_Element{
    
    protected $template = 'section';
    protected $directory = 'settings';
    
    
    public function add_settings_section() {
        add_settings_section(
            parent::get_option_value('id'), 
            parent::get_option_value('title'),
            array($this->renderer, 'render'),
            parent::get_option_value('page')
        );
    }
       
}
