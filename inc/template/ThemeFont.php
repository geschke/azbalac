<?php

/**
 * Implements Custom Fonts functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac One 0.5
 * @copyright Copyright (c) 2022, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Theme_Font 
{


    public static function buildStyles() 
    {
        echo self::getStyles();
    
    }

    public static function getStyles()
    {
        $bodyFont = json_decode(rawurldecode((string) get_theme_mod('azbalac_setting_typography_body')));
        $headlineFont = json_decode(rawurldecode((string) get_theme_mod('azbalac_setting_typography_headline')));
        $navbarFont = json_decode(rawurldecode((string) get_theme_mod('azbalac_setting_typography_navbar')));
        $titleFont = json_decode(rawurldecode((string) get_theme_mod('azbalac_setting_typography_title')));
      
        $subtitleFont = json_decode(rawurldecode((string) get_theme_mod('azbalac_setting_typography_subtitle')));
        
        
        $cssHeadline = self::buildHeadlineCss($headlineFont);
        $cssBody = self::buildBodyCss($bodyFont);
        $cssNavbar = self::buildNavbarCss($navbarFont);
        $cssTitle = self::buildTitleCss($titleFont);
      
        $cssSubtitle = self::buildSubtitleCss($subtitleFont);
       

        return $cssBody . $cssHeadline . $cssNavbar . $cssTitle . $cssSubtitle;
    }

    protected static function buildBodyCss($bodyFont)
    {
        $cssStart = '<style id="typography-body" type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;

        $fontFamily = self::buildFontFamilyCss($bodyFont, 'azbalac-typography-body-font');
        
        if (isset($bodyFont->size) && absint($bodyFont->size) > 0 && absint($bodyFont->size) <= 120) {
            $fontSize = absint($bodyFont->size) . "px";
        } else {
            // size not set, use default size 
            $fontSize = null;
        }

        // font family and size could be used independently
        if ($fontFamily) {
            $css .= "
            body {
                font-family: $fontFamily; 
            }";
        }
        if ($fontSize) {
            $css .= "
            body {
                font-size: $fontSize; 
            }";
        
        }
    
        if ($css) {
            return $cssStart . $css . $cssEnd;
        }
        return $css;
    }

    protected static function buildTitleCss($font)
    {
        
        $cssStart = '<style id="typography-title" type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;

        $fontFamily = self::buildFontFamilyCss($font, 'azbalac-typography-title-font');
        
        if (isset($font->size) && absint($font->size) > 0 && absint($font->size) <= 120) {
            $fontSize = absint($font->size) . "px";
        } else {
            // size not set, use default size 
            $fontSize = null;
        }

        // font family and size could be used independently
        if ($fontFamily) {
            $css .= "
            #site-header-text a {
                font-family: $fontFamily; 
            }";
        }
        if ($fontSize) {
            $css .= "
            #site-header-text a {
                font-size: $fontSize; 
            }";
        
        }
    
        if ($css) {
            return $cssStart . $css . $cssEnd;
        }
        return $css;
    }

    protected static function buildSubtitleCss($font)
    {
        $cssStart = '<style id="typography-subtitle" type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;

        $fontFamily = self::buildFontFamilyCss($font, 'azbalac-typography-subtitle-font');
        
        if (isset($font->size) && absint($font->size) > 0 && absint($font->size) <= 120) {
            $fontSize = absint($font->size) . "px";
        } else {
            // size not set, use default size 
            $fontSize = null;
        }

        // font family and size could be used independently
        if ($fontFamily) {
            $css .= "
            #site-description {
                font-family: $fontFamily; 
            }";
        }
        if ($fontSize) {
            $css .= "
            #site-description {
                font-size: $fontSize; 
            }";
        
        }
    
        if ($css) {
            return $cssStart . $css . $cssEnd;
        }
        return $css;
    }

    protected static function buildNavbarCss($navbarFont)
    {
        $cssStart = '<style id="typography-navbar" type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;

        $fontFamily = self::buildFontFamilyCss($navbarFont, 'azbalac-typography-navbar-font');
        
        if (isset($navbarFont->size) && absint($navbarFont->size) > 0 && absint($navbarFont->size) <= 120) {
            $fontSize = absint($navbarFont->size) . "px";
        } else {
            // size not set, use default size 
            $fontSize = null;
        }

        // font family and size could be used independently
        if ($fontFamily) {
            $css .= "
            nav#navbarMain {
                font-family: $fontFamily; 
            }";
        }
        if ($fontSize) {
            $css .= "
            nav#navbarMain {
                font-size: $fontSize; 
            }
            nav#navbarMain ul.dropdown-menu {
                font-size: $fontSize; 
            }
            ";
        
        }
    
        if ($css) {
            return $cssStart . $css . $cssEnd;
        }
        return $css;
    }


    protected static function buildHeadlineCss($headlineFont)
    {
        $cssStart = '<style id="typography-headline" type="text/css">';
        $cssEnd = '</style>';
        $css = '';
        $fontSize = null;
        
        $fontFamily = self::buildFontFamilyCss($headlineFont, 'azbalac-typography-headline-font');

        if (isset($headlineFont->size) && absint($headlineFont->size) > 0 && absint($headlineFont->size) <= 120) {
            $sizeBase = absint($headlineFont->size);
            // size calculations from Bootstrap framework
            $sizeH1 = floor($sizeBase * 2.6) . 'px';
            $sizeH2 = floor($sizeBase * 2.15) . 'px';
            $sizeH3 = ceil($sizeBase * 1.7) . 'px';
            $sizeH4 = ceil($sizeBase * 1.28) . 'px';
            $sizeH5 = $sizeBase . 'px';
            $sizeH6 = ceil($sizeBase * 0.85) . 'px';
            $sizeSubtitle = floor($sizeBase * 1.5) . 'px';
            $sizeJumbotronHeading = ceil($sizeBase * 4.5) . 'px';
            
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
                font-family: $fontFamily; 
            }";
        }
        if ($fontSize) {
            $css .= "
            h1 {
                font-size: $sizeH1;
            }
            h2 {
                font-size: $sizeH2;
            }
            h3 {
                font-size: $sizeH3;
            }
            h4 {
                font-size: $sizeH4;
            }
            h5 {
                font-size: $sizeH5;
            }
            h6 {
                font-size: $sizeH6;
            }
            #site-description {
                font-size: $sizeSubtitle;
            }
            .azbalac-featured-large h1 {
                font-size: $sizeJumbotronHeading;
            }
            ";
        }
    
        if ($css) {
            return $cssStart . $css . $cssEnd;
        }
        return $css;

    }
    
    protected static function buildFontFamilyCss($font, $identifier) 
    {
        $fontFamily = '';
      
        if ( isset($font) && is_object($font) && isset($font->font)) {
           

         
            
            $fontValue = (string) $font->font;

            if (ctype_digit($fontValue) && array_key_exists($fontValue, Azbalac_Custom_Font_List::FONTS)) {
                // font from list in azbalac_Custom_Font_List
              
                $fontFamily = Azbalac_Custom_Font_List::FONTS[$fontValue];

            
            } elseif (
                !ctype_digit($fontValue)
                && preg_match('/^[\p{L}\p{N} ._-]+$/u', $fontValue)
            ) {
              
                // should be ggl font
                // todo: optimize - it is not necessary to load google font array and to go through the loop
                /*$gglfonts = $GLOBALS['azbalacGoogleFonts']; 
                $fontData = null;
                foreach ($gglfonts['items'] as $gglfont) {
                    if ($gglfont['family'] == $font->font) {
                        $fontData = $gglfont;
                        break;
                    }
                }*/
              
                $fontQuery = str_replace('%20', '+', rawurlencode($fontValue));
                $variant = isset($font->gglfontdata->variant)
                    ? strtolower((string) $font->gglfontdata->variant)
                    : 'regular';

                if ($variant === 'italic') {
                    $fontQuery .= ':ital@1';
                } elseif (preg_match('/^([1-9]00)$/', $variant, $matches)) {
                    $fontQuery .= ':wght@' . $matches[1];
                } elseif (preg_match('/^([1-9]00)italic$/', $variant, $matches)) {
                    $fontQuery .= ':ital,wght@1,' . $matches[1];
                }

                wp_enqueue_style(
                    $identifier,
                    'https://fonts.googleapis.com/css2?family=' . $fontQuery . '&display=swap',
                    array(),
                    null
                );
                $fontFamily = "'" . $fontValue . "'";
                
              

            } else {
              
                $fontFamily = '';
                // no font selected
            }

        }
        return $fontFamily;
    }


}
