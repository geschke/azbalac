<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */

 $content = [];

if ( has_nav_menu( 'secondary' ) ) {
	$content['wpNavMenu'] = wp_nav_menu( array( 'theme_location' => 'secondary', 
	'echo' => false ) );

}

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$content['isActiveSidebar']['sidebar_1'] = true;
	ob_start();	
	dynamic_sidebar( 'sidebar-1' ); 
	$content['sidebar_1'] = ob_get_clean();

}

$tikvaContainer = Tikva_DataContainer::getInstance();
$tikvaContainer->contentSidebar = $content;
