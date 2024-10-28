<?php
namespace AttachmentUsage\SettingsLib\Elements\Fields;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;

class File extends Basic_Field{
    
    protected $template = 'file';
    protected $directory = 'settings/fields';    

    
    protected function provide_value(){
        $option_value = get_option($this->data['option_name'], 0);
        $post = get_post($option_value);
        $url = '';
        if($post !== NULL && $post->post_type === 'attachment'){
            $url = wp_get_attachment_url($post->ID);
            $this->data['attachment'] = $post->ID;
            $this->data['attachment_title'] = $post->post_title;
            $this->data['url'] = $url;
        }else{
            $this->data['attachment'] = 0;
            $this->data['attachment_title'] = '';
            $this->data['url'] = '';
        }
        $this->data['option_value'] = $option_value;
    }
    
}

