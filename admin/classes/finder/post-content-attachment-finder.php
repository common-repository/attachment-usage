<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Abstract_Attachment_Finder;

class Post_Content_Attachment_Finder extends Abstract_Attachment_Finder{

    /*
     * defines the arguments trying to match with content/excerpt.
     * in case of images arguments classes will be considered, as
     * gutenberg editor saves img tags with class and not all image dimensions as 
     * srcset, which is done by page builder (elementor)
     * this is done in this way, instead of creating array with all img dims and compare each one with src
     */
    protected function prepare_finder_args(){
        $args_array = [];
        $args_array['default'][] = $this->media_file->get_src();
        if($this->media_file->get_short_mime_type() == 'image'){
            $args_array['default'][] = 'wp-image-'.$this->media_file->get_id().'"';
            $args_array['default'][] = 'wp-image-'.$this->media_file->get_id().' ';
            if(defined( 'WPB_VC_VERSION' )){
                $args_array['default'][] = 'image="'.$this->media_file->get_id().'"'; 
            }           
        }      
        if(defined('ELEMENTOR_VERSION')){
            $args_array['elementor'][] = '"id":'.$this->media_file->get_id().'}';
            $args_array['elementor'][] = '"id":'.$this->media_file->get_id().',';
        }
        return $args_array;
    }

    protected function check_finder_content($args){
        foreach($this->content as $key => $val){
            foreach($args['default'] as $arg){
                if(strpos($val->post_content, $arg) !== FALSE 
                        || strpos($val->post_excerpt, $arg) !== FALSE){
                    $this->finder_details[] = $val->ID;
                    break;
                }        
            }         
            if(!in_array($val->ID, $this->finder_details)){
                $this->make_additional_content_checks($val, $args);
            }
        }
    }
    
    private function make_additional_content_checks($content, $args){
        if(defined('WPB_VC_VERSION')){
            $content_arr = array($content->post_excerpt, $content->post_content);
            $content_ids_arr = $this->get_prepared_wpb_content($content_arr);
            if(!empty($content_ids_arr)){
                $this->check_wpb_content($content_ids_arr, $content->ID);
            }
        }else if(defined('ELEMENTOR_VERSION') && $content->meta_value !== NULL){
            $this->check_elementor_content($content, $args['elementor']);
        }
        if(!in_array($content->ID, $this->finder_details)){
            $this->check_media_library_items($content);
        }
    }
    
    /*
     * it checks if gallery, playlists (audio, video) were inserted via the media library
     */
    private function check_media_library_items($content){
        $pattern = '/\[*ids="(.*?)"/';
        preg_match_all($pattern, $content->post_excerpt, $output_excerpt);
        preg_match_all($pattern, $content->post_content, $output_content);
        
        $excerpt_ids = array_map(function($val){
            return explode(',', $val);
        }, $output_excerpt[1]);
        
        $content_ids = array_map(function($val){
            return explode(',', $val);
        }, $output_content[1]);       
                
        $overall_ids_tmp = array_merge($excerpt_ids, $content_ids);
        $overall_ids = [];
        
        foreach($overall_ids_tmp as $id_arr){
            $overall_ids = array_merge($id_arr, $overall_ids);
        }
        if(in_array($this->media_file->get_id(), $overall_ids)){
            $this->finder_details[] = $content->ID;
        }
    }

    private function check_elementor_content($content, $args){              
        if(strpos($content->meta_value, $args[0]) !== FALSE 
            || strpos($content->meta_value, $args[1]) !== FALSE){
            $this->finder_details[] = $content->ID;
        }       
    }
    
    private function prepare_wpb_content($content, $search_pattern, $replace){
        preg_match_all($search_pattern, $content, $output_arr);
        if(!empty($output_arr[0])){       
            $modified_output_arr = str_replace($replace, '', $output_arr[0]);
            $modified_output_arr = str_replace('"', '', $modified_output_arr);
            $modified_output_arr = array_map(function($val) {
                return explode(',', $val);
                }, $modified_output_arr);
        }else{
            return array();
        }
        return $modified_output_arr;       
    }
    
    private function get_prepared_wpb_content($content_arr){
        $merged_ids_arr = [];
        foreach($content_arr as $content){
            $gallery_ids_arr = $this->prepare_wpb_content($content, '/images=".*?"/', 'images=');
            $grid_ids_arr = $this->prepare_wpb_content($content, '/include=".*?"/', 'include=');
            $merged_ids_arr = array_merge($merged_ids_arr, $gallery_ids_arr, $grid_ids_arr);
        }
        return $merged_ids_arr;
    }
    
    private function check_wpb_content($content_ids_arr, $post_id){
        foreach($content_ids_arr as $id_arr){
            if(in_array($this->media_file->get_id(), $id_arr)){
                $this->finder_details[] = $post_id;
                break;
            }
        }
    }

}
