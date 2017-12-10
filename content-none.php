<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package Tivka7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 */


$content['pageTitle'] = __( 'Nothing Found', 'tikva' );

if ( is_home() && current_user_can( 'publish_posts' ) ) {

	$content['theContent'] = sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'tikva' ), admin_url( 'post-new.php' ) );
	$content['searchForm'] = '';
} elseif ( is_search() ) {
	$content['theContent'] = __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'tikva' );
	$content['searchForm'] = get_search_form(false);
} else {
	$content['theContent'] = __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'tikva' ); 
	$content['searchForm'] = get_search_form(false);
}


$tikvaContainer = Tikva_DataContainer::getInstance();
$tikvaContainer->contentNone = $content;
