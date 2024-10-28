<?php
namespace AttachmentUsage\SettingsLib\Elements;

class Basic_Field extends Basic_Element{
    
    protected $directory = 'settings/fields';
    
    
    public function __construct(array $options){
        parent::__construct($options);        
        foreach($this->keys as $key){
            $this->data[$key] = $options[$key];
        }       
        $this->data['id'] = $options['id'];
                
        if(array_key_exists('option_name', $options)){
            $this->data['option_name'] = $options['option_name'];
        }
        if(array_key_exists('group', $options)){
            $this->data['group'] = $options['group'];
        }
        if(array_key_exists('group_option_name', $options)){
            $this->data['group_option_name'] = $options['group_option_name'];
        }
        if(array_key_exists('default_value', $options)){
            $this->data['default_value'] = $options['default_value'];
        }
        if(array_key_exists('is_required', $options) && $options['is_required']){
            $this->options['title'] = $options['title'].'*';
        }
        $this->provide_value();
    }
    
    protected function get_provided_default_value($option_value){
        if($this->is_default_value_provided()){
            return $this->data['default_value'];
        }
        return $option_value;
    }
    
    protected function is_default_value_provided(){
        if(array_key_exists('default_value', $this->data)){
            return TRUE;
        }
        return FALSE;
    }
    
    protected function get_saved_option_value(){
        return get_option($this->data['option_name'], '');
    }
    
    protected function provide_value(){
        $option_value = $this->get_saved_option_value();
        if(empty($option_value)){
            $option_value = $this->get_provided_default_value($option_value);
        }
        $this->data['option_value'] = $option_value;
    }
    
    public function add_settings_field() {
        add_settings_field(
            $this->get_option_value('id'), 
            $this->get_option_value('title'), 
            array($this->renderer, "render"), 
            $this->get_option_value('page'),
            $this->get_option_value('section')
        );
        
    }
    
}
