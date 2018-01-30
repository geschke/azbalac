<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package azbalac
 * @subpackage Themes
 */


ob_start();
the_ID();
$content['theId'] = ob_get_contents();
ob_end_clean();

ob_start();
post_class('mb-5');
$content['postClass'] = ob_get_contents();
ob_end_clean();

ob_start();
if ( is_single() ) {
	the_title( '<h1 class="entry-title">', '</h1>' );
	
} else {
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	
}
$content['theTitle'] = ob_get_contents();
ob_end_clean();

ob_start();
if ( 'post' == get_post_type() ) {
	azbalac_posted_on();
}
$content['azbalacPostedOn'] = ob_get_contents();
ob_end_clean();

$content['commentsPopupLink'] = '';

if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	ob_start();

	comments_popup_link( sprintf( __( '<span class="byline-icon fa fa-comment" aria-hidden="true"></span> Leave a comment<span class="screen-reader-text"> on %s</span>', 'azbalac' ), get_the_title()),
	__( '1 Comment', 'azbalac' ), __( '% Comments', 'azbalac' ) ); 

	$content['commentsPopupLink'] = ob_get_contents();
	ob_end_clean();
}					



ob_start();
	edit_post_link( sprintf( __( ' <span class="byline-icon fa fa-pencil-square-o" aria-hidden="true"></span> Edit <span class="screen-reader-text">%s</span>', 'azbalac' ), get_the_title()), '<span class="edit-link">', '</span>' );

$content['editPostLink'] = ob_get_contents();
ob_end_clean();

$content['theContent'] = '';
ob_start();
if ( is_search() ) 
{
	$content['is_search'] = true;
	the_excerpt(); 
} else {
	$content['is_search'] = false;
	    if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
        }

			the_content( '<br/><span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'azbalac'), get_the_title()) );
		    wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:',
                        'azbalac' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			
}
$content['theContent'] = ob_get_contents();
ob_end_clean();

ob_start();
the_tags( __('<span class="byline-icon fa fa-tags"></span> Tags: ','azbalac'), ' ','' );
$content['theTags'] = ob_get_contents();
ob_end_clean();

$categories = get_the_category();
$separator = ' ';
$content['output'] = '';

if($categories) {
    $content['output'] .= '<div><span class="fa fa-th-list"></span> ';
        $content['output'] .= _n( 'Category:', 'Categories:', count($categories), 'azbalac' );
        $content['output'] .= '&nbsp;';
        foreach($categories as $category) {
            $catOutput .= '<a class="badge badge-secondary" href="'.get_category_link( $category->term_id ).'"
                title="' .
                esc_attr( sprintf( __( "View all posts in %s",'azbalac' ), $category->name ) ) . '">'.$category->cat_name
                .'</a>'.$separator;
        }
        $content['output'] .= trim($catOutput, $separator);
        $content['output'] .= '</div>';

    }


$azbalacContainer = Azbalac_DataContainer::getInstance();
$azbalacContainer->content = $content;