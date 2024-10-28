<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;

class Radio_Whitelist_Validator extends Abstract_Whitelist_Validator{
    
    protected function create_whitelist() {
        foreach($this->field->get_option_value('group') as $key => $val){
            $this->whitelist[] = $val['value'];
        }
    }
    
    protected function make_sanity_checks($input){
        if(is_string($input) && $input !== ''){
            if($this->is_input_in_whitelist($input)){
                $this->is_whitelisted = TRUE;
            };
        }
    }

}