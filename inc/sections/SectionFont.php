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
        
        $cssHeadline = self::buildHeadlineCss($headlineFont);
        $cssBody = self::buildBodyCss($bodyFont);

      
        echo $cssBody;
        echo $cssHeadline;
       
    
    }

    protected static function buildBodyCss($bodyFont)
    {
        $cssStart = '<style type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;

        list($fontFamily, $cssHeader) = self::buildFontFamilyCss($bodyFont);
        
        if (isset($bodyFont->size) && intval($bodyFont->size) != 0) {
            $fontSize = $bodyFont->size . "px";
        } else {
            // size not set, use default size 
            $fontSize = null;
        }

        // font family and size could be used independently
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
    
        if ($css) {
            return $cssHeader . $cssStart . $css . $cssEnd;
        }
        return $css;
    }

    protected static function buildHeadlineCss($headlineFont)
    {
        $cssStart = '<style type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;
        
        list($fontFamily, $cssHeader) = self::buildFontFamilyCss($headlineFont);

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

        } else { 
            // size not set or set to 0 (zero), use default size of the css theme
            $fontSize = null; 
        }

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
    
        if ($css) {
            return $cssHeader . $cssStart . $css . $cssEnd;
        }
        return $css;

    }
    
    protected static function buildFontFamilyCss($font) 
    {
        $cssHeader = '';
        $fontFamily = '';
       
        if ( isset($font) && is_object($font) && isset($font->font)) {
           
            if (intval($font->font) != 0) {
                // font from list in Tikva_Custom_Font_List
                $fontFamily = Tikva_Custom_Font_List::FONTS[$font->font];

            } elseif (intval($font->font == 0) && is_string($font->font) && strlen($font->font) > 1) {
                // should be ggl font
                // todo: optimize - it is not necessary to load google font array and to go through the loop
                $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
                $fontData = null;
                foreach ($gglfonts['items'] as $gglfont) {
                    if ($gglfont['family'] == $font->font) {
                        $fontData = $gglfont;
                        break;
                    }
                }
                if (!$fontData) {
                    // gglfont not found, fallback to standard font
                    $fontFamily = '';
                } else {
                    $fontVariant = '';
                    // add variant if not regular
                    if (isset($font->gglfontdata->variant) && $font->gglfontdata->variant != 'regular') {
                        $fontVariant = ':' . $font->gglfontdata->variant;
                    }
                    $cssHeader = '<link rel="stylesheet"
                    href="https://fonts.googleapis.com/css?family=' . urlencode($fontData['family']) . $fontVariant . '">';
                    $fontFamily = "'" . $fontData['family'] . "'";
                  
                }
              

            } else {
                $fontFamily = '';
                // no font selected
            }

        }
        return array($fontFamily, $cssHeader);
    }


}
