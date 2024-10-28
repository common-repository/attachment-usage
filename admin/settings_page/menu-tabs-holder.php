<?php
namespace AttachmentUsage\SettingsLib;

class Menu_Tabs_Holder{
    
    protected $tabs = [];
    protected $active_tab;
    
    public function __construct(Array $tabs){
        foreach($tabs as $tab){
            $tab_obj = new Tab($tab);
            $tab_obj->configure();
            $this->tabs[] = $tab_obj;
        }
    }
    
    public function get_tabs(){
        return $this->tabs;
    }
    
    public function check_tab_clicked(){
        if(isset($_GET['tab'])){
            return true;
        }
        return false;
    }
    
    public function get_active_tab(){
        foreach($this->tabs as $tab){
            if($tab->get_active_tab_boolean()){
                $this->active_tab = $tab;
            }
        }
        if($this->active_tab == null){
            $this->active_tab = $this->tabs[0];
        }
        
        return $this->active_tab;
    }
}
