<?php

/**
 * Add-ons for Customizer
 *
 * @package   WordPress
 * @subpackage azbalac
 * @since azbalac 0.4.6
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Customizer_Addon
{

    private $customizer;

    public function __construct($wp_customize)
    {
        $this->customizer = $wp_customize;
    }

    public function initPreview()
    {
        // todo: activate again, bit it should work as expected
        //$this->customizer->get_setting( 'blogname' )->transport = 'postMessage';
        //$this->customizer->get_setting( 'blogdescription' )->transport = 'postMessage';
        //$this->customizer->get_setting( 'header_textcolor' )->transport = 'postMessage';
        
        $this->customizer->get_setting( 'azbalac_setting_color_bg_header' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_color_fg_footer' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_color_bg_footer' )->transport = 'postMessage';

        $this->customizer->get_setting( 'azbalac_setting_color_fg_sidebar' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_color_bg_sidebar' )->transport = 'postMessage';

        $this->customizer->get_setting( 'azbalac_setting_color_fg_title' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_color_fg_subtitle' )->transport = 'postMessage';

        $this->customizer->get_setting( 'azbalac_setting_header_color_bg')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_header_background_transp')->transport = 'postMessage';
        //$this->customizer->get_setting( 'azbalac_setting_header_alignment')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_header_distance_top')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_header_distance_left')->transport = 'postMessage';
        

//        var_dump($this->customizer->get_setting('azbalac_setting_header_color_bg')->value());
//        var_dump($this->customizer->get_setting('azbalac_setting_header_background_transp')->value());
        
       /* wp_enqueue_script( 'azbalac-admin-stuff', get_template_directory_uri().'/js/admin-header-options.js', array( 'jquery'), '', true );
        
        //wp_add_inline_script('azbalac-social-media-buttons',$js);
        wp_localize_script( 'azbalac-admin-stuff', 'objectAdminHeader', array(
            'azbalac_setting_header_color_bg' => $this->customizer->get_setting('azbalac_setting_header_color_bg')->value(),
            'azbalac_setting_header_background_transp' => $this->customizer->get_setting('azbalac_setting_header_background_transp')->value()

        ) );
*/
        // $this->customizer->get_setting( 'azbalac_setting_introduction_area_elements' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_typography_headline')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_typography_body')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_typography_navbar')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_typography_title')->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_typography_subtitle')->transport = 'postMessage';
        
        //   $headlineFont = json_decode(urldecode(get_theme_mod('azbalac_setting_typography_headline')));
       
        $this->customizer->get_setting( 'blogname' )->transport        = 'postMessage';
        $this->customizer->get_setting( 'blogdescription' )->transport = 'postMessage';
    
        $this->customizer->selective_refresh->add_partial( 'blogname', array(
            'selector' => '#site-header-text a',
            'container_inclusive' => false,
            'render_callback' => array($this,'customizePartialBlogName')
        ) );
        $this->customizer->selective_refresh->add_partial( 'blogdescription', array(
            'selector' => '#site-description',
            'container_inclusive' => false,
            'render_callback' => array($this, 'customizePartialBlogDescription')
        ) );

        
        $this->customizer->get_setting( 'azbalac_setting_subfooter_content' )->transport = 'postMessage';
        $this->customizer->selective_refresh->add_partial('azbalac_setting_subfooter_content', array(
            'selector' => '.subfooter .site-info',
            'container_inclusive' => false,
            'render_callback' => array($this, 'customizePartialSubfooterContent')
        ));


        $this->customizer->get_setting( 'azbalac_setting_introduction_area_title' )->transport = 'postMessage';
        $this->customizer->selective_refresh->add_partial('azbalac_setting_introduction_area_title', array(
            'selector' => '#section-introduction .section-title',
            'container_inclusive' => false,
            'render_callback' => array($this, 'customizePartialIntroductionAreaTitle')
        ));

        $this->customizer->get_setting( 'azbalac_setting_introduction_area_subtitle' )->transport = 'postMessage';
        $this->customizer->selective_refresh->add_partial('azbalac_setting_introduction_area_subtitle', array(
            'selector' => '#section-introduction .section-subtitle',
            'container_inclusive' => false,
            'render_callback' => array($this, 'customizePartialIntroductionAreaSubtitle')
        ));



        $this->customizer->get_setting( 'azbalac_setting_introduction_area_elements' )->transport = 'postMessage';
        $this->customizer->selective_refresh->add_partial('azbalac_setting_introduction_area_elements', array(
            'selector' => '.azbalac-introduction .section-introduction-elements',
            'container_inclusive' => false,
            'render_callback' => array($this, 'customizePartialIntroductionAreaElements')
        ));

        

        $this->customizer->get_setting( 'azbalac_setting_social_media_activate' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_media_alignment' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_button_size' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_button_type' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_button_color_fg' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_button_color_bg' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_social_button_color_bg_hover' )->transport = 'postMessage';

        $this->customizer->selective_refresh->add_partial('azbalac_setting_social_media_activate', array(
            'selector' => '.social-media-buttons',
            'container_inclusive' => false,
            'settings' => array(
                'azbalac_setting_social_media_activate',
                'azbalac_setting_social_media_alignment',
                'azbalac_setting_social_button_size',
                'azbalac_setting_social_button_type',
              
            ),
            'render_callback' => array($this, 'customizePartialSocialMediaButtons')
        ));

        
        $this->customizer->get_setting( 'azbalac_setting_slider_activate' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_slider_indicators' )->transport = 'postMessage';
        
        $this->customizer->selective_refresh->add_partial('azbalac_setting_slider_activate', array(
            'selector' => '.azbalac-slider', // todo here...the same as with social media buttons
            'container_inclusive' => true,
            'settings' => array(
                'azbalac_setting_slider_activate',
                'azbalac_setting_slider_indicators'
              
            ),
            'render_callback' => array($this, 'customizePartialSlider')
        ));


        

        $this->customizer->get_setting( 'azbalac_setting_footer_activate' )->transport = 'postMessage';
        $this->customizer->get_setting( 'azbalac_setting_footer_layout' )->transport = 'postMessage';
        
        $this->customizer->selective_refresh->add_partial('azbalac_setting_footer_activate', array(
            'selector' => '.azbalac-footer', // todo here...the same as with social media buttons
            'container_inclusive' => false,
            'settings' => array(
                'azbalac_setting_footer_activate',
                'azbalac_setting_footer_layout',
              
            ),
            'render_callback' => array($this, 'customizePartialFooter')
        ));



        add_action('customize_preview_init', array($this, 'customizeRegisterLivePreview'));
    }

    /**
     * Render the blog name selective refresh partial
     */
    public function customizePartialBlogName()
    {
        bloginfo('name');
    }

    /**
     * Render the blog description selective refesh partial 
     */
    public function customizePartialBlogDescription() 
    {
        bloginfo('description');
    }

    /**
     * Render the subfooter selective refresh partial
     */
    public function customizePartialSubfooterContent() 
    {
        Azbalac_Section_Subfooter::buildContentRaw();
    }

    public function customizePartialIntroductionAreaTitle()
    {
        echo Azbalac_Section_Content_Column::getIntroductionTitle();
    }

    public function customizePartialIntroductionAreaSubtitle()
    {
        echo Azbalac_Section_Content_Column::getIntroductionSubtitle();
    }

    public function customizePartialIntroductionAreaElements()
    {
        echo Azbalac_Section_Content_Column::getElementBox(false); // without surrounding row/box
    }

    public function customizePartialSocialMediaButtons()
    {
        echo Azbalac_Section_Social_Media_Buttons::getButtonsContainer();
    }

    public function customizePartialSlider()
    {
        echo  Azbalac_Section_Slider::buildContainer();
    }

    public function customizePartialFooter()
    {
        echo  Azbalac_Section_Footer::get();
    }


    /**
    * Used by hook: 'customize_preview_init'
    *
    * @see add_action('customize_preview_init',$func)
    */
    public function customizeRegisterLivePreview()
    {
          
        
        wp_enqueue_script(
            'azbalac-themecustomizer',            //Give the script an ID
            get_template_directory_uri().'/js/theme-customizer.js', //Point to file
            array( 'jquery','customize-preview' ),  //Define dependencies
            '',                         //Define a version (optional)
            true                        //Put script in footer?
        );

        // see https://wordpress.stackexchange.com/questions/106520/wp-localize-script-variable-is-not-defined-in-jquery
        // wp_localize_script must be called after the script it's being attached!
        wp_localize_script( 'azbalac-themecustomizer', 'azbalacAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
    }
}

