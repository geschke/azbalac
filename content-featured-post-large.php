<?php
/**
 * The template for displaying large featured posts on the front page
 *
 * @package WordPress
 * @subpackage tikva
 * @since tikva 0.1
 */
?>

<div class="jumbotron">
    <div class="container">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php 
        the_title( '<h1 class="entry-title tikva-jumbotron"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' ); 

                 if (absint(get_option('setting_posts_featured_date'))) {
        
                if ( 'post' == get_post_type() ) {
                    tikva_posted_on();
                    echo '&nbsp; ';
                }
                edit_post_link( sprintf( __( '<span class="byline-icon fa fa-pencil-square-o" aria-hidden="true"></span>Edit <span class="screen-reader-text">%s</span>', 'tikva' ), get_the_title()), '<span class="edit-link">', '</span>' );
            
                }
                
                // Output the featured image.
                if ( has_post_thumbnail() ) :
                ?>
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

            <p></p>
            <?php
            if (preg_match('/<!--more.*-->/',$post->post_content)) {
            	the_content( '<br/><span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'tikva'), get_the_title()) );

            } else {
                the_excerpt();
            }
            ?>
            
    </article>
    </div>
</div>



