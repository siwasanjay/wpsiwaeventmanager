<?php
/**
 * Schedules of the event
 * Start date-time and end date-time
 *
 * @since       1.0.0
 * @package     event-manager
 * @subpackage  event-manager/admin
 */
class WPSEM_SCHEDULE {

    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
            
            // add necessary scripts
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_date_picker' ) );
        }

    }

    /**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    /**
     * Adds the meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'event-schedules',
            __( 'Event Schedules', 'wpsiwa-event-mangager' ),
            array( $this, 'render_metabox' ),
            'events',
            'advanced',
            'high'
        );
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        
        wp_nonce_field( 'wpsemes_nonce_action', 'wpsemes_custom_nonce' ); ?>
        <p>
            <!-- event start date -->
            <label for="event-start-date"><?php _e( "Start Date", 'wpsiwa-event-mangager' ); ?></label>
            <input class="widefat date-picker" type="text" name="event-start-date" id="event-start-date" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wpsem_event_start_date', true ) ); ?>" size="30" />
            <!-- event end date -->
            <label for="event-end-date"><?php _e( "End Date", 'wpsiwa-event-mangager' ); ?></label>
            <input class="widefat date-picker" type="text" name="event-end-date" id="event-end-date" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wpsem_event_end_date', true ) ); ?>" size="30" />
            <!-- event location -->
            <label for="event-location"><?php _e( "Location", 'wpsiwa-event-mangager' ); ?></label>
            <input class="widefat location" type="text" name="event-location" id="event-location" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wpsem_event_location', true ) ); ?>" size="30" />
        </p>

    <?php }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // check for the nonce
        if ( !isset( $_POST['wpsemes_custom_nonce'] ) || !wp_verify_nonce( $_POST['wpsemes_custom_nonce'], 'wpsemes_nonce_action' ) )
            return $post_id;
        $post_type = get_post_type_object( $post->post_type );
        // if current user is not permited to edit the post type
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        // new value for the dates
        $new_str_date  = isset( $_POST['event-start-date'] ) ?  $_POST['event-start-date']  : '' ;
        $new_end_date  = isset( $_POST['event-end-date'] ) ?  $_POST['event-end-date']  : '' ;
        $new_location  = isset( $_POST['event-location'] ) ? $_POST['event-location'] : '';

        // old value for the dates
        $old_str_date   = get_post_meta( $post_id, '_wpsem_event_start_date', true );
        $old_end_date   = get_post_meta( $post_id, '_wpsem_event_end_date', true );
        $old_location   = get_post_meta( $post_id, '_wpsem_event_location', true );

        // if new start date value different
        if ( !empty( $new_str_date ) && $new_str_date != $old_str_date ) {
            update_post_meta( $post_id, '_wpsem_event_start_date', $new_str_date );
            update_post_meta( $post_id, '_wpsem_event_sd_timestramp', strtotime($new_str_date) );
        } // if new start date is empty
        else if ( empty( $new_str_date ) && $old_str_date ) {
            delete_post_meta( $post_id, '_wpsem_event_start_date', $old_str_date );    
            delete_post_meta( $post_id, '_wpsem_event_sd_timestramp', strtotime($old_str_date) );    
        }
        // if new end date has different value
        if ( !empty( $new_end_date ) && $new_end_date != $old_end_date ) {
            update_post_meta( $post_id, '_wpsem_event_end_date', $new_end_date );
            update_post_meta( $post_id, '_wpsem_event_ed_timestramp', strtotime($new_end_date) );
        } 
        // if new end date is empty 
        else if ( empty( $new_end_date ) && $old_end_date ) {
            delete_post_meta( $post_id, '_wpsem_event_end_date', $old_end_date );    
            delete_post_meta( $post_id, '_wpsem_event_ed_timestramp', strtotime($old_end_date) );    
        }
        // if new location 
        if( !empty( $new_location ) && $new_location != $old_location ) {
            update_post_meta( $post_id, '_wpsem_event_location', $new_location );
        }
        // if new location is empty
        else if ( empty( $new_end_date ) && $old_end_date ) {
            delete_post_meta( $post_id, '_wpsem_event_location', $old_location );
        }

    }

 
    public function enqueue_date_picker( $hook ) {
        if( 'post.php' != $hook ) return;
        
        wp_enqueue_style( 'style-jquery-ui', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/assets/css/jquery.datetimepicker.min.css' );

        // juqery ui core
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        // jquery datetime picker 
        wp_enqueue_script( 'wpsem-jquery-datetime', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/assets/js/jquery.datetimepicker.full.min.js', array ( 'jquery', 'jquery-ui-core' ), '1.6.3', true );
        // custom js
        wp_enqueue_script( 'wpsem-custom-js', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/assets/js/custom.js', array ( 'jquery', 'jquery-ui-datepicker' ), '1.0.0', true );
        // Localize the script with new data
        $translation_array = array(
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'dateFormat'   => get_option( 'date_format' ),
            'timeFormat'   => get_option( 'time_format' ),
    
        );
        wp_localize_script( 'wpsem-custom-js', 'WPSEM', $translation_array );

    }

}
new WPSEM_SCHEDULE();
