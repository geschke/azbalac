<?php
/**
 * The template for displaying the footer
 *
 * @since Tikva 0.1
 */
?>

	
<?php
if ( is_front_page() ) {
	Tikva_Section_Slider::showSlider(4);
	Tikva_Section_Content_Column::showIntroductionElements(4);
}

Tikva_Section_Social_Media_Buttons::showButtons(2);
	
?>

<?php
$footerStyles = Tikva_Section_Footer::getStyles();
?>

<div class="site-footer-1" style="<?php echo $footerStyles['footerStyleColorBg'] . $footerStyles['footerStyleColorFg'] ?>">

<div role="complementary" class="container">
    
<?php
Tikva_Section_Footer::build();
// todo: add styling...
?>
</div>

<?php
//Tikva_Section_Content_Column::showIntroductionElements(4);

Tikva_Section_Social_Media_Buttons::showButtons(3);

?>

<div class="container">
    <hr/>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tikva' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'tikva' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->

</div>

    </div>

	<?php wp_footer(); ?>
<div id="media-width-detection-element"></div>
</body>
</html>