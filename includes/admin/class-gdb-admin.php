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
 * Coordinates admin functionality and manages assets loading.
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
     * CPT Manager instance
     *
     * @since    2.0.0
     * @access   private
     * @var      GDB_CPT_Manager    $cpt_manager    The CPT manager instance.
     */
    private $cpt_manager;

    /**
     * Meta Boxes Manager instance
     *
     * @since    2.0.0
     * @access   private
     * @var      GDB_Meta_Boxes    $meta_boxes    The meta boxes manager instance.
     */
    private $meta_boxes;

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
        
        $this->load_dependencies();
        $this->init_admin_components();
    }

    /**
     * Load the required dependencies for admin functionality.
     *
     * @since    2.0.0
     * @access   private
     */
    private function load_dependencies() {
        // Load CPT Manager
        require_once GDB_PLUGIN_PATH . 'includes/admin/class-gdb-cpt-manager.php';
        
        // Load Meta Boxes Manager
        require_once GDB_PLUGIN_PATH . 'includes/admin/class-gdb-meta-boxes.php';
    }

    /**
     * Initialize admin components.
     *
     * @since    2.0.0
     * @access   private
     */
    private function init_admin_components() {
        // Initialize CPT Manager
        $this->cpt_manager = new GDB_CPT_Manager();
        
        // Initialize Meta Boxes Manager
        $this->meta_boxes = new GDB_Meta_Boxes();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {
        // Only load on Calendar Restriction CPT edit screen
        $screen = get_current_screen();
        if (!$screen || $screen->post_type !== 'gdb_restriction' || $screen->base !== 'post') {
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
        // Only load on Calendar Restriction CPT edit screen
        $screen = get_current_screen();
        if (!$screen || $screen->post_type !== 'gdb_restriction' || $screen->base !== 'post') {
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

        // Get current disabled dates for existing posts
        $disabled_dates = array();
        if (isset($_GET['post']) && is_numeric($_GET['post'])) {
            $post_id = intval($_GET['post']);
            $disabled_dates = get_post_meta($post_id, '_gdb_disabled_dates', true);
            if (!is_array($disabled_dates)) {
                $disabled_dates = array();
            }
        }

        // Localize script with current disabled dates
        wp_localize_script($this->plugin_name . '-admin', 'gdbAdminData', array(
            'disabledDates' => $disabled_dates,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gdb_admin_nonce')
        ));
    }

    /**
     * Get CPT Manager instance
     *
     * @since    2.0.0
     * @return   GDB_CPT_Manager    The CPT manager instance.
     */
    public function get_cpt_manager() {
        return $this->cpt_manager;
    }

    /**
     * Get Meta Boxes Manager instance
     *
     * @since    2.0.0
     * @return   GDB_Meta_Boxes    The meta boxes manager instance.
     */
    public function get_meta_boxes() {
        return $this->meta_boxes;
    }
} 