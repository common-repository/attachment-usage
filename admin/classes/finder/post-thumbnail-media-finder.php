<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Abstract_Attachment_Finder;

class Post_Thumbnail_Media_Finder extends Abstract_Attachment_Finder{

    protected function prepare_finder_args(){
        $arg = $this->media_file->get_id();
        return array($arg);
    }

    protected function check_finder_content($args){
        $this->finder_details = [];
        foreach($this->content as $key => $val){
            foreach($args as $arg){
                if($val->meta_value == $arg){
                    $this->is_found = TRUE;
                    if($val->post_type === 'product_variation'){
                        $this->finder_details['product_variation'][] = array(
                            'parent' => $val->post_parent,
                            'child' => $val->post_id
                            );
                    }else{
                        $this->finder_details['default'][] = $val->post_id;
                    }
                }
            }
        }
    }
    
}

