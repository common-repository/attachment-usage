<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Media_File;
use AttachmentUsage\Core\Attachment_Item_Usage_DB_Controller;
use AttachmentUsage\Core\ContentHolder\Content_Holder_Wrapper;
use AttachmentUsage\Core\Finder\Post_Content_Attachment_Finder;
use AttachmentUsage\Core\Finder\Post_Thumbnail_Media_Finder;
use AttachmentUsage\Core\Finder\Product_Gallery_Media_Finder;
use AttachmentUsage\Core\Finder\Product_Category_Media_Finder;
use AttachmentUsage\Core\Finder\Widget_Media_Finder;
use AttachmentUsage\Core\Custom_Post_Type_Helper;

class Attachment_Finder_Wrapper{
    
    private $content_holder_wrapper;
    private $image_finder = [];
    private $attachment_finder = [];
    
    public function __construct(){
        $this->content_holder_wrapper = new Content_Holder_Wrapper();
    }
    
    private function prepare_finders(){       
        $this->attachment_finder[] = new Post_Content_Attachment_Finder($this->content_holder_wrapper->get_holder('post'), 'post');
        $this->attachment_finder[] = new Post_Content_Attachment_Finder($this->content_holder_wrapper->get_holder('page'), 'page');
  
        $custom_post_types = Custom_Post_Type_Helper::get_public_custom_post_types();
        if(!empty($custom_post_types)){
            foreach($custom_post_types as $custom_post_type){
                $this->attachment_finder[] = new Post_Content_Attachment_Finder($this->content_holder_wrapper->get_holder($custom_post_type, TRUE), $custom_post_type);
            }
        }
        
        $this->image_finder[] = new Post_Thumbnail_Media_Finder($this->content_holder_wrapper->get_holder('thumbnail'), 'thumbnail');
        $this->image_finder[] = new Product_Gallery_Media_Finder($this->content_holder_wrapper->get_holder('wc-gallery'), 'wc-gallery');
        $this->image_finder[] = new Product_Category_Media_Finder($this->content_holder_wrapper->get_holder('wc-category'), 'wc-category');
        $this->image_finder[] = new Widget_Media_Finder($this->content_holder_wrapper->get_holder('widget'), 'sidebar', 'image');                

        $this->image_finder = array_merge($this->attachment_finder, $this->image_finder);
        /* 
         * placed attachment_finder assignment after array_merge, because the
         * WidgetMediaFinder can have an optional parameter, which is only needed
         * for the image_finder
         */
        $this->attachment_finder[] = new Widget_Media_Finder($this->content_holder_wrapper->get_holder('widget'), 'sidebar');                
    }
    
    public function get_attachment_usage($media_files){        
        $overall_usages = [];
        $this->prepare_finders();
        $attachment_item_usage_db = new Attachment_Item_Usage_DB_Controller();
        $is_attachment_list_sortable = get_option('au_filter_by_usage');
        $media_files_usage = [];
        
        foreach($media_files as $media_file){
            $usages = [];
            $finders = $this->determine_finders($media_file->get_short_mime_type());
            foreach($finders as $finder){    
                $finder->set_media_file($media_file);
                $finder->unset_finder_details();
                $result = $finder->get_result();
                $usages = $this->prepare_usages($result, $usages, $finder);
            }
            $overall_usages = $this->prepare_overall_usages($usages, $media_file, $overall_usages);
            $media_files_usage[] = array(
                'media_file' => $media_file->get_id(), 
                'usage' => !empty($usages) ? 'found': 'not-found'
            );
        }
        if($is_attachment_list_sortable){
            $attachment_item_usage_db->trigger_database_actions($media_files_usage);  
        }
        /*
         * guarantee that usage option in db has always the required array keys needed 
         * for the result builder
         */
        if(!array_key_exists('not-found', $overall_usages)){
            $overall_usages['not-found'] = [];
        }
        if(!array_key_exists('found', $overall_usages)){
            $overall_usages['found'] = [];
        }
        return $overall_usages;
    }
    
    private function prepare_usages($result, $usages, $finder){
        if(!empty($result)){
            $type = $finder->get_finder_type();
            $usages[$type] = $result;
        }
        return $usages;
    }
    
    private function prepare_overall_usages($usages, Media_File $media_file, $overall_usages){
        if(!empty($usages)){
            $overall_usages['found'][$media_file->get_id()] = $usages;
        }else{
            $overall_usages['not-found'][] = $media_file->get_id();
        }
        return $overall_usages;
    }
    
    private function determine_finders($attachment_type){
        if($attachment_type == 'image'){
            return $this->image_finder;
        }
        return $this->attachment_finder;
    }
    
}

