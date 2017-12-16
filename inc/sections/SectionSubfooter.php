<?php

/**
 * Implements Subfooter functionality.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.5.0
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Subfooter
{

    public static function buildStyles()
    {
        echo self::getStyles();
    }

    public static function getStyles() 
    {
        $output = '';
        $footerActivate =  get_option('setting_subfooter_activate',1);
        if (intval($footerActivate) !== 1) {
          return '';
        }
        $colorLink = get_theme_mod('setting_subfooter_color_link');
        
        $output .= '<style type="text/css">
         .subfooter a, .subfooter a:hover {
            color: ' . $colorLink .';
        }

        </style>';
        return $output;        
    }
    
    /**
     * Add Custom SubFooter Content 
     */
    public static function buildContent()
    {
        echo self::getContent();
    }

    public static function getContent()
    {
        $output = '';        
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
        $styles = self::getStyleData();
        
        $output .= '<div class="subfooter" style="' . $styles['styleColorBg'] . $styles['styleColorFg'] . '">
        <div class="container">

    <footer id="colophonsub" class="site-footer" role="contentinfo">
    <div class="site-info">' . $content . '</div><!-- .site-info -->
    </footer><!-- #colophonsub -->

</div>
</div>';
        return $output;
    }

    public static function getStyleData()
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
