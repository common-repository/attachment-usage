<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;

class Dropdown_Whitelist_Validator extends Abstract_Whitelist_Validator{
    
    protected function create_whitelist(){
        foreach($this->field->get_option_value('dropdown_options') as $key => $val){
            $this->whitelist[] = $key;
        }
    }
    
    protected function make_sanity_checks($input){
        if($input === '' || is_string($input)){
            if($this->is_input_in_whitelist($input)){
                $this->is_whitelisted = TRUE;
            };
        }
    }

}

