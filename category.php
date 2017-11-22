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



$twigLoader = new Twig_Loader_Filesystem(get_template_directory() . '/templates/src/');
$twig = new Twig_Environment($twigLoader, array(
    'cache' => get_template_directory() . '/templates/cache/',
    'debug' => true // todo: set to false when upload to WordPress theme repository
));

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



if ( have_posts() ) {
	$tikva_have_posts = true;
	
		$archive_title = sprintf( __( 'Category Archives: %s', 'tikva' ), single_cat_title( '', false ) );
	
		$term_description = term_description();
	
		while ( have_posts() ) {
			
			ob_start();
			the_post(); 
		
			get_template_part( 'content',  get_post_format() );
				
			$tikva_posts[] = ob_get_contents();
			ob_end_clean();
		}
		// Previous/next post navigation.
		ob_start();
		tikva_paging_nav();
		$tikva_paging_nav = ob_get_contents();
		ob_end_clean();
	} else {
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


echo $twig->render('category.html.twig', array('header' => $header,
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

