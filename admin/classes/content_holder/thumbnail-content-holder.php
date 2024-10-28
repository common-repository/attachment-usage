<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Abstract_Content_Holder;

class Thumbnail_Content_Holder extends Abstract_Content_Holder{

    public function fetch_content(){
        $field = '_thumbnail_id';
        $sql = $this->wpdb->prepare("SELECT pm.post_id, pm.meta_value, p.post_type, p.post_parent "
                . "FROM {$this->wpdb->prefix}postmeta AS pm INNER JOIN {$this->wpdb->prefix}posts AS p "
                . "ON p.ID=pm.post_id WHERE pm.meta_key=%s", $field);
        $this->content = $this->wpdb->get_results($sql);
    }

}

