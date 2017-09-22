<?php

/**
 * Implements Footer functionality.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.5.0
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Content_Column
{

    /* Add Custom Footer Layout */

    public static function build()
    {
        ?>
      
        <div class="container marketing">
        
              <!-- Three columns of text below the carousel -->
              <div class="row">
                <div class="col-lg-4 col-md-4  col-sm-4">
                  <img class="img-circle" src="http://test.geschke.net/wp-content/themes/tikva/images/tikva_default_header_image.jpg" alt="Generic placeholder image" width="140" height="140">
                  <h2>Heading</h2>
                  <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4 col-md-4  col-sm-4">
                  <img class="img-circle" src="http://test.geschke.net/wp-content/themes/tikva/images/tikva_default_header_image.jpg" alt="Generic placeholder image" width="140" height="140">
                  <h2>Heading</h2>
                  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4  col-md-4 col-sm-4">
                  <img class="img-circle" src="http://test.geschke.net/wp-content/themes/tikva/images/tikva_default_header_image.jpg" alt="Generic placeholder image" width="140" height="140">
                  <h2>Heading</h2>
                  <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
              </div><!-- /.row -->
        
        

        <?php
       
    }


}
