<?php




// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

require_once( get_template_directory() . '/inc/header-addons.php' );
require_once( get_template_directory() . '/inc/post-addons.php' );
include get_template_directory() . '/inc/info-screen/welcome-screen.php';

require_once( get_template_directory() . '/inc/customizer/CustomRadioImageControl.php' );
require_once( get_template_directory() . '/inc/customizer/CustomSliderControl.php' );

require_once( get_template_directory() . '/inc/customizer/class-tikva-sanitizer.php' );
require_once( get_template_directory() . '/inc/customizer/class-tikva-customizer.php' );

require_once( get_template_directory() . '/inc/class-tikva-footer.php' );


new Tikva_Customizer();

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
    
        load_theme_textdomain( 'tikva', get_template_directory() . '/languages' );

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
 * Add color styling from theme
 */
// wp_enqueue_style( 'tikva-default-style', get_template_directory_uri() . '/css/default.css' );
 
if ( ! function_exists( 'tikva_add_social_button_style' ) ) :
function tikva_add_social_button_style() {
    /*wp_enqueue_style(
        'tikva-default-style',
        get_template_directory_uri() . '/css/default.css'
    );
      */
    $css = '';
    $social_button_color_bg_hover = get_theme_mod('setting_social_button_color_bg_hover');
    $social_button_color_bg = get_theme_mod('setting_social_button_color_bg');
    $social_button_color_fg = get_theme_mod('setting_social_button_color_fg');
    if ($social_button_color_bg_hover) {
        $css .= ".socialhover {
    color: $social_button_color_bg_hover !important;
        } 
                 ";
    }
    if ($social_button_color_bg) {
        $css .= "
    .innersocialbg {
        color: $social_button_color_bg ;
            }
                 ";
    }
    if ($social_button_color_fg) {
        $css .= "
    .innersocial {
        color: $social_button_color_fg;  
    }
    
                ";
    }
    
   
    wp_add_inline_style( 'tikva-default-style', $css );
}
endif;

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

        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );

}

endif;


