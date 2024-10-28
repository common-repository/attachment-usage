<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Abstract_Content_Holder;

class Product_Category_Content_Holder extends Abstract_Content_Holder{

    public function fetch_content(){
        $field = 'thumbnail_id';
        $sql = $this->wpdb->prepare("SELECT term_id, meta_value FROM {$this->wpdb->prefix}termmeta "
                . "WHERE meta_key=%s", $field);
        $this->content = $this->wpdb->get_results($sql);
    }

}
