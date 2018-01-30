<?php
/**
 * The template for displaying the footer
 *
 * @since Azbalac 0.1
 */

 $content = [];
 if ( is_front_page() ) {

	$content['slider_4'] = azbalac_Section_Slider::getSlider(4);
	$content['showIntroductionElements']['4'] = azbalac_Section_Content_Column::getIntroductionElements(4);
}


$content['socialMediaButtons']['2'] = azbalac_Section_Social_Media_Buttons::getButtons(2);
	
$content['styles'] = azbalac_Section_Footer::getStyles();

$content['footer'] = azbalac_Section_Footer::get();


$content['socialMediaButtons']['3'] = azbalac_Section_Social_Media_Buttons::getButtons(3);


$content['subfooter'] = azbalac_Section_Subfooter::getContent();

ob_start();
wp_footer(); 
$content['wpFooter'] = ob_get_clean();


$azbalacContainer = azbalac_DataContainer::getInstance();

$azbalacContainer->footerData = $content;
