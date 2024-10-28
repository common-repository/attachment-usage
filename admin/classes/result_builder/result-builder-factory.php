<?php
namespace AttachmentUsage\Core\ResultBuilder;
use AttachmentUsage\Interfaces\IFactory;
use AttachmentUsage\Core\ResultBuilder\Widget_Attachment_Result_Builder;
use AttachmentUsage\Core\ResultBuilder\Default_Attachment_Result_Builder;
use AttachmentUsage\Core\OutputSetting\Attachment_Output_Setting_Factory;

class Result_Builder_Factory implements IFactory{
    
    private $object;
    private $type;
    private $data;
    
    public function __construct($type, $data){
        $this->type = $type;
        $this->data = $data;
        $this->object = $this->determine_obj();
    }
    
    private function determine_obj(){
        switch($this->type){
            case 'sidebar':
                return new Widget_Attachment_Result_Builder(
                        $this->data,
                        new Attachment_Output_Setting_Factory($this->type)
                        );
            case 'thumbnail':
                return new Thumbnail_Attachment_Result_Builder(
                        $this->data,
                        new Attachment_Output_Setting_Factory($this->type)
                        );
            default:
                return new Default_Attachment_Result_Builder(
                        $this->data,
                        new Attachment_Output_Setting_Factory($this->type)
                        );
        }
    }
    
    public function get_object() {
        return $this->object;
    }
    
}