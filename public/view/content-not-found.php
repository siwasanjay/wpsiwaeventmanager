<?php 
/**
 * the template file to show if no events were found
 *
 */

$html  = '';
$html .= '<h3>' . __( 'No any events found.', 'wpsiwa-event-manager' ) . '</h3>';

echo apply_filters( 'em_conetnt_not_found_html', $html );
