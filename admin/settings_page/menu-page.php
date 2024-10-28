<?php
namespace AttachmentUsage\SettingsLib;
use AttachmentUsage\Interfaces\IConfigure;

class Menu_Page implements IConfigure{
    
    protected $template = 'menu_page';
    protected $directory = 'pages';
    protected $file_type = 'php';
    protected $page_elements_holder;
    protected $settings_holder;
    protected $options;
    protected $data;
    protected $keys;
    protected $renderer;
    
    
    public function __construct($page_elements, $options, $settings){
        $this->page_elements_holder = new Page_Elements_Holder($page_elements);
        $fields = $this->page_elements_holder->get_fields();
        $this->settings_holder = new Settings_Holder($settings, $fields);  

        if(array_key_exists("keys", $options)){
            $this->keys = $options["keys"];
        }
        
        if(array_key_exists("template", $options)){
            $this->template = $options["template"];
        }
        
        if(array_key_exists("directory", $options)){
            $this->directory = $options["directory"];
        }
        
        if(array_key_exists("data", $options)){
            $this->data = $options["data"];
        }
        
        foreach($this->keys as $key){
            $this->data[$key] = $options[$key];
        }        
        $this->options = $options;     
        $this->data['display_required_message'] = $this->page_elements_holder->is_any_field_required();
    }

    public function configure(){
        $template_path_finder = new Template_Path_Finder(               
                $this->directory,
                $this->template,
                $this->file_type
                );
        $this->renderer = new Renderer($template_path_finder, $this->data);    
    }
    
    public function get_settings_holder(){
        return $this->settings_holder;
    }
    
    public function get_page_elements_holder(){
        return $this->page_elements_holder;
    }
    
    public function create_menu_page(){
        if($this->options['is_top_page']){
            add_menu_page(
                $this->options['page_title'],
                $this->options['menu_title'],
                $this->options['capability'],
                $this->options['menu_slug'],
                array($this->renderer, 'render')               
            );
        }else{
            add_submenu_page(
                $this->options['parent_slug'],
                $this->options['page_title'],
                $this->options['menu_title'],
                $this->options['capability'],
                $this->options['menu_slug'],
                array($this->renderer, 'render')
            );
        }
    }

}