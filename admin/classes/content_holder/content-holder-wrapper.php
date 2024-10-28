<?php
namespace AttachmentUsage\Core\ContentHolder;
use AttachmentUsage\Core\ContentHolder\Content_Holder;
use AttachmentUsage\Core\ContentHolder\Thumbnail_Content_Holder;
use AttachmentUsage\Core\ContentHolder\Gallery_Content_Holder;
use AttachmentUsage\Core\ContentHolder\Widget_Content_Holder;
use AttachmentUsage\Core\ContentHolder\Product_Category_Content_Holder;

class Content_Holder_Wrapper{
    
    private $post_content_holder;
    private $thumbnail_content_holder;
    private $gallery_content_holder;
    private $widget_content_holder;
    private $product_category_content_holder;
    private $page_content_holder;
    
    
    public function __construct(){
        global $wpdb;
        $this->post_content_holder = new Content_Holder($wpdb, 'post');
        $this->page_content_holder = new Content_Holder($wpdb, 'page');
        $this->thumbnail_content_holder = new Thumbnail_Content_Holder($wpdb);
        $this->gallery_content_holder = new Gallery_Content_Holder($wpdb);
        $this->widget_content_holder = new Widget_Content_Holder($wpdb);
        $this->product_category_content_holder = new Product_Category_Content_Holder($wpdb);
    }
    
    public function get_holder($finder, $is_custom_type = FALSE){
        if($is_custom_type){
            global $wpdb;
            return new Content_Holder($wpdb, $finder);
        }else{
            switch($finder){
                case 'thumbnail':
                    return $this->thumbnail_content_holder;
                case 'wc-gallery':
                    return $this->gallery_content_holder;
                case 'wc-category':
                    return $this->product_category_content_holder;
                case 'post':
                    return $this->post_content_holder;
                case 'page':
                    return $this->page_content_holder;            
                case 'widget':
                    return $this->widget_content_holder;
            }
        }
    }
    
}
