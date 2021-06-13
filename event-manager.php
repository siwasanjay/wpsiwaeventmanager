<?php
/**
*
* @since             1.0.0
* @package           event-manager
*
* @wordpress-plugin
* Plugin Name: 	  	 Event Manager
* Description:       Manage your events. Create and manage your events. Events showcase with filter through shortcode. 
* Version:           1.0.0
* Requires at least: 5.7
* Requires PHP:      7.3
* Author:            Sanjay Kumar Siwa
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       wpsiwa-event-manager
* Domain Path:       /languages
*/

// If file is called directly.
if( !defined( 'WPINC' ) ) {
	die();
}
// Current Plugin Version
define( 'WPSEM_VERSION', '0.0.1' );
// Plugin Name
define( 'WPSEM_NAME', 'Event Manager' );

/**
 * Plugin core class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event-manager.php';

/**
 * Run the plugin.
 */
function wpsiwa_event_manager_run() {
	new WPSEM();
}

wpsiwa_event_manager_run();
