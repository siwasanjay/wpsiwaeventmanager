<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_editor_assets', 'wpsem_slider_editor_assets' );

function wpsem_slider_editor_assets() {
    // Scripts.
    wp_enqueue_script( 'slick', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/slick.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'wpsem-slider-script-slider-script', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/script.js', array( 'jquery', 'slick' ), '1.0.0', true );
}

add_action( 'init', 'wpsem_slider_init' );

function wpsem_slider_init() {
    // Scripts.
    wp_register_script( 'wpsem-slider-script-slider', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/block.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'jquery', 'slick', 'wpsem-slider-script-slider-script' ), '1.0.0' );
    wp_enqueue_script( 'slick', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/slick.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'wpsem-slider-script-slider-script', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/script.js', array( 'jquery', 'slick' ), '1.0.0', true );

    // Styles.
    wp_enqueue_style( 'wpsem-slider-script-slider-editor', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/editor.css', '1.0.0' );



    register_block_type( 'wpsem/wpsem-slider-script', array(
        'editor_script' => 'wpsem-slider-script-slider',
        'render_callback' => 'wpsem_event_slider',
    ) );
}

// Frontend scripts and styles
add_action( 'wp_enqueue_scripts', 'wpsem_slider_frontend_scripts' );

function wpsem_slider_frontend_scripts() {
    // Scripts.
    wp_enqueue_script( 'slick', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/slick.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'wpsem-slider-script-slider-script', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/script.js', array( 'jquery', 'slick' ), '1.0.0', true );
}

// Server render method
if ( ! function_exists( 'wpsem_event_slider' ) ) {
    function wpsem_event_slider( $atts = array() ) {
        ob_start();

        $args = array(
            'post_type' => 'events',
            'posts_per_page' => 5,
        );

        $events = new WP_Query( $args );
        if ( $events->have_posts() ) {
            ?>
            <div class="images-container">
                <div class="slider slider-single-item">
                    <?php
                    while ( $events->have_posts() ) {
                        $events->the_post(); 
                        ?>
                        <div>
                            <?php echo get_the_post_thumbnail(); ?>
                            <p><?php echo get_the_title(); ?></p>
                        </div>
                        <?php
                    } // end while
                    ?>
                </div>
            </div>
        <?php
        }
        /* Restore original Post Data */
        wp_reset_postdata();

        return ob_get_clean();
    }
}
