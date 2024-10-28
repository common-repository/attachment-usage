<?php
namespace AttachmentUsage\SettingsLib;
use AttachmentUsage\SettingsLib\Setting;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingsHolder
 *
 * @author Konstantin
 */
class Settings_Holder {
    
    private $settings = [];
    
    public function __construct(Array $settings, $fields) {
        foreach($settings as $setting){
            $field_obj = $fields[$setting['option_name']];
            if(array_key_exists('args', $setting)){
                $this->settings[] = new Setting($setting['option_group'], $setting['option_name'], $field_obj, $setting['args']);
            }else{
                $this->settings[] = new Setting($setting['option_group'], $setting['option_name'], $field_obj);                
            }
        }
    }
    
    public function get_settings(){
        return $this->settings;
    }
    
    public function register_settings(){
        foreach($this->settings as $setting){
            register_setting($setting->get_option_group(), $setting->get_option_name(), $setting->get_args());
        }
    }
 
}
