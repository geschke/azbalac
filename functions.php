<?php


if ( function_exists('register_sidebar') )
    register_sidebar();

if ( ! function_exists( 'jfl_categorized_blog' ) ) :

    function jfl_categorized_blog() {
        return true;
    }
endif;

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since jfl 1.0
 *
 * @return void
 */
function jfl_scripts() {
    // Add Lato font, used in the main stylesheet.
    //wp_enqueue_style( 'jfl-lato', twentyfourteen_font_url(), array(), null );

    // Add Genericons font, used in the main stylesheet.
    //wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

    // Load our main stylesheet.
    //wp_enqueue_style( 'twentyfourteen-style', get_stylesheet_uri(), array( 'genericons' ) );

    // Load the Internet Explorer specific stylesheet.
   // wp_enqueue_style( 'twentyfourteen-ie', get_template_directory_uri() . '/css/ie.css',
   //     array( 'twentyfourteen-style', 'genericons' ), '20131205' );
    //wp_style_add_data( 'twentyfourteen-ie', 'conditional', 'lt IE 9' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    /*if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'twentyfourteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
    }*/

    /*if ( is_active_sidebar( 'sidebar-3' ) ) {
        wp_enqueue_script( 'jquery-masonry' );
    }*/

    /*if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
        wp_enqueue_script( 'twentyfourteen-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
        wp_localize_script( 'twentyfourteen-slider', 'featuredSliderDefaults', array(
            'prevText' => __( 'Previous', 'twentyfourteen' ),
            'nextText' => __( 'Next', 'twentyfourteen' )
        ) );
    }*/

    wp_enqueue_script( 'jfl-script', get_template_directory_uri() . '/js/functions.js',
        array( 'jquery' ), '20131224', true );
}
add_action( 'wp_enqueue_scripts', 'jfl_scripts' );

function add_class_the_tags($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="btn btn-info btn-xs"',$html);
    return $html;
}
add_filter('the_tags','add_class_the_tags',10,1);