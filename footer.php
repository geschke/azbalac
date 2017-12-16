<?php
/**
 * The template for displaying the footer
 *
 * @since Tikva7 0.1
 */

 $content = [];
 if ( is_front_page() ) {

	$content['slider_4'] = Tikva_Section_Slider::getSlider(4);
	$content['introductionElements_4'] = Tikva_Section_Content_Column::getIntroductionElements(4);
}


$content['socialMediaButtons_3'] = Tikva_Section_Social_Media_Buttons::getButtons(2);
	
$content['styles'] = Tikva_Section_Footer::getStyles();

$content['footer'] = Tikva_Section_Footer::get();


$content['socialMediaButtons_3'] = Tikva_Section_Social_Media_Buttons::getButtons(3);


$content['subfooter'] = Tikva_Section_Subfooter::getContent();

ob_start();
wp_footer(); 
$content['wpFooter'] = ob_get_clean();


$tikvaContainer = Tikva_DataContainer::getInstance();

$tikvaContainer->footerData = $content;
