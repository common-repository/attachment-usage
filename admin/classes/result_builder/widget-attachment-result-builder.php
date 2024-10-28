<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Core\ResultBuilder\Abstract_Attachment_Result_Builder;

class Widget_Attachment_Result_Builder extends Abstract_Attachment_Result_Builder{
    
    public function get_usage_output(){
        $this->attachment_output->set_results($this->results);

        $str = '';
        if(count($this->results) > 0){
            $str = '<h4 class>'.$this->get_section_title().'</h4>';
            foreach($this->results as $key => $val){           
                $str .= '<a target="_blank" href="'.$this->get_edit_link($key).'">'
                        .$this->get_title($key).'</a> '.$this->get_location_info().'</br>';
            }
        }
        return $str;
    }
    
}
