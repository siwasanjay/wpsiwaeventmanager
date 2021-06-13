<?php
/**
 * The necessary extend for the REST API
 *
 * @since   	1.0.0
 * @package 	event-manager
 * @subpackage  event-manager/includes
 */
class WSEM_REST {

	/**
	 * Construct
	 */
	public function __construct() {
		add_filter( 'rest_rout_for_post', array( $this, 'wpsem_custom_event_rout'), 10, 2 );
	}


	/**
	 * Custom rout
	 */
	public function wpsem_custom_event_rout( $route, $post ) {
		if( $post->post_type === 'events' ) {
			$route = '/wp/v2/wpsem-events/' . $post->ID; 
		}
		return $route;
	}
}
// new WSEM_REST();	