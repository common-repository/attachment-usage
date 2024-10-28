<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\SettingsLib\Elements\Validators\Abstract_Validator;
use AttachmentUsage\SettingsLib\Setting_String_Helper;

abstract class Abstract_Whitelist_Validator extends Abstract_Validator{
    
    protected $whitelist;
    protected $is_whitelisted  = FALSE;
    
    
    public function __construct($option_name, $callback_args, $field) {
        $this->messages['not-valid'] = Setting_String_Helper::translate_string_with_args(
                'change-value', array($field->get_option_value('title')));
        $this->messages['required'] = Setting_String_Helper::translate_string_with_args(
                'required-field', array($field->get_option_value('title')));
        parent::__construct($option_name, $callback_args, $field);
        $this->create_whitelist();   
    }
    
    abstract protected function create_whitelist();
    abstract protected function make_sanity_checks($input);
    
    protected function check_input_against_sanitize($input){
        $this->make_sanity_checks($input);
        
        if($this->is_whitelisted){
            $this->is_valid = TRUE;
        }
        
        if(!$this->is_valid){
            add_settings_error($this->option_name, $this->code, $this->messages['not-valid']);
        }
    }
    
    protected function is_input_in_whitelist($input){
        if(in_array($input, $this->whitelist)){
            return TRUE;
        }
        return FALSE;
    }
    
    /*
     * 0,NULL,FALSE,'0',array(),'' -> empty VALUE
     */  
    protected function validate_required_field($input){
        if(empty($input)){
            add_settings_error($this->option_name, $this->code, $this->messages['required']);            
        }else{
            $this->check_input_against_sanitize($input);
        }
    }
    
}