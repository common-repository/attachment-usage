<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\SettingsLib\Setting_String_Helper;
use AttachmentUsage\SettingsLib\Elements\Validators\Abstract_Validator;

class String_Validator extends Abstract_Validator{
    
    private $field_type;

    
    public function __construct($option_name, $callback_args, $field){
        $this->messages['not-valid'] = __('The entered data is not valid - just text', 'attachment-usage');
        $this->messages['required'] = Setting_String_Helper::translate_string_with_args(
                    'required-field', array($field->get_option_value('title')));
        parent::__construct($option_name, $callback_args, $field);
        if($this->field->get_option_value('type') === 'text'){
            $this->field_type = 'text';
        }else{
            $this->field_type = 'textarea';
        }
    }

    private function is_valid_input($input){
        if($input === sanitize_text_field($input)){
            return TRUE;
        }
        return FALSE;         
    }
    
    private function is_valid_textarea($input){
        if($input === sanitize_textarea_field($input)){
            return TRUE;
        }
        return FALSE;   
    }
    
    protected function check_input_against_sanitize($input){      
        if($this->field_type == 'text'){
            $this->is_valid = $this->is_valid_input($input);
        }
        if($this->field_type == 'textarea'){
            $this->is_valid = $this->is_valid_textarea($input);
        }
        
        if(!$this->is_valid){
            add_settings_error($this->option_name, $this->code, $this->messages['not-valid']);
        }
    }
    
    protected function validate_required_field($input){  
        if(!is_array($input) && !preg_match('/\S/', $input)){
            add_settings_error($this->option_name, $this->code, $this->messages['required']);            
        }else{
            $this->check_input_against_sanitize($input);
        }
    }
    
}

