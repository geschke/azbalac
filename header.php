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

$content['headerImageData'] = azbalac_get_header_image_data();

$content['layoutStyle'] = azbalac_get_layout();

$content['bodyStyles'] = azbalac_get_body_styles();

$content['navbarFixed'] = azbalac_get_navbar_layout(); // fixed-top or default

$content['hasNavMenuHeaderMenu'] = has_nav_menu('header-menu'); // ok, this is a bit ugly...

$content['headerWidgetRight'] = Azbalac_Section_Widgets::get('header-widget-right');
$content['navigationWidgetRight'] = Azbalac_Section_Widgets::get('navigation-widget-right');



$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
if ( has_custom_logo() ) {
    $content['customLogo'] = $logo[0];
//        echo '<img src="'. esc_url( $logo[0] ) .'">';
} 

$content['customLogoPosition'] = get_option('setting_general_logo_position', 1);

$content['displayHeaderText'] = display_header_text();


$content['subfooterStyles'] = Azbalac_Section_Subfooter::getStyles();

ob_start();
wp_head(); 
$content['wpHead'] = ob_get_clean();

if (has_nav_menu('header-menu')) {
    
    $navbarAlignment = get_option('setting_navbar_menu_alignment','1'); // left is default
    switch (intval($navbarAlignment)) {
        case 3: // right
            $whitespacePosition = 'l';
        break;
        case 2: // centered
            $whitespacePosition = 'm';
        break;
        case 1: 
        default: // left
            $whitespacePosition = 'r';
        break;
    }

    $navbarWhitespace = intval(get_option('setting_navbar_menu_whitespace','1'));
   
    switch ($navbarWhitespace) {
        case 5:
            $menuWhitespace = 'mx-4';

        break;
        case 4:
            $menuWhitespace = 'mx-3';

        break;
        case 3:
            $menuWhitespace = 'mx-2';
        break;
        case 2:
            $menuWhitespace = 'mx-1';
        break;
        case 1:
        default:
            $menuWhitespace = '';
    }

    $content['wpNavMenu'] = wp_nav_menu( array( 
    'theme_location' => 'header-menu',
                    'items_wrap' => '%3$s',
                'container' => '',
                'menu_class'     => 'nav navbar-nav',
                'walker' => new HeaderMenuWalker(),
                'echo' => false,
                'menuWhitespace' => $menuWhitespace,
                'menuWhitespacePosition' => $whitespacePosition

                ) );

}


$content['sectionFontStyles'] = Azbalac_Theme_Font::getStyles();

$content['bodyClass'] = 'class="' . join( ' ', get_body_class( ) ) . '"';

$content['skipToMainContent'] = __( 'Skip to main content', 'azbalac' );

$content['headerStyles'] = azbalac_get_header_styles( $content['navbarFixed'] );

$content['description'] = get_bloginfo( 'name', 'display' ); // no raw
$content['subtitleDescription'] = get_bloginfo( 'description', 'display' ); // no raw

$content['homeUrl'] = home_url( '/' ); // no raw

$content['headerImage'] = get_header_image(); // no raw

$content['customHeader'] = get_custom_header();

$content['headerImageAlt'] = __( 'Header Image - navigate to homepage', 'azbalac' );

if ( is_front_page()) {
    
    $content['showSlider']['1'] = Azbalac_Section_Slider::getSlider(1);

    $content['showIntroductionElements']['1'] = Azbalac_Section_Content_Column::getIntroductionElements(1);
    $content['showIntroductionElements']['2'] = Azbalac_Section_Content_Column::getIntroductionElements(2);

}

$content['toggleNavigation'] = __( 'Toggle navigation', 'azbalac' );
          

$azbalacContainer = Azbalac_DataContainer::getInstance();

$azbalacContainer->headerData = $content;

      

