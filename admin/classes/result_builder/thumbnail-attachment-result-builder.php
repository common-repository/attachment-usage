<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Core\ResultBuilder\Abstract_Attachment_Result_Builder;

class Thumbnail_Attachment_Result_Builder extends Abstract_Attachment_Result_Builder{
    
    public function get_usage_output(){       
        $str = '';
        $content = '';
        if(array_key_exists('product_variation', $this->results)){
            $content = $this->build_product_variations_output($content);
        }
        if(array_key_exists('default', $this->results)){
            $content = $this->build_default_output($content);
        }
        if(!empty($content)){
            $str = '<h4 class>'.$this->get_section_title().'</h4>';
            $str .= $content;
        }
        return $str;
    }   
    
    private function build_product_variations_output($str){
        foreach($this->results['product_variation'] as $key => $val){
            $parent_val = $val['parent'];
            $child_val = $val['child'];
            $str .= '<a href="'.$this->get_edit_link($parent_val).'">'
                .$this->get_title($child_val).'</a> '.$this->get_location_info().'</br>';
        }
        return $str;
    }
    
    private function build_default_output($str){
        foreach($this->results['default'] as $key => $val){
            $str .= '<a href="'.$this->get_edit_link($val).'">'
                .$this->get_title($val).'</a> '.$this->get_location_info().'</br>';
        }
        return $str;
    }

}
