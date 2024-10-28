<?php
if (!defined('ABSPATH')){
    exit;
}

return array(
    'au_admin_path' => plugin_dir_path(__FILE__),
    'au_admin_templates' => plugin_dir_path(__FILE__) . 'templates/',
    'au_admin_page' => plugin_dir_path(__FILE__) . 'pages/',
    'au_admin_renderer' => plugin_dir_path(__FILE__) . 'renderer.php',
);
