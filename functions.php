<?php

define('AZBALAC_DATEVERSION','2021052501');

/**
 * Azbalac only works with PHP 7 and above.
 */
if (version_compare(phpversion(), '7.2.5', '<')) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


require_once( get_template_directory() .'/vendor/autoload.php');
require_once( get_template_directory() . '/inc/template/Template.php' );
require_once( get_template_directory() . '/inc/template/TwigSectionExtension.php' );

require_once( get_template_directory() . '/inc/template/DataContainer.php' );

$aztpl = new Azbalac_Template();

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

require_once( get_template_directory() . '/inc/header-addons.php' );
require_once( get_template_directory() . '/inc/post-addons.php' );
include get_template_directory() . '/inc/info-screen/welcome-screen.php';

require_once( get_template_directory() . '/inc/customizer/CustomLatestPostControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomRadioImageControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomSliderControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomRepeaterHelper.php' );
require_once( get_template_directory() . '/inc/customizer/CustomRepeaterControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomFontControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomThemeControl.php' );

require_once( get_template_directory() . '/inc/customizer/CustomizerSanitizer.php' );
require_once( get_template_directory() . '/inc/customizer/CustomizerAddon.php' );

require_once( get_template_directory() . '/inc/customizer/Customizer.php' );

require_once( get_template_directory() . '/inc/sections/SectionContentColumn.php' );
require_once( get_template_directory() . '/inc/sections/SectionSlider.php' );
require_once( get_template_directory() . '/inc/sections/SectionSocialMediaButtons.php' );
require_once( get_template_directory() . '/inc/sections/SectionFooter.php' );
require_once( get_template_directory() . '/inc/sections/SectionWidgets.php' );
require_once( get_template_directory() . '/inc/sections/SectionSubfooter.php' );
require_once( get_template_directory() . '/inc/template/ThemeFont.php' );
require_once( get_template_directory() . '/inc/template/Theme.php' );

require_once( get_template_directory() . '/inc/Featured.php' );



if ( ! function_exists( '_wp_render_title_tag' ) ) {
    	function theme_slug_render_title() {
           ?>
            <title><?php wp_title( '|', true, 'right' ); ?></title>
            <?php
        }
	add_action( 'wp_head', 'theme_slug_render_title' );
}


if (! function_exists('azbalac_admin_enqueue_scripts')) :
    
    function azbalac_admin_enqueue_scripts() {
        // UPLOAD ENGINE
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'azbalac-admin-style', get_template_directory_uri() . '/css/admin.css' );
    }
endif;
            

if ( ! function_exists( 'azbalac_setup' ) ) :
    /**
     * azbalac theme setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since azbalac 0.1
     */
    function azbalac_setup() {

        /*
         * Make azbalac theme available for translation.
         *
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on azbalac, use a find and
         * replace to change 'azbalac' to the name of your theme in all
         * template files.
         */

        load_theme_textdomain( 'azbalac', get_template_directory() . '/languages' );

        // This theme styles the visual editor to resemble the theme style.
        //add_editor_style( array( 'css/editor-style.css', azbalac_font_url() ) );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support('post-thumbnails');
        //set_post_thumbnail_size( 672, 372, true );
        //add_image_size( 'azbalac-full-width', 1038, 576, true );

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
        //add_theme_support( 'custom-background', apply_filters( 'azbalac_custom_background_args', array(
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
            //'wp-head-callback'       => 'azbalac_header_style',

        );
        add_theme_support( 'custom-header', $headerDefaults );

        // Add theme support for Custom Logo.
        add_theme_support( 'custom-logo', array(
            'width'       => 250,
            'height'      => 250,
            'flex-width'  => true,
        ) );

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( 'css/editor-style.css' );

        add_theme_support( 'title-tag' );
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_action( 'admin_enqueue_scripts', 'azbalac_admin_enqueue_scripts' );
        
        add_action( 'customize_register', 'azbalac_register_customize_javascript_template_types' );
        

        // Initialize Customizer after all custom controls are loaded
        new Azbalac_Customizer();

        // This theme uses its own gallery styles.
        //add_filter( 'use_default_gallery_style', '__return_false' );
    }
