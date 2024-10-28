<?php
namespace AttachmentUsage\Core\OutputSetting;
use AttachmentUsage\Interfaces\IAttachmentOutput;


class Attachment_Output_Setting implements IAttachmentOutput{
    
    private $location_info;
    private $section_title;
    
    public function __construct($location_info, $section_title){
        $this->location_info = $location_info;
        $this->section_title = $section_title;
    }
    
    public function get_location_info(){
        return $this->location_info;
    }
    
    public function get_section_title(){
        return $this->section_title;
    }
    
    public function get_edit_link($post_id){
        return get_edit_post_link($post_id);
    }
    
    public function get_title($post_id){
        $title = get_the_title($post_id);
        return !empty($title) ? $title : get_edit_post_link($post_id);
    }
    
    
}

