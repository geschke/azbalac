<?php
/**
 * The template for displaying the footer
 *
 * @since Tikva 0.1
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
<div id="media-width-detection-element"></div>
</body>
</html>