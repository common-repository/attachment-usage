<?php
namespace AttachmentUsage\SettingsLib;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of path_finder
 *
 * @author Konstantin
 */
class Template_Path_Finder {
    
    private $path_to_templates;
    private $directory;
    private $template_name;
    private $supported_file_types = array('php', 'html', 'phtml');
    private $file;
    private $file_type = null;
    
    public function __construct($directory, $template_name, $file_type) {
        $config = include('config.php');
        $this->path_to_templates = $config['au_admin_templates'];
        $this->directory = $directory;
        $this->template_name = $template_name;
        if(in_array($file_type, $this->supported_file_types)){
            $this->file_type = $file_type;
        }
    }
    
    public function check_template(){
        $this->prepare_path_elements();
        if(file_exists($this->file)){
            return true;
        }else{
            throw new Exception(
                    sprintf("Template %s in %s with type %s was not found",
                            $this->template_name,
                            $this->directory,
                            $this->file_type
                            )
                    );
        }
    }
    
    public function get_file(){
        return $this->file;
    }
    
    private function prepare_path_elements(){
        $this->template_name = strtolower(rtrim($this->template_name, '/'));
        $this->directory = rtrim($this->directory, '/');
        $this->file = $this->path_to_templates . $this->directory . '/' .
                $this->template_name . '.' . $this->file_type; 
    }
    
}
