<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 */



$twigLoader = new Twig_Loader_Filesystem(get_template_directory() . '/templates/src/');
$twig = new Twig_Environment($twigLoader, array(
    'cache' => get_template_directory() . '/templates/cache/',
    'debug' => true // todo: set to false when upload to WordPress theme repository
));

ob_start();
get_header(); 
$header = ob_get_contents();
ob_end_clean();

$showSlider_2 = '';
if ( is_front_page() ) {
    $showSlider_2 = Tikva_Section_Slider::getSlider(2);
    $showSlider_3 = Tikva_Section_Slider::getSlider(3);
    $introElements_3 = Tikva_Section_Content_Column::getIntroductionElements(3);
} 

ob_start();
get_template_part( 'featured-content' );
$template_part_featured_content = ob_get_contents();
ob_end_clean();

$layoutStyle = tikva_get_layout();

ob_start();
get_sidebar('content');
get_sidebar();
$sidebar = ob_get_contents();
ob_end_clean();





if ( have_posts() ) {
    $tikva_have_posts = true;
 
    
    // Start the Loop.
    while ( have_posts() ) {
       
        ob_start();
        the_post(); 
    
        get_template_part( 'content', 'page' );
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }


        $tikva_posts[] = ob_get_contents();
        ob_end_clean();
    }
    // Previous/next post navigation.
    ob_start();
    //tikva_paging_nav();
    //$tikva_paging_nav = ob_get_contents();
    ob_end_clean();
}
else {
    $tikva_have_posts = false;

    ob_start();

    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );
    $tikva_no_posts = ob_get_contents();
    ob_end_clean();

}


ob_start();
get_footer();
$tikva_footer = ob_get_contents();
ob_end_clean();


echo $twig->render('index.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'tikva_has_featured_posts' => tikva_has_featured_posts(),
'show_slider_2' => $showSlider_2,
'show_slider_3' => $showSlider_3,
'template_part_featured_content' => $template_part_featured_content,
'intro_elements_3' => $introElements_3,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $tikva_have_posts,
'posts' => $tikva_posts,
'no_posts' => $tikva_no_posts,
//'paging_nav' => $tikva_paging_nav,
'footer' => $tikva_footer
));            




