<?php
namespace AttachmentUsage\Core\OutputSetting;
use AttachmentUsage\Interfaces\IAttachmentOutput;

class Widget_Attachment_Output_Setting implements IAttachmentOutput{
    
    private $location_info;
    private $section_title;
    private $results;
    
    public function __construct($location_info, $section_title){
        $this->location_info = $location_info;
        $this->section_title = $section_title;
    }
    
    public function set_results($results){
        $this->results = $results;
    }
    
    public function get_title($sidebar) {
        return $this->section_title.'-'.ucfirst($sidebar);
    }

    public function get_edit_link($sidebar) {
        $url_param = "widgets.php?show_widgets=".$sidebar.'&widget_elements=';
        $count = count($this->results[$sidebar]);
        for($i = 0; $i < $count; ++$i){
            $val = $this->results[$sidebar][$i];
            if($i < $count - 1){
                $url_param .= $val.',';
            }else{
                $url_param .= $val;
            }
        }       
        return admin_url($url_param);
    }

    public function get_location_info() {
        return $this->location_info;
    }

    public function get_section_title() {
        return $this->section_title;
    }

    
}