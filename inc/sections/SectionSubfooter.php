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
        $footerActivate =  get_option('setting_subfooter_activate',1);
        if (intval($footerActivate) !== 1) {
          return '';
        }
        $colorLink = get_theme_mod('setting_subfooter_color_link');
        
        ?>
        <style type="text/css">
         .subfooter a, .subfooter a:hover {
            color: <?php echo $colorLink; ?> ;
        }

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
