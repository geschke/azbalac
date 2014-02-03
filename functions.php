<?php

require_once( get_template_directory() . '/admin/admin-config.php' );


require_once( get_template_directory() . '/inc/header-addons.php' );


if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="well widget %2$s">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => "</h3>\n"
    ));

register_sidebar( array(
    'name' => 'Footer Sidebar 1 (left)',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );
register_sidebar( array(
    'name' => 'Footer Sidebar 2 (middle)',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );
register_sidebar( array(
    'name' => 'Footer Sidebar 3 (right)',
    'id' => 'footer-sidebar-3',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );
}


function jfl_comment_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );


    $fields['author'] = '<div class="form-group comment-form-author">' . '<label class="col-sm-2 control-label" for="author">' . __( 'Name*' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['email'] = '<div class="form-group comment-form-email"><label class="col-sm-2 control-label" for="email">' . __( 'Email*' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['url'] = '<div class="form-group comment-form-url"><label class="col-sm-2 control-label" for="url">' . __( 'Website' ) . '</label>' .
        '<div class="col-sm-10"><input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>';

    return $fields;
}

// see above...
add_filter('comment_form_default_fields','jfl_comment_fields');



if ( ! function_exists( 'jfl_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     *
     * @return void
     */
    function jfl_paging_nav() {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $GLOBALS['wp_query']->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => __( '&laquo; Previous', 'jfl' ),
            'next_text' => __( 'Next &raquo;', 'jfl' ),
            'type' => 'array'
        ) );

        if ( $links ) :

            ?>
            <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'jfl' ); ?></h1>
                <ul class="pagination loop-pagination">
                    <?php
                    foreach ($links as $link) {
                        echo '<li>' . $link . '</li>';
                    }
                    ?>
                </ul><!-- .pagination -->
            </nav><!-- .navigation -->
        <?php
        endif;
    }
endif;


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


function bootstrap_styles()
{
    global $jfl_theme;
    if (isset($jfl_theme['stylesheet']))
    {
        $stylesheet = $jfl_theme['stylesheet'];
    }
    else {
        $stylesheet = 'bootstap.min.css';
    }

    // Register the style like this for a theme:
    wp_register_style( 'bootstrap-styles', get_template_directory_uri() .'/css/design/' . $stylesheet, array(),
        '2014011301','all');
        //. bi_get_data('bootswatch'), array(), '3.0.3', 'all' );
    //wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.0.3', 'all' );
    //wp_register_style( 'magnific', get_template_directory_uri() . '/css/magnific.css', array(), '0.9.4', 'all' );
    //wp_register_style( 'responsive-style', get_stylesheet_uri(), false, '3.0.3' );


    //  enqueue the style:
    wp_enqueue_style( 'bootstrap-styles' );
    //wp_enqueue_style( 'font-awesome' );
    //wp_enqueue_style( 'magnific' );
    //wp_enqueue_style( 'responsive-style' );

}
add_action( 'wp_enqueue_scripts', 'bootstrap_styles' );



function add_class_the_tags($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="btn btn-info btn-xs"',$html);
    return $html;
}
add_filter('the_tags','add_class_the_tags',10,1);

function register_my_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );

add_theme_support('post-thumbnails');

/*
function add_menu_parent_class( $items ) {

    $parents = array();
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
        }
    }

    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'dropdown';
        }
    }

    return $items;
}

add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
*/


if ( ! function_exists( 'jfl_get_layout' ) ) :

    function jfl_get_layout() {
        global $jfl_theme;
        if (!isset($jfl_theme['layout'])) {
            $jfl_theme['layout'] = 2; // default: content left, sidebar right
        }
        switch ($jfl_theme['layout']) {
            case 1:
                $columns = 1;
                $content = 1; // main content in single column
                $styleCol_1 = 'col-md-12 col-sm-12 col-xs-12';
                $styleCol_2 = 'col-md-12 col-sm-12 col-xs-12';
                break;
            case 3:
                $columns = 2;
                $content = 2; // main content right
                $styleCol_1 = 'col-md-9 col-sm-9 col-xs-9';
                $styleCol_2 = 'col-md-3 col-sm-3 col-xs-3';
                break;
            case 2:
            default:
                $columns = 2;
                $content = 1; // main content left
                $styleCol_1 = 'col-md-9 col-sm-9 col-xs-9';
                $styleCol_2 = 'col-md-3 col-sm-3 col-xs-3';
                break;
        }
        return array('columns' => $columns, 'col_1' => $styleCol_1, 'col_2' => $styleCol_2, 'content' => $content);
    }
endif;