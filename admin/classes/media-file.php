<?php
namespace AttachmentUsage\Core;
use AttachmentUsage\Core\Attachment_Type;
use AttachmentUsage\Core\File_Url_Handler;
        
class Media_File{
    
    private $id;
    private $mime_type;
    private $short_mime_type;
    private $file_url_handler;
    
    
    public function __construct($post_id, $post_mime_type, File_Url_Handler $file_url_handler) {
        $this->id = $post_id;
        $this->mime_type = $post_mime_type;
        $attachment_type_obj = new Attachment_Type($this->mime_type);
        $this->short_mime_type = $attachment_type_obj->get_attachment_type();
        $this->file_url_handler = $file_url_handler;
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function get_short_mime_type(){
        return $this->short_mime_type;
    }

    public function get_mime_type(){
        return $this->mime_type;
    }
    
    public function get_src(){
        return $this->file_url_handler->get_url();
    }
    
}

