<?php
namespace AttachmentUsage\SettingsLib;
use AttachmentUsage\Interfaces\IConfigure;

class Tab implements IConfigure{
    
    private $class = "nav-tab";
    private $active_class = "nav-tab-active";
    private $options;
    private $active_tab_boolean;
    
    
    public function __construct(Array $options){
        $this->options = $options;
    }
    
    public function configure() {
        $this->check_active_tab_boolean();
    }
    
    private function get_option_value($key){
        if(array_key_exists($key, $this->options)){
            return $this->options[$key];
        }
        return false;
    }
    
    public function get_menu_slug(){
        return $this->get_option_value("menu_slug");
    }
    
    public function get_title(){
        return $this->get_option_value("title");
    }
    
    public function get_class(){
        if($this->active_tab_boolean){
            return $this->class . " " . $this->active_class;
        }else{
            return $this->class;
        }
    }
    
    public function get_active_tab_boolean(){
        return $this->active_tab_boolean;
    }

    private function check_active_tab_boolean(){
        if(isset($_GET['tab']) && $_GET['tab'] == $this->get_option_value('menu_slug')){
            $this->active_tab_boolean = TRUE;
        }else{
            $this->active_tab_boolean = FALSE;
        }
    }
    
}
