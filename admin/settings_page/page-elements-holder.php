<?php
namespace AttachmentUsage\SettingsLib;
use AttachmentUsage\SettingsLib\Elements\Fields\Image;
use AttachmentUsage\SettingsLib\Elements\Fields\Checkbox;
use AttachmentUsage\SettingsLib\Elements\Fields\Textarea;
use AttachmentUsage\SettingsLib\Elements\Fields\Number;
use AttachmentUsage\SettingsLib\Elements\Fields\Radio;
use AttachmentUsage\SettingsLib\Elements\Fields\Input;
use AttachmentUsage\SettingsLib\Elements\Fields\File;
use AttachmentUsage\SettingsLib\Elements\Fields\Email;
use AttachmentUsage\SettingsLib\Elements\Fields\Dropdown;
use AttachmentUsage\SettingsLib\Elements\Section;
use AttachmentUsage\Interfaces\IConfigure;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageElementsHolder
 *
 * @author Konstantin
 */
class Page_Elements_Holder implements IConfigure{
       
    private $sections = [];
    private $fields = [];
    private $tabs = [];
    private $navigation;
    private $notifications = [];
    private $descriptions = [];
    
    public function __construct(Array $type_elements){
        $this->add_elements($type_elements);
    }
        
    public function configure(){
        foreach($this->get_elements() as $page_element){          
            if($page_element instanceof IConfigure){
                $page_element->configure();
            }
        }
    }
    
    private function add_elements($type_elements){
        $keys = array_keys($type_elements);
        foreach($keys as $key){
            switch($key){
                case $key == 'section':
                    $this->add_sections($type_elements[$key]);
                    break;
                case $key == 'tab':
                    $this->add_tabs($type_elements[$key]);
                    break;
                case $key == 'notification':
                    $this->add_notifications($type_elements[$key]);
                    break;
                case $key == 'description':
                    $this->add_descriptions($type_elements[$key]);
                    break;
                case $key == 'field':
                    $this->add_fields($type_elements[$key]);
                    break;               
            }
        }
    }
    
    public function get_elements(){       
        $elements = [];
        $page_elements = array(
            $this->sections,
            $this->fields,
            $this->tabs,
            $this->notifications,
            $this->navigation,
            $this->descriptions
        );
        foreach($page_elements as $key => $array){
            if(!empty($array)){
                foreach($array as $item){
                    $elements[] = $item;
                }
            }
        }   
        return $elements;
    } 
    
    private function add_sections($sections){
        foreach($sections as $section){
            $this->sections[] = new Section($section);      
        }
    }
    
    public function get_sections(){
        return $this->sections;
    }
    
    private function add_tabs($tabs){
        foreach($tabs as $tab){
            $this->tabs[$tab['id']] = new Tab($tab['id']);
        }
    }
    
    private function add_notifications($notifications){
        foreach($notifications as $notification){
            $this->notifications[$notification['id']] = new Notification($notification['id']);
        }
    }
    
    private function add_descriptions($descriptions){
        foreach($descriptions as $description){
            $this->descriptions[$description['id']] = new Description($description['id']);
        }
    }
    
    private function add_fields($fields){
        foreach($fields as $field){
            switch($field['type']){
                case $field['type'] == 'checkbox':
                    $this->fields[$field['option_name']] = new Checkbox($field);
                    break;
                case $field['type'] == 'dropdown':
                    $this->fields[$field['option_name']] = new Dropdown($field);
                    break;
                case $field['type'] == 'text':
                    $this->fields[$field['option_name']] = new Input($field);
                    break;
                case $field['type'] == 'radio':
                    $this->fields[$field['option_name']] = new Radio($field);
                    break;
                case $field['type'] == 'textarea':
                    $this->fields[$field['option_name']] = new Textarea($field);
                    break;
                case $field['type'] == 'image':
                    $this->fields[$field['option_name']] = new File($field);
                    break;
                case $field['type'] == 'number':
                    $this->fields[$field['option_name']] = new Number($field);
                    break;
                case $field['type'] == 'file':
                    $this->fields[$field['option_name']] = new File($field);
                    break;
                case $field['type'] == 'email':
                    $this->fields[$field['option_name']] = new Email($field);
                    break;
            }
            
        }        
    }
    
    public function add_settings_section(){
        foreach($this->sections as $section){
            $section->add_settings_section();
        }
    }
    
    public function add_settings_field(){
        foreach($this->fields as $field){
            $field->add_settings_field();
        }
    }
    
    public function get_fields(){
        return $this->fields;
    }
    
    public function is_any_field_required(){
        $display_required_message = FALSE;
        foreach($this->fields as $field){
            if($field->get_option_value('is_required')){
                $display_required_message = TRUE;
                break;
            }
        }
        return $display_required_message;
    }
  
}
