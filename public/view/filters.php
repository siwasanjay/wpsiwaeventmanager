<?php
// event types
$event_types = get_terms( array(
		'taxonomy' => 'event_type',
	)
);
// event tags
$event_tags = get_terms( array(
		'taxonomy' => 'post_tag',
	)
);
?>
<form action="" type="post">
	<!-- event type -->
	<select id="ev_cat" name="event_type">
		<option value=""><?php _e( 'All Types', 'wpsiwa-event-manager' ); ?></option>
		<?php 
		if( !empty( $event_types ) ) {
			foreach ( $event_types as $type ) {
				?>
				<option value="<?php echo esc_attr( $type->term_id ); ?>">
					<?php echo esc_html( $type->name ); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<!-- Tags -->
	<select id="ev_tag" name="event_tag">
		<option value=""><?php _e( 'All Tags', 'wpsiwa-event-manager' ); ?></option>
		<?php 
		if( !empty( $event_tags ) ) {
			foreach ( $event_tags as $tag ) {
				?>
				<option value="<?php echo esc_attr( $tag->term_id ); ?>">
					<?php echo esc_html( $tag->name ); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<!-- Based on event date -->
	<select id="ev_date" name="event_date">
		<option value=""><?php _e( 'All', 'wpsiwa-event-manager' ); ?></option>
		<option value="up-comming"><?php _e( 'Up Comming', 'wpsiwa-event-manager' ); ?></option>
		<option value="ended"><?php _e( 'Finished', 'wpsiwa-event-manager' ); ?></option>
	</select>

</form>