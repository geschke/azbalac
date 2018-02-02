<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 */


$azbalacContainer = Azbalac_DataContainer::getInstance();

get_header(); 
$header = $azbalacContainer->headerData;



$layoutStyle = azbalac_get_layout();

get_sidebar();
$sidebar = $azbalacContainer->contentSidebar;



$azbalacContainer = Azbalac_DataContainer::getInstance();

if ( have_posts() ) {
	$azbalac_have_posts = true;
	$azbalac_no_posts = null;
	
	$archive_title = sprintf( __( 'Category Archives: %s', 'azbalac' ), single_cat_title( '', false ) );

	$term_description = term_description();

	while ( have_posts() ) {
		
		ob_start();
		the_post(); 
	
		get_template_part( 'content',  get_post_format() );

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
} else {
	$azbalac_have_posts = false;
	
	// If no content, include the "No posts found" template.
	get_template_part( 'content', 'none' );

    $azbalac_no_posts =  $azbalacContainer->contentNone;
	
}
	

get_footer();
$azbalac_footer = $azbalacContainer->footerData;



echo $t7tpl->render('category.html.twig', array('header' => $header,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $azbalac_have_posts,
'posts' => $azbalac_posts,
'no_posts' => $azbalac_no_posts,
'paging_nav' => $azbalac_paging_nav,
'footer' => $azbalac_footer,
'archive_title' => $archive_title,
'term_description' => $term_description
));            

