<?php

/**
 * Activates Theme Mode
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Loads OptionTree
 */
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Loads Theme Options
 */
require( trailingslashit( get_template_directory() ) . 'admin/theme-options.php' );


//require_once dirname( __FILE__ ) . '/inc/3rd/class-tgm-plugin-activation.php';

//add_action( 'tgmpa_register', 'tikva_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

function tikva_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'ReduxFramework', // The plugin name.
            'slug'               => 'redux-framework', // The plugin slug (typically the folder name).
            //'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        )


    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'tgmpa_tikva',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tikva' ),
            'menu_title'                      => __( 'Install Plugins', 'tikva' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tikva' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tikva' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tikva' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tikva' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tikva' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tikva' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tikva' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tikva' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tikva' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tikva' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tikva' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tikva' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tikva' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tikva' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tikva' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}

load_theme_textdomain( 'tikva', get_template_directory() . '/languages' );

//require_once( get_template_directory() . '/admin/admin-config.php' );


// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

require_once( get_template_directory() . '/inc/header-addons.php' );
require_once( get_template_directory() . '/inc/post-addons.php' );


if ( ! function_exists( '_wp_render_title_tag' ) ) {
    	function theme_slug_render_title() {
           ?>
            <title><?php wp_title( '|', true, 'right' ); ?></title>
            <?php
        }
	add_action( 'wp_head', 'theme_slug_render_title' );
}
            

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
//        load_theme_textdomain( 'tikva', get_template_directory() . '/languages' );

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
            'default-image'          =>  null,
            'uploads'                => true,
            'flex-width'    => true,
        	'width'         => 1115,
	        'flex-height'    => true,
            'wp-head-callback'       => 'tikva_header_style',

        );
       add_theme_support( 'custom-header', $headerDefaults );

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( 'css/editor-style.css' );

        add_theme_support( 'title-tag' );


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

if ( ! function_exists( 'tikva_enqueue_font_awesome' ) ) :

    function tikva_enqueue_font_awesome() {

        wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );

}

endif;

if ( ! function_exists( 'tikva_get_body_styles' ) ) :

    function tikva_get_body_styles() {
    
        $colorBgSidebar = ot_get_option('color_bg_sidebar');
        if (!$colorBgSidebar) {
            $sidebarStyleColorBg = '';
        }
        else {
            $sidebarStyleColorBg = ' background-color: ' . $colorBgSidebar .';';
        }
       
        $colorFgSidebar = ot_get_option('color_fg_sidebar');
        if (!$colorFgSidebar) {
            $sidebarStyleColorFg = '';
        }
        else {
            $sidebarStyleColorFg = ' color: ' . $colorFgSidebar .';';
        }
        
        return array(
            'sidebarStyleColorBg' => $sidebarStyleColorBg,
            'sidebarStyleColorFg' => $sidebarStyleColorFg
        );
    }
endif;

