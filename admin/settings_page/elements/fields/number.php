<?php
namespace AttachmentUsage\SettingsLib\Elements\Fields;
use AttachmentUsage\SettingsLib\Elements\Basic_Field;

class Number extends Basic_Field{
    
    protected $template = 'number';
    
    public function __construct(array $options) {
        parent::__construct($options);
        if(array_key_exists('step', $options)){
            $this->data['step'] = $options['step'];
        }
    }

}
