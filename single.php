<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Tikva
 * @since Tikva 0.1
 */

get_header(); ?>


<div class="row">

    <div class="col-md-9 col-sm-8">


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					// Previous/next post navigation.
					//tikva_post_nav();
echo "hrrrrrrrrrr";
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
                        echo "hhhhhh?????";
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
    </div>

    <div class="col-md-3 col-sm-4">
    <?php
        get_sidebar( 'content' );
        get_sidebar();
    ?>
    </div>

    </div><!-- row -->

<?php
get_footer();
