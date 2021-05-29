<?php

/**
 * Implements Slider Sections functionality.
 * The code was previously included in the main functions.php file.
 *
 * @package   WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Slider
{

    public static function getSlider($position) 
    {
        /*if (!get_option('azbalac_setting_slider_activate')) {
            return '';
        }*/

        if (get_option('azbalac_setting_slider_position','2') != $position) {
            return '';
        }
        return self::build();
    }

    public static function showSlider($position)
    {
        echo self::getSlider($position);
    }

    public static function build()
    {
        
        $output = '';
        
        $output .= '<div class="container"><!-- slider section -->';

        $output .= self::buildContainer();

        $output .= '</div><!-- end slider section -->';

        return $output;
    }

    public static function buildContainer()
    {
      
      
        if (!get_option('azbalac_setting_slider_activate')) {
            return '';
        }
      
        ob_start();
        self::showContainer();
        $output = ob_get_clean();
        return $output;
    }

    public static function showContainer()
    {
        // this is too late, so set above...
        //add_action( 'wp_enqueue_scripts', 'azbalac_set_slider_text_style' );
    
        $sliderInterval = get_theme_mod('azbalac_setting_slider_interval',5000);
        $sliderPause = get_option('azbalac_setting_slider_pause','1') ? 'hover': '';
        $sliderKeyboard = get_option('azbalac_setting_slider_keyboard','1') ? 'true': 'false';
        $sliderWrap = get_option('azbalac_setting_slider_wrap','1') ? 'true': 'false';
        $sliderIndicators = get_option('azbalac_setting_slider_indicators','1') ? true: false;
       
        for ($i = 1; $i <= 6; $i++) {
            $sliderImage = wp_get_attachment_image_src(absint(get_option('azbalac_setting_slider_' . $i . '_image')), 'original');
            if ($sliderImage) {
                $sliderData[$i]['image'] = $sliderImage;
                $sliderData[$i]['title'] = get_theme_mod('azbalac_setting_slider_' . $i . '_title');
                $sliderData[$i]['description'] = get_theme_mod('azbalac_setting_slider_' . $i . '_description');
                $sliderData[$i]['text_position'] = get_option('azbalac_setting_slider_' . $i . '_text_position');
                $sliderData[$i]['page'] = get_option('azbalac_setting_slider_' . $i . '_page');
                $sliderData[$i]['post'] = get_option('azbalac_setting_slider_' . $i . '_post');
                $sliderData[$i]['url'] = get_option('azbalac_setting_slider_' . $i . '_url');
                $colorFgText = get_theme_mod('azbalac_setting_slider_' . $i . '_text_color');
                if ($colorFgText) {
                    $sliderData[$i]['style'] = ' color: ' . $colorFgText .';';
                } else {
                    $sliderData[$i]['style'] = '';
                }
            }
        }
        ?>

        
        <div id="azbalacSlider" class="azbalac-slider carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo $sliderInterval; ?>" data-bs-pause="<?php echo $sliderPause; ?>" data-bs-wrap="<?php echo $sliderWrap; ?>" data-bs-keyboard="<?php echo $sliderKeyboard; ?>" >
        <?php 
        if (isset($sliderData) && count($sliderData)) {
            if ($sliderIndicators === true) { 
            ?>
        
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php
            
                foreach ($sliderData as $idx => $sliderElement) {
                    echo '<li data-bs-target="#azbalacSlider" data-bs-slide-to="';
                    echo $idx - 1;
                    echo '"';
                    if ($idx == 1) {
                        echo ' class="active"';
                    }
                    echo '></li>' . "\n";
                }
            
            ?>
        </ol>
        <?php
            } 
        }
        ?>
        <!-- Wrapper for slides -->
            
    
        <div class="carousel-inner">
                
        <?php
        if (isset($sliderData) && count($sliderData)) {
            foreach ($sliderData as $idx => $sliderElement) {
                echo ' <div class="carousel-item ';
                if ($idx == 1) {
                    echo 'active';
                }
                echo '">';
                if ($sliderElement['url']) {
                    $sliderUrl = $sliderElement['url'];
                } elseif ($sliderElement['page']) {
                    $sliderUrl = get_page_link($sliderElement['page']);
                } elseif ($sliderElement['post']) {
                    $sliderUrl = get_page_link($sliderElement['post']);
                } else {
                    $sliderUrl = null;
                }
                if ($sliderUrl) {
                    echo '<a href="' . $sliderUrl . '">';
                }
                echo '<img class="d-block w-100" src="' . $sliderElement['image'][0] .'" alt="&hellip;">';
                if ($sliderUrl) {
                    echo '</a>';
                }
                echo ' <div class="carousel-caption d-none d-md-block';
                switch ($sliderElement['text_position']) {
                    case 1:
                        echo " carousel-caption-left";
                        break;
                    case 3:
                        echo ' carousel-caption-right';
                        break;
                    // no default, centered is default
                }
                echo '">';
                if ($sliderElement['title']) {
                    echo '<h3 style="' . $sliderElement['style'] . '">';
                    if ($sliderUrl) {
                        echo '<a style="' . $sliderElement['style'] . '" href="' . $sliderUrl . '">';
                    }
                    echo '<span style="' . $sliderElement['style'] . '">' . $sliderElement['title'] . '</span>';
                    if ($sliderUrl) {
                        echo '</a>';
                    }
                    echo '</h3>';
                }
                if ($sliderElement['description']) {
                    echo '<p>';
                    if ($sliderUrl) {
                        echo '<a style="' . $sliderElement['style'] . '" href="' . $sliderUrl . '">';
                    }
                    echo '<span style="' . $sliderElement['style'] . '">' . $sliderElement['description'] . '</span>';
                    
                    if ($sliderUrl) {
                        echo '</a>';
                    }
                    echo '</p>';
                }
                echo '</div>    ';
                echo '</div>' . "\n";
            }
        }
        echo '</div>';
    
        if (isset($sliderData) && count($sliderData)) {
          echo '<!-- Controls -->
        <a class="carousel-control-prev" href="#azbalacSlider" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">' . __( 'Previous', 'azbalac')  . '</span>
        </a>
        <a class="carousel-control-next" href="#azbalacSlider" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">' . __( 'Next', 'azbalac' ) . '</span>
        </a>';
        }
        echo '</div>';
    }

    public static function addSliderStyle()
    {
        wp_enqueue_style(
                'azbalac-default-style', get_template_directory_uri() . '/css/default.css'
        );
        $custom_css = "
                .carousel-caption-left {
                text-align: left !important;
            }
            .carousel-caption-right {
                text-align: right !important;
            }
            .azbalac-slider {
                margin-bottom: 10px;
            }";
        
        wp_add_inline_style('azbalac-default-style', $custom_css);
    }

}


