<?
/**
 * @package My Base CPT
 * @version 1.0
 */
/*
Plugin Name: My Base CPT
Description: My Base CPT
Author: Stanislav Shvaiko
Version: 1.0
*/
class My_Base_Custom_Post_Type
{
    public $supports = array( 'title', 'editor', );
    public $post_type = 'post_type';

    public function __construct() {
        // Register custom post types and taxonomies
        add_action( 'init', array( $this, 'mb_custom_post_types_callback' ), 5 );
    }
    public function mb_custom_post_types_callback() {
        register_post_type( $this->post_type, array(
            'labels' => array(
                'name' => __("Items", 'mbsbase'),
                'singular_name' => __("Item", 'mbsbase'),
                'add_new' => _x("Add New", 'pluginbase', 'mbsbase' ),
                'add_new_item' => __("Add New Base Item", 'mbsbase' ),
                'edit_item' => __("Edit Base Item", 'mbsbase' ),
                'new_item' => __("New Base Item", 'mbsbase' ),
                'view_item' => __("View Base Item", 'mbsbase' ),
                'search_items' => __("Search Base Items", 'mbsbase' ),
                'not_found' =>  __("No base items found", 'mbsbase' ),
                'not_found_in_trash' => __("No base items found in Trash", 'mbsbase' ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'rewrite' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => $this->supports,
            'hierarchical' => 'false'
        ));
    }
}
?>