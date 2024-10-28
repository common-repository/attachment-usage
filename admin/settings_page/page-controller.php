<?php
namespace AttachmentUsage\SettingsLib;

class Page_Controller{
    
    private $pages = array(
        0 => array('type' => 'menu_page', 'name' => 'attachment_usage_page'),
    );
    private $page_objects = [];
    

    private function create_page_objects(){
        $config = include(plugin_dir_path(__FILE__).'config.php');
        foreach($this->pages as $page){
            $settings = include($config['au_admin_page'].$page['name'].'/settings.php');
            $page_elements = include($config['au_admin_page'].$page['name'].'/page_elements.php');
            $options = include($config['au_admin_page'].$page['name'].'/options.php');

            switch($page['type']){
                case 'menu_page':
                    $page = new Menu_Page($page_elements, $options, $settings);
                    break;
                case 'tabbed_menu_page':
                    $tabs = include($config['au_admin_page'].$page['name'].'/tabs.php');
                    $page = new Tabbed_Menu_Page($page_elements, $options, $settings, $tabs);           
                    break;
            }
            $this->page_objects[] = $page;
        }
    }
    
    public function create_menu_page(){
        $this->create_page_objects();
        foreach($this->page_objects as $obj){
            $obj->configure();
            $obj->create_menu_page();
        }
    }
    
    public function prepare_page_elements(){
        foreach($this->page_objects as $obj){
            $obj->get_settings_holder()->register_settings();
            $obj->get_page_elements_holder()->configure();
            $obj->get_page_elements_holder()->add_settings_section();
            $obj->get_page_elements_holder()->add_settings_field();
        }
    }

}
