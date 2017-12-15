<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 */

$content = [];
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

if ( ! post_password_required() ) {
	$content['postPasswordRequired'] = false;

	if ( have_comments() ) {
		$content['haveComments'] = true;

		$content['commentsTitle'] = sprintf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'tikva' ), number_format_i18n( get_comments_number() ), get_the_title() );
		
		$content['getCommentPagesCount'] = get_comment_pages_count();
		$content['optionPageComments'] = get_option('page_comments');
		
		if ( $content['getCommentPagesCount'] > 1 && $content['optionPageComments'] ) {
			$content['commentNavigation'] = __( 'Comment navigation', 'tikva' ); 
			$content['navPrevious'] = get_previous_comments_link( __( '&larr; Older Comments', 'tikva' ) );
			$content['navNext'] = get_next_comments_link( __( 'Newer Comments &rarr;', 'tikva' ) );

		}

		$content['commentList'] = wp_list_comments( array( 'style'      => 'ol',
															'short_ping' => true,
															'avatar_size'=> 34,
															'echo' => false
														) );

		$content['commentsOpen'] = comments_open();
		if ( ! comments_open() ) {

			$content['commentsClosed'] = __( 'Comments are closed.', 'tikva' );
		}

	}

	
    $formArgs = ['comment_field' => '<div class="form-group comment-form-comment"><label class="col-sm-2 control-label" for="comment">' . _x( 'Comment', 'noun', 'tikva' ) . '</label>' .
        '<div class="col-sm-10"><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></div>',
	];

    ob_start();
    comment_form($formArgs);
    $commentForm = ob_get_clean();
    $commentForm = str_replace('class="comment-form"','class="form-horizontal comment-form"', $commentForm);
    $commentForm = str_replace('id="submit"','id="submit" class="btn btn-primary"', $commentForm);
    $commentForm = str_replace('<code>','<pre>', $commentForm);
    $commentForm = str_replace('</code>','</pre>', $commentForm);

	$content['commentForm'] = $commentForm;
    

}

$tikvaContainer = Tikva_DataContainer::getInstance();
$tikvaContainer->commentData = $content;