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

        // Query all published Calendar Restriction posts
        $restriction_posts = get_posts(array(
            'post_type' => 'gdb_restriction',
            'post_status' => 'publish',
            'numberposts' => -1,
            'meta_query' => array(
                array(
                    'key' => '_gdb_form_id',
                    'value' => '',
                    'compare' => '!='
                )
            )
        ));

        // If no configurations found, don't enqueue scripts
        if (empty($restriction_posts)) {
            return;
        }

        // Build configuration array
        $frontend_configs = array();
        foreach ($restriction_posts as $post) {
            $form_id = get_post_meta($post->ID, '_gdb_form_id', true);
            $checkin_field_name = get_post_meta($post->ID, '_gdb_checkin_field_name', true);
            $checkout_field_name = get_post_meta($post->ID, '_gdb_checkout_field_name', true);
            $disabled_dates = get_post_meta($post->ID, '_gdb_disabled_dates', true);

            // Skip if essential data is missing
            if (empty($form_id) || empty($checkin_field_name) || empty($checkout_field_name)) {
                continue;
            }

            // Ensure disabled_dates is an array
            if (!is_array($disabled_dates)) {
                $disabled_dates = array();
            }

            // Add configuration to array
            $frontend_configs[] = array(
                'restrictionId' => $post->ID,
                'restrictionTitle' => $post->post_title,
                'formId' => intval($form_id),
                'checkinField' => sanitize_text_field($checkin_field_name),
                'checkoutField' => sanitize_text_field($checkout_field_name),
                'disabledDates' => $disabled_dates
            );
        }

        // If no valid configurations found, don't enqueue scripts
        if (empty($frontend_configs)) {
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

        // Localize script with multiple configurations
        wp_localize_script($this->plugin_name . '-frontend', 'gdbFrontendConfigs', $frontend_configs);
        
        // Also localize debug mode setting
        wp_localize_script($this->plugin_name . '-frontend', 'gdbFrontendData', array(
            'debugMode' => defined('WP_DEBUG') && WP_DEBUG,
            'configCount' => count($frontend_configs)
        ));
    }
} 