endif; // azbalac_setup
add_action( 'after_setup_theme', 'azbalac_setup' );

/**
 * Make call to register_control_type to enable underscore JavaScript template integration
*/
if (! function_exists('azbalac_register_customize_javascript_template_types')) :

    function azbalac_register_customize_javascript_template_types($wp_customize)
    {
        // Load our custom control.
        //require_once( get_template_directory() . '/inc/customizer/CustomRepeaterControl.php' );

        // Register the control type.
        $wp_customize->register_control_type( 'Azbalac_Custom_Repeater_Control' );
        $wp_customize->register_control_type( 'Azbalac_Custom_Font_Control' );
        $wp_customize->register_control_type( 'Azbalac_Custom_Theme_Control' );
    }

endif;



/**
 * Set up the content width value based on the theme's design.
 *
 * @see azbalac_content_width()
 *
 * @since azbalac 0.1
 */
if ( ! isset( $content_width ) ) {
    $content_width = 474;
}



if ( ! function_exists( 'azbalac_get_body_styles' ) ) :

    function azbalac_get_body_styles() 
    {
    
        $colorBgSidebar = get_theme_mod('azbalac_setting_color_bg_sidebar');
        if (!$colorBgSidebar) {
            $sidebarStyleColorBg = '';
        }
        else {
            $sidebarStyleColorBg = ' background-color: ' . $colorBgSidebar .';';
        }
       
        $colorFgSidebar = get_theme_mod('azbalac_setting_color_fg_sidebar');
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

function theme_azbalac_widgets_init()
{
    $bodyStyles = azbalac_get_body_styles();

    register_sidebar(array(
        'name' => __("Sidebar 1", 'azbalac'),
        'id' => 'sidebar-1',
        'class' => '',
        'before_widget' => '<div class="card"><div id="%1$s" style="' . $bodyStyles['sidebarStyleColorBg'] . $bodyStyles['sidebarStyleColorFg'] . '" class="card-body widget %2$s">',
        'after_widget' => "</div></div>\n",
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => "</h3>\n"
    ));

    for ($i = 1; $i <= 6; $i++) {
        register_sidebar(array(
            'name' => sprintf(__("Footer Widget Area #%d", 'azbalac'), $i),
            'id' => sprintf("footer-sidebar-%d", $i),
            'description' => 'Appears in the footer area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    register_sidebar(array(
        'name' => __("Header Widget Area", 'azbalac'),
        'id' => "header-widget-right",
        'description' => 'Appears in the header on right side',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        //'before_title' => '<h3 class="widget-title">',
        //'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __("Navigation Right Widget Area", 'azbalac'),
        'id' => "navigation-widget-right",
        'description' => 'Appears in the navigation on right side',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        //'before_title' => '<h3 class="widget-title">',
        //'after_title' => '</h3>',
    ));


}

if ( function_exists('register_sidebar') ) {

    add_action( 'widgets_init', 'theme_azbalac_widgets_init' );
 
}


function azbalac_comment_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] = '<div class="form-group comment-form-author">' . '<label class="col-sm-2 control-label" for="author">' . __( 'Name*','azbalac' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['email'] = '<div class="form-group comment-form-email"><label class="col-sm-2 control-label" for="email">' . __( 'Email*', 'azbalac' ) . '</label> ' .
        '<div class="col-sm-10"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>';

    $fields['url'] = '<div class="form-group comment-form-url"><label class="col-sm-2 control-label" for="url">' . __( 'Website', 'azbalac' ) . '</label>' .
        '<div class="col-sm-10"><input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>';

    return $fields;
}

// see above...
add_filter('comment_form_default_fields','azbalac_comment_fields');



if ( ! function_exists( 'azbalac_categorized_blog' ) ) :

    function azbalac_categorized_blog() {
        return true;
    }
endif;

if ( ! function_exists( 'azbalac_get_search_form' ) ) :

function azbalac_get_search_form() {

    $form = '<form role="form search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div class="form-group"><label class="screen-reader-text" for="s">' . _x( 'Search for:','label','azbalac' ) . '</label>
    <input class="form-control" type="text" placeholder="' . _x( 'Search &hellip;','placeholder','azbalac' ) . '" value="' . get_search_query() . '" name="s" id="s" />
    </div>
    <div class="form-group"><input class="btn btn-primary" type="submit" id="searchsubmit" value="'. esc_attr__( __( 'Search', 'azbalac') ) .'" />
    </div>
    </form>';
    return $form;
}
endif;

add_filter( 'get_search_form', 'azbalac_get_search_form' );


/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Azbalac 0.1
 *
 * @return void
 */
function azbalac_scripts() {
    // Add Lato font, used in the main stylesheet.
    //wp_enqueue_style( 'azbalac-lato', azbalac_font_url(), array(), null );

    // Add Genericons font, used in the main stylesheet.
    //wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

    // Load our main stylesheet.
    wp_enqueue_style( 'azbalac-style', get_stylesheet_uri(), array());

    // Load the Internet Explorer specific stylesheet.
   // wp_enqueue_script( 'azbalac-ie', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); //get_template_directory_uri() . '/css/ie.css',
        // array( 'azbalac-style', 'genericons' ), '20131205' );
    //wp_st_add_data( 'azbalac-ie', 'conditional', 'lt IE 9' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    /*if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'azbalac-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
    }*/

    /*if ( is_active_sidebar( 'sidebar-3' ) ) {
        wp_enqueue_script( 'jquery-masonry' );
    }*/

    /*if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
        wp_enqueue_script( 'azbalac-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
        wp_localize_script( 'azbalac-slider', 'featuredSliderDefaults', array(
            'prevText' => __( 'Previous', 'azbalac' ),
            'nextText' => __( 'Next', 'azbalac' )
        ) );
    }*/

    //wp_enqueue_script( 'azbalac-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), AZBALAC_DATEVERSION , true );

    // check version of jQuery used in WordPress
    $jQueryVersion = '3.5.1';
    $jQueryHandle = (version_compare($GLOBALS['wp_version'], '3.6-alpha1', '>=') ) ? 'jquery-core' : 'jquery';

    // Get the WP built-in version
    $jQueryVersionWordPress = $GLOBALS['wp_scripts']->registered[$jQueryHandle]->ver;

    // load jQuery only if version does not match
    if (version_compare($jQueryVersionWordPress, $jQueryVersion, '!=')) {
        wp_enqueue_script( 'azbalac-jquery', get_template_directory_uri() . '/js/jquery-3.5.1.min.js', array(), $jQueryVersion, false );

    }

    
    wp_enqueue_script( 'azbalac-script', get_template_directory_uri() . '/js/functions.js',
        array(  ), AZBALAC_DATEVERSION , true );

        //wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array(), '1.12.9', true );
        
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '4.5.3', true );
        

    /*if (is_customize_preview()) {
        wp_enqueue_script( 'azbalac-admin-header', get_template_directory_uri().'/js/admin-options.js', array( 'jquery'), '', true );
            
        //wp_add_inline_script('azbalac-social-media-buttons',$js);
        wp_localize_script( 'azbalac-admin-header', 'objectAdminHeader', array(
            'azbalac_setting_header_color_bg' => get_theme_mod('azbalac_setting_header_color_bg'),
            'azbalac_setting_header_background_transp' => get_option('azbalac_setting_header_background_transp',70) 

        ) );
    }*/
}

