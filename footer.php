<?php
/**
 * The template for displaying the footer
 *
 * @since Tikva 0.1
 */
?>

		</div><!-- #main -->
</div><!-- container -->

<div class="row">
<div class="container">
    <div class="col-md-12 social-media-buttons"> 
        <div style="text-align: center;">
        <div  class="socialcircle">
        <a  href=""><i class="fa fa-twitter fa-2x fa-inverse "></i></a>
        </div>
 <div s class="socialcircle">
        <a  href=""><i class="fa fa-facebook fa-2x fa-inverse "></i></a>
        </div>
        <div  class="socialcircle">
        <a  href=""><i class="fa fa-github fa-2x fa-inverse "></i></a>
        </div>
        <div  class="socialcircle">
        <a  href=""><i class="fa fa-google-plus fa-2x fa-inverse "></i></a>
        </div>
    <div  class="socialcircle">
        <a  href=""><i class="fa fa-instagram fa-2x fa-inverse "></i></a>
        </div>
     <div  class="socialcircle">
        <a  href=""><i class="fa fa-linkedin fa-2x fa-inverse "></i></a>
        </div>   
    
      <div  class="socialcircle">
        <a  href=""><i class="fa fa-slideshare fa-2x fa-inverse "></i></a>
        </div>  
       <div  class="socialcircle">
        <a  href=""><i class="fa fa-vine fa-2x fa-inverse "></i></a>
        </div>      
     <div  class="socialcircle">
        <a  href=""><i class="fa fa-xing fa-2x fa-inverse "></i></a>
        </div>
        <div class="socialcircle">
        <a  href=""><i class="fa fa-youtube fa-2x fa-inverse "></i></a>
        </div>
         
       
        </div>
    </div>
</div>
</div>
<?php
$footerStyles = tikva_get_footer_styles();
?>

<div style="<?php echo $footerStyles['footerStyleColorBg'] . $footerStyles['footerStyleColorFg'] ?>">

<div role="complementary" class="container">
<div class="row" style="padding: 10px; 0px; 10px;">
    <div class="col-md-4 col-sm-4">
        <?php
        if(is_active_sidebar('footer-sidebar-1')){
            dynamic_sidebar('footer-sidebar-1');
        }
        ?>
    </div>
    <div class="col-md-4 col-sm-4">
        <?php
        if(is_active_sidebar('footer-sidebar-2')){
            dynamic_sidebar('footer-sidebar-2');
        }
        ?>
    </div>
    <div class="col-md-4 col-sm-4">
        <?php
        if(is_active_sidebar('footer-sidebar-3')){
            dynamic_sidebar('footer-sidebar-3');
        }
        ?>
    </div>
</div>
</div>


<div class="container">
    <hr/>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tikva' ) ); ?>"><?php printf( __
                    ( 'Proudly powered by %s', 'tikva' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->

</div>

    </div>

	<?php wp_footer(); ?>
<div id="media-width-detection-element" ></div>
</body>
</html>