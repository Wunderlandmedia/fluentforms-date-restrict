<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wunderlandmedia.com/
 * @since      1.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/includes/core
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/includes/core
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Set default options if they don't exist
        if (false === get_option('gdb_disabled_dates')) {
            add_option('gdb_disabled_dates', array());
        }
        
        // Set plugin version
        add_option('gdb_version', GDB_VERSION);
        
        // Create any necessary database tables or options here
        // For now, we only need the disabled dates option
        
        // Flush rewrite rules if needed
        flush_rewrite_rules();
    }
} 