<?php

/**
 * Get ReduxFramework from embedded installation if plugin isn't installed.
 * Follows the recommendations of ReduxFraework
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/inc/3rd/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/3rd/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/inc/3rd/ReduxFramework/sample/sample-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/3rd/ReduxFramework/sample/sample-config.php' );
}

require_once( get_template_directory() . '/admin/admin-config.php' );


require_once( get_template_directory() . '/inc/header-addons.php' );
require_once( get_template_directory() . '/inc/post-addons.php' );


if ( ! function_exists( 'tikva_setup' ) ) :
    /**
     * tikva theme setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since tikva 0.1
     */
    function tikva_setup() {

        /*
         * Make tikva theme available for translation.
         *
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on tikva, use a find and
         * replace to change 'tikva' to the name of your theme in all
         * template files.
         */
        load_theme_textdomain( 'tikva', get_template_directory() . '/languages' );

        // This theme styles the visual editor to resemble the theme style.
        //add_editor_style( array( 'css/editor-style.css', tikva_font_url() ) );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support('post-thumbnails');
        //set_post_thumbnail_size( 672, 372, true );
        //add_image_size( 'tikva-full-width', 1038, 576, true );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list',
        ) );

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ) );


        // This theme allows users to set a custom background.
        //add_theme_support( 'custom-background', apply_filters( 'tikva_custom_background_args', array(
        //    'default-color' => 'f5f5f5',
        //) ) );
        add_theme_support( 'custom-background');

        $headerDefaults = array(
            'default-color'          => 'ffffff',
            'default-image'          =>  null
        );
       add_theme_support( 'custom-header', $headerDefaults );

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( 'css/editor-style.css' );




        // This theme uses its own gallery styles.
        //add_filter( 'use_default_gallery_style', '__return_false' );
    }
endif; // tikva_setup
add_action( 'after_setup_theme', 'tikva_setup' );

/**
 * Set up the content width value based on the theme's design.
 *
 * @see tikva_content_width()
 *
 * @since tikva 0.1
 */
if ( ! isset( $content_width ) ) {
    $content_width = 474;
}


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


function tikva_comment_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );


    $fields['author'] = '<div class="form-group comment-form-author">' . '<label class="col-sm-2 control-label" for="author">' . __( 'Name*','tikva' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['email'] = '<div class="form-group comment-form-email"><label class="col-sm-2 control-label" for="email">' . __( 'Email*', 'tikva' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['url'] = '<div class="form-group comment-form-url"><label class="col-sm-2 control-label" for="url">' . __( 'Website', 'tikva' ) . '</label>' .
        '<div class="col-sm-10"><input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>';

    return $fields;
}

// see above...
add_filter('comment_form_default_fields','tikva_comment_fields');



if ( ! function_exists( 'tikva_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     *
     * @return void
     */
    function tikva_paging_nav() {
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
            'prev_text' => __( '&laquo; Previous', 'tikva' ),
            'next_text' => __( 'Next &raquo;', 'tikva' ),
            'type' => 'array'
        ) );

        if ( $links ) :

            ?>
            <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'tikva' ); ?></h1>
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


if ( ! function_exists( 'tikva_categorized_blog' ) ) :

    function tikva_categorized_blog() {
        return true;
    }
endif;

if ( ! function_exists( 'tikva_get_search_form' ) ) :

function tikva_get_search_form() {

    $form = '<form role="form search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div class="form-group"><label class="screen-reader-text" for="s">' . _x( 'Search for:','label','tikva' ) . '</label>
    <input class="form-control" type="text" placeholder="' . _x( 'Search &hellip;','placeholder','tikva' ) . '" value="' . get_search_query() . '" name="s" id="s" />
    </div>
    <div class="form-group"><input class="btn btn-primary" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';
    return $form;
}
endif;

add_filter( 'get_search_form', 'tikva_get_search_form' );


/**
 * Enqueue scripts and styles for the front end.
 *
 * @since tikva 0.1
 *
 * @return void
 */
function tikva_scripts() {
    // Add Lato font, used in the main stylesheet.
    //wp_enqueue_style( 'tikva-lato', tikva_font_url(), array(), null );

    // Add Genericons font, used in the main stylesheet.
    //wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

    // Load our main stylesheet.
    wp_enqueue_style( 'tikva-style', get_stylesheet_uri(), array());

    // Load the Internet Explorer specific stylesheet.
   // wp_enqueue_script( 'tikva-ie', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); //get_template_directory_uri() . '/css/ie.css',
        // array( 'tikva-style', 'genericons' ), '20131205' );
    //wp_st_add_data( 'tikva-ie', 'conditional', 'lt IE 9' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.1.1', true );

    /*if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'tikva-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
    }*/

    /*if ( is_active_sidebar( 'sidebar-3' ) ) {
        wp_enqueue_script( 'jquery-masonry' );
    }*/

    /*if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
        wp_enqueue_script( 'tikva-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
        wp_localize_script( 'tikva-slider', 'featuredSliderDefaults', array(
            'prevText' => __( 'Previous', 'tikva' ),
            'nextText' => __( 'Next', 'tikva' )
        ) );
    }*/


    wp_enqueue_script( 'tikva-script', get_template_directory_uri() . '/js/functions.js',
        array( 'jquery' ), '20140605', true );
}
add_action( 'wp_enqueue_scripts', 'tikva_scripts' );


function bootstrap_styles()
{
    global $tikva_theme;
    if (isset($tikva_theme['stylesheet']))
    {
        $stylesheet = $tikva_theme['stylesheet'];
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

function register_tikva_menus() {
    register_nav_menus(array('header-menu' => __( 'Header Menu', 'tikva' ),));
}
add_action( 'init', 'register_tikva_menus' );


/*
 *  function add_menu_parent_class( $items ) {

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

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since tikva 0.1
 *
 * @return bool Whether there are featured posts.
 */
function tikva_has_featured_posts() {
    return !is_paged() && (bool) tikva_get_featured_posts();
}

/**
 * Getter function for Featured Content Plugin.
 *
 * @since tikva 0.1
 *
 * @return array An array of WP_Post objects.
 */
function tikva_get_featured_posts() {
    /**
     * Filter the featured posts to return in Tikva.
     *
     * @since tikva 0.1
     *
     * @param array|bool $posts Array of featured posts, otherwise false.
     */
    return apply_filters( 'tikva_get_featured_posts', array() );
}



add_theme_support( 'featured-content', array(
    'featured_content_filter' => 'tikva_get_featured_posts',
    'max_posts' => 4,
) );

if ( ! function_exists( 'tikva_get_layout' ) ) :

    function tikva_get_layout() {
        global $tikva_theme;
        if (!isset($tikva_theme['layout'])) {
            $tikva_theme['layout'] = 2; // default: content left, sidebar right
        }
        switch ($tikva_theme['layout']) {
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


function tikva_excerpt_more( $more ) {
    return '...<br/> <p> <a class="read-more btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . __( 'Read More &raquo;', 'tikva' ). '</a></p>';
}
add_filter( 'excerpt_more', 'tikva_excerpt_more' );

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
    require get_template_directory() . '/inc/featured-content.php';
}