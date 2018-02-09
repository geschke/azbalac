<?php

/**
 * Implements Custom Theme functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Theme
{


    public static function setStyles()
    {
        $stylesheetSetting = get_theme_mod('setting_general_theme',0);
    
        $timestamp = '2018020901';
    
        if (!$stylesheetSetting)
        {
            // fallback to default theme
            //$stylesheet = $stylesheetData;
            $themeFolder = 'bootstrap/';
            $themeCss = 'bootstrap.min.css';

        }
        else {
            $stylesheetData = json_decode(urldecode($stylesheetSetting));
        
            if (isset($stylesheetData->theme) && $stylesheetData->theme !== 0) {
                $themeData = $stylesheetData->data;
                // todo: check type: currently only "simple", i.e. load css file from folder
                $themeFolder = $themeData->folder . '/';
                $themeCss = $themeData->stylesheet;

            } else { // fallback to default theme
                $themeFolder = 'bootstrap/';
                $themeCss = 'bootstrap.min.css';

            }
        }

        wp_register_style( 'bootstrap-styles', get_template_directory_uri() .'/css/' . $themeFolder . $themeCss, array(), $timestamp,'all');
        

        //  enqueue the style:
        wp_enqueue_style( 'bootstrap-styles' );
    

    }


    public static function enqueueFontAwesome()
    {

        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );
    
    }
  

}
