<?php
namespace AttachmentUsage\Core;
use AttachmentUsage\Core\ResultBuilder\Result_Builder_Controller;

class Attachment_List_Table{
    
    private $is_sortable;
    private $is_usage_display;
            
            
    public function __construct(){
        $this->is_sortable = get_option('au_filter_by_usage') === 'yes' ? TRUE : FALSE;
        $this->is_usage_display = get_option('au_display_usage_listview', 'yes') === 'yes' ? TRUE : FALSE;
    }
    
    public function add_custom_media_list_column($columns){
        $columns['attachment-usage'] = __('Status', 'attachment-usage');
        if($this->is_usage_display){
            $columns['attachment-usage-display'] = __('Usages', 'attachment-usage');
        }
        return $columns;
    }

    public function is_sortable(){
        return $this->is_sortable;
    }
    
    public function attachment_usage_content($column_name, $post_id){
        if($column_name === 'attachment-usage'){
            $this->display_attachment_status($post_id);
        }else if($column_name === 'attachment-usage-display'){
            $this->display_attachment_usage($post_id);
        }else{
            return;
        }        
    }
    
    private function display_attachment_status($post_id){
        $usage_data = get_option('au_attachment_usage_found');       
        if(in_array($post_id, $usage_data['not-found'])){
            _e('not-found', 'attachment-usage');
        }else{
            _e('found', 'attachment-usage');
        }
    }
    
    private function display_attachment_usage($post_id){
        $result_builder_controller = new Result_Builder_Controller($post_id);
        if($result_builder_controller->is_attachment_found()){
            $result_builder_controller->build_result();
        }
        $result = $result_builder_controller->get_result();
        echo $result;
    }

    public function attachment_usage_display_content($column_name, $post_id){
        if($column_name !== 'attachment-usage'){
            return;
        }
        $usage_data = get_option('au_attachment_usage_found');       
        if(in_array($post_id, $usage_data['not-found'])){
            _e('not-found', 'attachment-usage');
        }else{
            _e('found', 'attachment-usage');
        }
    }
    
    public function attachment_usage_sortable_column($columns){
        $columns['attachment-usage'] = 'attachment-usage';
        return $columns;
    }

    public function sort_attachment_list($query){
        if(!is_admin()){
            return;
        }
        $orderby = $query->get('orderby');
        if($orderby == 'attachment-usage'){
            $query->set('meta_key', 'au_attachment_item_usage');
            $query->set('orderby', 'meta_value');
        }
    }

}
