<?php
namespace AttachmentUsage\Core\Finder;
use AttachmentUsage\Core\Media_File;

abstract class Abstract_Attachment_Finder{
    
    protected $media_file;
    protected $content;
    protected $finder_details = [];
    protected $finder_type = 'page';
    
    
    public function __construct($content, $finder_type) {
        $this->content = $content->get_content();
        $this->finder_type = $finder_type;
    }
    
    protected abstract function prepare_finder_args();
    protected abstract function check_finder_content($args);

    public function set_media_file(Media_File $media_file){
        $this->media_file = $media_file;
    }
    
    public function get_finder_type(){
        return $this->finder_type;
    }

    public function get_result(){
        $args = $this->prepare_finder_args();
        $this->check_finder_content($args);
        return $this->finder_details;
    }
    
    public function unset_finder_details(){
        $this->finder_details = [];
    }
    
}

