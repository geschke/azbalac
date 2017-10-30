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
        $cssHeadline = '';
        $cssBody = '';
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

            if (isset($bodyFont->size) && intval($bodyFont->size) == 0) {
                $fontSize = Tikva_Custom_Font_List::DEFAULT_SIZE['body'];
            } elseif (!isset($bodyFont->size)) {
                //echo " size not set, use default size ";
                $fontSize = Tikva_Custom_Font_List::DEFAULT_SIZE['body'];
            }

            //echo "size: $fontSize";
            if ($fontFamily) {
                $cssBody .= "
                body {
                    font-family: $fontFamily !important; 
                }";
            }
            
        }
    
        
        ?>
        <style type="text/css">
        <?php
        echo $cssBody;
        ?>

        </style>

        <?php
      
        
    }
    
    /**
     * Add Custom SubFooter Content 
     */
    public static function build()
    {
        
        $footerActivate =  get_option('setting_subfooter_activate',1);
       
        if (intval($footerActivate) !== 1) {
          return '';
        }
        $content = get_theme_mod('setting_subfooter_content');
        if ($content === false) {
            // no value in database, so the option is not overwritten, use default
            $content = __('Powered by <a href="https://wordpress.org">WordPress</a>. Theme Tikva by <a href="https://www.geschke.net">Ralf Geschke</a>.','tikva');
        }
        if (!$content) {
            return; // no output
        }
        $styles = self::getStyles();
               ?>
<div class="subfooter" style="<?php echo $styles['styleColorBg']; echo $styles['styleColorFg']; ?>">
<div class="container">

    <footer id="colophonsub" class="site-footer" role="contentinfo">
    <div class="site-info">
        <?php echo $content; ?>
        </div><!-- .site-info -->
    </footer><!-- #colophonsub -->

</div>
</div>
        <?php 
    }

    public static function getStyles()
    {
        $colorBg = get_theme_mod('setting_subfooter_color_bg');

        if ($colorBg) {
            $styleColorBg = ' background-color: ' . $colorBg . ';';
        } else {
            $styleColorBg = '';
        }

        $colorFg = get_theme_mod('setting_subfooter_color_fg');

        if ($colorFg) {
            $styleColorFg = ' color: ' . $colorFg . ';';
        } else {
            $styleColorFg = '';
        }


        return array(
            'styleColorBg' => $styleColorBg,
            'styleColorFg' => $styleColorFg,
        );
    }

}
