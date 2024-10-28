<?php
namespace AttachmentUsage\Core\ContentHolder;

abstract class Abstract_Content_Holder{
    
    protected $content;
    protected $wpdb;   
    
    public function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $this->fetch_content();
    }
    
    abstract protected function fetch_content();
    
    public function get_content(){
        return $this->content;
    }

}

