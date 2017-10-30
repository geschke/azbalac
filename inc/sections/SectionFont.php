<?php

/**
 * Implements Subfooter functionality.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.5.3
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Font 
{

    public static function buildStyles() 
    {
        $bodyFont = json_decode(urldecode(get_theme_mod('setting_typography_body')));
        $headlineFont = json_decode(urldecode(get_theme_mod('setting_typography_headline')));
        
        //var_dump($bodyFont);
        //var_dump($headlineFont);
        $cssHeadline = self::buildHeadlineCss($headlineFont);
        $cssBody = self::buildBodyCss($bodyFont);

        ?>
        <style type="text/css">
        <?php
        echo $cssBody;
        echo $cssHeadline;
        ?>
        </style>
        <?php
    }

    protected static function buildBodyCss($bodyFont)
    {
        $css = '';
        if (isset($bodyFont) && is_object($bodyFont)) {
            if (intval($bodyFont->font) != 0) {
                //echo "default font";
                $fontFamily = Tikva_Custom_Font_List::FONTS[$bodyFont->font];
                //echo $fontFamily;


            } elseif (intval($bodyFont->font == 0) && is_string($bodyFont->font) && strlen($bodyFont->font) > 1) {
                echo "should be ggl font";
                echo $bodyFont->font;
                $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
                // print_r($gglfonts);
                $fontData = null;
                foreach ($gglfonts['items'] as $gglfont) {
                    if ($gglfont['family'] == $bodyFont->font) {
                        $fontData = $gglfont;
                        break;
                    }
                }
                if (!$fontData) {
                    echo "gglfont not found, fallback to standard font";
                    return;
                }
                echo "<pre>";
                var_dump($fontData);
                echo "</pre>";
                

            } else {
                echo "no font selected";
            }

            if (isset($bodyFont->size) && intval($bodyFont->size) != 0) {
                $fontSize = $bodyFont->size . "px";
            } elseif (!isset($bodyFont->size)) {
                //echo " size not set, use default size ";
                $fontSize = Tikva_Custom_Font_List::DEFAULT_SIZE['body'] . "px";
            }


            //echo "size: $fontSize";
            if ($fontFamily) {
                $css .= "
                body {
                    font-family: $fontFamily !important; 
                }";
            }
            if ($fontSize) {
                $css .= "
                body {
                    font-size: $fontSize !important; 
                }";
            
            }

          
        }
        return $css;
    }

    protected static function buildHeadlineCss($headlineFont)
    {
        $css = '';
        if ( isset($headlineFont) && is_object($headlineFont)) {
            if (intval($headlineFont->font) != 0) {
                //echo "default font";
                $fontFamily = Tikva_Custom_Font_List::FONTS[$headlineFont->font];
                //echo $fontFamily;


            } elseif (intval($headlineFont->font == 0) && is_string($headlineFont->font) && strlen($headlineFont->font) > 1) {
                echo "should be ggl font";
                echo $headlineFont->font;
                $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
                // print_r($gglfonts);
                $fontData = null;
                foreach ($gglfonts['items'] as $gglfont) {
                    if ($gglfont['family'] == $headlineFont->font) {
                        $fontData = $gglfont;
                        break;
                    }
                }
                if (!$fontData) {
                    echo "gglfont not found, fallback to standard font";
                    return;
                }
                echo "<pre>";
                var_dump($fontData);
                echo "</pre>";
                

            } else {
                echo "no font selected";
            }

            if (isset($headlineFont->size) && intval($headlineFont->size) != 0) {
                $sizeBase = intval($headlineFont->size);
                // size calculations from Bootstrap framework
                $sizeH1 = floor($sizeBase * 2.6) . 'px';
                $sizeH2 = floor($sizeBase * 2.15) . 'px';
                $sizeH3 = ceil($sizeBase * 1.7) . 'px';
                $sizeH4 = ceil($sizeBase * 1.28) . 'px';
                $sizeH5 = $sizeBase . 'px';
                $sizeH6 = ceil($sizeBase * 0.85) . 'px';

                //$lineHeightBase = 1.428571429; // maybe later?
                //$lineHeightComputed = floor($sizeBase * $lineHeightBase); // maybe later?
                $fontSize = true;

            } else { //  (!isset($headlineFont->size)) {
                //echo " size not set, use default size ";
                $fontSize = ''; // size not set, use default of the theme
            }

            //echo "size: $fontSize";
            if ($fontFamily) {
                $css .= "
                h1, h2, h3, h4, h5, h6 {
                    font-family: $fontFamily !important; 
                }";
            }
            if ($fontSize) {
                $css .= "
                h1 {
                    font-size: $sizeH1 !important;
                }
                h2 {
                    font-size: $sizeH2 !important;
                }
                h3 {
                    font-size: $sizeH3 !important;
                }
                h4 {
                    font-size: $sizeH4 !important;
                }
                h5 {
                    font-size: $sizeH5 !important;
                }
                h6 {
                    font-size: $sizeH6 !important;
                }

                ";
            }

            
        }
        return $css;

    }
    
  

}
