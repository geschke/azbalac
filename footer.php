<?php
/**
 * The template for displaying the footer
 *
 * @since Azbalac 0.1
 */

 $content = [];
 if ( is_front_page() ) {

	$content['slider_4'] = Azbalac_Section_Slider::getSlider(4);
	$content['showIntroductionElements']['4'] = Azbalac_Section_Content_Column::getIntroductionElements(4);
}


$content['socialMediaButtons']['2'] = Azbalac_Section_Social_Media_Buttons::getButtons(2);
	
$content['styles'] = Azbalac_Section_Footer::getStyles();

$content['footer'] = Azbalac_Section_Footer::get();


$content['socialMediaButtons']['3'] = Azbalac_Section_Social_Media_Buttons::getButtons(3);


$content['subfooter'] = Azbalac_Section_Subfooter::getContent();

ob_start();
wp_footer(); 
$content['wpFooter'] = ob_get_clean();


$azbalacContainer = Azbalac_DataContainer::getInstance();

$azbalacContainer->footerData = $content;
