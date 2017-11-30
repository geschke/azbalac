<?php
/**
 * The template for displaying Search Results pages
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


$title_search_results = '';
if ( have_posts() ) {
    $tikva_have_posts = true;
 
    $title_search_results = sprintf( __( 'Search Results for: %s', 'tikva' ), get_search_query() ); 
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


echo $t7tpl->render('search.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'tikva_has_featured_posts' => tikva_has_featured_posts(),
'show_slider_2' => $showSlider_2,
'template_part_featured_content' => $template_part_featured_content,
'intro_elements_3' => $introElements_3,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $tikva_have_posts,
'posts' => $tikva_posts,
'no_posts' => $tikva_no_posts,
'paging_nav' => $tikva_paging_nav,
'title_search_results' => $title_search_results,
'footer' => $tikva_footer
));            


