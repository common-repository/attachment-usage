<?php
namespace AttachmentUsage\Core;
use AttachmentUsage\Core\Fetch_Button_Content_Helper;
use AttachmentUsage\Core\ResultBuilder\Result_Builder_Controller;
use AttachmentUsage\Interfaces\IConfigure;

class Meta_Box implements IConfigure{
    
    private $id;
    private $title;
    private $site;
    private $ctxt;
    private $priority;
    
    public function __construct($id, $title, $site, $ctxt, $priority){
        $this->id = $id;
        $this->title = $title;
        $this->site = $site;
        $this->ctxt = $ctxt;
        $this->priority = $priority;
    }
    
    public function configure(){
        add_meta_box($this->id, $this->title, array($this, 'render'), $this->site, 
                $this->ctxt, $this->priority);
    }
    
    public function render($post){
        $result_builder_controller = new Result_Builder_Controller($post->ID);
        if($result_builder_controller->is_attachment_found()){
            $result_builder_controller->build_result();
        }
        $result = $result_builder_controller->get_result();
        
        $fetch_btn_content_helper = new Fetch_Button_Content_Helper($post->ID);
        $content = $fetch_btn_content_helper->get_button_with_result($result);

        echo $content;
    }
    
}

