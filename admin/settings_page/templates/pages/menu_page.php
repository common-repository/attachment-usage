<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<div class="wrap">
    <h1><?php echo $page_title; ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_errors();
            settings_fields($menu_slug);           
            do_settings_sections($menu_slug);

            if($display_required_message){
                _e('Fields marked with * are required', 'attachment-usage');
            }
            
            submit_button(__("Save Settings","attachment-usage"));
        ?>
    </form>
</div>
    

