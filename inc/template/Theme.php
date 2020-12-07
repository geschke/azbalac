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
        $stylesheetSetting = get_theme_mod('azbalac_setting_general_theme',0);
    
        if (!$stylesheetSetting)
        {
            // fallback to default theme
            //$stylesheet = $stylesheetData;
            $themeFolder = 'bootstrap/';
            $themeCss[] = 'bootstrap.min.css';

        }
        else {
            $stylesheetData = json_decode(urldecode($stylesheetSetting));
        
            if (isset($stylesheetData->theme) && $stylesheetData->theme !== 0) {
                $themeData = $stylesheetData->data;
                // todo: check type: currently only "simple", i.e. load css file from folder
                $themeFolder = $themeData->folder . '/';
                if (isset($themeData->stylesheets)) { // multiple stylesheets
                    foreach ($themeData->stylesheets as $stylesheet) {
                        $themeCss[] = $stylesheet;
                    }
                } else { // single stylesheet
                    $themeCss[] = $themeData->stylesheet;

                }
    
            } else { // fallback to default theme
                $themeFolder = 'bootstrap/';
                $themeCss[] = 'bootstrap.min.css';

            }
        }

        foreach ($themeCss as $key => $stylesheet) {
            wp_register_style( 'bootstrap-styles_' . $key, get_template_directory_uri() .'/css/' . $themeFolder . $stylesheet, array(), AZBALAC_DATEVERSION ,'all');
        
            //  enqueue the style:
            wp_enqueue_style( 'bootstrap-styles_' . $key );
        }

    }


    public static function enqueueFontAwesome()
    {

        wp_enqueue_style( 'azbalac-font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );
    
    }
  

    public static function styleLoaderTagFilter($html, $handle)
    {

        if ($handle === 'azbalac-font-awesome') {
            return str_replace("rel='stylesheet'", "rel='preload' as='font'", $html);
        }
        return $html;
    }

}
