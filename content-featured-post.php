<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package WordPress
 * @subpackage jfl
 * @since jfl 1.0
 */
?>

<div class="col-lg-4 col-md-4 col-sm-4">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
	<?php
		// Output the featured image.
		if ( has_post_thumbnail() ) :
			if ( 'grid' == get_theme_mod( 'featured_content_layout' ) ) {
				the_post_thumbnail();
			} else {
				the_post_thumbnail( 'jfl-full-width' );
			}
		endif;
	?>
	</a>

	<header class="entry-header">
		<?php

        the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' );
        the_excerpt();
        ?>

	</header><!-- .entry-header -->
</article><!-- #post-## -->

    </div>