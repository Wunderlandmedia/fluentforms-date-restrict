<?php
/**
 * Custom Post Type Manager for Calendar Restrictions
 *
 * @link       https://wunderlandmedia.com/ 
 * @since      2.0.0
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 */

/**
 * Handles Custom Post Type registration for Calendar Restrictions
 *
 * @package    Global_Date_Blocker
 * @subpackage Global_Date_Blocker/admin
 * @author     Wunderlandmedia <info@wunderlandmedia.com>
 */
class GDB_CPT_Manager {

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     */
    public function __construct() {
        add_action('init', array($this, 'register_calendar_restriction_cpt'));
    }

    /**
     * Register the Calendar Restriction Custom Post Type
     *
     * @since    2.0.0
     */
    public function register_calendar_restriction_cpt() {
        $labels = array(
            'name'                  => _x('Calendar Restrictions', 'Post type general name', 'global-date-blocker'),
            'singular_name'         => _x('Calendar Restriction', 'Post type singular name', 'global-date-blocker'),
            'menu_name'             => _x('Calendar Restrictions', 'Admin Menu text', 'global-date-blocker'),
            'name_admin_bar'        => _x('Calendar Restriction', 'Add New on Toolbar', 'global-date-blocker'),
            'add_new'               => __('Add New', 'global-date-blocker'),
            'add_new_item'          => __('Add New Restriction', 'global-date-blocker'),
            'new_item'              => __('New Restriction', 'global-date-blocker'),
            'edit_item'             => __('Edit Restriction', 'global-date-blocker'),
            'view_item'             => __('View Restriction', 'global-date-blocker'),
            'all_items'             => __('All Restrictions', 'global-date-blocker'),
            'search_items'          => __('Search Restrictions', 'global-date-blocker'),
            'parent_item_colon'     => __('Parent Restrictions:', 'global-date-blocker'),
            'not_found'             => __('No restrictions found.', 'global-date-blocker'),
            'not_found_in_trash'    => __('No restrictions found in Trash.', 'global-date-blocker'),
            'featured_image'        => _x('Calendar Restriction Cover Image', 'Overrides the "Featured Image" phrase for this post type.', 'global-date-blocker'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type.', 'global-date-blocker'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type.', 'global-date-blocker'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type.', 'global-date-blocker'),
            'archives'              => _x('Calendar Restriction archives', 'The post type archive label used in nav menus.', 'global-date-blocker'),
            'insert_into_item'      => _x('Insert into calendar restriction', 'Overrides the "Insert into post"/"Insert into page" phrase.', 'global-date-blocker'),
            'uploaded_to_this_item' => _x('Uploaded to this calendar restriction', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase.', 'global-date-blocker'),
            'filter_items_list'     => _x('Filter calendar restrictions list', 'Screen reader text for the filter links heading.', 'global-date-blocker'),
            'items_list_navigation' => _x('Calendar restrictions list navigation', 'Screen reader text for the pagination heading.', 'global-date-blocker'),
            'items_list'            => _x('Calendar restrictions list', 'Screen reader text for the items list heading.', 'global-date-blocker'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'capabilities'       => array(
                'edit_post'          => 'edit_posts',
                'read_post'          => 'read',
                'delete_post'        => 'delete_posts',
                'edit_posts'         => 'edit_posts',
                'edit_others_posts'  => 'edit_others_posts',
                'publish_posts'      => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
            ),
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-calendar-alt',
            'supports'           => array('title'),
            'show_in_rest'       => false,
        );

        register_post_type('gdb_restriction', $args);
    }
} 