<?php
namespace AttachmentUsage\SettingsLib;

class Settings_Bootstrap{
    
    public static function bootstrap(){

        require_once plugin_dir_path( __FILE__ ) . 'setting-string-helper.php';
        require_once plugin_dir_path( __FILE__ ) . 'template-path-finder.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/basic-element.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/basic-field.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/section.php';                

        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/checkbox.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/email.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/dropdown.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/radio.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/textarea.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/number.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/input.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/image.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/fields/file.php';

        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/abstract-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/abstract-whitelist-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/dropdown-whitelist-validator.php';              
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/radio-whitelist-validator.php';              
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/checkbox-whitelist-validator.php';              
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/string-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/email-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/number-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/file-validator.php';
        require_once plugin_dir_path( __FILE__ ) . 'elements/validators/validator-factory.php';

        require_once plugin_dir_path( __FILE__ ) . 'menu-page.php';
        require_once plugin_dir_path( __FILE__ ) . 'tab.php';
        require_once plugin_dir_path( __FILE__ ) . 'tabbed-menu-page.php';
        require_once plugin_dir_path( __FILE__ ) . 'menu-tabs-holder.php';
        require_once plugin_dir_path( __FILE__ ) . 'renderer.php';
        require_once plugin_dir_path( __FILE__ ) . 'page-controller.php';
        require_once plugin_dir_path( __FILE__ ) . 'page-elements-holder.php';
        require_once plugin_dir_path( __FILE__ ) . 'setting.php';
        require_once plugin_dir_path( __FILE__ ) . 'settings-holder.php';
        
    }
    
}
                                
