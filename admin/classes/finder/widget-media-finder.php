<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Abstract_Attachment_Finder;

class Widget_Media_Finder extends Abstract_Attachment_Finder{
    
    private $widgets = [];

    public function __construct($content, $finder_type, $file_type = NULL) {
        if($file_type === NULL){
            parent::__construct($content, $finder_type);
        }else{
            $this->content = $content->get_content($file_type);
            $this->finder_type = $finder_type;
        }
    }
        
    private function fetch_widget_by_id($widgets_content, $widget_type){
        foreach($widgets_content as $key => $val){
            if(is_array($val) && $val['attachment_id'] == $this->media_file->get_id()){
                $this->widgets[] = $widget_type.'-'.$key;
            }
        }
    }
    
    private function fetch_image_widgets(){
        $widgets_content = $this->content['widgets']['widget_media_image'];
        $this->fetch_widget_by_id($widgets_content, 'media_image');

        $widgets_content = $this->content['widgets']['widget_media_gallery'];
        foreach($widgets_content as $key => $val){
            if(is_array($val) && in_array($this->media_file->get_id(), $val['ids'])){
                $this->widgets[] = 'media_gallery-'.$key;
            }
        }
        
        $widgets_content = $this->content['widgets']['widget_text'];
        $search1 = 'wp-image-'.$this->media_file->get_id().' ';
        $search2 = 'wp-image-'.$this->media_file->get_id().'"';
        foreach($widgets_content as $key => $val){
            if(is_array($val) && array_key_exists('text', $val)){
                if(strpos($val['text'], $search1) !== FALSE 
                    || strpos($val['text'], $search2) !== FALSE){
                     $this->widgets[] = 'text-'.$key;
                }
                if(!in_array('text-'.$key, $this->widgets)){
                    $this->check_media_library_items($val['text'], $key);
                }
            }
        }
    }
    
    private function check_media_library_items($content, $key){
        $pattern = '/\[*ids="(.*?)"/';
        preg_match_all($pattern, $content, $output);
        
        $ids = array_map(function($val){
            return explode(',', $val);
        }, $output[1]);
 
        $overall_ids = [];       
        foreach($ids as $id_arr){
            $overall_ids = array_merge($id_arr, $overall_ids);
        }
        if(in_array($this->media_file->get_id(), $overall_ids)){
            $this->widgets[] = 'text-'.$key;
        }
    }
      
    private function fetch_audio_widgets(){
        $widgets_content = $this->content['widgets']['widget_media_audio'];
        $this->fetch_widget_by_id($widgets_content, 'media_audio');
        $this->fetch_default_widgets();     
    }
    
    private function fetch_video_widgets(){
        $widgets_content = $this->content['widgets']['widget_media_video'];
        $this->fetch_widget_by_id($widgets_content, 'media_video');
        $this->fetch_default_widgets();
    }
    
    private function fetch_default_widgets(){
        $widgets_content = $this->content['widgets']['widget_text'];
        foreach($widgets_content as $key => $val){
            $search = $this->media_file->get_src();
            if(is_array($val) && array_key_exists('text', $val)){
                if(strpos($val['text'], $search) !== FALSE ){
                    $this->widgets[] = 'text-'.$key;
                }
                if(!in_array('text-'.$key, $this->widgets)){
                    $this->check_media_library_items($val['text'], $key);
                }
            }
        }
    }
    
    protected function prepare_finder_args(){
        switch($this->media_file->get_short_mime_type()){
            case 'image':
                $this->fetch_image_widgets();
                break;
            case 'audio':
                $this->fetch_audio_widgets();
                break;
            case 'video':
                $this->fetch_video_widgets();
                break;
            default:
                $this->fetch_default_widgets();
                break;
        }
        return $this->widgets;
    }
    
    public function unset_finder_details() {
        parent::unset_finder_details();
        $this->widgets = [];
    }
    
    protected function check_finder_content($args) {
        $this->finder_details = [];
        $sidebar_widget_areas = $this->content['sidebars'];
        foreach($sidebar_widget_areas as $area_key => $widget_area){
            foreach($args as $widget_key => $widget_val){ 
                if(is_array($widget_area) && in_array($widget_val, $widget_area)){
                    $this->finder_details[$area_key][] = $widget_val;
                }
            }
        }
    }


}
