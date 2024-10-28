<?php
namespace AttachmentUsage\Core\OutputSetting;
use AttachmentUsage\Interfaces\IAttachmentOutput;


class Product_Category_Attachment_Output_Setting implements IAttachmentOutput{
    
    private $location_info;
    private $section_title;
    
    public function __construct($location_info, $section_title){
        $this->location_info = $location_info;
        $this->section_title = $section_title;
    }
    
    public function get_title($id) {
        return get_term_field('name', $id);
    }

    public function get_edit_link($id) {
         return get_edit_term_link($id);
    }

    public function get_location_info() {
        return $this->location_info;
    }

    public function get_section_title() {
        return $this->section_title;
    }

}

