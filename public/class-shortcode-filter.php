<?php
/**
 * Shortcode to show the events with filter options
 * This shortcode displayes on the latest events and filters
 * uses [em_events_filter limit=""] 
 * 
 * @since 		1.0.0
 * @package 	event-manager
 * @subpackage 	event-manager/public
 */
class WPSEM_SCFILTER {

	/**
	 * Initialize and get class instance
	 *
	 * @since 	1.0.0
	 */
	public function __construct() {
		// shortcode
		add_shortcode( 'em_events_filter', array( $this, 'shortcode' ) );
		// filter script
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
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
		), $atts) );

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		// necessary arguments for the events query
		$args = array(
			'post_type'			=> 'events',
			'posts_per_page' 	=> $limit, 
			'paged'				=> $paged,
		);

		// create new query
		$events = new WP_Query( $args );

		// maximum number of pages.
		$max_pages = $events->max_num_pages;

		ob_start();

		/* Filter options */
		$this->filters();

		/* Events */
		if ( $events->have_posts() ) {
			?>
			<div class="event-wrapper wpsem-filter" data-limit="<?php echo $limit; ?>">
				<?php
				while ( $events->have_posts() ) {
					$events->the_post(); 
					include plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/content-found.php';
				} // end while
				?>
			</div>
			<?php
			if( $max_pages > 1 ) {
				echo '<button id="loadmore" data-next="2">' . __( 'Load More', 'wpsiwa-event-manager' ) . '</button>'; 
			}
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

	/**
	 * Filters html elements
	 */
	public function filters() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/filters.php';
	}

	/**
	 * Filter script
	 *
	 */
	public function enqueue_script() {
		// custom js
        wp_enqueue_script( 'wpsem-filter-js', plugin_dir_url( dirname( __FILE__ ) ) . 'public/assets/js/filter.js', array ( 'jquery' ), '1.0.0', true );
        // Localize the script with new data
        $translation_array = array(
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
        );
        wp_localize_script( 'wpsem-filter-js', 'WPSEM', $translation_array );
	}

}

new WPSEM_SCFILTER();