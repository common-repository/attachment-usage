<?php
namespace AttachmentUsage\SettingsLib;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of renderer
 *
 * @author Konstantin
 */
class Renderer{
    
    private $data;
    private $template_path_finder;
    
    public function __construct(Template_Path_Finder $template_path_finder, $data){
        $this->template_path_finder = $template_path_finder;
        $this->data = $data;
    }

    public function render(){
        try{
            $this->template_path_finder->check_template();
            if(!empty($this->data)){                
                ob_start();         
                foreach($this->data as $key => $value){
                    ${$key} = $value;
                }     
                include($this->template_path_finder->get_file());            
                $content = ob_get_contents();
                ob_end_clean();
                echo $content;      
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }    
    }  

}