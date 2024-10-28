<?php
namespace AttachmentUsage\SettingsLib;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;
use AttachmentUsage\SettingsLib\Elements\Validators\Validator_Factory;

class Setting{
   
    private $option_name;
    private $option_group;
    private $args;
    private $validator;
    private $field;
    
    
    public function __construct($option_group, $option_name, Basic_Field $field, $args = NULL) {
        $this->option_group = $option_group;
        $this->option_name = $option_name;       
        $this->args = $args;
        $this->field = $field;
        
        if(is_array($this->args) && array_key_exists('sanitize_callback_type', $this->args)){
            $type = $this->args['sanitize_callback_type'];
            $message = NULL;
            if(array_key_exists('sanitize_callback_message', $this->args)){
                $message = $this->args['sanitize_callback_message'];
            }
            
            $factory = new Validator_Factory($type, $this->option_name, $this->field, $this->args);
            $this->validator = $factory->get_object();
            $this->args['sanitize_callback'] = array($this->validator, 'validate');
        }
    }
    
    public function get_args(){
        return $this->args;
    }

    public function get_option_name(){
        return $this->option_name;
    }
    
    public function get_option_group(){
        return $this->option_group;
    }
}

