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
        <div class="container azbalac-introduction-section my-4 py-4" style="<?php echo $styleColorBg; ?>">
            <div class="azbalac-introduction container ">

        <section class="section-introduction" id="section-introduction">
          <?php if ($introTitle || $introSubtitle) { ?>
				    <div class="row">
              <div class="col-md-8 offset-md-2">
              <?php if ($introTitle) { ?><h2 class="section-title"><?php echo $introTitle ?></h2><?php } ?>
              <?php if ($introSubtitle) { ?><h5 class="section-subtitle"><?php echo $introSubtitle ?></h5><?php } ?>
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
        $introElements = json_decode(urldecode(get_theme_mod('azbalac_setting_introduction_area_elements')));

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
        if (isset($element->elements->post)) {
            $url = get_permalink($element->elements->post->value);
        } elseif (isset($element->elements->page)) {
            $url = get_page_link($element->elements->page->value);
        } elseif (isset($element->elements->url)) {
            $url = $element->elements->url->value;
        } else {
            $url = '#';
        }
        if (isset($element->elements->icon)) {
            $colorStyle = '';
            if (isset($element->elements->color_icon)) {
                $iconColor = $element->elements->color_icon->value;
            
                if ($iconColor) {
                    $colorStyle = 'color: ' . $iconColor . ';';
                }      
            }
  

          $header = '
          <div class="icon">
          <i style="font-size: 4rem; ' . $colorStyle . '" class="bi bi-' . $element->elements->icon->value . '"></i>
        </div>';
        } elseif (isset($element->elements->image)) {
          $imageShape = '2'; // default circle
          if (isset($element->elements->image_shape)) {
            $imageShape = $element->elements->image_shape->value;
          }
          switch ($imageShape) {
            case '1': // rounded corners
                $imgClass = 'rounded';
            break;
            case '2': // circle
                $imgClass = 'rounded-circle';
            break;
            case '3': // thumbnail
                $imgClass = 'img-thumbnail';
            break;
            default: // no image shape
                $imgClass = '';
            break;
          }
          $attr = array('class' => $imgClass);
          $image = wp_get_attachment_image($element->elements->image->value,'thumbnail',false,$attr);
          $header = $image;
        }
       
        $output .= sprintf('<div class="col-lg-%d col-md-%d col-sm-%d introduction-box">', $columnClass, $columnClass, $columnClass);

        $output .= '<a href="' . $url . '">' . $header . '</a>';
        $output .= '<h2><a class="section-introduction-url" href="' . $url . '">' . $title . '</a></h2>';
        $output .= '<p>' . $content . '</p>';
        if (!self::$disableReadMore) { 
            $output .= '<p><a class="btn btn-primary" href="' . $url .'" role="button">' . __("Read more &raquo;",'azbalac') . '</a></p>';
        }
        $output .= sprintf(' </div><!-- /.col-lg-%d -->', $columnClass);
        return $output;
    }
}
