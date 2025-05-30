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
        // Set default options if they don't exist (maintain backward compatibility)
        if (false === get_option('gdb_disabled_dates')) {
            add_option('gdb_disabled_dates', array());
        }
        
        // Set plugin version
        update_option('gdb_version', GDB_VERSION);
        
        // Register the CPT before flushing rewrite rules
        // We need to create a temporary instance to register the CPT
        if (class_exists('GDB_Admin')) {
            $temp_admin = new GDB_Admin('global-date-blocker', GDB_VERSION);
            $temp_admin->register_calendar_restriction_cpt();
        }
        
        // Flush rewrite rules for the new CPT
        flush_rewrite_rules();
    }
} 