<?php 
/**
 * the template file to show the found events
 *
 */

$html  = '';
$html .= '<h2>' . get_the_title() . '</h2>';

$event_str_date = get_post_meta( get_the_ID(), '_wpsem_event_start_date', true );
$event_end_date = get_post_meta( get_the_ID(), '_wpsem_event_end_date', true );

if( $event_str_date ) {
	$html .= '<h4>Schedule:</h4>';
	// start date time
	$html .= '<p>Start: ' . $event_str_date . '</p>';
	// end date time
	if( $event_end_date ) {
		$html .= '<p>End: ' . $event_end_date . '</p>';
	}
}
$location = get_post_meta( get_the_ID(), '_wpsem_event_location', true ); 
if( $location ) {
	$html .= '<p>Location: ' . $location . '</p>';
}

$html .= get_the_excerpt( get_the_ID() );  

echo apply_filters( 'em_conetnt_found_html', $html );