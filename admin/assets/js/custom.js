jQuery(document).ready(function($) {
	jQuery('.date-picker').each(function( i, el ) {
		jQuery(this).datetimepicker({
			step: 30,
			format: WPSEM.dateFormat + ' ' + WPSEM.timeFormat,
		});
	} );
	
});