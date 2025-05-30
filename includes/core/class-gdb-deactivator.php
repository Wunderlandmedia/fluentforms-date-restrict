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
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Note: We don't delete the main options here as users might want to keep their settings
        // If you want to clean up everything on deactivation, uncomment the following:
        // delete_option('gdb_disabled_dates');
        // delete_option('gdb_version');
    }
} 