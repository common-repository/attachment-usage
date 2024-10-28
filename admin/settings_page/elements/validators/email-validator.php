<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\SettingsLib\Setting_String_Helper;
use AttachmentUsage\SettingsLib\Elements\Validators\Abstract_Validator;

class Email_Validator extends Abstract_Validator{
        
    public function __construct($option_name, $callback_args, $field){
        $this->messages['not-valid'] = __('No valid Email', 'attachment-usage');
        $this->messages['required'] = Setting_String_Helper::translate_string_with_args(
                    'required-field', array($field->get_option_value('title')));
        parent::__construct($option_name, $callback_args, $field);
    }
    
    protected function check_input_against_sanitize($input){
        if(!is_array($input) && (sanitize_email($input) === $input || $input === '') ){
            $this->is_valid = TRUE;
        }else{
            add_settings_error($this->option_name, $this->code, $this->messages['not-valid']);
        }
    }
    
    protected function validate_required_field($input){
        if(empty($input)){
            add_settings_error($this->option_name, $this->code, $this->messages['required']);            
        }else{
            $this->check_input_against_sanitize($input);
        }
    }
    
}

