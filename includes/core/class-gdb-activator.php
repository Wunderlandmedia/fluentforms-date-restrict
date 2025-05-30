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
     * Plugin activation tasks.
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
        // Load and initialize the CPT Manager to register the CPT
        require_once GDB_PLUGIN_PATH . 'includes/admin/class-gdb-cpt-manager.php';
        $cpt_manager = new GDB_CPT_Manager();
        $cpt_manager->register_calendar_restriction_cpt();
        
        // Flush rewrite rules for the new CPT
        flush_rewrite_rules();
    }
} 