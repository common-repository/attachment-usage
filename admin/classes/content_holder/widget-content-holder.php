<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Abstract_Content_Holder;

class Widget_Content_Holder extends Abstract_Content_Holder{
    
    public function fetch_content(){
        $sidebars = get_option('sidebars_widgets');
        unset($sidebars['wp_inactive_widgets']);
        $this->content['sidebars'] = $sidebars;
        $this->content['widgets']['widget_media_image'] = get_option('widget_media_image');
        $this->content['widgets']['widget_media_gallery'] = get_option('widget_media_gallery');
        $this->content['widgets']['widget_text'] = get_option('widget_text');
        $this->content['widgets']['widget_media_audio'] = get_option('widget_media_audio');
        $this->content['widgets']['widget_media_video'] = get_option('widget_media_video');
    }
    
    /*
     * the optional file type should provide only needed data and therefore minimize 
     * computational time when checking for all attachments
     */
    public function get_content($file_type = NULL){
        $tmp_content_holder = $this->content;
        switch($file_type){
            case 'image':
                unset($tmp_content_holder['widgets']['widget_media_audio']);
                unset($tmp_content_holder['widgets']['widget_media_video']);
                break;
            default:
                unset($tmp_content_holder['widgets']['widget_media_image']);
                unset($tmp_content_holder['widgets']['widget_media_gallery']);
                break;
        }
        return $tmp_content_holder;
    }

}

