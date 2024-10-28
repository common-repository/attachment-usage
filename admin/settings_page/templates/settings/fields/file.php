<?php
if (!defined('ABSPATH')){
    exit;
}
?>
<div class="file-wrapper">
    <button data-type="application" class="upload-attachment button-secondary"><?php _e('Upload File', 'attachment-usage'); ?></button>
    <input class="file-id" type="hidden" name="<?php esc_attr_e($option_name); ?>" 
           id="<?php esc_attr_e($id);?>" value="<?php esc_attr_e($attachment); ?>">
    <a class="file-link" target="_blank" href="<?php esc_attr_e($url); ?>">
        <?php echo $attachment_title; ?>
    </a>
    <a href="#" class="remove-attachment <?php if($url === ''){echo 'hide';}?>">
        <?php _e('Remove File', 'attachment-usage');?>
    </a></br>
</div>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>