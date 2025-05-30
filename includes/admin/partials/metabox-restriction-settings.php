<?php
/**
 * Disabled Dates Meta Box Template
 *
 * This file is used to markup the disabled dates meta box.
 *
 * @link       https://wunderlandmedia.com/     
 * @since      2.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin/partials
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add nonce for security
wp_nonce_field('gdb_save_disabled_dates', 'gdb_disabled_dates_nonce');
?>

<div class="gdb-disabled-dates-container">
    <p><?php _e('Click on dates in the calendar below to disable them. Click again to enable them.', 'global-date-blocker'); ?></p>
    <div id="gdb-flatpickr-container" class="gdb-flatpickr-container"></div>
    <input type="hidden" id="gdb_disabled_dates_hidden" name="gdb_disabled_dates" value="<?php echo esc_attr(json_encode($disabled_dates)); ?>" />
</div>

<style>
    .gdb-flatpickr-container {
        margin: 20px 0;
    }
</style> 