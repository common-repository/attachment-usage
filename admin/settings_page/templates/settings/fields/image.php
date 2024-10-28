<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<div class="image-wrapper">
    <button data-type="image" class="upload-attachment button-secondary"><?php _e('Upload Image', 'attachment-usage'); ?></button>
    <img src="<?php esc_attr_e($url); ?>" class="preview-holder" />
    <a href="#" class="remove-attachment <?php if($url === ''){ echo 'hide';}?>">
        <?php _e('Remove Image', 'attachment-usage');?>
    </a>
    <input class="image-id" type="hidden" name="<?php esc_attr_e($option_name);?>" 
           id="<?php esc_attr_e($id);?>" value="<?php esc_attr_e($attachment);?>">
</div>
    
<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>