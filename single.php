<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Tikva
 * @since Tikva 0.1
 */

 get_header(); ?>


 <div class="container">
 
   <?php
   if ( is_front_page() ) {

Tikva_Section_Slider::showSlider(2);

   } 
   ?>
   
<div id="main" class="site-main">

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

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {

						comments_template();
					}
				endwhile;
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
	 
 
 
 



    