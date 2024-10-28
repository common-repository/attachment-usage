<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Core\ResultBuilder\Abstract_Attachment_Result_Builder;

class Default_Attachment_Result_Builder extends Abstract_Attachment_Result_Builder{
    
    public function get_usage_output(){       
        $str = '';
        if(count($this->results) > 0){
            $str = '<h4 class>'.$this->get_section_title().'</h4>';
            foreach($this->results as $key => $val){
                $str .= '<a href="'.$this->get_edit_link($val).'">'
                        .$this->get_title($val).'</a> '.$this->get_location_info().'</br>';
            }
        }
        return $str;
    }

}