function theme_tikva_widgets_init() 
{
    $bodyStyles = tikva_get_body_styles();

    register_sidebar(array(
        'name' => 'Sidebar 1',
        'id' => 'sidebar-1',
        'class'         => '',
        'before_widget' => '<div id="%1$s" style="'. $bodyStyles['sidebarStyleColorBg'] . $bodyStyles['sidebarStyleColorFg']  . '" class="well widget %2$s">',
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


if ( function_exists('register_sidebar') ) {

    add_action( 'widgets_init', 'theme_tikva_widgets_init' );
 
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
    <div class="form-group"><input class="btn btn-primary" type="submit" id="searchsubmit" value="'. esc_attr__( __( 'Search', 'tikva') ) .'" />
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

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.6', true );

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
        array( 'jquery' ), '20160410', true );
}


function tikva_bootstrap_styles()
{
    $stylesheetData = ot_get_option('stylesheet');
    
    if ($stylesheetData)
    {
        $stylesheet = $stylesheetData;
    }
    else {
        $stylesheet = 'slate_accessibility_ready.min.css';
    }

    // Register the style like this for a theme:
    wp_register_style( 'bootstrap-styles', get_template_directory_uri() .'/css/design/' . $stylesheet, array(),
        '20160411','all');
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

add_action( 'wp_enqueue_scripts', 'tikva_bootstrap_styles' );
add_action( 'wp_enqueue_scripts', 'tikva_scripts' );
add_action( 'wp_enqueue_scripts', 'tikva_enqueue_font_awesome' );
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 * in head of document, based on current view.
 * in head of document, based on current view.
 *
 * @since Tikva 0.1.4
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function tikva_wp_title( $title, $sep ) {
        global $paged, $page;

        if ( is_feed() ) {
                return $title;
        }

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
                $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 ) {
                $title = "$title $sep " . sprintf( __( 'Page %s', 'tikva' ), max( $paged, $page ) );
        }

        return $title;
}
add_filter( 'wp_title', 'tikva_wp_title', 10, 2 );



function add_class_the_tags($html){
    $html = str_replace('<a','<a class="btn btn-info btn-xs"',$html);
    return $html;
}
add_filter('the_tags','add_class_the_tags',10,1);

function register_tikva_menus() {
    register_nav_menus(array('header-menu' => __( 'Header Menu', 'tikva' ),));
}
add_action( 'init', 'register_tikva_menus' );


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
    
        $layoutData = ot_get_option('layout');
    
        if (!isset($layoutData) || !$layoutData) {
            $layoutData = 2; // default: content left, sidebar right
        }
        switch ($layoutData) {
            case 1:
                $columns = 1;
                $content = 1; // main content in single column
                $styleCol_1 = 'col-md-12 col-sm-12';
                $styleCol_2 = 'col-md-12 col-sm-12';
                break;
            case 3:
                $columns = 2;
                $content = 2; // main content right
                $styleCol_1 = 'col-md-9 col-sm-8';
                $styleCol_2 = 'col-md-3 col-sm-4';
                break;
            case 2:
            default:
                $columns = 2;
                $content = 1; // main content left
                $styleCol_1 = 'col-md-9 col-sm-8';
                $styleCol_2 = 'col-md-3 col-sm-4';
                break;
        }
        return array('columns' => $columns,
            'col_1' => $styleCol_1,
            'col_2' => $styleCol_2,
            'content' => $content);
    }
endif;

if ( ! function_exists( 'tikva_get_navbar_layout' ) ) :

    
    function tikva_get_navbar_layout() {
    
         $navbarData = ot_get_option('navbar_fixed');
         if ($navbarData == 'fixed-top') {
            $navbarFixed = 'fixed-top';
         }
         else {
            $navbarFixed = 'default';
         }
         return $navbarFixed;
    }
endif;

if ( ! function_exists( 'tikva_get_header_styles' ) ) :

    function tikva_get_header_styles($navbarFixed) {
         
        $navbarData = ot_get_option('navbar_style_inverse');
    
        $navbarStyleClass = '';

        if ($navbarData == 'inverse') {
            $navbarStyleClass .= ' navbar-inverse';
        }
        else {
            $navbarStyleClass .= ' navbar-default';
        }

        if ($navbarFixed == 'fixed-top') {
            $navbarStyleClass .= ' navbar-fixed-top';
        }
        else {
            $navbarStyleClass .= ' '; // todo: set css style when not fixed... or if fixed. hm
        }
        
        $colorBgHeaderData = ot_get_option('color_bg_header');
        if ($colorBgHeaderData) {
            $headerStyleColorBg = $colorBgHeaderData;
        }
        else {
            $headerStyleColorBg = '';
        }
        // this is currently not used, maybe in another version. The only foreground color is modifiey by CSS definition, because it's displayed as an URL.
        
        $colorFgHeaderData = ot_get_option('color_fg_header');
        
        if ($colorFgHeaderData) {
            $headerStyleColorFg = ' color: ' . $colorFgHeaderData .';';
        }
        else {
            $headerStyleColorFg = '';
        }

        return array('navbarStyleClass' => $navbarStyleClass,
            'headerStyleColorBg' => $headerStyleColorBg,
            'headerStyleColorFg' => $headerStyleColorFg
        );
    }
endif;


if ( ! function_exists( 'tikva_get_footer_styles' ) ) :

    function tikva_get_footer_styles() {
    
    
        global $tikva_theme;

        if (isset($tikva_theme['color-bg-footer']) && $tikva_theme['color-bg-footer'] && stripos($tikva_theme['color-bg-footer'], 'transparent') !== false ) {
            $footerStyleColorBg = '';
        }
        elseif (isset($tikva_theme['color-bg-footer']) && $tikva_theme['color-bg-footer'] ) {
            $footerStyleColorBg = ' background-color: ' . $tikva_theme['color-bg-footer'] .';';
        }
        else {
            $footerStyleColorBg = '';
        }

        if (isset($tikva_theme['color-fg-footer']) && $tikva_theme['color-fg-footer'] && stripos($tikva_theme['color-fg-footer'], 'transparent') !== false ) {
            $footerStyleColorFg = '';
        }
        elseif (isset($tikva_theme['color-fg-footer']) && $tikva_theme['color-fg-footer'] ) {
            $footerStyleColorFg = ' color: ' . $tikva_theme['color-fg-footer'] .';';
        }
        else {
            $footerStyleColorFg = '';
        }
        return array(
            'footerStyleColorBg' => $footerStyleColorBg,
            'footerStyleColorFg' => $footerStyleColorFg
        );
    }
endif;




if ( ! function_exists( 'tikva_get_header_image_data' ) ) :

    function tikva_get_header_image_data() {
        global $tikva_theme;
        $imageData = array();

        if (get_header_image()) {
            $largeImage = get_custom_header();
            $imageData[0] = array('url' => $largeImage->url,
                'height' => $largeImage->height,
                'width' => $largeImage->width,
                'thumbnail' => $largeImage->thumbnail_url,
                'id' => $largeImage->attachment_id); //$tikva_theme['header-image-large'];
        }
        elseif (!isset($tikva_theme['header-image-example-tikva']) ||
            (isset($tikva_theme['header-image-example-tikva']) &&
                $tikva_theme['header-image-example-tikva'] == '1'
            )
        ) {
            // fallback to example image if not overwritten or switched off
            $imageData[0] = array('url' => get_template_directory_uri() . '/images/tikva_default_header_image.jpg',
                'height' => 213,
                'width' => 1115,
                'thumbnail' => '', // not used here
                'id' => 0);

        } else {
            $imageData[0] = '';
        }
        if (isset($imageData[0]) && $imageData[0] !== '') {
            if (isset($tikva_theme['header-image-large-dontscale']) && $tikva_theme['header-image-large-dontscale']) {
                $imageData[0]['dontscale'] = $tikva_theme['header-image-large-dontscale'];
            } else {
                $imageData[0]['dontscale'] = 0;
            }
        }

        if (isset($tikva_theme['header-image-medium']) && $tikva_theme['header-image-medium'] &&
            isset($tikva_theme['header-image-medium']['url']) && $tikva_theme['header-image-medium']['url']) {
            $imageData[1] = $tikva_theme['header-image-medium'];
            if (isset($tikva_theme['header-image-medium-dontscale']) && $tikva_theme['header-image-medium-dontscale']) {
                $imageData[1]['dontscale'] = $tikva_theme['header-image-medium-dontscale'];
            } else {
                $imageData[1]['dontscale'] = 0;
            }
        } else {
            $imageData[1] = '';
        }

        if (isset($tikva_theme['header-image-small']) && $tikva_theme['header-image-small'] &&
            isset($tikva_theme['header-image-small']['url']) && $tikva_theme['header-image-small']['url']) {

            $imageData[2] = $tikva_theme['header-image-small'];
            if (isset($tikva_theme['header-image-small-dontscale']) && $tikva_theme['header-image-small-dontscale']) {
                $imageData[2]['dontscale'] = $tikva_theme['header-image-small-dontscale'];
            } else {
                $imageData[2]['dontscale'] = 0;
            }

        } else {
            $imageData[2] = '';
        }
        if (isset($tikva_theme['header-image-xsmall']) && $tikva_theme['header-image-xsmall'] &&
            isset($tikva_theme['header-image-xsmall']['url']) && $tikva_theme['header-image-xsmall']['url']) {

            $imageData[3] = $tikva_theme['header-image-xsmall'];
            if (isset($tikva_theme['header-image-xsmall-dontscale']) && $tikva_theme['header-image-xsmall-dontscale']) {
                $imageData[3]['dontscale'] = $tikva_theme['header-image-xsmall-dontscale'];
            } else {
                $imageData[3]['dontscale'] = 0;
            }

        } else {
            $imageData[3] = '';
        }

        return '<script type="text/javascript">var tikvaHeaderImage = ' . json_encode($imageData) . '</script>';
    }
endif;



if ( ! function_exists( 'tikva_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own tikva_header_style() function to override in a child theme.
 *
 * @since Tikva 0.2
 *
 * @see twentysixteen_custom_header_and_background().
 */
function tikva_header_style() {
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="tikva-header-css">

		#site-header-text {
                    display: none;
		}
	</style>
	<?php
}
endif; // tikva_header_style




function tikva_excerpt_more( $more ) {
    return '...<br/> <p> <a rel="bookmark" class="read-more btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . sprintf(__( 'Read More <span class="screen-reader-text">on %1$s </span>&raquo;', 'tikva' ), get_the_title())  . '</a></p>';
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
