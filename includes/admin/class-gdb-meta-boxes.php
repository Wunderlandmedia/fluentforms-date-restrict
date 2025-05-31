<?php
/**
 * Meta Boxes Manager for Calendar Restrictions
 *
 * @link       https://wunderlandmedia.com/ 
 * @since      2.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 */

/**
 * Handles meta boxes for Calendar Restrictions CPT
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_Meta_Boxes {

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_calendar_restriction_meta_boxes'));
        add_action('save_post_gdb_restriction', array($this, 'save_calendar_restriction_meta'), 10, 2);
    }

    /**
     * Add meta boxes for Calendar Restriction CPT
     *
     * @since    2.0.0
     */
    public function add_calendar_restriction_meta_boxes() {
        add_meta_box(
            'gdb_restriction_settings',
            __('Restriction Settings', 'global-date-blocker'),
            array($this, 'render_restriction_settings_meta_box'),
            'gdb_restriction',
            'normal',
            'high'
        );

        add_meta_box(
            'gdb_disabled_dates',
            __('Disabled Dates', 'global-date-blocker'),
            array($this, 'render_disabled_dates_meta_box'),
            'gdb_restriction',
            'normal',
            'high'
        );
    }

    /**
     * Render the Restriction Settings meta box
     *
     * @since    2.0.0
     * @param    WP_Post    $post    The post object.
     */
    public function render_restriction_settings_meta_box($post) {
        // Get current values
        $form_id = get_post_meta($post->ID, '_gdb_form_id', true);
        $checkin_field_name = get_post_meta($post->ID, '_gdb_checkin_field_name', true);
        $checkout_field_name = get_post_meta($post->ID, '_gdb_checkout_field_name', true);

        // Default values
        if (empty($form_id)) {
            $form_id = '';
        }
        if (empty($checkin_field_name)) {
            $checkin_field_name = 'checkin';
        }
        if (empty($checkout_field_name)) {
            $checkout_field_name = 'checkout';
        }

        // Include the partial template
        include_once GDB_PLUGIN_PATH . 'includes/admin/partials/metabox-restriction-settings.php';
    }

    /**
     * Render the Disabled Dates meta box
     *
     * @since    2.0.0
     * @param    WP_Post    $post    The post object.
     */
    public function render_disabled_dates_meta_box($post) {
        // Get current disabled dates
        $disabled_dates = get_post_meta($post->ID, '_gdb_disabled_dates', true);
        if (!is_array($disabled_dates)) {
            $disabled_dates = array();
        }

        // Include the partial template
        include_once GDB_PLUGIN_PATH . 'includes/admin/partials/metabox-disabled-dates.php';
    }

    /**
     * Save meta data for Calendar Restriction CPT
     *
     * @since    2.0.0
     * @param    int       $post_id    Post ID.
     * @param    WP_Post   $post       Post object.
     */
    public function save_calendar_restriction_meta($post_id, $post) {
        // Check if user has permissions to edit this post
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check if this is an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check if this is a revision
        if (wp_is_post_revision($post_id)) {
            return;
        }

        // Only process if we have POST data (to avoid issues during normal post operations)
        if (empty($_POST)) {
            return;
        }

        // Save restriction settings
        $this->save_restriction_settings($post_id);
        
        // Save disabled dates
        $this->save_disabled_dates($post_id);
    }

    /**
     * Save restriction settings meta data
     *
     * @since    2.0.0
     * @param    int    $post_id    Post ID.
     */
    private function save_restriction_settings($post_id) {
        if (!isset($_POST['gdb_restriction_settings_nonce'])) {
            return;
        }

        $nonce_valid = wp_verify_nonce($_POST['gdb_restriction_settings_nonce'], 'gdb_save_restriction_settings');
        if (!$nonce_valid) {
            return;
        }

        // Save Form ID
        if (isset($_POST['gdb_form_id'])) {
            $form_id = absint($_POST['gdb_form_id']);
            update_post_meta($post_id, '_gdb_form_id', $form_id);
        }

        // Save Check-in Field Name
        if (isset($_POST['gdb_checkin_field_name'])) {
            $checkin_field_name = sanitize_text_field($_POST['gdb_checkin_field_name']);
            update_post_meta($post_id, '_gdb_checkin_field_name', $checkin_field_name);
        }

        // Save Check-out Field Name
        if (isset($_POST['gdb_checkout_field_name'])) {
            $checkout_field_name = sanitize_text_field($_POST['gdb_checkout_field_name']);
            update_post_meta($post_id, '_gdb_checkout_field_name', $checkout_field_name);
        }
    }

    /**
     * Save disabled dates meta data
     *
     * @since    2.0.0
     * @param    int    $post_id    Post ID.
     */
    private function save_disabled_dates($post_id) {
        if (!isset($_POST['gdb_disabled_dates_nonce'])) {
            return;
        }

        $nonce_valid = wp_verify_nonce($_POST['gdb_disabled_dates_nonce'], 'gdb_save_disabled_dates');
        if (!$nonce_valid) {
            return;
        }

        // Save Disabled Dates
        if (isset($_POST['gdb_disabled_dates'])) {
            // Use wp_unslash to handle WordPress's automatic escaping
            $disabled_dates_json = wp_unslash($_POST['gdb_disabled_dates']);
            $disabled_dates = json_decode($disabled_dates_json, true);
            
            // Validate and sanitize dates
            $sanitized_dates = array();
            if (is_array($disabled_dates)) {
                foreach ($disabled_dates as $date) {
                    // Validate date format (YYYY-MM-DD)
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                        $sanitized_dates[] = sanitize_text_field($date);
                    }
                }
            }
            
            update_post_meta($post_id, '_gdb_disabled_dates', $sanitized_dates);
        }
    }
} 