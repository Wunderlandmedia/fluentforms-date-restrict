<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://wunderlandmedia.com/
 * @since      1.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/includes/core
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/includes/core
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Flush rewrite rules to clean up CPT rules
        flush_rewrite_rules();
        
        // Note: We don't delete the main options here as users might want to keep their settings
        // We also don't delete CPT posts as users might want to keep their calendar restrictions
        // If you want to clean up everything on deactivation, you would need to:
        // - Delete all gdb_calendar_restriction posts
        // - Delete their meta data
        // - Delete legacy options: gdb_disabled_dates, gdb_form_id, gdb_checkin_field, gdb_checkout_field, gdb_version
    }
} 