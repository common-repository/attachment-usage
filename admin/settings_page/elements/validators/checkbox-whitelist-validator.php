<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;

class Checkbox_Whitelist_Validator extends Abstract_Whitelist_Validator{

    protected function create_whitelist() {
        if(!$this->field->get_option_value('group')){
            $this->whitelist = array('1',NULL);
        }else{
            foreach($this->field->get_option_value('group') as $key => $val){
                $this->whitelist[] = $val['value'];
            }
        }
    }
    
    protected function make_sanity_checks($input){
        if(!$this->field->get_option_value('group')){
            $this->sanity_checks_single_checkbox($input);
        }else{
            $this->sanity_checks_multiple_checkboxes($input);
        }
    }
    
    //no need for the is_input_in_whitelist because the checks represent
    //the whitelist values
    private function sanity_checks_single_checkbox($input){
        if($input === '1' || $input === NULL){
            $this->is_whitelisted = TRUE;
        }
    }
    
    private function sanity_checks_multiple_checkboxes($input){
        if(is_array($input) && !empty($input)){
            foreach($input as $input_element){
                if($this->is_input_in_whitelist($input_element)){
                    $this->is_whitelisted = TRUE;
                }else{
                    $this->is_whitelisted = FALSE;
                    break;
                }
            }
        }else if(is_array($input) && empty($input)){
            $this->is_whitelisted = TRUE;
        }else{
            $this->is_whitelisted = FALSE;
        }
    }

}