add_action( 'wp_enqueue_scripts', array('Azbalac_Theme', 'setStyles' ));

add_action( 'wp_enqueue_scripts', 'azbalac_scripts' );
add_action( 'wp_enqueue_scripts', array('Azbalac_Theme', 'enqueueBootstrapIcons' ) );

add_action( 'wp_enqueue_scripts',  array('Azbalac_Section_Social_Media_Buttons','addSocialButtonStyle' ) );
add_action( 'wp_enqueue_scripts', array('Azbalac_Section_Slider','addSliderStyle') );

add_filter('style_loader_tag', array('Azbalac_Theme','styleLoaderTagFilter'),10,2);


/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 * in head of document, based on current view.
 * in head of document, based on current view.
 *
 * @since Azbalac 0.1.4
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function azbalac_wp_title( $title, $sep ) {
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
                $title = "$title $sep " . sprintf( __( 'Page %s', 'azbalac' ), max( $paged, $page ) );
        }

        return $title;
}
add_filter( 'wp_title', 'azbalac_wp_title', 10, 2 );



function add_class_the_tags($html){
    $html = str_replace('<a','<a class="badge bg-info"',$html);
    return $html;
}
add_filter('the_tags','add_class_the_tags',10,1);

function register_azbalac_menus() {
    register_nav_menus(array('header-menu' => __( 'Header Menu', 'azbalac' ),));
}
add_action( 'init', 'register_azbalac_menus' );


