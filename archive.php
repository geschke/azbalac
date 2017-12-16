<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Tikva
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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


$page_title = '';
if ( have_posts() ) {

	if ( is_day() ) {
		$page_title = sprintf( __( 'Daily Archives: %s', 'tikva' ), get_the_date() );
	} elseif ( is_month() ) {
		$page_title = sprintf( __( 'Monthly Archives: %s', 'tikva' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'tikva' ) ) );
	} elseif ( is_year() ) {
		$page_title = sprintf( __( 'Yearly Archives: %s', 'tikva' ), get_the_date( _x( 'Y', 'yearly archives date format', 'tikva' ) ) );
	} else {
		$page_title = __( 'Archives', 'tikva' );
	}


	$tikva_have_posts = true;
	

	// Start the Loop.
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



echo $t7tpl->render('archive.html.twig', array('header' => $header,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $tikva_have_posts,
'posts' => $tikva_posts,
'no_posts' => $tikva_no_posts,
'paging_nav' => $tikva_paging_nav,
'footer' => $tikva_footer,
'page_title' => $page_title
));            
