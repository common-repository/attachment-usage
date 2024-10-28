<?php
namespace AttachmentUsage\Core;

class Fetch_Button_Content_Helper{
    
    private $attachment_id;
    
    
    public function __construct($attachment_id) {
        $this->attachment_id = $attachment_id;
    }
    
    public function get_button(){
        $btn = '<button data-id="'.esc_attr($this->attachment_id).'" '
                . 'class="fetch-attachment-usage media-list button-secondary" '
                . 'id="'.esc_attr('fetch-usage-nonce-'.$this->attachment_id).'" '
                . 'value="'.esc_attr(wp_create_nonce('fetch_attachment_usage')).'">'
                .__('Fetch Attachment Usage', 'attachment-usage').'</button>';
        return $btn;
    }
    
    public function get_button_with_result($result){
        $content = $this->get_button().'<span class="spinner"></span><br>'
                . '<div class="attachment-usage-wrapper">'.$result.'</div>';
        return $content;
    }
    
}

