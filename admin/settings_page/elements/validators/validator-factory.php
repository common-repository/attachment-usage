<?php
namespace AttachmentUsage\SettingsLib\Elements\Validators;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;
use AttachmentUsage\Interfaces\IFactory;

class Validator_Factory implements IFactory{
    
    private $validator_type;
    private $option_name;
    private $callback_args;
    private $field;
    
    public function __construct($type, $option_name, Basic_Field $field, $callback_args) {
        $this->validator_type = $type;
        $this->option_name = $option_name;        
        $this->callback_args = $callback_args;
        $this->field = $field;
    }
    
    public function get_object() {
        switch($this->validator_type){
            case 'string':
                return new String_Validator($this->option_name, $this->callback_args, $this->field);
            case 'radio-whitelist':
                return new Radio_Whitelist_Validator($this->option_name, $this->callback_args, $this->field);
            case 'checkbox-whitelist':
                return new Checkbox_Whitelist_Validator($this->option_name, $this->callback_args, $this->field);
            case 'dropdown-whitelist':
                return new Dropdown_Whitelist_Validator($this->option_name, $this->callback_args, $this->field);
            case 'number':
                return new Number_Validator($this->option_name, $this->callback_args, $this->field);             
            case 'file':
                return new File_Validator($this->option_name, $this->callback_args, $this->field);
            case 'email':
                return new Email_Validator($this->option_name, $this->callback_args, $this->field);
        }
    }
    
}