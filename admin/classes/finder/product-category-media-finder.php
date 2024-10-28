<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Abstract_Attachment_Finder;

class Product_Category_Media_Finder extends Abstract_Attachment_Finder{
    
    protected function prepare_finder_args(){
        $arg = $this->media_file->get_id();
        return array($arg);
    }

    protected function check_finder_content($args){
        $this->finder_details = [];
        foreach($this->content as $key => $val){
            foreach($args as $arg){
                if($val->meta_value == $arg){ 
                    $this->finder_details[] = $val->term_id;
                }
            }
        }
    }

}

