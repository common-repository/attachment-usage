<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Abstract_Content_Holder;

class Content_Holder extends Abstract_Content_Holder{

    private $field;
    
    public function __construct($wpdb, $field){
        $this->field = $field;
        parent::__construct($wpdb);
    }
    
    public function fetch_content(){
        $field = $this->field;
        if(defined('ELEMENTOR_VERSION')){
            $sql = $this->wpdb->prepare("SELECT p.post_type, p.post_content, p.post_excerpt, p.ID, pm.meta_value "
                    . "FROM {$this->wpdb->prefix}posts AS p LEFT JOIN {$this->wpdb->prefix}postmeta "
                    . "AS pm ON p.ID=pm.post_id AND pm.meta_key='_elementor_data' "
                    . "WHERE p.post_type=%s", $field);
        }else{
            $sql = $this->wpdb->prepare("SELECT post_type, post_content, post_excerpt, ID "
                    . "FROM {$this->wpdb->prefix}posts WHERE post_type=%s", $field);
        }
        $this->content = $this->wpdb->get_results($sql);
    }

}

