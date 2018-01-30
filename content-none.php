<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 */


$content['pageTitle'] = __( 'Nothing Found', 'azbalac' );

if ( is_home() && current_user_can( 'publish_posts' ) ) {

	$content['theContent'] = sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'azbalac' ), admin_url( 'post-new.php' ) );
	$content['searchForm'] = '';
} elseif ( is_search() ) {
	$content['theContent'] = __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'azbalac' );
	$content['searchForm'] = get_search_form(false);
} else {
	$content['theContent'] = __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'azbalac' ); 
	$content['searchForm'] = get_search_form(false);
}


$azbalacContainer = azbalac_DataContainer::getInstance();
$azbalacContainer->contentNone = $content;
