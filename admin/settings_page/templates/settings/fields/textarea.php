<?php
if (!defined('ABSPATH')){
    exit;
}
?>
<label for="<?php esc_attr_e($id); ?>">
    <textarea class="widefat" name="<?php esc_attr_e($option_name); ?>" 
              id="<?php esc_attr_e($id);?>"><?php echo $option_value; ?></textarea>
</label>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>