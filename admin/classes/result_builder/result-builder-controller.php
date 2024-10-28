<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Core\ResultBuilder\Result_Builder_Factory;

class Result_Builder_Controller{
    
    private $found_data;
    private $result = '';
    private $attachment_id;
    private $usage_data;
    
    public function __construct($attachment_id){
        $this->attachment_id = $attachment_id;
        $this->usage_data = get_option('au_attachment_usage_found');
    }
    
    public function is_attachment_found(){
        if(!in_array($this->attachment_id, $this->usage_data['not-found'])
            && array_key_exists($this->attachment_id, $this->usage_data['found'])){
            return TRUE;
        }
        return FALSE;
    }
    
    public function build_result(){
        $this->found_data = $this->usage_data['found'][$this->attachment_id];
        foreach($this->found_data as $result_type => $result_data){
            $attachment_result_builder_factory = new Result_Builder_Factory($result_type, $result_data);
            $attachment_result_builder = $attachment_result_builder_factory->get_object();
            $this->result .= $attachment_result_builder->get_usage_output();
        }
    }
    
    public function get_result(){
        if($this->result == ''){
            $this->result = __('Attachment not found', 'attachment-usage');
        }
        return $this->result;
    }
}

