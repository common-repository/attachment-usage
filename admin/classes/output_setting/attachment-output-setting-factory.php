<?php
namespace AttachmentUsage\Core\OutputSetting;
use AttachmentUsage\Interfaces\IFactory;
use AttachmentUsage\Core\OutputSetting\Widget_Attachment_Output_Setting;
use AttachmentUsage\Core\OutputSetting\Product_Category_Attachment_Output_Setting;
use AttachmentUsage\Core\OutputSetting\Attachment_Output_Setting;

class Attachment_Output_Setting_Factory implements IFactory{
    
    private $type;
    private $output_location_info;
    private $output_section_title;
    private $object;
    
    
    public function __construct($type) {
        $this->type = $type;
        $this->object = $this->determine_object();
    }
    
    private function determine_object(){
        switch($this->type){
            case 'sidebar':
                $this->set_output_data(
                    __('(in widget)', 'attachment-usage'),
                    __('Widgets', 'attachment-usage')
                );
                return new Widget_Attachment_Output_Setting($this->output_location_info, $this->output_section_title);
            case 'wc-category':
                $this->set_output_data(
                    __('(in product category)', 'attachment-usage'),
                    __('Product Category', 'attachment-usage')
                );
                return new Product_Category_Attachment_Output_Setting($this->output_location_info, $this->output_section_title);
            case 'wc-gallery':
                $this->set_output_data(
                    __('(in product gallery)', 'attachment-usage'),
                    __('Product Attachment', 'attachment-usage')
                );
                break;
            case 'product':
                $this->set_output_data(
                    __('(in product content)', 'attachment-usage'),
                    __('Product Content', 'attachment-usage')
                );
                break;
            case 'post':
                $this->set_output_data(
                    __('(in post content)', 'attachment-usage'),
                    __('Post Content', 'attachment-usage')
                 );
                break;
            case 'page':
                $this->set_output_data(
                    __('(in page content)', 'attachment-usage'),
                    __('Page Content', 'attachment-usage')
                 );
                break;
            case 'thumbnail':
                $this->set_output_data(
                    __('(thumbnail)', 'attachment-usage'),
                    __('Post Attachment', 'attachment-usage')
                );
                break;
            default:
                $custom_post_type = get_post_type_object($this->type);
                $custom_post_type_name = $custom_post_type->labels->singular_name;
                $this->set_output_data(
                    __('(in content)', 'attachment-usage'),
                    sprintf(__('Custom Post Type: %s', 'attachment-usage'), $custom_post_type_name)
                );
                break;
        }
        return new Attachment_Output_Setting($this->output_location_info, $this->output_section_title);
    }
    
    private function set_output_data($location_info, $section_title){
        $this->output_location_info = $location_info;
        $this->output_section_title = $section_title;
    }
    
    public function get_object(){
        return $this->object;
    }
    
}

