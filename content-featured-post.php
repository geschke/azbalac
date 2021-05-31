<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 */

$content = [];

$content['theId'] = get_the_ID();

$content['themeCols'] = $post->themeCols;
$content['linebreak'] = $post->linebreak;


$content['postClass'] = 'class="mb-4 ' . join( ' ', get_post_class() ) . '"'; // taken from post-template.php 

$content['title'] = get_the_title();

$content['permalink'] = get_permalink();
// esc_url?? check this!


            
// Output the featured image.
if ( has_post_thumbnail() ) {
    $content['has_post_thumbnail'] = true;

    if ( 'grid' == get_theme_mod( 'featured_content_layout' ) ) {
        $content['thumbnail'] = get_the_post_thumbnail();
    } else {
        $content['thumbnail'] = get_the_post_thumbnail(null,'azbalac-full-width');
    }
}



if (absint(get_option('azbalac_setting_posts_featured_date'))) {
    
    $content['azbalac_setting_posts_featured_date'] = true;

    if ( 'post' == get_post_type() ) {
        $content['postType'] = 'post';
        $content['postedOn'] = get_azbalac_posted_on();
    }

    ob_start(); // todo...
    edit_post_link( sprintf( __( '<span class="byline-icon bi bi-pencil-square" aria-hidden="true"></span>Edit <span class="screen-reader-text">%s</span>', 'azbalac' ), get_the_title()), '<span class="edit-link">', '</span>' );
    $content['editPostLink'] = ob_get_contents();
    ob_end_clean();
    
} 


if (preg_match('/<!--more.*-->/',$post->post_content)) {
    
    $contentMain = get_the_content( '<br/><span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'azbalac'), get_the_title()) );
    $contentMain = apply_filters( 'the_content', $contentMain );
    $content['content'] = $contentMain;
} else {
    //$contentMain = get_the_excerpt();
    $contentMain = apply_filters( 'the_excerpt', get_the_excerpt() );
    $contentMain .= '<span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'azbalac'), get_the_title()); 

    $content['content'] = $contentMain;
}


  
$azbalacContainer = Azbalac_DataContainer::getInstance();
$azbalacContainer->contentFeaturedPost = $content;
    
