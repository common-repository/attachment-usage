<?php
namespace AttachmentUsage\Core;

class Screen_Helper{
    
    private $screen;
    private $mode;
    
    
    public function __construct(){
        $this->screen = get_current_screen();
        global $mode;
        $this->mode = $mode;
    }
    
    public function is_mode_like($mode){
        if($this->is_defined('mode')){
            if($this->mode === $mode){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function is_screen_like($id){
        if($this->is_defined('screen')){
            if($this->screen->id === $id){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function is_screen_in_arr($array){
        if($this->is_defined('screen')){
            if(in_array($this->screen->id, $array)){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function get_identifier($identifier){
        if($identifier === 'screen'){
            $identifier = $this->screen;
        }else if($identifier === 'mode'){
            $identifier = $this->mode;
        }
        return $identifier;
    }
    
    private function is_defined($identifier){
        if($this->get_identifier($identifier) !== null){
            return TRUE;
        }
        return FALSE;
    }
}
