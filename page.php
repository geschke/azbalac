<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Tikva
 * @since Tikva 0.1.8
 */

get_header(); 

if ( is_front_page() ) {
    Tikva_Section_Slider::showSlider(2);
} 

if ( is_front_page() && tikva_has_featured_posts() ) {
?>

<div id="featured-main" class="featured-main">

<div class="container">
      <?php
    // Include the featured content template.
    get_template_part( 'featured-content' );
    //   echo "<h1>show featured content</h1>";
    ?>
    </div><!-- end container -->
    </div><!-- end featured-main -->
    <?php
}
?>

<?php
if ( is_front_page() ) {
    Tikva_Section_Content_Column::showIntroductionElements(3);
    Tikva_Section_Slider::showSlider(3);
               
}

?>




<div id="main" class="site-main">

<div class="container">



    <div class="row">

        <div id="main-content" class="main-content">

            <?php
            $layoutStyle = tikva_get_layout();
          
          
            if ($layoutStyle['content'] == 2) {
                ?>
                <div class="<?php echo $layoutStyle['col_2']; ?>">
                    <?php get_sidebar( 'content' );
                    get_sidebar();
                    ?>
                </div>
            <?php
            }
            ?>

            <div class="<?php echo $layoutStyle['col_1']; ?>">

                <div id="primary" class="content-area">
                    <div id="content" class="site-content" role="main">

                        <?php
                        if ( have_posts() ) :
                            // Start the Loop.
                            while ( have_posts() ) : the_post();
                                /*
                                 * Include the post format-specific template for the content. If you want to
                                 * use this in a child theme, then include a file called called content-___.php
                                 * (where ___ is the post format) and that will be used instead.
                                 */

                                get_template_part( 'content', 'page' );
                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) {
                                    comments_template();
                                }

                            endwhile;
                            // Previous/next post navigation.
                            //tikva_paging_nav();
                        else :
                            // If no content, include the "No posts found" template.
                            get_template_part( 'content', 'none' );

                        endif;
                        ?>
                    </div><!-- #content -->
                </div><!-- #primary -->

            </div>

            <?php

            if ($layoutStyle['columns'] == 2) {
                if ($layoutStyle['content'] == 1) {
                    ?>
                    <div class="<?php echo $layoutStyle['col_2']; ?>">
                        <?php get_sidebar( 'content' );
                        get_sidebar();
                        ?>
                    </div>
                <?php
                }
            } ?>

 
        </div><!-- #main-content -->

    </div><!-- row -->
 <?php
    
     ?>
     	
</div><!-- container -->
</div><!-- #main -->
     <?php
get_footer();
?>




