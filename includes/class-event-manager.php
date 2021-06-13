<?php
/**
 * The file that defines the core plugin class
 *
 * @since 		1.0.0
 * @package 	event-manager
 * @subpackage 	event-manager/includes
 */
class WPSEM {

	/**
	 * Initialize and get class instance
	 *
	 * @since 	1.0.0
	 */
	public function __construct() {
		$this->run();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since 	1.0.0
	 *
	 */
	public function run() {
		
		// register custom post type event
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/class-register-cpt.php';

		// handel ajax calls
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '/public/class-ajax-calls.php';
		
		if( ! is_admin() ) {
			// shortcode to display for the events
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/public/class-shortcode.php';

			// shortcode with filter
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/public/class-shortcode-filter.php';
		} 
		// only for admin side
		else {
			// metabox
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/class-metabox-schedule.php';

		}

		// REST API
		// for now this is basically handeled with the parameters on the cpt registration.
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . '/includes/class-rest-api.php';
	}
}
