<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<label for="<?php esc_attr_e($id); ?>">
    <input id="<?php esc_attr_e($id); ?>" type="checkbox" value="1" name="<?php esc_attr_e($option_name); ?>" <?php checked( $option_value ); ?>>
    <?php echo $title; ?>
</label>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>