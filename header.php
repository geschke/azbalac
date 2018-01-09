<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */


$content = [];

$content['languageAttributes'] = get_language_attributes();

$content['bloginfo']['charset'] = get_bloginfo('charset');
$content['bloginfo']['description'] = get_bloginfo('description');
$content['bloginfo']['pingback_url'] = get_bloginfo('pingback_url');

$content['headerImageData'] = tikva_get_header_image_data();

$content['layoutStyle'] = tikva_get_layout();

$content['bodyStyles'] = tikva_get_body_styles();

$content['navbarFixed'] = tikva_get_navbar_layout(); // fixed-top or default

$content['hasNavMenuHeaderMenu'] = has_nav_menu('header-menu'); // ok, this is a bit ugly...



$content['subfooterStyles'] = Tikva_Section_Subfooter::getStyles();

ob_start();
wp_head(); 
$content['wpHead'] = ob_get_clean();

if (has_nav_menu('header-menu')) {
    

    $content['wpNavMenu'] = wp_nav_menu( array( 
    'theme_location' => 'header-menu',
                    'items_wrap' => '%3$s',
                'container' => '',
                'menu_class'     => 'nav navbar-nav',
                'walker' => new HeaderMenuWalker(),
                'echo' => false
                ) );

}


$content['sectionFontStyles'] = Tikva_Section_Font::getStyles();

$content['bodyClass'] = 'class="' . join( ' ', get_body_class( $class ) ) . '"';

$content['skipToMainContent'] = __( 'Skip to main content', 'tikva' );

$content['headerStyles'] = tikva_get_header_styles($navbarFixed);

$content['description'] = get_bloginfo( 'name', 'display' ); // no raw
$content['subtitleDescription'] = get_bloginfo( 'description', 'display' ); // no raw

$content['homeUrl'] = home_url( '/' ); // no raw

$content['headerImage'] = get_header_image(); // no raw

$content['customHeader'] = get_custom_header();

$content['headerImageAlt'] = __( 'Header Image - navigate to homepage', 'tikva' );

if ( is_front_page()) {
    
    $content['showSlider_1'] = Tikva_Section_Slider::getSlider(1);
    $content['showIntroductionElements']['1'] = Tikva_Section_Content_Column::getIntroductionElements(1);
    $content['showIntroductionElements']['2'] = Tikva_Section_Content_Column::getIntroductionElements(2);

}

$content['toggleNavigation'] = __( 'Toggle navigation', 'tikva' );

                    

$tikvaContainer = Tikva_DataContainer::getInstance();

$tikvaContainer->headerData = $content;

      

