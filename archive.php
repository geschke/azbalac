<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Azbalac
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
$azbalac_posts = null;
$azbalac_paging_nav = null;


$page_title = '';
if ( have_posts() ) {
	$azbalac_no_posts = null;

	if ( is_day() ) {
		$page_title = sprintf( __( 'Daily Archives: %s', 'azbalac' ), get_the_date() );
	} elseif ( is_month() ) {
		$page_title = sprintf( __( 'Monthly Archives: %s', 'azbalac' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'azbalac' ) ) );
	} elseif ( is_year() ) {
		$page_title = sprintf( __( 'Yearly Archives: %s', 'azbalac' ), get_the_date( _x( 'Y', 'yearly archives date format', 'azbalac' ) ) );
	} else {
		$page_title = __( 'Archives', 'azbalac' );
	}


	$azbalac_have_posts = true;
	

	// Start the Loop.
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



echo $aztpl->render('archive.html.twig', array('header' => $header,
'layout_style' => $layoutStyle,
'sidebar' => $sidebar,
'have_posts' => $azbalac_have_posts,
'posts' => $azbalac_posts,
'no_posts' => $azbalac_no_posts,
'paging_nav' => $azbalac_paging_nav,
'footer' => $azbalac_footer,
'page_title' => $page_title
));            
