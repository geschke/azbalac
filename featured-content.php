<?php
/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<div id="featured-content" class="featured-content">
	<div class="featured-content-inner">
	<?php
		/**
		 * Fires before the jfl featured content.
		 *
		 * @since jfl 1.0
		 */
		do_action( 'jfl_featured_posts_before' );

		$featured_posts = jfl_get_featured_posts();
        $postNumber = 0;
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );
            $post->postNumber = $postNumber++;
            // todo here: show jumbotron or another content in template

           	 // Include the featured content template.
			get_template_part( 'content', 'featured-post' );
		endforeach;

		/**
		 * Fires after the jfl featured content.
		 *
		 * @since jfl 1.0
		 */
		do_action( 'jfl_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
