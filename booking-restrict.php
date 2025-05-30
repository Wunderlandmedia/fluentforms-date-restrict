<?php
/**
 * Plugin Name: Global Date Blocker
 * Plugin URI: https://wunderlandmedia.com/
 * Description: A WordPress plugin to manage globally disabled dates for Fluent Forms date pickers and enable date range selection functionality.
 * Version: 1.0.0
 * Author: Wunderlandmedia
 * Author URI: https://wunderlandmedia.com/
 * Text Domain: global-date-blocker
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 8.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('GDB_VERSION', '1.0.0');
define('GDB_PLUGIN_FILE', __FILE__);
define('GDB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GDB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GDB_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Include core files
require_once GDB_PLUGIN_DIR . 'includes/core/class-gdb-activator.php';
require_once GDB_PLUGIN_DIR . 'includes/core/class-gdb-deactivator.php';
require_once GDB_PLUGIN_DIR . 'includes/core/class-gdb-loader.php';
require_once GDB_PLUGIN_DIR . 'includes/core/class-gdb-i18n.php';

// Include admin and frontend classes
require_once GDB_PLUGIN_DIR . 'includes/admin/class-gdb-admin.php';
require_once GDB_PLUGIN_DIR . 'includes/frontend/class-gdb-frontend.php';

// Include main plugin class
require_once GDB_PLUGIN_DIR . 'includes/class-global-date-blocker.php';

/**
 * Plugin activation hook
 */
function gdb_activate_plugin() {
    GDB_Activator::activate();
}

/**
 * Plugin deactivation hook
 */
function gdb_deactivate_plugin() {
    GDB_Deactivator::deactivate();
}

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'gdb_activate_plugin');
register_deactivation_hook(__FILE__, 'gdb_deactivate_plugin');

/**
 * Initialize the plugin
 */
function gdb_run_plugin() {
    $plugin = new Global_Date_Blocker();
    $plugin->run();
}

// Start the plugin
gdb_run_plugin(); 