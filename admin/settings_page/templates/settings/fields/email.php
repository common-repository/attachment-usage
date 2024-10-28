<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<label for="<?php esc_attr_e($id); ?>">
    <input type="email" name="<?php esc_attr_e($option_name); ?>" 
           id="<?php esc_attr_e($id);?>" value="<?php esc_attr_e($option_value); ?>" >
</label>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>