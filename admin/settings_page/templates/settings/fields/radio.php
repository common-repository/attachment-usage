<?php
if (!defined('ABSPATH')){
    exit;
}
?>
<?php if(isset($group)): ?>
    <?php foreach($group as $item): ?>
        <label for="<?php esc_attr_e($item['id']); ?>">
            <input id="<?php esc_attr_e($item['id']); ?>" type="radio" 
                   value="<?php esc_attr_e($item['value']);?>" 
                   name="<?php esc_attr_e($option_name); ?>" 
                       <?php checked($item['value'] === $option_value ); ?>>
                       <?php echo $item['title'];?></br>
        </label>
    <?php endforeach; 

    if(isset($description)) : ?>
        <p class="description"><?php echo $description; ?></p>
    <?php endif; ?>
    
<?php endif; ?>
