<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wunderlandmedia.com/     
 * @since      1.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin/partials
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php 
    // Display settings errors/messages
    settings_errors('gdb_messages');
    
    if (isset($_GET['settings-updated'])): ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Settings saved successfully!', 'global-date-blocker'); ?></p>
        </div>
    <?php endif; ?>
    
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('gdb_save_dates_action', 'gdb_nonce'); ?>
        <input type="hidden" name="action" value="gdb_save_dates" />
        
        <h2><?php _e('Form Configuration', 'global-date-blocker'); ?></h2>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Form Targeting Settings', 'global-date-blocker'); ?></th>
                <td>
                    <div style="display: flex; gap: 20px; align-items: flex-start;">
                        <div style="flex: 1;">
                            <label for="gdb_form_id" style="font-weight: 600; display: block; margin-bottom: 5px;">
                                <?php _e('Target Form ID', 'global-date-blocker'); ?>
                            </label>
                            <input type="number" id="gdb_form_id" name="gdb_form_id" value="<?php echo esc_attr($form_id); ?>" class="small-text" min="1" />
                            <p class="description" style="margin-top: 5px;">
                                <?php _e('Form ID number', 'global-date-blocker'); ?>
                            </p>
                        </div>
                        <div style="flex: 1;">
                            <label for="gdb_checkin_field" style="font-weight: 600; display: block; margin-bottom: 5px;">
                                <?php _e('Check-in Field Name', 'global-date-blocker'); ?>
                            </label>
                            <input type="text" id="gdb_checkin_field" name="gdb_checkin_field" value="<?php echo esc_attr($checkin_field); ?>" class="regular-text" />
                            <p class="description" style="margin-top: 5px;">
                                <?php _e('Field name attribute', 'global-date-blocker'); ?>
                            </p>
                        </div>
                        <div style="flex: 1;">
                            <label for="gdb_checkout_field" style="font-weight: 600; display: block; margin-bottom: 5px;">
                                <?php _e('Check-out Field Name', 'global-date-blocker'); ?>
                            </label>
                            <input type="text" id="gdb_checkout_field" name="gdb_checkout_field" value="<?php echo esc_attr($checkout_field); ?>" class="regular-text" />
                            <p class="description" style="margin-top: 5px;">
                                <?php _e('Field name attribute', 'global-date-blocker'); ?>
                            </p>
                        </div>
                    </div>
                    <p class="description" style="margin-top: 15px;">
                        <?php _e('Configure which Fluent Form and which date fields this plugin should target. Make sure the field names match exactly with your form field name attributes.', 'global-date-blocker'); ?>
                    </p>
                </td>
            </tr>
        </table>
        
        <h2><?php _e('Disabled Dates Configuration', 'global-date-blocker'); ?></h2>
        
        <?php if (!empty($disabled_dates)): ?>
            <div class="gdb-current-dates" style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h3 style="margin-top: 0;"><?php _e('Currently Selected Dates:', 'global-date-blocker'); ?></h3>
                <ul style="margin: 10px 0 0 20px;">
                    <?php foreach ($disabled_dates as $date): ?>
                        <li style="margin-bottom: 5px; color: #555;">
                            <?php 
                            $formatted_date = date_i18n('F j, Y', strtotime($date));
                            echo esc_html($formatted_date . ' (' . $date . ')');
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="gdb_date_picker"><?php _e('Select Disabled Dates', 'global-date-blocker'); ?></label>
                </th>
                <td>
                    <div class="gdb-calendar-container">
                        <input type="text" id="gdb_date_picker" name="gdb_date_picker" class="regular-text" readonly />
                        <input type="hidden" id="gdb_disabled_dates" name="gdb_disabled_dates" value="<?php echo esc_attr(json_encode($disabled_dates)); ?>" />
                    </div>
                    <p class="description">
                        <?php _e('Click on the calendar to select multiple dates that should be disabled in your forms. Click again to deselect.', 'global-date-blocker'); ?>
                    </p>
                </td>
            </tr>
        </table>
        
        <?php submit_button(__('Save Settings', 'global-date-blocker'), 'primary', 'gdb_save_dates'); ?>
    </form>
</div> 