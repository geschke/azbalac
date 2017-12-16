<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 */


$tikvaContainer = Tikva_DataContainer::getInstance();

ob_start();
get_header(); 
$header = ob_get_contents();
ob_end_clean();


$layoutStyle = tikva_get_layout();

ob_start();
get_sidebar('content');
get_sidebar();
$sidebar = ob_get_contents();
ob_end_clean();


$tikvaContainer = Tikva_DataContainer::getInstance();

if ( have_posts() ) {
	$tikva_have_posts = true;
	
	$archive_title = sprintf( __( 'Category Archives: %s', 'tikva' ), single_cat_title( '', false ) );

	$term_description = term_description();

	while ( have_posts() ) {
		
		ob_start();
		the_post(); 
	
		get_template_part( 'content',  get_post_format() );

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
} else {
	$tikva_have_posts = false;
	
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );

    $tikva_no_posts =  $tikvaContainer->contentNone;
	
}
	

get_footer();
$tikva_footer = $tikvaContainer->footerData;



echo $t7tpl->render('category.html.twig', array('header' => $header,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $tikva_have_posts,
'posts' => $tikva_posts,
'no_posts' => $tikva_no_posts,
'paging_nav' => $tikva_paging_nav,
'footer' => $tikva_footer,
'archive_title' => $archive_title,
'term_description' => $term_description
));            

