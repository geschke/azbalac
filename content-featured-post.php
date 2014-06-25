<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package WordPress
 * @subpackage tikva
 * @since tikva 0.1
 */
?>

<?php
echo '<div class="col-lg-' .  $post->themeCols . ' col-md-' . $post->themeCols . ' col-sm-' . $post->themeCols . '">';

    ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Output the featured image.
		if ( has_post_thumbnail() ) : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>">
<?php 
			if ( 'grid' == get_theme_mod( 'featured_content_layout' ) ) {
				the_post_thumbnail();
			} else {
				the_post_thumbnail( 'tikva-full-width' );
			}
                ?>
                </a>
                <?php			
		endif;
	?>

	<header class="entry-header">
		<?php
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' );
        if (preg_match('/<!--more.*-->/',$post->post_content)) {
            the_content( '<br/><span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'tikva'), get_the_title()) );

            //the_content( '<br/><p><span class="btn btn-primary"><span class="screen-reader-text">'. __('Continue reading on ', 'tikva') . esc_html(get_the_title()) . '</span>' . __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'tikva' ) . '</span></p>' );
        } else {
            the_excerpt();
        }
        ?>

	</header><!-- .entry-header -->
</article><!-- #post-## -->

    </div>