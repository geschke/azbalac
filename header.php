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

$content['customLogoPosition'] = get_option('azbalac_setting_general_logo_position', 1);

$content['displayHeaderText'] = display_header_text();


$content['subfooterStyles'] = Azbalac_Section_Subfooter::getStyles();

ob_start();
wp_head(); 
$content['wpHead'] = ob_get_clean();

if (has_nav_menu('header-menu')) {
    
    $navbarAlignment = get_option('azbalac_setting_navbar_menu_alignment','1'); // left is default
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

    $navbarWhitespace = intval(get_option('azbalac_setting_navbar_menu_whitespace','1'));
   
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

$content['headerOptions']['show_title_image'] = get_option('azbalac_setting_header_show_title_image','');
$content['headerOptions']['header_color_bg'] = get_theme_mod('azbalac_setting_header_color_bg','#000000'); // default black
$content['headerOptions']['header_background_transp'] = get_option('azbalac_setting_header_background_transp',70); // default 70%
$content['headerOptions']['header_background_transp_hex'] = dechex(round(255 / 100 * $content['headerOptions']['header_background_transp']));
$content['headerOptions']['header_alignment'] = get_option('azbalac_setting_header_alignment',1);
switch (intval($content['headerOptions']['header_alignment'])) {
    case 2: // top, center
        $headerContainerClass = ' fixed-top ';
        $headerBoxClassTitle = ' d-flex justify-content-center ';
        $headerBoxClassSubtitle = ' d-flex justify-content-center ';
    
    break;
    case 3: // top, right
        $headerContainerClass = ' fixed-top ';
        $headerBoxClassTitle = ' d-flex justify-content-end ';
        $headerBoxClassSubtitle = ' d-flex justify-content-end ';
    break;
    case 4: // bottom, left
        $headerContainerClass = ' fixed-bottom ';
        $headerBoxClassTitle = ' d-flex justify-content-start ';
        $headerBoxClassSubtitle = ' d-flex justify-content-start ';
    break;
    case 5: // bottom, center
        $headerContainerClass = ' fixed-bottom ';
        $headerBoxClassTitle = ' d-flex justify-content-center ';
        $headerBoxClassSubtitle = ' d-flex justify-content-center';
    break;
    case 6: // bottom, right
        $headerContainerClass = ' fixed-bottom ';
        $headerBoxClassTitle = ' d-flex justify-content-end ';
        $headerBoxClassSubtitle = ' d-flex justify-content-end ';
    break;
    case 1: // top, left (default)
    default:
        $headerContainerClass = ' fixed-top ';
        $headerBoxClassTitle = ' d-flex justify-content-start ';
        $headerBoxClassSubtitle = ' d-flex justify-content-start ';
    break;
}

$content['headerOptions']['header_container'] = ['container_class' => $headerContainerClass,
'box_class_title' => $headerBoxClassTitle,
'box_class_subtitle' => $headerBoxClassSubtitle];
$content['headerOptions']['header_distance_top'] = get_option('azbalac_setting_header_distance_top',10);
$content['headerOptions']['header_distance_left'] = get_option('azbalac_setting_header_distance_left',20);
$content['headerOptions']['header_distance_between'] = get_option('azbalac_setting_header_distance_between',10);

if (is_customize_preview()) {
    // transport header options to JavaScript only in Customizer view, otherwise they aren't needed
    wp_enqueue_script( 'azbalac-admin-header', get_template_directory_uri().'/js/admin-options.js', array( 'jquery'), '', true );
    wp_localize_script( 'azbalac-admin-header', 'objectAdminHeader', $content['headerOptions'] );
}

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

      

