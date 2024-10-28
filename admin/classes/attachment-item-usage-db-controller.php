<?php
namespace AttachmentUsage\Core;

class Attachment_Item_Usage_DB_Controller{
    
    private $attachment_items_with_postmeta;
    private $attachment_items_usage = [];
    private $wpdb;
    
    
    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $fields = array('au_attachment_item_usage', 'attachment');
        $sql = $this->wpdb->prepare("Select p.ID, pm.meta_key, pm.meta_value FROM {$this->wpdb->prefix}posts AS p "
                . "LEFT JOIN {$this->wpdb->prefix}postmeta AS pm on p.ID=pm.post_id "
                . "AND pm.meta_key=%s WHERE p.post_type=%s", $fields);
        $results = $this->wpdb->get_results($sql);
        $this->attachment_items_with_postmeta = $results;
        $this->prepare_attachment_items_usage();
    }
    
    private function prepare_attachment_items_usage(){
        foreach($this->attachment_items_with_postmeta as $attachment_item){
            if(!empty($attachment_item->meta_key)){
                $this->attachment_items_usage[$attachment_item->ID] = $attachment_item->meta_value;
            }else{
                $this->attachment_items_usage[$attachment_item->ID] = NULL;
            }
        }
    }

    public function trigger_database_actions($media_files_usage){
        $attachments_update_needed = [];
        $attachments_insert_needed = [];
        foreach($media_files_usage as $key => $val){
            $attachment_id = $val['media_file'];
            $usage = $val['usage'];
            
            if($this->is_update_needed($attachment_id, $usage)){
                if($this->attachment_items_usage[$attachment_id] === NULL){
                    $attachments_insert_needed[$attachment_id] = $usage;
                }else{
                    $attachments_update_needed[$attachment_id] = $usage;
                }               
            }
        }
        if(!empty($attachments_insert_needed)){
            $this->insert_attachments_usage($attachments_insert_needed);
        }
        if(!empty($attachments_update_needed)){
            $this->update_attachments_usage($attachments_update_needed);
        }
    }
    
    private function insert_attachments_usage($attachments_insert_needed){
        $values = '';
        $attachments_size = count($attachments_insert_needed);
        $i = 1;
        
        foreach($attachments_insert_needed as $attachment_id => $usage){
            if($i < $attachments_size){
                $values .= '('.$attachment_id.','.'"au_attachment_item_usage",'.'"'.$usage.'"),';
            }else{
                $values .= '('.$attachment_id.','.'"au_attachment_item_usage",'.'"'.$usage.'")';
            }
            $i += 1;
        }
        
        $this->wpdb->query("INSERT INTO {$this->wpdb->prefix}postmeta "
        . "(post_id, meta_key, meta_value) VALUES {$values}");
    }
    
    private function update_attachments_usage($attachments_update_needed){
        $table = $this->wpdb->prefix.'postmeta';
        foreach($attachments_update_needed as $attachment_id => $usage){
            $data = array('meta_value' => $usage);
            $where = array(
                'post_id' => $attachment_id, 
                'meta_key' => 'au_attachment_item_usage'
            );               
            $this->wpdb->update($table, $data, $where);
        }
    }

    private function is_update_needed($attachment_id, $usage){
        if($this->attachment_items_usage[$attachment_id] !== $usage){
            return TRUE;
        }
        return FALSE;
    }
    
}

