<?php
namespace AttachmentUsage\Admin;
use AttachmentUsage\Core\Screen_Helper;
use AttachmentUsage\Core\Fetch_Button_Content_Helper;
use AttachmentUsage\Core\Finder\Attachment_Finder_Controller;
use AttachmentUsage\Core\ResultBuilder\Result_Builder_Controller;

class Attachment_Usage_Admin {

	private $plugin_name;
	private $version;

        
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
        
        public function check_media_screen(){
            $screen_helper = new Screen_Helper();
            if($screen_helper->is_screen_like('upload')){
                $attachment_finder_controller = new Attachment_Finder_Controller();
                $attachment_finder_controller->sync_attachment_usage();                
            }           
        }

        public function async_attachment_sync(){
            $attachment_finder_controller = new Attachment_Finder_Controller();
            $attachment_finder_controller->sync_attachment_usage();
        }
        
        /*
         * register shutdown function async_attachment_sync only when post is saved
         * avoid unnecessary computation, this is the entry point to be sure data might 
         * have been written to database afterwards
         */
        public function prepare_attachment_sync($post_id){
            $supported_types = array('page', 'post', 'product');
            if(in_array(get_post_type($post_id), $supported_types)){
                add_action('shutdown', array($this, 'async_attachment_sync'));
            }
        }
        
        public function custom_class_attachment_usage_status($response, $attachment, $meta){
            $usage_data = get_option('au_attachment_usage_found');
            $custom_class = 'found';
            if(in_array($attachment->ID, $usage_data['not-found'])
                || !array_key_exists($attachment->ID, $usage_data['found'])){
                $custom_class = 'not-found';
            }
            $response['custom_class'] = $custom_class;
            return $response;
        }
        
        public function custom_class_media_grid_elements(){
            $params = array(
                'ajax_nonce' => wp_create_nonce('fetch_attachment_usage'),
                'render_fetch_attachment_button' => FALSE,
                'display_custom_class' => get_option('au_color_status') == 'yes' ? TRUE : FALSE
            );
            $screen_helper = new Screen_Helper();
            if($screen_helper->is_screen_like('upload')){
                $params['render_fetch_attachment_button'] = TRUE;
            }
            
            wp_register_script('custom-class-media-grid-elements', plugin_dir_url( __FILE__ ) . 'js/custom-class-media-grid-element.js', array( 'jquery' ));
            wp_localize_script('custom-class-media-grid-elements', 'obj', $params );
            wp_enqueue_script('custom-class-media-grid-elements');
        }
        
        public function display_attachment_usage($form_fields, $post){
 
            /*
             * this condition is made to exclude media usage on attachment page,
             * because a metabox will hold the content there
             */
            $is_attachment = FALSE;
            $screen_helper = new Screen_Helper();
            if($screen_helper->is_screen_like('attachment')){
                $is_attachment = TRUE;
            }
            
            $result_builder_controller = new Result_Builder_Controller($post->ID);
            if($result_builder_controller->is_attachment_found()){
                $result_builder_controller->build_result();
            }
            $result = $result_builder_controller->get_result();

            if(!$is_attachment){
                $fetch_btn_content_helper = new Fetch_Button_Content_Helper($post->ID);
                $content = $fetch_btn_content_helper->get_button_with_result($result);
                
                $form_fields['media_usage'] = array(
                    'label' => __('Attachment Usages','attachment-usage'),
                    'input' => 'html',
                    'html' => $content,
                    'value' => ''
                );
            } 
            return $form_fields;
        }
        
        public function fetch_all_attachments_btn(){
            $screen_helper = new Screen_Helper();
            if($screen_helper->is_screen_like('upload') && $screen_helper->is_mode_like('list')){
                $fetch_btn_content_helper = new Fetch_Button_Content_Helper($post_id = 0);
                $btn = $fetch_btn_content_helper->get_button();
                echo '<div id="attachment-usage-table">'.$btn.'<span class="spinner"></span></div>';
            }
        }
        
        public function fetch_attachment_usage(){
            if(!check_ajax_referer('fetch_attachment_usage', '_wpnonce', FALSE)){
                wp_send_json_error(__('No valid Ajax request', 'attachment-usage'));
            }
            
            $attachment_finder_controller = new Attachment_Finder_Controller();
            $attachment_finder_controller->sync_attachment_usage();

            if(!isset($_REQUEST['attachment_id']) || !is_numeric($_REQUEST['attachment_id'])
                    || (is_numeric($_REQUEST['attachment_id']) && $_REQUEST['attachment_id'] < '0')){
                wp_send_json_error(__('No valid Attachment Id sent','attachment-usage'));
            }
            
            $attachment_id = (int) $_REQUEST['attachment_id'];
            $is_found = TRUE;
            
            if($attachment_id !== 0){
                $result_builder_controller = new Result_Builder_Controller($attachment_id);
                if($result_builder_controller->is_attachment_found()){
                    $result_builder_controller->build_result();
                    $is_found = TRUE;
                }else{
                    $is_found = FALSE;
                }
                $result = $result_builder_controller->get_result();             
            }else{
                $result = NULL;
            }
            
            $json_arr = array("content" => $result, "is_found" => $is_found);
            wp_send_json_success($json_arr);
        }
        
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/attachment-usage-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {
            $params = array(
                'render_fetch_attachment_button' => FALSE,
                'ajax_nonce' => wp_create_nonce('fetch_attachment_usage'),
                'display_custom_class' => get_option('au_color_status') == 'yes' ? TRUE : FALSE
            );
            
            $screen_helper = new Screen_Helper();
            if($screen_helper->is_screen_like('upload')){
                if(get_option('au_auto_sync') == 'yes'){
                    $params['render_fetch_attachment_button'] = FALSE;
                }else{
                    $params['render_fetch_attachment_button'] = TRUE;
                }
            }
            
            wp_register_script('au-media-library-behavior', plugin_dir_url( __FILE__ ) . 'js/attachment-usage-media-library-behavior.js', array('jquery', 'wp-i18n'));
            wp_set_script_translations('au-media-library-behavior', 'attachment-usage');
            if($hook === 'widgets.php'){
                wp_register_script('attachment-usage-widget-behavior', plugin_dir_url( __FILE__ ) . 'js/attachment-usage-widget-behavior.js', array( 'jquery', 'wp-i18n', 'au-media-library-behavior'));
                wp_localize_script('attachment-usage-widget-behavior', 'obj', $params );
                wp_enqueue_script('attachment-usage-widget-behavior');
            }else{
                wp_register_script('attachment-usage-admin', plugin_dir_url( __FILE__ ) . 'js/attachment-usage-admin.js', array( 'jquery', 'au-media-library-behavior'));
                wp_register_script('attachment-usage-media-frame', plugin_dir_url( __FILE__ ) . 'js/attachment-usage-media-frame.js', array( 'jquery', 'wp-i18n'));
                wp_set_script_translations('attachment-usage-media-frame', 'attachment-usage');
                wp_localize_script('attachment-usage-admin', 'obj', $params );
                wp_enqueue_media();
                wp_enqueue_script('attachment-usage-admin');
                wp_enqueue_script('attachment-usage-media-frame');
            } 
	}

}
