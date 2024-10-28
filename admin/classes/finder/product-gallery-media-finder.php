<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Abstract_Attachment_Finder;

class Product_Gallery_Media_Finder extends Abstract_Attachment_Finder{
    
    protected function prepare_finder_args(){
        $arg1 = $this->media_file->get_id().',';
        $arg2 = ','.$this->media_file->get_id().',';
        $arg3 = ','.$this->media_file->get_id();
        return array($arg1, $arg2, $arg3);
    }

    protected function check_finder_content($args){
        $this->finder_details = [];
        foreach($this->content as $key => $val){
            foreach($args as $arg){
                if(strpos($val->meta_value, $arg) !== FALSE){ 
                    $this->finder_details[] = $val->post_id;
                    break;
                }
            }
            if(!in_array($val->post_id, $this->finder_details)){
                $this->check_single_image_gallery($val);
            }
        }
    }
    
    /*
     * this function checks the case if only one image is attached as product gallery;
     * problem with prepare_finder_args is that solely passing the attachment id
     * can lead to false true checks; e.g. 17 is part of 175 and would lead to false findings
     */
    private function check_single_image_gallery($val){
        $id = strval($this->media_file->get_id());
        if($val->meta_value === $id){
            $this->finder_details[] = $val->post_id;
        }
    }
    
}
