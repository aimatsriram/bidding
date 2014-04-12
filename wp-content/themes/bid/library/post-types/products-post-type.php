<?php

// let's create the function for the custom type
function products_for_bidding() { 
	// creating (registering) the custom type 
	register_post_type( 'products', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Products', 'bidtheme'), /* This is the Title of the Group */
			'singular_name' => __('Product', 'bidtheme'), /* This is the individual type */
			'all_items' => __('All Products', 'bidtheme'), /* the all items menu item */
			'add_new' => __('Add New', 'bidtheme'), /* The add new menu item */
			'add_new_item' => __('Add New Product', 'bidtheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bidtheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Product', 'bidtheme'), /* Edit Display Title */
			'new_item' => __('New Product', 'bidtheme'), /* New Display Title */
			'view_item' => __('View Product', 'bidtheme'), /* View Display Title */
			'search_items' => __('Search Product', 'bidtheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'bidtheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'bidtheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example custom post type', 'bidtheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'custom_type', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'products_for_bidding');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'products_cat', 
    	array('products'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Products Categories', 'bidtheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Products Category', 'bidtheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Product Categories', 'bidtheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Product Categories', 'bidtheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Product Category', 'bidtheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Product Category:', 'bidtheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Product Category', 'bidtheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Product Category', 'bidtheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Product Category', 'bidtheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Product Category Name', 'bidtheme' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'products-category' ),
    	)
    );   
    
	// now let's add custom tags (these act like categories)
    register_taxonomy( 'products_tag', 
    	array('products'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Products Tags', 'bidtheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Product Tag', 'bidtheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Product Tags', 'bidtheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Products Tags', 'bidtheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Product Tag', 'bidtheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Product Tag:', 'bidtheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Product Tag', 'bidtheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Product Tag', 'bidtheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Product Tag', 'bidtheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Product Tag Name', 'bidtheme' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); 
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
	

?>
