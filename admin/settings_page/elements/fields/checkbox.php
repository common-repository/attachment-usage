<?php
namespace AttachmentUsage\SettingsLib\Elements\Fields;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;

class Checkbox extends Basic_Field{
    
    protected $template = 'checkbox';
        
    protected function get_saved_option_value(){
        if(array_key_exists('group', $this->data)){
            return get_option($this->data['option_name'], []);
        }else{
            return get_option($this->data['option_name'], NULL);
        }
    }

}
