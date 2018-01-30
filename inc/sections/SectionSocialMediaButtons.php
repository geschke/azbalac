<?php

/**
 * Implements Social Media Buttons Sections functionality.
 * The code was previously included in the main functions.php file.
 *
 * @package   WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.5.0
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Social_Media_Buttons
{


    public static function showButtons($position)
    {
        $output = self::getButtons($position);
        if (null === $output) {
            return null;
        }
        echo $output;
    }


    public static function getButtons($position)
    {
      
        if (!get_option('setting_social_media_activate',false)) {
            return null;
        }
        $positionOption = absint(get_option('setting_social_media_position',2));
        if ($positionOption != $position) {
            return null;
        }
      
        return self::buildButtons();
    }

    public static function buildButtons()
    {
        $output = '';
        $socialButtons = array('social_media_facebook' => 'facebook',
        'social_media_github' => 'github',
        'social_media_google' => 'google-plus',
        'social_media_instagram' => 'instagram',
        'social_media_linkedin' => 'linkedin',
        'social_media_slideshare' => 'slideshare',
        'social_media_snapchat' => 'snapchat',
        'social_media_twitter' => 'twitter',
        'social_media_vine' => 'vine',
        'social_media_xing' => 'xing',
        'social_media_youtube' => 'youtube');
        switch (get_option('setting_social_media_alignment')) {
            case 1:
                $align = 'left';
                break;
            case 3:
                $align = 'right';
                break;
            default:
                $align = 'center';
        }
        $buttonSize = get_option('setting_social_button_size','2');
        $buttonType = get_option('setting_social_button_type','1');
        $output .= '    

<div class="container">
<div class="col-md-12 social-media-buttons"> 
    <div style="text-align: ' . $align . '">';
        
        $socialOutput = '';
        foreach ($socialButtons as $socialOption => $socialIcon) {
            $socialOutput .= self::buildSocialButton($socialOption, $socialIcon, $buttonSize, $buttonType);
        }
        $output .= $socialOutput;
        $output .= '
        </div>
</div>
</div>';

    return $output;
}


    protected static function buildSocialButton($socialOption, $socialIcon, $buttonSize, $buttonType)
    {
        $url = get_theme_mod($socialOption);
        if (!$url) {
            return '';
        }
        $faType = ($buttonType == 2) ? 'fa-square' : 'fa-circle';
        switch ($buttonSize) {
            case 1:
                $faSize = ' ';
                break;
            case 2:
                $faSize = ' fa-lg ';
                break;
            case 3:
                $faSize = ' fa-2x ';
                break;
        }
        $styleFg = '';
        $styleBg = '';
        
        $output = sprintf('<a target="_blank" href="%s"><span class="fa-stack %s"><i %s class="fa %s fa-stack-2x innersocialbg"></i><i %s class="fa fa-%s fa-stack-1x  innersocial"></i></span></a>', esc_url($url), $faSize, $styleBg, $faType, $styleFg, $socialIcon);
     
        return $output;
    }

 
    /**
     * Add color styling from theme
     */
    public static function addSocialButtonStyle()
    {
        wp_enqueue_style(
            'azbalac-default-style',
            get_template_directory_uri() . '/css/default.css'
        );
         
        $css = '';
        $social_button_color_bg_hover = get_theme_mod('setting_social_button_color_bg_hover');
        $social_button_color_bg = get_theme_mod('setting_social_button_color_bg');
        $social_button_color_fg = get_theme_mod('setting_social_button_color_fg');
        if ($social_button_color_bg_hover) {
            $css .= ".socialhover {
        color: $social_button_color_bg_hover !important;
            } 
                     ";
        }
        if ($social_button_color_bg) {
            $css .= "
        .innersocialbg {
            color: $social_button_color_bg ;
                }
                     ";
        }
        if ($social_button_color_fg) {
            $css .= "
        .innersocial {
            color: $social_button_color_fg;  
        }
        
                    ";
        }
        
       
        wp_add_inline_style( 'azbalac-default-style', $css );
    }
}