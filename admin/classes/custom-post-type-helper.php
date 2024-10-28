<?php
namespace AttachmentUsage\Core;

class Custom_Post_Type_Helper{

    public static function get_public_custom_post_types(){
        $args = array('_builtin' => FALSE, 'public' => TRUE);
        return get_post_types($args);
    }
    
}
