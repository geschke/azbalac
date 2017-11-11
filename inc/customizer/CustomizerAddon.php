<?php

/**
 * Add-ons for Customizer
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4.6
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Customizer_Addon
{

    private $customizer;

    public function __construct($wp_customize)
    {
        $this->customizer = $wp_customize;
    }

    public function initPreview()
    {
        $this->customizer->get_setting( 'blogname' )->transport = 'postMessage';
        $this->customizer->get_setting( 'blogdescription' )->transport = 'postMessage';
        $this->customizer->get_setting( 'header_textcolor' )->transport = 'postMessage';
        
        $this->customizer->get_setting( 'color_bg_header' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_fg_footer' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_bg_footer' )->transport = 'postMessage';

        $this->customizer->get_setting( 'color_fg_sidebar' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_bg_sidebar' )->transport = 'postMessage';

        // $this->customizer->get_setting( 'setting_introduction_area_elements' )->transport = 'postMessage';
        $this->customizer->get_setting( 'setting_typography_headline')->transport = 'postMessage';
        $this->customizer->get_setting( 'setting_typography_body')->transport = 'postMessage';
        
        //   $headlineFont = json_decode(urldecode(get_theme_mod('setting_typography_headline')));
       

         add_action('customize_preview_init', array($this, 'customizeRegisterLivePreview'));
    }

    /**
    * Used by hook: 'customize_preview_init'
    *
    * @see add_action('customize_preview_init',$func)
    */
    public function customizeRegisterLivePreview()
    {
          
        
        wp_enqueue_script(
            'tikva-themecustomizer',            //Give the script an ID
            get_template_directory_uri().'/js/tikva-customizer.js', //Point to file
            array( 'jquery','customize-preview' ),  //Define dependencies
            '',                         //Define a version (optional)
            true                        //Put script in footer?
        );

        // see https://wordpress.stackexchange.com/questions/106520/wp-localize-script-variable-is-not-defined-in-jquery
        // wp_localize_script must be called after the script it's being attached!
        wp_localize_script( 'tikva-themecustomizer', 'tikvaAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
    }
}

