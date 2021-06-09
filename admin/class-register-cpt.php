<?php
/** 
 * Register custom post type: Events
 * Register taxonomy for the custom post type.
 *
 * @since 		1.0.0
 * @package 	event-manager
 * @subpackage 	event-manager/admin
 */
class WPSEM_CPT {

	/**
	 * Construct
	 *
	 * @since 	1.0.0
	 */
	public function __construct() {
		// register custom post type events
		add_action( 'init', array( $this, 'register_event_cpt' ) );
		// register custom taxonomy event types
		add_action( 'init', array( $this, 'register_event_taxonomy' ) );
	}

	/**
	 * Register custom post type.
	 *
	 * @since 	1.0.0
	 *
	 */
	public function register_event_cpt() {
		// arguments
		$args = $this->get_args();

		// register custom post type events.
		register_post_type( 'events', $args );
	}

	/**
	 * Register custom taxonomy event type for events
	 *
	 * @since 1.0.0
	 */
	public function register_event_taxonomy() {
		// register custom taxonomy for events.

		$tax_args = $this->tax_args();

		register_taxonomy( 'event_type' , array( 'events' ), $tax_args ); // categories
	}

	/**
	 * arguments for our custom post type
	 *
	 * @since 1.0.0
	 * @ return $args  array  
	 */
	public function get_args() {

		// label for our custom post type
		$labels = $this->get_labels();
		// arguments for our custom post events
		$args = array(
			'labels' 			 => $labels,
			'description' 		 => 'Create, manage or delete you events',
			'public'			 => true,
			'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'events' ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => 20,
	        'menu_icon'			 => 'dashicons-buddicons-groups',
	        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
	        'taxonomies'         => array( 'event_type', 'post_tag' ),
	        'show_in_rest'       => true
		);

		return $args;
	}

	/**
	 * labels for our custom post events
	 *
	 * @return $labels array
	 */
	public function get_labels() {

		$labels = array(
			'name'                  => _x( 'Events', 'Post type general name', 'wpsiwa-event-manager' ),
			'singular_name'         => _x( 'Event', 'Post type singular name', 'wpsiwa-event-manager' ),
			'menu_name'             => _x( 'Events', 'Admin Menu text', 'wpsiwa-event-manager' ),
			'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'wpsiwa-event-manager' ),
			'add_new'               => __( 'Add New', 'wpsiwa-event-manager' ),
			'add_new_item'          => __( 'Add New Event', 'wpsiwa-event-manager' ),
			'new_item'              => __( 'New Event', 'wpsiwa-event-manager' ),
			'edit_item'             => __( 'Edit Event', 'wpsiwa-event-manager' ),
			'view_item'             => __( 'View Event', 'wpsiwa-event-manager' ),
			'all_items'             => __( 'All Events', 'wpsiwa-event-manager' ),
			'search_items'          => __( 'Search Events', 'wpsiwa-event-manager' ),
			'parent_item_colon'     => __( 'Parent Events:', 'wpsiwa-event-manager' ),
			'not_found'             => __( 'No events found.', 'wpsiwa-event-manager' ),
			'not_found_in_trash'    => __( 'No events found in Trash.', 'wpsiwa-event-manager' ),
		);

		return $labels;
	}


	/**
	 * arguments for our category
	 *
	 * @since 1.0.0
	 * @ return $tax_args  array  
	 */
	public function tax_args() {

		// label for our custom taxonomy
		$tax_labels = $this->tax_labels();
		// arguments for our taxonomy
		$tax_args = array( 
			'hierarchical' => true,
		    'labels' => $tax_labels,
		    'show_ui' => true,
		    'show_in_rest' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'event_type' ),
		);

		return $tax_args;
	}

	/**
	 * labels for our taxonomy.
	 *
	 * @since 1.0.0
	 * @ return $tax_labels  array  
	 */
	public function tax_labels() {

		$tax_labels = array(
			'name' 				=> _x( 'Event Types', 'taxonomy general name', 'wpsiwa-event-manager' ),
			'singular_name' 	=> _x( 'Event Type', 'taxonomy singular name', 'wpsiwa-event-manager' ),
			'search_items' 		=> __( 'Search Event Type', 'wpsiwa-event-manager' ),
			'all_items' 		=> __( 'All Event Types', 'wpsiwa-event-manager' ),
			'parent_item'		=> __( 'Parent Event Type', 'wpsiwa-event-manager' ),
			'parent_item_colon' => __( 'Parent Event Type:', 'wpsiwa-event-manager' ),
			'edit_item' 		=> __( 'Edit Event Type', 'wpsiwa-event-manager' ), 
			'update_item' 		=> __( 'Update Event Type', 'wpsiwa-event-manager' ),
			'add_new_item' 		=> __( 'Add New Event Type', 'wpsiwa-event-manager' ),
			'new_item_name' 	=> __( 'New Event Type Name', 'wpsiwa-event-manager' ),
			'menu_name' 		=> __( 'Event Type', 'wpsiwa-event-manager' ),
		);  

		return $tax_labels;
	}


}

new WPSEM_CPT();
