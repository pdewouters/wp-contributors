<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'wpc_define_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wpc_define_metaboxes( array $meta_boxes ) {

	$authors = get_users(
			array(
				'who' => 'authors',
				'fields' => 'all'
				)
		);

	foreach ($authors as $author) {
		$options[$author->ID] = $author->user_nicename;
	}

	//print_r($option); die();
	//print_r($authors); die();
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_wpc_';

	$meta_boxes[] = array(
		'id'         => 'contrib_metabox',
		'title'      => 'Contributors',
		'pages'      => array( 'page', 'post'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name'    => 'Blog Authors',
				'desc'    => 'select the contributors for this post',
				'id'      => $prefix . 'author_multicheckbox',
				'type'    => 'multicheck',
				'options' => $options
			),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'wpc_cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function wpc_cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once WP_CONTRIB_INCLUDES . 'metabox/init.php';

}