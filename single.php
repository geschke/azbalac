<?php
/**
 * The Template for displaying all single posts
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 */



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

$featured = new Tikva_Featured();
$featuredPosts = $featured->getFeaturedPosts();

$layoutStyle = tikva_get_layout();

ob_start();
get_sidebar('content');
get_sidebar();
$sidebar = ob_get_contents();
ob_end_clean();




$tikvaContainer = Tikva_DataContainer::getInstance();

if ( have_posts() ) {
    $tikva_have_posts = true;
 
    
    // Start the Loop.
    while ( have_posts() ) {
       
       
        the_post(); 
    
        get_template_part( 'content', get_post_format() );


        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

        
        $tikva_posts_content = ''; // not needed anymore!
     
      
        $tikva_posts_data = $tikvaContainer->content;
        $tikva_posts_comment = $tikvaContainer->commentData;
       
        $tikva_posts[] = ['content' => $tikva_posts_content, 
            'commentData' => $tikva_posts_comment, 
            'data' => $tikva_posts_data];
        
    }
    // Previous/next post navigation.
    //ob_start();
    //tikva_paging_nav();
    //$tikva_paging_nav = ob_get_contents();
    //ob_end_clean();
}
else {
    $tikva_have_posts = false;

    // If no content, include the "No posts found" template.
    get_template_part( 'content', 'none' );

    $tikva_no_posts =  $tikvaContainer->contentNone;

}


get_footer();
$tikva_footer = $tikvaContainer->footerData;


echo $t7tpl->render('single.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'tikva_has_featured_posts' => tikva_has_featured_posts(),
'featured' => $featuredPosts,
'show_slider_2' => $showSlider_2,
//'show_slider_3' => $showSlider_3,
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

