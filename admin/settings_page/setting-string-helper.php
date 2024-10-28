<?php
namespace AttachmentUsage\SettingsLib;

class Setting_String_Helper{

    public static function translate_string_with_args($string, $args){
        $strings_arr = array(
            'required-field' => vsprintf(__('Field "%s" is required','attachment-usage'), $args),
            'change-value' => vsprintf(__('Do not change value of field "%s"','attachment-usage'), $args)
        );
        
        if(array_key_exists($string, $strings_arr)){
            return $strings_arr[$string];
        }
    }
    
    public static function translate_string($string){
        $strings_arr = array(
            'required-field' => __('Field is required','attachment-usage'),
            'change-value' => __('Do not change value of field','attachment-usage')
        );
        
        if(array_key_exists($string, $strings_arr)){
            return $strings_arr[$string];
        }
    }
    
}