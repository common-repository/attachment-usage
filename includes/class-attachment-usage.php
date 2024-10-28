<?php
namespace AttachmentUsage\Includes;
use AttachmentUsage\PublicPlugin\Attachment_Usage_Public;
use AttachmentUsage\Includes\Attachment_Usage_i18n;
use AttachmentUsage\Includes\Attachment_Usage_Loader;
use AttachmentUsage\Admin\Attachment_Usage_Admin;
use AttachmentUsage\Core\Attachment_List_Table;
use AttachmentUsage\Core\Meta_Box;
use AttachmentUsage\Core\Rating_Banner;
use AttachmentUsage\SettingsLib\Page_Controller;
use AttachmentUsage\SettingsLib\Settings_Bootstrap;

class Attachment_Usage {

    protected $loader;
    protected $plugin_name;
    protected $version;


    public function __construct() {
        if(defined('ATTACHMENT_USAGE_VERSION')){
                $this->version = ATTACHMENT_USAGE_VERSION;
        }else{
                $this->version = '1.2';
        }
        $this->plugin_name = 'attachment-usage';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-attachment-usage-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-attachment-usage-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-attachment-usage-admin.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-attachment-usage-public.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/interfaces/configure.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/interfaces/factory.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/interfaces/validator.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/interfaces/attachment-output.php';                            

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/media-file.php';       

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/content-holder-wrapper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/abstract-content-holder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/gallery-content-holder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/content-holder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/thumbnail-content-holder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/widget-content-holder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/content_holder/product-category-content-holder.php';                

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/attachment-finder-controller.php';                
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/attachment-finder-wrapper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/abstract-attachment-finder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/post-content-attachment-finder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/post-thumbnail-media-finder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/product-category-media-finder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/product-gallery-media-finder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/finder/widget-media-finder.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/result-builder-controller.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/abstract-attachment-result-builder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/default-attachment-result-builder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/thumbnail-attachment-result-builder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/result-builder-factory.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/result_builder/widget-attachment-result-builder.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/output_setting/attachment-output-setting-factory.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/output_setting/attachment-output-setting.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/output_setting/product-category-attachment-output-setting.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/output_setting/widget-attachment-output-setting.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/rating-banner.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/custom-post-type-helper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/attachment-type.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/file-url-handler.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/attachment-item-usage-db-controller.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/attachment-list-table.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/meta-box.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/fetch-button-content-helper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/classes/screen-helper.php';                
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings_page/settings-bootstrap.php';

        $this->loader = new Attachment_Usage_Loader();
    }

    private function set_locale() {
        $plugin_i18n = new Attachment_Usage_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    private function define_admin_hooks() {                
        Settings_Bootstrap::bootstrap();
        $page_controller = new Page_Controller();
        $this->loader->add_action('admin_menu', $page_controller, 'create_menu_page');
        $this->loader->add_action('admin_init', $page_controller, 'prepare_page_elements');

        $attachment_meta_box = new Meta_Box('usage-media-box'
                , __('Attachment Usages', 'attachment-usage')
                , 'attachment', 'side', 'low');
        $this->loader->add_action('add_meta_boxes', $attachment_meta_box, 'configure'); 

        $attachment_list_table = new Attachment_List_Table();
        $this->loader->add_filter('manage_media_columns', $attachment_list_table, 'add_custom_media_list_column');
        $this->loader->add_action('manage_media_custom_column', $attachment_list_table, 'attachment_usage_content', 10, 2);
        if($attachment_list_table->is_sortable()){
            $this->loader->add_filter('manage_upload_sortable_columns', $attachment_list_table, 'attachment_usage_sortable_column');
            $this->loader->add_filter('pre_get_posts', $attachment_list_table, 'sort_attachment_list');
        }

        $plugin_admin = new Attachment_Usage_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_filter('attachment_fields_to_edit', $plugin_admin, 'display_attachment_usage', null, 2); 
        $this->loader->add_filter('wp_ajax_fetch_attachment_usage', $plugin_admin, 'fetch_attachment_usage');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('save_post', $plugin_admin, 'prepare_attachment_sync', 100);

        if(get_option('au_auto_sync') == 'yes'){
            $this->loader->add_action('current_screen', $plugin_admin, 'check_media_screen');
        }else{
            $this->loader->add_action('restrict_manage_posts', $plugin_admin, 'fetch_all_attachments_btn');
        }

        if(get_option('au_color_status') == 'yes'){
            $this->loader->add_filter('wp_prepare_attachment_for_js', $plugin_admin, 'custom_class_attachment_usage_status', 10, 3);
        }
        
        $rating_banner = new Rating_Banner(filemtime(__FILE__));
        $this->loader->add_action('admin_notices', $rating_banner, 'display_banner');
        $this->loader->add_filter('wp_ajax_au_dismiss_rating_banner', $rating_banner, 'dismiss_rating_banner');
    }

    private function define_public_hooks() {
        $plugin_public = new Attachment_Usage_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }

}
