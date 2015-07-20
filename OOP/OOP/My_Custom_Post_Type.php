<?
/**
 * Theme functions CPT
 *
 * @package WordPress
 * @subpackage Shvaika
 * @since Shvaika 0.1
 */
class My_Custom_Post_Type
{
    public $post_type = 'my_cpt';
    public function __construct() {
        $object = new My_Base_Custom_Post_Type();
        $object->post_type =  $this->post_type;
        $object->supports = array( 'title', 'editor', 'thumbnail');
        add_theme_support( 'post-thumbnails' );
        add_filter('manage_edit-'.$object->post_type.'_columns', array( $this, 'add_image_column'), 4);
        add_action( 'manage_'.$object->post_type.'_posts_custom_column' , array( $this, 'image_columns_data'), 5, 2 );
        add_action('admin_head',  array( $this, 'image_column_width'));
        add_action('add_meta_boxes', array( $this, 'add_custom_meta_boxes'));
        add_action('save_post', array( $this, 'save_custom_meta_data'));
        add_action('post_edit_form_tag', array( $this, 'post_edit_form_tag'));
    }
    //Add image
    public function add_image_column( $columns ){
        $new = array();
        foreach($columns as $key => $title) {
            if ($key=='title')
                $new['image'] = 'Image';
            $new[$key] = $title;
        }
        return $new;
    }
    public function image_columns_data( $column, $post_ID ) {
        if (has_post_thumbnail())
            the_post_thumbnail(array(50, 50));
    }
    public function image_column_width() {
        echo '<style type="text/css">';
        echo '.wp-list-table .column-image { width: 70px; }';
        echo '</style>';
    }
    function post_edit_form_tag() {
        echo ' enctype="multipart/form-data"';
    }
    //Add PDF
    public function add_custom_meta_boxes() {
        // Define the custom attachment for posts
        add_meta_box(
            'wp_custom_attachment',
            'PDF file',
            array( $this, 'wp_custom_attachment' ),
            $this->post_type,
            'side'
        );

    }
    public function wp_custom_attachment($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
        $html = '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';
        if ( $attachments = get_children( array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post->ID
        )));
        echo $html;
        foreach ($attachments as $attachment) {
            echo '<a href="' . wp_get_attachment_url( $attachment->ID ) . '">'.$attachment->post_name.'</a><br>';
        }

    }
    public function save_custom_meta_data($id) {
        /* --- security verification --- */
        if(!wp_verify_nonce($_POST['wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {
        return $id;
        }
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $id;
        }
        if('page' == $_POST['post_type']) {
            if(!current_user_can('edit_page', $id)) {
                return $id;
            }
        } else {
            if(!current_user_can('edit_page', $id)) {
                return $id;
            }
        } // end if
        /* - end security verification - */
        // Make sure the file array isn't empty
        if(!empty($_FILES['wp_custom_attachment']['name'])) {
            // Setup the array of supported file types. In this case, it's just PDF.
            $supported_types = array('application/pdf');
            // Get the file type of the upload
            $arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
            $uploaded_type = $arr_file_type['type'];
            // Check if the type is supported. If not, throw an error.
            if(in_array($uploaded_type, $supported_types)) {
                // Use the WordPress API to upload the file
                $upload = media_handle_upload("wp_custom_attachment", $id, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
                print_r($upload);
                if(isset($upload['error']) && $upload['error'] != 0) {
                    wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
                } else {
                    add_post_meta($id, 'wp_custom_attachment', $upload);
                    update_post_meta($id, 'wp_custom_attachment', $upload);
                }
            } else {
                wp_die("The file type that you've uploaded is not a PDF.");
            }
        }
    }
}
new My_Custom_Post_Type();
?>
