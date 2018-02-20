<?php

/**
 * Implements Additional Widgets functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.2
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Widgets
{
    /* Assign function for widget areas */

    private static function initializeWidget($widgetId)
    {
        $output = '';
        if (!is_active_sidebar($widgetId)) {
            return $output;

        } else {
            ob_start();
            dynamic_sidebar($widgetId);
            $output .= ob_get_clean();
        }
        return $output;
    }
     

  

    public static function get($widgetId)
    {
        $output = '';
        $output .= self::initializeWidget($widgetId);
        return $output;
    }

   

}
