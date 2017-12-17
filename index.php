<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */


$tikvaContainer = Tikva_DataContainer::getInstance();

get_header(); 
$header = $tikvaContainer->headerData;


$showSlider_2 = '';
$showSlider_3 = '';
$introElements_3 = '';
if ( is_front_page() ) {
    $showSlider_2 = Tikva_Section_Slider::getSlider(2);
    $showSlider_3 = Tikva_Section_Slider::getSlider(3);
    $introElements_3 = Tikva_Section_Content_Column::getIntroductionElements(3);
} 

$featured = new Tikva_Featured();
$featuredPosts = $featured->getFeaturedPosts();

$layoutStyle = tikva_get_layout();


get_sidebar();
$sidebar = $tikvaContainer->contentSidebar;


if ( have_posts() ) {
    $tikva_have_posts = true;
 
    
    // Start the Loop.
    while ( have_posts() ) {
       
        ob_start();
        the_post(); 
    
        get_template_part( 'content', get_post_format() );

        $tikva_posts_content  = ob_get_contents();
        $tikva_posts_data = $tikvaContainer->content;
        $tikva_posts[] = ['content' => $tikva_posts_content, 'data' => $tikva_posts_data];
        ob_end_clean();

    }
    // Previous/next post navigation.
    ob_start();
    tikva_paging_nav();
    $tikva_paging_nav = ob_get_contents();
    ob_end_clean();
}
else {
    $tikva_have_posts = false;

    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );

    $tikva_no_posts =  $tikvaContainer->contentNone;

}


get_footer();
$tikva_footer = $tikvaContainer->footerData;


echo $t7tpl->render('index.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'tikva_has_featured_posts' => tikva_has_featured_posts(),
'featured' => $featuredPosts,
'show_slider_2' => $showSlider_2,
'show_slider_3' => $showSlider_3,
'template_part_featured_content' => $template_part_featured_content,
'intro_elements_3' => $introElements_3,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $tikva_have_posts,
'posts' => $tikva_posts,
'no_posts' => $tikva_no_posts,
'paging_nav' => $tikva_paging_nav,
'footer' => $tikva_footer
));            

