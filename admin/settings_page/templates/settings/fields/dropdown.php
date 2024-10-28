<?php
if (!defined('ABSPATH')){
    exit;
}
?>

<label for="<?php esc_attr_e($id); ?>">
    <select name="<?php esc_attr_e($option_name); ?>" id="<?php esc_attr_e($id);?>">
        <?php foreach($dropdown_options as $key=>$value):?>
                <option value="<?php esc_attr_e($key);?>" <?php if($key === $option_value){echo "selected='selected'" ;} ?>>
                    <?php echo $value; ?>
                </option>
        <?php endforeach; ?>       
    </select>
</label>

<?php if(isset($description)) : ?>
    <p class="description"><?php echo $description; ?></p>
<?php endif; ?>