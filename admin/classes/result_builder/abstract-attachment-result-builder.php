<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Core\OutputSetting\Attachment_Output_Setting_Factory;

abstract class Abstract_Attachment_Result_Builder{
    
    protected $results;
    protected $attachment_output;
    
    
    public function __construct($results, Attachment_Output_Setting_Factory $attachment_output_factory){
        $this->results = $results;
        $this->attachment_output = $attachment_output_factory->get_object();
    }
    
    abstract public function get_usage_output();
    
    protected function get_section_title(){
        return $this->attachment_output->get_section_title();
    }
    
    protected function get_location_info(){
        return $this->attachment_output->get_location_info();
    }
    
    protected function get_edit_link($post_id){
        return $this->attachment_output->get_edit_link($post_id);
    }
    
    protected function get_title($post_id){
        return $this->attachment_output->get_title($post_id);
    }
}

