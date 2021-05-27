<?php

/**
 * Implements Social Media Buttons Sections functionality.
 * The code was previously included in the main functions.php file.
 *
 * @package   WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Social_Media_Buttons
{


    public static function showButtons($position, $contentComplete = true)
    {
        $output = self::getButtons($position, $contentComplete);
        if (null === $output) {
            return null;
        }
        echo $output;
    }


    public static function getButtons($position, $contentComplete = true)
    {
      
        if (!get_option('azbalac_setting_social_media_activate',false)) {
            return null;
        }
        $positionOption = absint(get_option('azbalac_setting_social_media_position',2));
        if ($positionOption != $position) {
            return null;
        }
      
        return self::buildButtons($contentComplete);
    }

    public static function buildButtons($contentComplete = true)
    {
        $output = '';
        
        if ($contentComplete) $output .= '<div class="container">';

        $output .= self::getButtonsContainer($contentComplete);
        if ($contentComplete) $output .= '</div>';

        return $output;
    }

    public static function getButtonsContainer($contentComplete = true)
    {
        $output = '';
        if (!get_option('azbalac_setting_social_media_activate',false)) {
            return $output;
        }
        /*
         Slideshare, Snapchat, Vine and Xing buttons taken from Font Awesome 5 
         */
        $socialButtons = array(
            'azbalac_social_media_discord' => 'discord',
            'azbalac_social_media_facebook' => 'facebook',
            'azbalac_social_media_github' => 'github',
            'azbalac_social_media_google' => 'google',
            'azbalac_social_media_instagram' => 'instagram',
            'azbalac_social_media_linkedin' => 'linkedin',
            'azbalac_social_media_mastodon' => 'mastodon',
            'azbalac_social_media_slideshare' => 'slideshare',
            'azbalac_social_media_skype' => 'skype',
            'azbalac_social_media_slack' => 'slack',
            'azbalac_social_media_snapchat' => 'snapchat',
            'azbalac_social_media_telegram' => 'telegram',
            'azbalac_social_media_twitch' => 'twitch',
            'azbalac_social_media_twitter' => 'twitter',
            'azbalac_social_media_vine' => 'vine',
            'azbalac_social_media_xing' => 'xing',
            'azbalac_social_media_whatsapp' => 'whatsapp',
            'azbalac_social_media_youtube' => 'youtube');
        switch (get_option('azbalac_setting_social_media_alignment')) {
            case 1:
                $align = 'left';
                break;
            case 3:
                $align = 'right';
                break;
            default:
                $align = 'center';
        }
        $buttonSize = get_option('azbalac_setting_social_button_size','2');
        $buttonType = get_option('azbalac_setting_social_button_type','1');
        

        if ($contentComplete) {
            $output .= '<div class="col-md-12 social-media-buttons"> 
                    <div style="text-align: ' . $align . '">';
        }    
        $socialOutput = '';
        foreach ($socialButtons as $socialOption => $socialIcon) {
            $socialOutput .= self::buildSocialButton($socialOption, $socialIcon, $buttonSize, $buttonType);
        }
        $output .= $socialOutput;


        if ($contentComplete) {
            $output .= '</div>
                        </div>';
        }
        return $output;        
    }

    protected static function buildSocialButton($socialOption, $socialIcon, $buttonSize, $buttonType)
    {
        $url = get_theme_mod($socialOption);
        if (!$url) {
            return '';
        }
        $faType = ($buttonType == 2) ? 'bi-square-fill' : 'bi-circle-fill';
        switch ($buttonSize) {
            case 1:
                $sizeClass = 'azbalac-social-1';
                break;
            case 2:
                $sizeClass = 'azbalac-social-2';
                
                break;
            case 3:
                $sizeClass = 'azbalac-social-3';

                break;
        }
        $styleFg = '';
        $styleBg = '';
        
        $svgName =  'css/icons/svg/' . $socialIcon . '.svg'; // works only with extension .php, so all svg files have been renamed to .svg.php

        ob_start();
        get_template_part( $svgName);
        $svgText = ob_get_clean();

        $f = '<div style="text-align: center"><a class="azbalac-social-3" target="_blank" role="img" href="https://www.facebook.com/rgeschke"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
</svg></a>';
        
        //$output = sprintf('<a target="_blank" href="%s"><i style="%s" class="bi bi-%s border border-primary border-2 rounded p-2 _innersocial"></i></a> ', esc_url($url), $fontSize, $socialIcon);
        $output = sprintf('<a class=" %s" target="_blank" role="img" href="%s">%s</a> ',  $sizeClass, esc_url($url), $svgText);
    
        return $output;
    }

 
    /**
     * Add color styling from theme
     */
    public static function addSocialButtonStyle()
    {
        wp_enqueue_style(
            'azbalac-default-style-socialmediabuttons',
            get_template_directory_uri() . '/css/default.css'
        );
         
      
        $css = "\n"; // dummy to generate the style block when no colors defined
        $social_button_color_bg_hover = get_theme_mod('azbalac_setting_social_button_color_bg_hover');
        $social_button_color_bg = get_theme_mod('azbalac_setting_social_button_color_bg');
        $social_button_color_fg = get_theme_mod('azbalac_setting_social_button_color_fg');
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
        
        //$js = 'var azbalac_setting_social_button_color_bg_hover="' . $social_button_color_bg_hover .'";';
       
        wp_add_inline_style( 'azbalac-default-style-socialmediabuttons', $css );

      
        //wp_add_inline_script('azbalac-default-script-socialmediabuttons',$js);

        wp_enqueue_script( 'azbalac-social-media-buttons', get_template_directory_uri().'/js/social-media-buttons.js', array( 'jquery'), '', true );
        
        //wp_add_inline_script('azbalac-social-media-buttons',$js);
        wp_localize_script( 'azbalac-social-media-buttons', 'objectSocialMediaButtons', array(
            'social_button_color_bg_hover' => $social_button_color_bg_hover,
            'social_button_color_bg' => $social_button_color_bg,
            'social_button_color_fg' => $social_button_color_fg

        ) );

    

    }
}