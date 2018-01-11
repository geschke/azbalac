<?php

/**
 * Implements Slider Sections functionality.
 * The code was previously included in the main functions.php file.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.5.0
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Slider
{

    public static function getSlider($position) 
    {
        ob_start();
        self::showSlider($position);
        $output = ob_get_clean();
        return $output;
    }

    public static function showSlider($position)
    {
        if (!get_option('setting_slider_activate')) {
            return '';
        }
        if (get_option('setting_slider_position') != $position) {
            return '';
        }
        self::build();
    }

    public static function build()
    {
        // this is too late, so set above...
        //add_action( 'wp_enqueue_scripts', 'tikva_set_slider_text_style' );
    
        $sliderInterval = get_theme_mod('setting_slider_interval',5000);
        $sliderPause = get_option('setting_slider_pause','1') ? 'hover': '';
        $sliderKeyboard = get_option('setting_slider_keyboard','1') ? 'true': 'false';
        $sliderWrap = get_option('setting_slider_wrap','1') ? 'true': 'false';
        $sliderIndicators = get_option('setting_slider_indicators','1') ? true: false;
       
        for ($i = 1; $i <= 6; $i++) {
            $sliderImage = wp_get_attachment_image_src(absint(get_option('setting_slider_' . $i . '_image')), 'original');
            if ($sliderImage) {
                $sliderData[$i]['image'] = $sliderImage;
                $sliderData[$i]['title'] = get_theme_mod('setting_slider_' . $i . '_title');
                $sliderData[$i]['description'] = get_theme_mod('setting_slider_' . $i . '_description');
                $sliderData[$i]['text_position'] = get_option('setting_slider_' . $i . '_text_position');
                $sliderData[$i]['page'] = get_option('setting_slider_' . $i . '_page');
                $sliderData[$i]['url'] = get_option('setting_slider_' . $i . '_url');
                $colorFgText = get_theme_mod('setting_slider_' . $i . '_text_color');
                if ($colorFgText) {
                    $sliderData[$i]['style'] = ' color: ' . $colorFgText .';';
                } else {
                    $sliderData[$i]['style'] = '';
                }
            }
        }
        
        ?>

        <div class="container"><!-- slider section -->
        <div id="tikvaSlider" class="tikva-slider carousel slide" data-ride="carousel" data-interval="<?php echo $sliderInterval; ?>" data-pause="<?php echo $sliderPause; ?>" data-wrap="<?php echo $sliderWrap; ?>" data-keyboard="<?php echo $sliderKeyboard; ?>" >
        <?php if ($sliderIndicators === true) { ?>
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php
            foreach ($sliderData as $idx => $sliderElement) {
                echo '<li data-target="#tikvaSlider" data-slide-to="';
                echo $idx - 1;
                echo '"';
                if ($idx == 1) {
                    echo ' class="active"';
                }
                echo '></li>' . "\n";
            }
            ?>
        </ol>
        <?php }
        ?>
        <!-- Wrapper for slides -->
            
    
        <div class="carousel-inner">
                
        <?php
        
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
            ?>
            
        </div>
    
        <!-- Controls -->
        <a class="carousel-control-prev" href="#tikvaSlider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only"><?php echo  __( 'Previous', 'tikva' ); ?></span>
        </a>
        <a class="carousel-control-next" href="#tikvaSlider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only"><?php echo  __( 'Next', 'tikva' ); ?></span>
        </a>
    </div>
    </div><!-- end slider section -->

            <?php
    }

    public static function addSliderStyle()
    {
        wp_enqueue_style(
                'tikva-default-style', get_template_directory_uri() . '/css/default.css'
        );
        $custom_css = "
                .carousel-caption-left {
                text-align: left !important;
            }
            .carousel-caption-right {
                text-align: right !important;
            }
            .tikva-slider {
                margin-bottom: 10px;
            }";
        
        wp_add_inline_style('tikva-default-style', $custom_css);
    }

}


