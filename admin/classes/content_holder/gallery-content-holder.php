<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Abstract_Content_Holder;

class Gallery_Content_Holder extends Abstract_Content_Holder{

    public function fetch_content(){
    $field = '_product_image_gallery';
        $sql = $this->wpdb->prepare("SELECT post_id, meta_value FROM {$this->wpdb->prefix}postmeta "
                . "WHERE meta_key=%s", $field);
        $this->content = $this->wpdb->get_results($sql);
    }

}
