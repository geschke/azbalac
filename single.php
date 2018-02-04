<?php
/**
 * The Template for displaying all single posts
 *
 * @package Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
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




$azbalacContainer = Azbalac_DataContainer::getInstance();

if ( have_posts() ) {
    $azbalac_have_posts = true;
    $azbalac_no_posts = null;
 
    
    // Start the Loop.
    while ( have_posts() ) {
       
       
        the_post(); 
    
        get_template_part( 'content', get_post_format() );


        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

        
        $azbalac_posts_content = ''; // not needed anymore!
     
      
        $azbalac_posts_data = $azbalacContainer->content;
        $azbalac_posts_comment = $azbalacContainer->commentData;
       
        $azbalac_posts[] = ['content' => $azbalac_posts_content, 
            'commentData' => $azbalac_posts_comment, 
            'data' => $azbalac_posts_data];
        
    }
    // Previous/next post navigation.
    //ob_start();
    //azbalac_paging_nav();
    //$azbalac_paging_nav = ob_get_contents();
    //ob_end_clean();
}
else {
    $azbalac_have_posts = false;

    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );

    $azbalac_no_posts =  $azbalacContainer->contentNone;

}


get_footer();
$azbalac_footer = $azbalacContainer->footerData;


echo $t7tpl->render('single.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'azbalac_has_featured_posts' => azbalac_has_featured_posts(),
'featured' => $featuredPosts,
'show_slider' => $showSlider,
//'show_slider_3' => $showSlider_3,
'intro_elements_3' => $introElements_3,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $azbalac_have_posts,
'posts' => $azbalac_posts,
'no_posts' => $azbalac_no_posts,
//'paging_nav' => $azbalac_paging_nav,
'footer' => $azbalac_footer
));            