if ( ! function_exists( 'tikva_get_body_styles' ) ) :

    function tikva_get_body_styles() {
    
        $colorBgSidebar = get_theme_mod('color_bg_sidebar');
        if (!$colorBgSidebar) {
            $sidebarStyleColorBg = '';
        }
        else {
            $sidebarStyleColorBg = ' background-color: ' . $colorBgSidebar .';';
        }
       
        $colorFgSidebar = get_theme_mod('color_fg_sidebar');
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
        'name' => __("Sidebar 1", 'tikva'),
        'id' => 'sidebar-1',
        'class' => '',
        'before_widget' => '<div id="%1$s" style="' . $bodyStyles['sidebarStyleColorBg'] . $bodyStyles['sidebarStyleColorFg'] . '" class="well widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => "</h3>\n"
    ));

    for ($i = 1; $i <= 6; $i++) {
        register_sidebar(array(
            'name' => sprintf(__("Footer Widget Area #%d", 'tikva'), $i),
            'id' => sprintf("footer-sidebar-%d", $i),
            'description' => 'Appears in the footer area',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
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

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.7', true );

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
    $stylesheetData = get_option('tikva_stylesheet');
   
    if ($stylesheetData)
    {
        $stylesheet = $stylesheetData;
    }
    else {
        $stylesheet = 'slate_accessibility_ready.min.css';
    }

    // Register the style like this for a theme:
    wp_register_style( 'bootstrap-styles', get_template_directory_uri() .'/css/design/' . $stylesheet, array(),
        '20160418','all');
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
add_action( 'wp_enqueue_scripts', 'tikva_add_social_button_style' );
add_action( 'wp_enqueue_scripts', 'tikva_set_slider_text_style' );


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
    
        $layoutData = get_option('tikva_layout');
    
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
    
         $navbarData = get_option('navbar_fixed');
        
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
         
        $navbarData = get_option('navbar_style_inverse');
    
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
        
        $colorBgHeaderData = get_theme_mod('color_bg_header');
        if ($colorBgHeaderData) {
            $headerStyleColorBg = $colorBgHeaderData;
        }
        else {
            $headerStyleColorBg = '';
        }
        // this is currently not used, maybe in another version. The only foreground color is modifiey by CSS definition, because it's displayed as an URL.
        
        $colorFgHeaderData = get_theme_mod('color_fg_header');
        
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


if ( ! function_exists( 'tikva_get_header_image_data' ) ) :

    function tikva_get_header_image_data() {
        
        $imageData = array();

        if (get_header_image()) {
            $largeImage = get_custom_header();
            //var_dump($largeImage);
            $imageData[0] = array('url' => $largeImage->url,
                'height' => $largeImage->height,
                'width' => $largeImage->width,
                'thumbnail' => $largeImage->thumbnail_url,
                'id' => $largeImage->attachment_id); 
        }
        elseif (get_option('header_image_example_tikva')) {
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
            
            if (get_option('header_image_large_dontscale')) {
                $imageData[0]['dontscale'] = get_option('header_image_large_dontscale');
            } else {
                $imageData[0]['dontscale'] = 0;
            }
        }
        
        
        $headerImageMediumData = wp_get_attachment_image_src(absint(get_option('header_image_medium')), 'original');
        $headerImageSmallData = wp_get_attachment_image_src(absint(get_option('header_image_small')), 'original');
        $headerImageXSmallData = wp_get_attachment_image_src(absint(get_option('header_image_xsmall')), 'original');
        
        if (isset($headerImageMediumData) && $headerImageMediumData) {
            
            $imageData[1]['url'] = $headerImageMediumData[0];
            $imageData[1]['width'] = $headerImageMediumData[1];
            $imageData[1]['height'] = $headerImageMediumData[2];
            $imageData[1]['thumbnail'] = '';
            $imageData[1]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('header_image_medium_dontscale'))
            {
                $imageData[1]['dontscale'] = 1;
            } else {
                $imageData[1]['dontscale'] = 0;
            }
        } else {
            $imageData[1] = '';
        }

        if (isset($headerImageSmallData) && $headerImageSmallData) {
            
            $imageData[2]['url'] = $headerImageSmallData[0];
            $imageData[2]['width'] = $headerImageSmallData[1];
            $imageData[2]['height'] = $headerImageSmallData[2];
            $imageData[2]['thumbnail'] = '';
            $imageData[2]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('header_image_small_dontscale'))
            {
                $imageData[2]['dontscale'] = 1;
            } else {
                $imageData[2]['dontscale'] = 0;
            }
        } else {
            $imageData[2] = '';
        }

         if (isset($headerImageXSmallData) && $headerImageXSmallData) {
            
            $imageData[3]['url'] = $headerImageXSmallData[0];
            $imageData[3]['width'] = $headerImageXSmallData[1];
            $imageData[3]['height'] = $headerImageXSmallData[2];
            $imageData[3]['thumbnail'] = '';
            $imageData[3]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('header_image_xsmall_dontscale'))
            {
                $imageData[3]['dontscale'] = 1;
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


function tikva_build_social_button($socialOption, $socialIcon, $buttonSize, $buttonType)
{
    $url = get_theme_mod($socialOption);
    if (!$url) {
        return '';
    }
    $faType = ($buttonType == 2) ? 'fa-square' : 'fa-circle';
    switch ($buttonSize) {
        case 1:
            $faSize = ' ';
            break;
        case 2: 
            $faSize = ' fa-lg ';
            break;
        case 3: 
            $faSize = ' fa-2x ';
            break;
     
        
    }
    $styleFg = '';
    $styleBg = '';
    
    $output = sprintf('<a target="_blank" href="%s"><span class="fa-stack %s"><i %s class="fa %s fa-stack-2x innersocialbg"></i><i %s class="fa fa-%s fa-stack-1x  innersocial"></i></span></a>', esc_url($url), $faSize, $styleBg, $faType, $styleFg, $socialIcon);
    return $output;
   
}


if ( ! function_exists( 'tikva_display_social_media_buttons' ) ) :
/**
 * Get position of Social Media Buttons
 *
 * @since Tikva 0.3
 *
 * @see twentysixteen_custom_header_and_background().
 */
function tikva_display_social_media_buttons($currentPosition) {
    $position = absint(get_option('setting_social_media_position'));
    if ($position != $currentPosition) {
        return null;
    }
    if (!get_option('setting_social_media_activate')) {
        return null;
    }
        
    $socialButtons = array('social_media_facebook' => 'facebook', 
        'social_media_github' => 'github',
        'social_media_google' => 'google-plus',
        'social_media_instagram' => 'instagram',
        'social_media_linkedin' => 'linkedin',
        'social_media_slideshare' => 'slideshare',
        'social_media_snapchat' => 'snapchat',
        'social_media_twitter' => 'twitter',
        'social_media_vine' => 'vine',
        'social_media_xing' => 'xing',
        'social_media_youtube' => 'youtube');
    switch (get_option('setting_social_media_alignment')) {
        case 1: $align = 'left';
            break;
        case 3: $align = 'right';
            break;
        default: $align = 'center';
    }
    $buttonSize = get_option('setting_social_button_size');
    $buttonType = get_option('setting_social_button_type');
    ?>
        
<div class="row">
<div class="container">
    <div class="col-md-12 social-media-buttons"> 
        <div style="text-align: <?php echo $align; ?>;">
            
            
            <?php
            $socialOutput = '';
            foreach ($socialButtons as $socialOption => $socialIcon) {
                $socialOutput .= tikva_build_social_button($socialOption, $socialIcon, $buttonSize, $buttonType);
            }
            echo $socialOutput;
            ?>
        </div>
    </div>
</div>
</div>
        <?php
    
}
endif; // tikva_display_social_media_buttons

if ( ! function_exists('tikva_set_slider_text_style')) :

    function tikva_set_slider_text_style()
    {
        wp_enqueue_style(
                'tikva-default-style', get_template_directory_uri() . '/css/default.css'
        );
        $custom_css = "
             .carousel-caption-left {
             text-align: left !important;
         }
         .carousel-caption-right {
             text-align: right !important;
         }
         .tikva-slider {
             margin-bottom: 10px;
         }
";
        
        wp_add_inline_style('tikva-default-style', $custom_css);
    }

endif; // tikva_set_slider_text_style

/*
if ( ! function_exists('tikva_admin_notice')) :

function tikva_admin_notice() {
  ?>
  <div class="updated notice tikva-admin-notice is-dismissible">
      <p><?php _e( 'Demo of admin notice...', 'tikva' ); ?></p>
  </div>
  <?php
}
endif; // tikva_admin_notice
*/

if ( ! function_exists( 'tikva_show_slider' ) ) :
function tikva_show_slider($sliderPosition) 
{
   if (!get_option('setting_slider_activate')) {
        return '';
    }
   
    if (get_option('setting_slider_position') != $sliderPosition) {
        return '';
    }
    // this is too late, so set above...
    //add_action( 'wp_enqueue_scripts', 'tikva_set_slider_text_style' );

    $sliderInterval = get_theme_mod('setting_slider_interval');
    $sliderPause = get_option('setting_slider_pause') ? 'hover': '';
    $sliderKeyboard = get_option('setting_slider_keyboard') ? 'true': 'false';
    $sliderWrap = get_option('setting_slider_wrap') ? 'true': 'false';
    
   for ($i = 1; $i <= 6; $i++) {
                $sliderImage = wp_get_attachment_image_src(absint(get_option('setting_slider_' . $i . '_image')), 'original');
                if ($sliderImage) {
                    $sliderData[$i]['image'] = $sliderImage;
                    $sliderData[$i]['title'] = get_theme_mod('setting_slider_' . $i . '_title');
                    $sliderData[$i]['description'] = get_theme_mod('setting_slider_' . $i . '_description');
                    $sliderData[$i]['text_position'] = get_option('setting_slider_' . $i . '_text_position');
                    $sliderData[$i]['page'] = get_option('setting_slider_' . $i . '_page');
                    $sliderData[$i]['url'] = get_option('setting_slider_' . $i . '_url');
                    $colorFgText = get_theme_mod('setting_slider_' . $i . '_text_color');
                    if ($colorFgText) {
                        $sliderData[$i]['style'] = ' color: ' . $colorFgText .';';
                    }
                    else {
                        $sliderData[$i]['style'] = '';
                    }
                }
            }
           
            ?>
            
            <div id="tikva-slider" class="tikva-slider carousel slide" data-ride="carousel" data-interval="<?php echo $sliderInterval; ?>" data-pause="<?php echo $sliderPause; ?>" data-wrap="<?php echo $sliderWrap; ?>" data-keyboard="<?php echo $sliderKeyboard; ?>">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <?php
           foreach ($sliderData as $idx => $sliderElement) {
            echo '<li data-target="#tikva-slider" data-slide-to="';
            echo $idx - 1;
            echo '"';
            if ($idx == 1) echo 'class="active"';
            echo '></li>';
      }
      ?>
  </ol>

  <!-- Wrapper for slides -->
     

  <div class="carousel-inner" role="listbox">
            
    <?php
    
      foreach ($sliderData as $idx => $sliderElement) {
         
          echo ' <div class="item ';
          if ($idx == 1) echo 'active';
          echo '">';
          if ($sliderElement['url']) {
              $sliderUrl = $sliderElement['url'];
          } elseif ($sliderElement['page']) {
              $sliderUrl = get_page_link($sliderElement['page']);
              
          }
          else {
              $sliderUrl = null;
          }
          if ($sliderUrl) {
            echo '<a href="' . $sliderUrl . '">';
          }
          echo '<img src="' . $sliderElement['image'][0] .'" alt="...">';
          if ($sliderUrl) {
            echo '</a>';
          }
          echo ' <div class="carousel-caption';
          switch ($sliderElement['text_position']) {
              case 1: echo " carousel-caption-left";
                  break;
              case 3: echo ' carousel-caption-right';
                  break;
              // no default, centered is default
          }          
          echo '">';
          if ($sliderElement['title']) {
              echo '<h3 style="' . $sliderElement['style'] . '">';
              if ($sliderUrl) {
            echo '<a style="' . $sliderElement['style'] . '" href="' . $sliderUrl . '">';
          }
            echo '<span style="' . $sliderElement['style'] . '">' . $sliderElement['title'] . '</span>';
                      if ($sliderUrl) {
            echo '</a>';
          }
            echo '</h3>';
                      
          }
          if ($sliderElement['description']) {
              echo '<p>';
                if ($sliderUrl) {
            echo '<a style="' . $sliderElement['style'] . '" href="' . $sliderUrl . '">';
          }
            echo '<span style="' . $sliderElement['style'] . '">' . $sliderElement['description'] . '</span>';
           
                   if ($sliderUrl) {
            echo '</a>';
          }
              echo '</p>';
                      
          }
          echo '</div>    ';
          echo '</div>';
      }
      ?>
        
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#tikva-slider" role="button" data-slide="prev">
    <span class="icon-prev fa fa-chevron-left" aria-hidden="true"></span>
    <span class="sr-only"><?php  __( 'Previous','tikva' ); ?></span>
  </a>
  <a class="right carousel-control" href="#tikva-slider" role="button" data-slide="next">
    <span class="icon-next fa fa-chevron-right" aria-hidden="true"></span>
    <span class="sr-only"><?php  __( 'Next','tikva' ); ?></span>
  </a>
</div>
     <?php
}

endif; // tikva_show_slider


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
