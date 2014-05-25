<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage jfp
 * @since Tikva 1.0
 */
?>

		</div><!-- #main -->
</div><!-- container -->

<?php
global $tikva_theme;

if (isset($tikva_theme['color-bg-footer']) && $tikva_theme['color-bg-footer']) {
    $colorBgFooter = $tikva_theme['color-bg-footer'];
}
else {
    $colorBgFooter = '#000000';
}
if (isset($tikva_theme['color-fg-footer']) && $tikva_theme['color-fg-footer'] && stripos($tikva_theme['color-fg-footer'], 'transparent') !== false ) {
    $footerStyleColorFg = '';
}
elseif (isset($tikva_theme['color-fg-footer']) && $tikva_theme['color-fg-footer'] ) {
    $footerStyleColorFg = ' color: ' . $tikva_theme['color-fg-footer'] .';';
}
else {
    $footerStyleColorFg = '';
}

?>
<div style="background-color: <?php echo $colorBgFooter; ?>; <?php echo $footerStyleColorFg; ?>;">

<div class="container">
<div class="row" style="padding: 10px; 0px; 10px;">
    <div class="col-md-4 col-sm-4 col-xs-4">
        <?php
        if(is_active_sidebar('footer-sidebar-1')){
            dynamic_sidebar('footer-sidebar-1');
        }
        ?>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
        <?php
        if(is_active_sidebar('footer-sidebar-2')){
            dynamic_sidebar('footer-sidebar-2');
        }
        ?>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
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

			<?php //get_sidebar( 'footer' ); // this has shown the right sidebar below the hr ??? ähh... ?>

			<div class="site-info">
				<?php //do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tikva' ) ); ?>"><?php printf( __
                    ( 'Proudly powered by %s', 'tikva' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->

</div>

    </div>

	<?php wp_footer(); ?>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
</body>
</html>