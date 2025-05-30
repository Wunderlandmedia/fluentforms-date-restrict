<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wunderlandmedia.com/
 * @since      1.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/frontend
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/frontend
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_Frontend {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        // Only enqueue if Fluent Forms is active
        if (!class_exists('FluentForm\Framework\Foundation\Application')) {
            return;
        }

        // Enqueue our frontend CSS
        wp_enqueue_style(
            $this->plugin_name . '-frontend',
            GDB_PLUGIN_URL . 'assets/css/gdb-frontend.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        // Only enqueue if Fluent Forms is active
        if (!class_exists('FluentForm\Framework\Foundation\Application')) {
            return;
        }

        // Enqueue our frontend script
        wp_enqueue_script(
            $this->plugin_name . '-frontend',
            GDB_PLUGIN_URL . 'assets/js/gdb-frontend.js',
            array('jquery'),
            $this->version,
            true
        );

        // Load configuration from database
        $disabled_dates = get_option('gdb_disabled_dates', array());
        $form_id = get_option('gdb_form_id', 3);
        $checkin_field = get_option('gdb_checkin_field', 'checkin');
        $checkout_field = get_option('gdb_checkout_field', 'checkout');
        
        // Localize script with disabled dates and configuration
        wp_localize_script($this->plugin_name . '-frontend', 'gdbFrontendData', array(
            'disabledDates' => $disabled_dates,
            'formId' => $form_id,
            'checkinField' => $checkin_field,
            'checkoutField' => $checkout_field,
            'debugMode' => defined('WP_DEBUG') && WP_DEBUG
        ));
    }
} 