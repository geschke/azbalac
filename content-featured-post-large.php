<?php
/**
 * The template for displaying large featured posts on the front page
 *
 * @package WordPress
 * @subpackage jfl
 * @since jfl 1.0
 */
?>

<div class="jumbotron">
    <div class="container">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <h1><?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' ); ?>
        </h1>

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

            <p>
            <?php
            the_excerpt("Mehr...");
            ?>
            </p>
    </article>
    </div>
</div>



