<?php
/**
 * Restriction Settings Meta Box Template
 *
 * This file is used to markup the restriction settings meta box.
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
wp_nonce_field('gdb_save_restriction_settings', 'gdb_restriction_settings_nonce');
?>

<table class="form-table">
    <tr>
        <th scope="row">
            <label for="gdb_form_id"><?php _e('Target Fluent Form ID', 'global-date-blocker'); ?></label>
        </th>
        <td>
            <input type="number" id="gdb_form_id" name="gdb_form_id" value="<?php echo esc_attr($form_id); ?>" min="1" class="regular-text" />
            <p class="description"><?php _e('Enter the numerical ID of the Fluent Form you want this restriction to affect.', 'global-date-blocker'); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="gdb_checkin_field_name"><?php _e('Check-in Field Name', 'global-date-blocker'); ?></label>
        </th>
        <td>
            <input type="text" id="gdb_checkin_field_name" name="gdb_checkin_field_name" value="<?php echo esc_attr($checkin_field_name); ?>" class="regular-text" />
            <p class="description"><?php _e('Enter the "name" attribute of the check-in date field in your Fluent Form (e.g., "checkin", "start_date").', 'global-date-blocker'); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="gdb_checkout_field_name"><?php _e('Check-out Field Name', 'global-date-blocker'); ?></label>
        </th>
        <td>
            <input type="text" id="gdb_checkout_field_name" name="gdb_checkout_field_name" value="<?php echo esc_attr($checkout_field_name); ?>" class="regular-text" />
            <p class="description"><?php _e('Enter the "name" attribute of the check-out date field in your Fluent Form (e.g., "checkout", "end_date").', 'global-date-blocker'); ?></p>
        </td>
    </tr>
</table>