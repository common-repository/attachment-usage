<?php
namespace AttachmentUsage\SettingsLib\Elements\Fields;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;

class Dropdown extends Basic_Field{
    
    protected $template = 'dropdown';

    public function __construct(array $options) {
        parent::__construct($options);
        if(array_key_exists("dropdown_options", $options)){
            $this->data["dropdown_options"] = $options["dropdown_options"];
        }
    }
   
}

