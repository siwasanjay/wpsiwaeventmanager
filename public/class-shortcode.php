<?php
/**
 * Shortcode to show the events
 * This shortcode displayes on the latest events
 * uses [em_events type="" limit=""] 
 * 
 * @since 		1.0.0
 * @package 	event-manager
 * @subpackage 	event-manager/public
 */
class WPSEM_SC {

	/**
	 * Initialize and get class instance
	 *
	 * @since 	1.0.0
	 */
	public function __construct() {
		// shortcode
		add_shortcode( 'em_events', array( $this, 'shortcode' ) );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * shortcode example [em_events]
	 *
	 * @since 	1.0.0
	 * 
	 */
	public function shortcode( $atts ) {
		// defaults
		extract( shortcode_atts( array(
			'limit'     => '10', // number of events
			'type'		=> '',
			'tag'		=> '',
			'relation'	=> 'OR',
		), $atts) );

		// necessary arguments for the events query
		$args = array(
			'post_type'			=> 'events',
			'posts_per_page' 	=> $limit, 
		);

		// to prevent accidental blank relation argument
		// or the value for relation is not and and or
		if( '' == $relation || 
			( strrpos( $relation, 'and' ) && ( strrpos( $relation, 'or' ) ) ) ) {
			// set the relation value to or
			$relation = 'OR';	
		}


		// if event type is defined on shortcode
		if( '' !== $type ) {
			$args['tax_query'] = array(
				'relation' => strtoupper( $relation ),
				array(
					'taxonomy' 	=> 'event_type',
					'field'		=> 'name',
					'terms'		=> $type,
				),
			);
		}

		// if the event tag is also present on shortcode
		if( '' !== $tag ) {
			$args['tax_query'][] = array(
					'taxonomy' 	=> 'post_tag',
					'field'		=> 'name',
					'terms'		=> $tag,
			);
		}

		// create new query
		$events = new WP_Query( $args );

		ob_start();

		if ( $events->have_posts() ) {
			?>
			<div class="event-wrapper">
				<?php
				while ( $events->have_posts() ) {
					$events->the_post(); 
					include plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/content-found.php';
				} // end while
				?>
			</div>
		<?php
		} // end if
		// if there are no any events.
		else {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/content-not-found.php';
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
		$returnvar = ob_get_clean();

		return $returnvar;
	}

}

new WPSEM_SC();