<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\Interfaces\IValidator;

abstract class Abstract_Validator implements IValidator{
    
    protected $option_name;
    protected $code;
    protected $messages;
    protected $field;
    protected $is_required;
    protected $is_valid = FALSE;
    protected $callback_args;
    protected $default_value;

    public function __construct($option_name, $callback_args, $field){
        $this->option_name = $option_name;
        $this->code = 'error';
        $this->field = $field;
        $this->callback_args = $callback_args;
        
        if(array_key_exists('sanitize_callback_required_message', $callback_args)
           && !array_key_exists('required', $this->messages)){
            $this->messages['required'] = $callback_args['sanitize_callback_required_message'];
        }
        if(array_key_exists('sanitize_callback_not_valid_message', $callback_args)
            && !array_key_exists('not-valid', $this->messages)){
            $this->messages['not-valid'] = $callback_args['sanitize_callback_not_valid_message'];
        }
        
        if($this->field->get_option_value('is_required')){
            $this->is_required = TRUE;
        }else{
            $this->is_required = FALSE;
        }
        // make check for non existing default values or implement for validators custom default value
        $this->default_value = $this->field->get_option_value('default_value');
    }
    
    //abstract protected function set_default_value($default_value = NULL);
    
    public function validate($input) {
        if($this->is_required){
            $this->validate_required_field($input);
        }else{
            $this->check_input_against_sanitize($input);
        }
        return $this->get_value($input);
    }
    
    protected function get_value($input){
        if($this->is_valid){
            return $input;
        }
        return $this->default_value;
    }
    
    abstract protected function check_input_against_sanitize($input);
    abstract protected function validate_required_field($input);
    
}

