<?php
namespace AttachmentUsage\SettingsLib\Elements;
use AttachmentUsage\SettingsLib\Template_Path_Finder;
use AttachmentUsage\SettingsLib\Renderer;
use AttachmentUsage\Interfaces\IConfigure;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BasicElement
 *
 * @author Konstantin
 */
abstract class Basic_Element implements IConfigure{
    
    protected $template = 'field';
    protected $directory = 'settings';
    protected $file_type = 'php';
    protected $data = [];
    protected $options;
    protected $keys = [];
    protected $renderer;
    
    
    public function __construct(array $options){
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
        $this->options = $options;
    }

    public function configure() {
        $this->prepare_rendered_data();
        $template_path_finder = new Template_Path_Finder(
            $this->directory,
            $this->template,
            $this->file_type
            );        
        $this->renderer = new Renderer($template_path_finder, $this->data);
    }
        
    private function prepare_rendered_data(){
        if(!empty($this->keys)){
            foreach($this->keys as $key){
                if($key != 'callback' && in_array($key, array_keys($this->options))){
                    $this->data[$key] = $this->options[$key];
                }               
            }
        }else{
            foreach($this->options as $key => $value){
                if($key != 'callback'){
                    $this->data[$key] = $value;
                }
            }
        }        
    }
    
    public function get_option_value($key){
        if(array_key_exists($key, $this->options)){
            return $this->options[$key];
        }
        return FALSE;
    }
    
}
