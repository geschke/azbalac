<?php

/**
 * Implements Content Sections functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Content_Column
{

    const MAX_COLUMNS = 12;

    protected static $disableReadMore = false;

    public static function getIntroductionTitle()
    {
        return get_theme_mod('azbalac_setting_introduction_area_title');
    }

    public static function getIntroductionSubtitle()
    {
        return get_theme_mod('azbalac_setting_introduction_area_subtitle');
    }

    public static function getIntroductionElements($position) 
    {
      
        ob_start();
        self::showIntroductionElements($position);
        $output = ob_get_clean();
        return $output;
    }

    public static function showIntroductionElements($position) 
    {
        $introActive =  get_option('azbalac_setting_introduction_area_activate',0);
        //echo "active? " . $introActivate;
        if (intval($introActive) !== 1) {
          return '';
        }
       
        if (get_option('azbalac_setting_introduction_position',2) != $position) {
          return '';
        }
        self::build();
    }

    public static function build()
    {
       
        $introTitle = get_theme_mod('azbalac_setting_introduction_area_title');
        $introSubtitle = get_theme_mod('azbalac_setting_introduction_area_subtitle');
       
        $colorBgData = get_theme_mod('azbalac_setting_introduction_area_color_bg');
        
        if ($colorBgData) {
            $styleColorBg = ' background-color: ' . $colorBgData . ';';
        } else {
            $styleColorBg = '';
        }
   
        ?>
        <div class="container azbalac-introduction-section my-4 py-4" style="<?php echo esc_attr($styleColorBg); ?>">
            <div class="azbalac-introduction container ">

        <section class="section-introduction" id="section-introduction">
          <?php if ($introTitle || $introSubtitle) { ?>
				    <div class="row">
              <div class="col-md-8 offset-md-2">
              <?php if ($introTitle) { ?><h2 class="section-title"><?php echo esc_html($introTitle); ?></h2><?php } ?>
              <?php if ($introSubtitle) { ?><h5 class="section-subtitle"><?php echo esc_html($introSubtitle); ?></h5><?php } ?>
						  </div>
          </div>
          <?php 
          } 

          echo self::getElementBox();
          ?>
          </section>
        </div>
        </div>
        <?php
    }

    public static function getElementBox($withRow = true)
    {
        $output = '';
        $introElements = json_decode(
            rawurldecode((string) get_theme_mod('azbalac_setting_introduction_area_elements', ''))
        );

        $disableReadMore = get_option('azbalac_setting_introduction_area_readmore', 0);
        if (intval($disableReadMore) === 1) {
            self::$disableReadMore = true;
        }

        if (is_object($introElements)) {
            $numberElements = count(get_object_vars($introElements));
        } else {
            $numberElements = 0;
        }
        if (!$numberElements) {
            return;
        }
        $columnClass = floor(self::MAX_COLUMNS / $numberElements); // intdiv

        if ($numberElements % self::MAX_COLUMNS > 0) {
            // do something?
        }

        if ($withRow) $output .= '<div class="row section-introduction-elements">';

        foreach ($introElements as $element) {
            $output .= self::showElement($element, $columnClass);
        }
     
        if ($withRow) $output .= '</div><!-- /.row -->';
        return $output;
    }

    protected static function showElement($element, $columnClass)
    {
        $header = '';
        $title = '';
        $content = '';
        $output = '';
        if (isset($element->elements->title->value)) {
            $title = $element->elements->title->value;
        }
        if (isset($element->elements->content->value)) {
            $content = $element->elements->content->value;
        }
        $postId = isset($element->elements->post->value)
            ? absint($element->elements->post->value)
            : 0;
        $pageId = isset($element->elements->page->value)
            ? absint($element->elements->page->value)
            : 0;
        $customUrl = isset($element->elements->url->value)
            ? esc_url_raw($element->elements->url->value)
            : '';

        if ($postId > 0) {
            $url = get_permalink($postId);
        } elseif ($pageId > 0) {
            $url = get_page_link($pageId);
        } elseif ($customUrl !== '') {
            $url = $customUrl;
        } else {
            $url = '#';
        }

        $url = $url ? esc_url($url) : '#';
        $icon = '';
        if (isset($element->elements->icon->value)) {
            $icon = sanitize_key($element->elements->icon->value);
        }

        $imageId = 0;
        if (isset($element->elements->image->value)) {
            $imageId = absint($element->elements->image->value);
        }

        if ($icon !== '' && $icon !== '0') {
            $iconColor = '';
            if (isset($element->elements->color_icon->value)) {
                $iconColor = sanitize_hex_color($element->elements->color_icon->value);

                if ($iconColor === null) {
                    $iconColor = '';
                }
            }

            $iconStyle = 'font-size: 4rem;';
            if ($iconColor !== '') {
                $iconStyle .= ' color: ' . $iconColor . ';';
            }

            $header = sprintf(
                '<div class="icon"><i style="%s" class="bi bi-%s"></i></div>',
                esc_attr($iconStyle),
                esc_attr($icon)
            );
        } elseif ($imageId > 0) {
            $imageClasses = array(
                '1' => 'rounded',
                '2' => 'rounded-circle',
                '3' => 'img-thumbnail',
                '4' => '',
            );
            $imageShape = isset($element->elements->image_shape->value)
                ? (string) $element->elements->image_shape->value
                : '2';
            $imgClass = isset($imageClasses[$imageShape])
                ? $imageClasses[$imageShape]
                : $imageClasses['2'];
            $attr = array('class' => $imgClass);
            $header = wp_get_attachment_image($imageId, 'thumbnail', false, $attr);
        }
       
        $output .= sprintf('<div class="col-lg-%d col-md-%d col-sm-%d mb-2 introduction-box">', $columnClass, $columnClass, $columnClass);

        $output .= '<a href="' . esc_url($url) . '">' . $header . '</a>';
        $output .= '<h2><a class="section-introduction-url" href="' . esc_url($url) . '">' . esc_html($title) . '</a></h2>';
        $output .= '<div class="introduction-content">' . wp_kses_post($content) . '</div>';
        if (!self::$disableReadMore) { 
            $output .= sprintf(
                '<p><a class="btn btn-primary" href="%s" role="button">%s</a></p>',
                esc_url($url),
                wp_kses_post(__("Read more &raquo;", 'azbalac'))
            );
        }
        $output .= sprintf(' </div><!-- /.col-lg-%d -->', $columnClass);
        return $output;
    }
}
