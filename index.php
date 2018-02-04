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
 * @package Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */


$azbalacContainer = Azbalac_DataContainer::getInstance();

get_header(); 
$header = $azbalacContainer->headerData;


$showSlider = [];
$introElements_3 = '';
if ( is_front_page() ) {
    $showSlider['2'] = Azbalac_Section_Slider::getSlider(2);
    $showSlider['3'] = Azbalac_Section_Slider::getSlider(3);
    $introElements_3 = Azbalac_Section_Content_Column::getIntroductionElements(3);
} 


$featured = new Azbalac_Featured();
$featuredPosts = $featured->getFeaturedPosts();

$layoutStyle = azbalac_get_layout();



get_sidebar();
$sidebar = $azbalacContainer->contentSidebar;

if ( have_posts() ) {
    $azbalac_have_posts = true;
    $azbalac_no_posts = null;
 
    
    // Start the Loop.
    while ( have_posts() ) {
       
        ob_start();
        the_post(); 
    
        get_template_part( 'content', get_post_format() );

        $azbalac_posts_content  = ob_get_contents();
        $azbalac_posts_data = $azbalacContainer->content;
        $azbalac_posts[] = ['content' => $azbalac_posts_content, 'data' => $azbalac_posts_data];
        ob_end_clean();

    }
    // Previous/next post navigation.
    ob_start();
    azbalac_paging_nav();
    $azbalac_paging_nav = ob_get_contents();
    ob_end_clean();
}
else {
    $azbalac_have_posts = false;

    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );

    $azbalac_no_posts =  $azbalacContainer->contentNone;

}


get_footer();
$azbalac_footer = $azbalacContainer->footerData;


echo $t7tpl->render('index.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'azbalac_has_featured_posts' => azbalac_has_featured_posts(),
'featured' => $featuredPosts,
'show_slider' => $showSlider,
'intro_elements_3' => $introElements_3,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $azbalac_have_posts,
'posts' => $azbalac_posts,
'no_posts' => $azbalac_no_posts,
'paging_nav' => $azbalac_paging_nav,
'footer' => $azbalac_footer
));            

