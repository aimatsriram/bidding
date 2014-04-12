<?php
/**
 * Include and setup custom metaboxes and fields.
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_bid_';

	$meta_boxes[] = array(
		'id'         => 'product_metabox',
		'title'      => 'Product Options',
		'pages'      => array( 'products', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Orginal Price',
				'desc' => 'Enter Orginal price',
				'id'   => $prefix . 'priceorginal',
				'type' => 'text_money',
			),
			array(
				'name' => 'Price',
				'desc' => 'Enter least bidding price',
				'id'   => $prefix . 'price',
				'type' => 'text_money',
			),
			array(
				'name' => 'Start Date',
				'desc' => 'Enter Start Date',
				'id'   => $prefix . 'startdate',
				'type' => 'text_datetime_timestamp',
			),
			array(
				'name' => 'End Date',
				'desc' => 'Enter End Date',
				'id'   => $prefix . 'enddate',
				'type' => 'text_datetime_timestamp',
			),
			array(
				'name' => 'Bidding fee',
				'desc' => 'Number of credits',
				'id'   => $prefix . 'numcredits',
				'type' => 'text_small',
			)
		)
	);
	
	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}