/**
 * A helper conditional function that returns a boolean value.
 *
 * @since azbalac 0.1
 *
 * @return bool Whether there are featured posts.
 */
function azbalac_has_featured_posts() {
    return !is_paged() && (bool) azbalac_get_featured_posts();
}

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Azbalac 0.1
 *
 * @return array An array of WP_Post objects.
 */
function azbalac_get_featured_posts() {
    /**
     * Filter the featured posts to return in azbalac.
     *
     * @since Azbalac 0.1
     *
     * @param array|bool $posts Array of featured posts, otherwise false.
     */
    return apply_filters( 'azbalac_get_featured_posts', array() );
}



add_theme_support( 'featured-content', array(
    'featured_content_filter' => 'azbalac_get_featured_posts',
    'max_posts' => 4,
) );

if ( ! function_exists( 'azbalac_get_layout' ) ) :

    function azbalac_get_layout() {
    
        $layoutData = get_option('azbalac_setting_layout');
    
        if (!isset($layoutData) || !$layoutData) {
            $layoutData = 2; // default: content left, sidebar right
        }
        switch ($layoutData) {
            case 1:
                $columns = 1;
                $content = 1; // main content in single column
                $styleCol_1 = 'col-xl-12 col-lg-12 col-md-12 col-sm-12';
                $styleCol_2 = 'col-xl-12 col-lg-12 col-md-12 col-sm-12';
                break;
            case 3:
                $columns = 2;
                $content = 2; // main content right
                $styleCol_1 = 'col-xl-9 col-lg-9 col-md-9 col-sm-8';
                $styleCol_2 = 'col-xl-3 col-lg-3 col-md-3 col-sm-4';
                break;
            case 2:
            default:
                $columns = 2;
                $content = 1; // main content left
                $styleCol_1 = 'col-xl-9 col-lg-9 col-md-9 col-sm-8';
                $styleCol_2 = 'col-xl-3 col-lg-3 col-md-3 col-sm-4';
                break;
        }
        return array('columns' => $columns,
            'col_1' => $styleCol_1,
            'col_2' => $styleCol_2,
            'content' => $content);
    }
endif;

if ( ! function_exists( 'azbalac_get_navbar_layout' ) ) :
    
    function azbalac_get_navbar_layout() {
    
         $navbarData = get_option('azbalac_setting_navbar_fixed');
        
         if ($navbarData == 'fixed-top') {
            $navbarFixed = 'fixed-top';
         }
         else {
            $navbarFixed = 'default';
         }
         return $navbarFixed;
    }
endif;

