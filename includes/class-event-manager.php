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
	}

}
