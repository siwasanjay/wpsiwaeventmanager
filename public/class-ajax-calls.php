<?php
// Filter on select option change.
add_action( "wp_ajax_wpsem_filter_event", "wpsem_filter_events" );
add_action( "wp_ajax_nopriv_wpsem_filter_event", "wpsem_filter_events" );
function wpsem_filter_events() {

	// Posts args
	$args = array(
		'post_type' 	 => 'events', // events only
		'posts_per_page' => $_POST['limit'], 
	);

	// Event Type
	if( isset( $_POST['curType'] ) && $_POST['curType'] != '' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' 	=> 'event_type',
				'field'		=> 'term_id',
				'terms'		=> $_POST['curType'],
			),
		);
	}

	// Event Tag
	if( isset( $_POST['curTag'] ) && $_POST['curTag'] != '' ) {
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'post_tag',
			'field'		=> 'term_id',
			'terms'		=> $_POST['curTag'],
		);
	}

	// Order by
	if( isset( $_POST['curDate'] ) && $_POST['curDate'] != '' ) {
		
		$set = $_POST['curDate'];

		// upcomming events.
		if( 'up-comming' == $set ) {
			$args['meta_query'] = array(
				array(
					'key' 	=> '_wpsem_event_sd_timestramp',
					'value' => time(),
					'compare' => '>',
				)
			);
		}
		// finished events.
		else if( 'ended' == $set ) {
			$args['meta_query'] = array(
				array(
					'key' 	=> '_wpsem_event_ed_timestramp',
					'value' => time(),
					'compare' => '<',
				)
			);
		}
	}
	
	if( isset( $_POST['cPage'] ) ) {
		$args['paged'] = $_POST['cPage'];
	}
	
	$events = new WP_Query( $args );

	$max = $events->max_num_pages;
	
	// next page
	if( $_POST['cPage'] && $max > $_POST['cPage'] ) {
		$paged = $_POST['cPage'];
		$paged++; 
	}
	
	ob_start();

	if ( $events->have_posts() ) {
		
		while ( $events->have_posts() ) {
			$events->the_post(); 
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/content-found.php';
		} // end while
			
	} // end if
	// if there are no any events.
	else {
		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/view/content-not-found.php';
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	$content = ob_get_clean();

	wp_send_json( array( 'content'=> $content, 'nextpage' => $paged ) );
	
}