if ( ! function_exists( 'azbalac_get_header_styles' ) ) :

    function azbalac_get_header_styles($navbarFixed) {
         
        $navbarData = get_option('azbalac_setting_navbar_style', 'light');
    
        $navbarStyleClass = '';

        if ($navbarData == 'dark') {
            $navbarStyleClass .= ' navbar-dark';
        }
        else { // light
            $navbarStyleClass .= ' navbar-light';
        }

        $navbarBgData = get_option('azbalac_setting_navbar_bg','default');
        $navbarBgCustomData = get_theme_mod('azbalac_setting_navbar_bg_custom','');
        if (!$navbarBgCustomData) { // don't add bg-* setting to navbar class definition if custom background is set
            if ($navbarBgData == 'default') {
                $navbarBgSetting = 'bg-' . $navbarData;
            } else {
                $navbarBgSetting = $navbarBgData;
            }
            $navbarStyleClass .= ' ' . $navbarBgSetting;
        }

        if ($navbarFixed == 'fixed-top') {
            $navbarStyleClass .= ' navbar-fixed-top';
        }
        else {
            $navbarStyleClass .= ' '; // todo: set css style when not fixed... or if fixed. hm
        }
        
        $colorBgHeaderData = get_theme_mod('azbalac_setting_color_bg_header');
        if ($colorBgHeaderData) {
            $headerStyleColorBg = $colorBgHeaderData;
        }
        else {
            $headerStyleColorBg = '';
        }

        // this is currently not used, maybe in another version. The only foreground color is modifiey by CSS definition, because it's displayed as an URL.
       

        $navbarAlignment = get_option('azbalac_setting_navbar_menu_alignment','1'); // left is default
        switch (intval($navbarAlignment)) {
            case 3: // right
                $navbarAlignmentClass = ' justify-content-end';
            break;
            case 2: // centered
                $navbarAlignmentClass = ' justify-content-center';
            break;
            case 1: 
            default: // left
                $navbarAlignmentClass = '';
            break;
        }
    
        $colorFgTitle = get_theme_mod('azbalac_setting_color_fg_title','');
        $colorFgSubtitle = get_theme_mod('azbalac_setting_color_fg_subtitle','');
       

        return array('navbarStyleClass' => $navbarStyleClass,
            'navbarBgCustom' => $navbarBgCustomData,
            'headerStyleColorBg' => $headerStyleColorBg,
            'navbarAlignment' => $navbarAlignmentClass,
            'colorFgTitle' => $colorFgTitle,
            'colorFgSubtitle' => $colorFgSubtitle // maybe todo: replace style in elements with global inline style
        );
    }
endif;


/*if ( ! function_exists( 'azbalac_get_header_image_data' ) ) :

    function azbalac_get_header_image_data() {
        
       $imageData = Azbalac_Theme::getHeaderImageData();
       
       return '<script type="text/javascript">var azbalacHeaderImage = ' . json_encode($imageData) . '</script>';
    }
endif;
*/


if ( ! function_exists( 'azbalac_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own azbalac_header_style() function to override in a child theme.
 *
 * @since Azbalac 0.2
 *
 * @see twentysixteen_custom_header_and_background().
 */
function azbalac_header_style() {
    // If the header text option is untouched, let's bail.
    
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="azbalac-header-css">

		#site-header-text, #site-description {
                    display: none;
		}
	</style>
	<?php
}
endif; // azbalac_header_style



/*
if ( ! function_exists('azbalac_admin_notice')) :

function azbalac_admin_notice() {
  ?>
  <div class="updated notice azbalac-admin-notice is-dismissible">
      <p><?php _e( 'Demo of admin notice...', 'azbalac' ); ?></p>
  </div>
  <?php
}
endif; // azbalac_admin_notice
*/


function azbalac_excerpt_more( $more ) {
    return '&hellip;<br/> <p> <a rel="bookmark" class="read-more btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . sprintf(__( 'Read More <span class="screen-reader-text">on %1$s </span>&raquo;', 'azbalac' ), get_the_title())  . '</a></p>';
}
add_filter( 'excerpt_more', 'azbalac_excerpt_more' );

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
    require get_template_directory() . '/inc/featured-content.php';
}

if (is_admin()) {
    $azbalacGoogleFonts = require_once( get_template_directory() . '/inc/customizer/webfonts.php' ); 
    
    $azbalacFontRequest = new Azbalac_Custom_Font_Request();

    $azbalacThemeRequest = new Azbalac_Custom_Theme_Request(); // register requests
}

