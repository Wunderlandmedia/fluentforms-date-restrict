<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wunderlandmedia.com/ 
 * @since      1.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {
        // Only load on our admin page
        if ('settings_page_global-date-blocker' !== $hook) {
            return;
        }

        // Enqueue Flatpickr CSS
        wp_enqueue_style(
            'flatpickr-css',
            'https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css',
            array(),
            '4.6.13'
        );

        // Enqueue admin-specific styles if needed
        wp_enqueue_style(
            $this->plugin_name . '-admin',
            GDB_PLUGIN_URL . 'assets/css/gdb-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {
        // Only load on our admin page
        if ('settings_page_global-date-blocker' !== $hook) {
            return;
        }

        // Enqueue Flatpickr
        wp_enqueue_script(
            'flatpickr-js',
            'https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js',
            array(),
            '4.6.13',
            true
        );

        // Enqueue our admin script
        wp_enqueue_script(
            $this->plugin_name . '-admin',
            GDB_PLUGIN_URL . 'assets/js/gdb-admin.js',
            array('jquery', 'flatpickr-js'),
            $this->version,
            true
        );

        // Localize script with current disabled dates
        $disabled_dates = get_option('gdb_disabled_dates', array());
        wp_localize_script($this->plugin_name . '-admin', 'gdbAdminData', array(
            'disabledDates' => $disabled_dates,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gdb_admin_nonce')
        ));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Global Date Blocker', 'global-date-blocker'),
            __('Global Date Blocker', 'global-date-blocker'),
            'manage_options',
            'global-date-blocker',
            array($this, 'admin_page')
        );
    }

    /**
     * Admin initialization
     */
    public function admin_init() {
        // Admin initialization tasks can go here if needed in the future
        // Form submission is now handled via admin_post hook
    }

    /**
     * Handle form submission via admin_post hook
     * 
     * @since    1.0.0
     */
    public function handle_form_submission() {
        // Check if user has proper capabilities
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'global-date-blocker'));
        }

        // Check nonce
        if (!isset($_POST['gdb_nonce']) || !wp_verify_nonce($_POST['gdb_nonce'], 'gdb_save_dates_action')) {
            wp_die(__('Security check failed. Please try again.', 'global-date-blocker'));
        }

        // Check if we have the required data
        if (!isset($_POST['gdb_disabled_dates'])) {
            wp_die(__('No date data received. Please try again.', 'global-date-blocker'));
        }

        $this->save_disabled_dates();
    }

    /**
     * Admin page content
     */
    public function admin_page() {
        $disabled_dates = get_option('gdb_disabled_dates', array());
        
        // Load form configuration settings with defaults
        $form_id = get_option('gdb_form_id', 3);
        $checkin_field = get_option('gdb_checkin_field', 'checkin');
        $checkout_field = get_option('gdb_checkout_field', 'checkout');

        // Include the admin page template
        include_once GDB_PLUGIN_DIR . 'includes/admin/partials/gdb-admin-display.php';
    }

    /**
     * Save disabled dates
     */
    private function save_disabled_dates() {
        $disabled_dates_json = sanitize_text_field($_POST['gdb_disabled_dates']);
        
        // Handle double-escaped JSON
        $disabled_dates_json = stripslashes($disabled_dates_json);
        
        $disabled_dates = json_decode($disabled_dates_json, true);
        
        // If JSON decode failed, try to handle it differently
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Try to fix common JSON issues
            $disabled_dates_json = str_replace('\\"', '"', $disabled_dates_json);
            $disabled_dates = json_decode($disabled_dates_json, true);
        }
        
        // Validate and sanitize dates
        $sanitized_dates = array();
        if (is_array($disabled_dates)) {
            foreach ($disabled_dates as $date) {
                $sanitized_date = sanitize_text_field($date);
                // Validate date format (YYYY-MM-DD)
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $sanitized_date) && strtotime($sanitized_date)) {
                    $sanitized_dates[] = $sanitized_date;
                }
            }
        }
        
        // Save disabled dates to database
        update_option('gdb_disabled_dates', $sanitized_dates);
        
        // Save form configuration settings
        if (isset($_POST['gdb_form_id'])) {
            $form_id = absint($_POST['gdb_form_id']);
            if ($form_id > 0) {
                update_option('gdb_form_id', $form_id);
            }
        }
        
        if (isset($_POST['gdb_checkin_field'])) {
            $checkin_field = sanitize_text_field($_POST['gdb_checkin_field']);
            if (!empty($checkin_field)) {
                update_option('gdb_checkin_field', $checkin_field);
            }
        }
        
        if (isset($_POST['gdb_checkout_field'])) {
            $checkout_field = sanitize_text_field($_POST['gdb_checkout_field']);
            if (!empty($checkout_field)) {
                update_option('gdb_checkout_field', $checkout_field);
            }
        }
        
        // Add success message
        if (count($sanitized_dates) > 0) {
            add_settings_error(
                'gdb_messages',
                'gdb_message',
                sprintf(__('Successfully saved %d disabled dates: %s', 'global-date-blocker'), 
                    count($sanitized_dates), 
                    implode(', ', $sanitized_dates)
                ),
                'updated'
            );
        } else {
            add_settings_error(
                'gdb_messages',
                'gdb_message',
                __('Settings saved successfully.', 'global-date-blocker'),
                'updated'
            );
        }
        
        // Secure redirect - use specifically constructed admin URL instead of wp_get_referer()
        $redirect_url = admin_url('options-general.php?page=global-date-blocker&settings-updated=true');
        wp_redirect($redirect_url);
        exit;
    }
} 