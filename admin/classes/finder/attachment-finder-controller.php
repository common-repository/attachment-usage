<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Finder\Attachment_Finder_Wrapper;
use AttachmentUsage\Core\File_Url_Handler;
use AttachmentUsage\Core\Media_File;

class Attachment_Finder_Controller{
  
    private $attachment_finder_wrapper;
    private $wpdb;
    private $posts;
    
    
    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->attachment_finder_wrapper = new Attachment_Finder_Wrapper();
        
        $fields = array('attachment', '_wp_attached_file');
        $sql = $this->wpdb->prepare("SELECT p.ID, p.guid, p.post_mime_type, pm.meta_value "
                . "FROM {$this->wpdb->prefix}posts AS p INNER JOIN {$this->wpdb->prefix}postmeta AS pm "
                . "ON p.ID=pm.post_id WHERE p.post_type=%s AND pm.meta_key=%s", $fields);
        $this->posts = $this->wpdb->get_results($sql);
    }
    
    public function sync_attachment_usage(){
        if(count($this->posts) > 0){
            $media_objs = [];
            foreach($this->posts as $key => $obj){
                $file_url_handler = new File_Url_Handler($obj->meta_value, $obj->guid);
                $media_obj = new Media_File($obj->ID, $obj->post_mime_type, $file_url_handler);
                $media_objs[] = $media_obj;                
            }
            $overall_usage = $this->attachment_finder_wrapper->get_attachment_usage($media_objs);
            update_option('au_attachment_usage_found', $overall_usage);
        }
    }

}

