<?php
if (!defined('ABSPATH')){
    exit;
}
?>
<div class="wrap">
    <h1><?php echo $page_title; ?></h1>

    <h2 class="nav-tab-wrapper">
        <?php 
        $index = 0;
        foreach($tabs as $tab){
            $url = "?page=".$menu_slug."&tab=".$tab->get_menu_slug();
            if($index == 0 && $tabs_clicked != 1){?>
                <a href="<?php _e($url); ?>" class="<?php _e($tab->get_class());?> nav-tab-active"><?php _e($tab->get_title()); ?></a>
            <?php }else{?>
                <a href="<?php _e($url); ?>" class="<?php _e($tab->get_class());?>"><?php _e($tab->get_title()); ?></a>
            <?php } 
            $index += 1;
        }
        ?>
    </h2>

    <form method="post" action="options.php">
        <?php
            settings_errors();
            settings_fields($active_tab->get_menu_slug());
            do_settings_sections($active_tab->get_menu_slug());
            
            if($display_required_message){
                _e('Fields marked with * are required', 'attachment-usage');
            }
            
            submit_button("Save Settings");
        ?>
    </form>
</div>
    

