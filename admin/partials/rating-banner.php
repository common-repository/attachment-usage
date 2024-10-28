<?php
if (!defined('ABSPATH')){
    exit;
}
?>
<div class="notice au-rating-banner">
    <h3><?php _e('Attachment Usage says Thank you!','attachment-usage'); ?></h3>
    <div class="content">
        <p><?php _e('I hope the "Attachment Usage" plugin helps you working more efficient on your site. '
                . 'If you like it, it would be very kind if you rate the plugin.', 'attachment-usage'); ?>
        </p>
        <p class="attachment-usage action-links">
            <a data-nonce="<?php esc_attr_e(wp_create_nonce('au_dismiss_rating_banner')); ?>" class="au-dismiss-rating-banner" href="#"><?php _e('Dismiss', 'attachment-usage'); ?></a>
            <a href="https://wordpress.org/support/plugin/attachment-usage/reviews/#new-post" target="_blank">
                <?php _e('Rate Attachment Usage', 'attachment-usage'); ?>
            </a>
            <span class="spinner"></span>
        </p>
    </div>
</div>