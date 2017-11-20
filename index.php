<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tikva
 * @subpackage Themes
 * @since Tikva 0.1
 */

$twigLoader = new Twig_Loader_Filesystem(get_template_directory() . '/templates/src/');
$twig = new Twig_Environment($twigLoader, array(
    'cache' => get_template_directory() . '/templates/cache/',
    'debug' => true // todo: set to false when upload to WordPress theme repository
));

ob_start();

get_header(); 

$header = ob_get_contents();
ob_end_clean();

$showSlider_2 = '';
if ( is_front_page() ) {
    $showSlider_2 = Tikva_Section_Slider::getSlider(2);
} 

ob_start();
get_template_part( 'featured-content' );
$template_part_featured_content = ob_get_contents();
ob_end_clean();


echo $twig->render('index.html.twig', array('header' => $header,
'is_front_page' => is_front_page(),
'tikva_has_featured_posts' => tikva_has_featured_posts(),
'show_slider_2' => $showSlider_2,
'template_part_featured_content' => $template_part_featured_content
));



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

					get_template_part( 'content', get_post_format() );
				endwhile;
				// Previous/next post navigation.
				tikva_paging_nav();
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


</div><!-- #main -->
</div><!-- container -->     
     <?php



get_footer();
?>
