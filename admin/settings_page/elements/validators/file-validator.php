<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\SettingsLib\Setting_String_Helper;
use AttachmentUsage\SettingsLib\Elements\Validators\Abstract_Validator;

class File_Validator extends Abstract_Validator{
        
    public function __construct($option_name, $callback_args, $field){
        $this->messages['not-valid'] = __('The entered data is no valid attachment id', 'attachment-usage');
        $this->messages['required'] = Setting_String_Helper::translate_string_with_args(
                    'required-field', array($field->get_option_value('title')));
        parent::__construct($option_name, $callback_args, $field);
    }
 
    private function check_valid_file($input){
        if(is_numeric($input) && (int) $input !== 0){
            $post_obj = get_post($input);
            if($post_obj === NULL || $post_obj->post_type != 'attachment'){
                add_settings_error($this->option_name, $this->code, $this->messages['not-valid']);
                return FALSE;
            }
            return TRUE;
        }else if(is_numeric($input) && (int) $input === 0){
            return TRUE;
        }
        return FALSE;
    }
    
    protected function check_input_against_sanitize($input){
        if(!is_array($input) 
            && is_numeric($input) && preg_match('/^\d+$/', $input)
            && $this->check_valid_file($input) ){
            $this->is_valid = TRUE;
        }else{
            $this->default_value = 0;
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

