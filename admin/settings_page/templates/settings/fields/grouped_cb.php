<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<?php foreach($group as $item): ?>
    <label for="<?php esc_attr_e($item['id']); ?>">
        <input id="<?php esc_attr_e($item['id']); ?>" type="checkbox" 
               value="<?php esc_attr_e($item['value']);?>" 
               name="<?php esc_attr_e($group_option_name); ?>" <?php checked(in_array($item['value'], $option_value)); ?>>
                   <?php echo $item['title'];?></br>
    </label>
<?php endforeach; ?>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>