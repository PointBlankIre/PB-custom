<?php
/*
Plugin Name: Point Blank Custom Post Type
Plugin URI: http://www.pointblank.ie/
Description: Declares a plugin that will create a custom post type. place single-custom.php in theme directory to modify.
Version: 1.0
Author: Turlough Rynne 
Author URI: http://www.pointblank.ie/
License: GPLv2
*/

add_action( 'init', 'create_pb_custom' );


function create_pb_custom() {
register_post_type( 'pb_custom',
array(
'labels' => array(
'name' => 'Custom',
'singular_name' => 'Custom Item',
'add_new' => 'Add New',
'add_new_item' => 'Add New Custom Item',
'edit' => 'Edit',
'edit_item' => 'Edit Custom Item',
'new_item' => 'New Custom Item',
'view' => 'View',
'view_item' => 'View Custom Item',
'search_items' => 'Search Custom Item',
'not_found' => 'No Custom Items found',
'not_found_in_trash' =>
'No Custom Item found in Trash',
'parent' => 'Parent Custom Item'
),
'public' => true,
'menu_position' => 15,
'supports' =>
array( 'title', 'thumbnail', 'editor'  ),
'taxonomies' => array( '' ),
// 'menu_icon' =>
// plugins_url( 'images/image.png', __FILE__ ),
'has_archive' => true,
'rewrite' => array('slug' => 'custom')
)
);
}



add_action('do_meta_boxes', 'pb_custom_image_box');
function pb_custom_image_box() {
	remove_meta_box( 'postimagediv', 'pb_custom', 'side' );
	add_meta_box('postimagediv', __('Custom Image'), 'post_thumbnail_meta_box', 'pb_custom', 'normal', 'high');
}


add_action( 'admin_init', 'my_admin_custom' );




function my_admin_custom() {
add_meta_box( 'custom_meta_box',
'Custom Item Details',
'display_custom_meta_box',
'pb_custom', 'normal', 'high' ); 
}


function display_custom_meta_box( $pb_custom ) {
// Retrieve current URL
$url_custom =
esc_html( get_post_meta( $pb_custom->ID,
'url_carousel', true ) );
$desc_custom =
esc_html( get_post_meta( $pb_custom->ID,
'desc_carousel', true ) );
?>

<table>
<tr>
<td>Description</td>
<td><input type="textarea" size="80"
name="desc_carousel_name"
value="<?php echo $desc_custom; ?>" placeholder="Description here..." /></td>
</tr>

<tr>
<td>Link for Carousel Item</td>
<td><input type="text" size="80"
name="url_carousel_name"
value="<?php echo $url_custom; ?>" placeholder="http://" /></td>
</tr>

</table>

<?php }


add_action( 'save_post',
'pb_custom_fields', 10, 2 );


function pb_custom_fields( $pb_custom_id,
$pb_custom ) {
// Check post type for movie reviews
if ( $pb_custom->post_type == 'pb_custom' ) {
// Store data in post meta table if present in post data
if ( isset( $_POST['url_carousel_name'] ) &&
$_POST['url_carousel_name'] != '' ) {
update_post_meta( $pb_custom_id, 'url_carousel',
$_POST['url_carousel_name'] );
}

if ( isset( $_POST['desc_carousel_name'] ) &&
$_POST['desc_carousel_name'] != '' ) {
update_post_meta( $pb_custom_id, 'desc_carousel',
$_POST['desc_carousel_name'] );
}

}
}


add_filter( 'template_include',
'include_template_function', 1 );


function include_template_function( $template_path ) {
if ( get_post_type() == 'pb_custom' ) {
if ( is_single() ) {
// checks if the file exists in the theme first,
// otherwise serve the file from the plugin
if ( $theme_file = locate_template( array
( 'single-custom.php' ) ) ) {
$template_path = $theme_file;
} else {
$template_path = plugin_dir_path( __FILE__ ) .
'/single-custom.php';
}
}
}
return $template_path;
}


?>