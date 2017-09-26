<?php

/**
 * Implements Content Sections functionality.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.5.0
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Content_Column
{

    const MAX_COLUMNS = 12;

    /* Add Custom Footer Layout */

    public static function build()
    {
        $introActivate =  get_option('setting_introduction_area_activate');
        $introTitle = get_theme_mod('setting_introduction_area_title');
        $introSubtitle = get_theme_mod('setting_introduction_area_subtitle');
        $introElements = json_decode(urldecode(get_theme_mod('setting_introduction_area_elements')));
      //echo "<pre>";
      //var_dump($introActivate);
      //die;
      //print_r($introTitle);
      //print_r($introSubtitle);
      //print_r($introElements);
      //echo count($introElements);
      
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
      //echo "ColumnClass: $columnClass";
        ?>
        <div class="container tikva-introduction">

        <section class="section-introduction" id="section-introduction">
          <?php if ($introTitle || $introSubtitle) { ?>
          <div class="container">
				    <div class="row">
              <div class="col-md-8 col-md-offset-2">
              <?php if ($introTitle) { ?><h2 class="section-title"><?php echo $introTitle ?></h2><?php } ?>
              <?php if ($introSubtitle) { ?><h5 class="section-description"><?php echo $introSubtitle ?></h5><?php } ?>
						  </div>
            </div>
          </div>
          <?php } ?>
        <div class="row">
        <?php

        foreach ($introElements as $element) {
            //var_dump($element);
            self::showElement($element, $columnClass);
        }
     
        ?>
        </div><!-- /.row -->
      </section>
      </div>
        <?php
    }


    protected static function showElement($element, $columnClass)
    {
      $header = '';
      $title = '';
      $content = '';
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
          <i style="' . $colorStyle . '" class="fa fa-4x ' . $element->elements->icon->value . '"></i>
        </div>';
        } elseif (isset($element->elements->image)) {
          $imageShape = '2'; // default circle
          if (isset($element->elements->image_shape)) {
            $imageShape = $element->elements->image_shape->value;
          }
          switch ($imageShape) {
            case '1': // rounded corners
                $imgClass = 'img-rounded';
            break;
            case '2': // circle
                $imgClass = 'img-circle';
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
       
        printf('<div class="col-lg-%d col-md-%d col-sm-%d introduction-box">', $columnClass, $columnClass, $columnClass);
        ?>
                  <?php echo $header; ?>
                  <h2><?php echo $title; ?></h2>
                  <p><?php echo $content; ?></p>
                  <p><a class="btn btn-default" href="<?php echo $url; ?>" role="button">View details &raquo;</a></p>


                     
      
        <?php
        printf(' </div><!-- /.col-lg-%d -->', $columnClass);
    }
}
