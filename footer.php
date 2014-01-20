<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage jfp
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->
</div><!-- container -->

<?php
global $jfl_theme;

if (isset($jfl_theme['color-bg-footer']) && $jfl_theme['color-bg-footer']) {
    $colorBgFooter = $jfl_theme['color-bg-footer'];
}
else {
    $colorBgFooter = '#000000';
}
if (isset($jfl_theme['color-fg-footer']) && $jfl_theme['color-fg-footer'] && stripos($jfl_theme['color-fg-footer'], 'transparent') !== false ) {
    $footerStyleColorFg = '';
}
elseif (isset($jfl_theme['color-fg-footer']) && $jfl_theme['color-fg-footer'] ) {
    $footerStyleColorFg = ' color: ' . $jfl_theme['color-fg-footer'] .';';
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

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<?php //do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'jfl' ) ); ?>"><?php printf( __
                    ( 'Proudly powered by %s', 'jfl' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->

</div>

    </div>


	<?php wp_footer(); ?>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
</body>
</html>