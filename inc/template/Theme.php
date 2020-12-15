<?php

/**
 * Implements Custom Theme functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.2
 * @copyright Copyright (c) 2020, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Theme
{


    /**
     * Return array of header image data with elements url, height, weight, thumbnail, id and dontscale or empty string if 
     * no image is set.
     * Remark: dontscale is not used anymore since version 0.3. Maybe it's more senseful to add a "dontscale" option for all images, but not for the special size
     */
    public static function getHeaderImageData()
    {
        $imageData = array();
     
        if (get_header_image()) {
            $largeImage = get_custom_header();
            //var_dump($largeImage);
            $imageData[0] = array('url' => $largeImage->url,
                'height' => $largeImage->height,
                'width' => $largeImage->width,
                'thumbnail' => $largeImage->thumbnail_url,
                'id' => $largeImage->attachment_id); 
        }
        elseif (get_option('azbalac_setting_header_image_example', 1)) {
            // fallback to example image if not overwritten or switched off
            $imageData[0] = array('url' => get_template_directory_uri() . '/images/azbalac_default_header_image.jpg',
                'height' => 213,
                'width' => 1115,
                'thumbnail' => '', // not used here
                'id' => 0);

        } else {
            $imageData[0] = '';
        }

        if (isset($imageData[0]) && $imageData[0] !== '') {
            
            if (get_option('azbalac_setting_header_image_large_dontscale')) {
                $imageData[0]['dontscale'] = get_option('azbalac_setting_header_image_large_dontscale');
            } else {
                $imageData[0]['dontscale'] = 0;
            }
        }
        
        $headerImageMediumData = wp_get_attachment_image_src(absint(get_option('azbalac_setting_header_image_medium')), 'original');
        $headerImageSmallData = wp_get_attachment_image_src(absint(get_option('azbalac_setting_header_image_small')), 'original');
        $headerImageXSmallData = wp_get_attachment_image_src(absint(get_option('azbalac_setting_header_image_xsmall')), 'original');
       
        if (isset($headerImageMediumData) && $headerImageMediumData) {
            
            $imageData[1]['url'] = $headerImageMediumData[0];
            $imageData[1]['width'] = $headerImageMediumData[1];
            $imageData[1]['height'] = $headerImageMediumData[2];
            $imageData[1]['thumbnail'] = '';
            $imageData[1]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('azbalac_setting_header_image_medium_dontscale'))
            {
                $imageData[1]['dontscale'] = 1;
            } else {
                $imageData[1]['dontscale'] = 0;
            }
        } else {
            if (isset($imageData[0]) && is_array($imageData[0])) {
                $imageData[1] = $imageData[0];
            }
            else {
                $imageData[1] = '';
            }
        }

        if (isset($headerImageSmallData) && $headerImageSmallData) {
            
            $imageData[2]['url'] = $headerImageSmallData[0];
            $imageData[2]['width'] = $headerImageSmallData[1];
            $imageData[2]['height'] = $headerImageSmallData[2];
            $imageData[2]['thumbnail'] = '';
            $imageData[2]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('azbalac_setting_header_image_small_dontscale'))
            {
                $imageData[2]['dontscale'] = 1;
            } else {
                $imageData[2]['dontscale'] = 0;
            }
        } else {
            if (isset($imageData[1]) && is_array($imageData[1])) {
                $imageData[2] = $imageData[1];
            } elseif (isset($imageData[0]) && is_array($imageData[0])) {
                $imageData[2] = $imageData[0];
            }
            else {
                $imageData[2] = '';
            }
        }

         if (isset($headerImageXSmallData) && $headerImageXSmallData) {
            
            $imageData[3]['url'] = $headerImageXSmallData[0];
            $imageData[3]['width'] = $headerImageXSmallData[1];
            $imageData[3]['height'] = $headerImageXSmallData[2];
            $imageData[3]['thumbnail'] = '';
            $imageData[3]['id'] = 0; // if necessary, set to attachment id. But check before.
            
            if (get_option('azbalac_setting_header_image_xsmall_dontscale'))
            {
                $imageData[3]['dontscale'] = 1;
            } else {
                $imageData[3]['dontscale'] = 0;
            }
        } else { // fallback to image with higher resolution
            if (isset($imageData[2]) && is_array($imageData[2])) {
                $imageData[3] = $imageData[2];
            } elseif (isset($imageData[1]) && is_array($imageData[1])) {
                $imageData[3] = $imageData[1];
            } elseif (isset($imageData[0]) && is_array($imageData[0])) {
                $imageData[3] = $imageData[0];
            }
            else {
                $imageData[3] = '';
            }
        }
        return $imageData;
    }

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
            return str_replace("rel='stylesheet'", "rel='stylesheet preload prefetch' as='style' crossorigin='anonymous'", $html);
        }
        return $html;
    }

}
