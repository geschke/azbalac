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
        $socialButtons = array(
            'azbalac_social_media_discord' => 'discord',
            'azbalac_social_media_facebook' => 'facebook',
            'azbalac_social_media_github' => 'github',
            'azbalac_social_media_google' => 'google',
            'azbalac_social_media_instagram' => 'instagram',
            'azbalac_social_media_linkedin' => 'linkedin',
            'azbalac_social_media_mastodon' => 'mastodon',
            //'azbalac_social_media_slideshare' => 'slideshare',
            'azbalac_social_media_skype' => 'skype',
            'azbalac_social_media_slack' => 'slack',
            //'azbalac_social_media_snapchat' => 'snapchat',
            'azbalac_social_media_telegram' => 'telegram',
            'azbalac_social_media_twitch' => 'twitch',
            'azbalac_social_media_twitter' => 'twitter',
            //'azbalac_social_media_vine' => 'vine',
            //'azbalac_social_media_xing' => 'xing',
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
                
                $fontSize = ' ';
                break;
            case 2:
                
                $fontSize = "font-size: 2rem!important;";
                break;
            case 3:
                
                $fontSize = "font-size: 3rem!important;";
                break;
        }
        $styleFg = '';
        $styleBg = '';
        
        //$output = sprintf('<a target="_blank" href="%s"><span class="fa-stack %s"><i %s class="fa %s fa-stack-2x innersocialbg"></i><i %s class="bi bi-%s fa-stack-1x  innersocial"></i></span></a>', esc_url($url), $faSize, $styleBg, $faType, $styleFg, $socialIcon);
        $svgName =  'css/icons/svg/' . $socialIcon . '.svg';

        ob_start();
        get_template_part( $svgName);
        $svgText = ob_get_clean();
$foo = '

        <div class="fs-2 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
<path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path>
</svg>
        Heading
      </div>
';
        //$output = $svgText;
        //$output = sprintf('<a target="_blank" href="%s"><i style="%s" class="bi bi-%s border border-primary border-2 rounded p-2 _innersocial"></i></a> ', esc_url($url), $fontSize, $socialIcon);
        $output = sprintf('<div class="azbalac-social" target="_blank" role="img" href="%s">%s FOO</div> ',  esc_url($url), $svgText);
     $output .= $foo;
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