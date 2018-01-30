<?php

/**
 * Implements Footer functionality.
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Section_Footer
{
    /* Assign function for widget areas */

    private static function initializeFooterWidget($footerNumber, $columns)
    {
        $output = '';
        $output .= sprintf('<div class="widget-area col-md-%d col-sm-%d">', $columns, $columns);
        if (!is_active_sidebar(sprintf("footer-sidebar-%d", $footerNumber))) {
            $output .= '<h3 class="widget-title">' . __('Please Add Widgets', 'azbalac') . '</h3>' .
            '<div class="error-icon">' .
            '<p>' . sprintf(__('Remove this message by adding widgets to Footer Widget Area #%d.', 'azbalac'), $footerNumber) . '</p>' .
            '<a href="' . esc_url(admin_url('widgets.php')) . '" title="' . __('No Widgets Selected', 'azbalac') . '">' . __('Click here to go to Widget area.', 'azbalac') . '</a>' . '</div>';
        } else {
            ob_start();
            dynamic_sidebar(sprintf("footer-sidebar-%d", $footerNumber));
            $output .= ob_get_clean();
        }
        $output .= '</div>';
        return $output;
    }
     

    /* Add Custom Footer Layout */

    public static function build()
    {
        echo self::get();
    }

    public static function get()
    {
        $output = '';
        $footerLayout = get_option('setting_footer_layout',3); // 3 is default, three columns with the same width
        $footerActivate = get_option('setting_footer_activate',1);
       

        if (intval($footerActivate) === 1 and ! empty($footerLayout)) {
            $output .= '<div class="row" style="padding: 10px; 0px; 10px;" id="footer">';
            if ($footerLayout == 1) {
                $output .= self::initializeFooterWidget(1, 12);
            } else if ($footerLayout == 2) {

                $output .= self::initializeFooterWidget(1, 6);
                $output .= self::initializeFooterWidget(2, 6);
            } else if ($footerLayout == 3) {
                $output .= self::initializeFooterWidget(1, 4);
                $output .= self::initializeFooterWidget(2, 4);
                $output .= self::initializeFooterWidget(3, 4);
            } else if ($footerLayout == 4) {
                $output .= self::initializeFooterWidget(1, 3);
                $output .= self::initializeFooterWidget(2, 3);
                $output .= self::initializeFooterWidget(3, 3);
                $output .= self::initializeFooterWidget(4, 3);
            } else if ($footerLayout == 5) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 2);
                $output .= self::initializeFooterWidget(3, 4);
                $output .= self::initializeFooterWidget(4, 2);
                $output .= self::initializeFooterWidget(5, 2);
            } else if ($footerLayout == 6) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 2);
                $output .= self::initializeFooterWidget(3, 2);
                $output .= self::initializeFooterWidget(4, 2);
                $output .= self::initializeFooterWidget(5, 2);
                $output .= self::initializeFooterWidget(6, 2);
            } else if ($footerLayout == 7) {
                $output .= self::initializeFooterWidget(1, 4);
                $output .= self::initializeFooterWidget(2, 8);
            } else if ($footerLayout == 8) {
                $output .= self::initializeFooterWidget(1, 8);
                $output .= self::initializeFooterWidget(2, 4);
            } else if ($footerLayout == 9) {
                $output .= self::initializeFooterWidget(1, 3);
                $output .= self::initializeFooterWidget(2, 9);
            } else if ($footerLayout == 10) {
                $output .= self::initializeFooterWidget(1, 9);
                $output .= self::initializeFooterWidget(2, 3);
            } else if ($footerLayout == 11) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 10);
            } else if ($footerLayout == 12) {
                $output .= self::initializeFooterWidget(1, 10);
                $output .= self::initializeFooterWidget(2, 2);
            } else if ($footerLayout == 13) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 2);
                $output .= self::initializeFooterWidget(3, 2);
                $output .= self::initializeFooterWidget(4, 6);
            } else if ($footerLayout == 14) {
                $output .= self::initializeFooterWidget(1, 6);
                $output .= self::initializeFooterWidget(2, 2);
                $output .= self::initializeFooterWidget(3, 2);
                $output .= self::initializeFooterWidget(4, 2);
            } else if ($footerLayout == 15) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 4);
                $output .= self::initializeFooterWidget(3, 6);
            } else if ($footerLayout == 16) {
                $output .= self::initializeFooterWidget(1, 6);
                $output .= self::initializeFooterWidget(2, 4);
                $output .= self::initializeFooterWidget(3, 2);
            } else if ($footerLayout == 17) {
                $output .= self::initializeFooterWidget(1, 3);
                $output .= self::initializeFooterWidget(2, 3);
                $output .= self::initializeFooterWidget(3, 2);
                $output .= self::initializeFooterWidget(4, 2);
                $output .= self::initializeFooterWidget(5, 2);
            } else if ($footerLayout == 18) {
                $output .= self::initializeFooterWidget(1, 2);
                $output .= self::initializeFooterWidget(2, 2);
                $output .= self::initializeFooterWidget(3, 2);
                $output .= self::initializeFooterWidget(4, 3);
                $output .= self::initializeFooterWidget(5, 3);
            }
            $output .=  '</div>';
        }
        return $output;
    }

    public static function getStyles()
    {
        $colorBgFooterData = get_theme_mod('color_bg_footer');

        if ($colorBgFooterData) {
            $footerStyleColorBg = ' background-color: ' . $colorBgFooterData . ';';
        } else {
            $footerStyleColorBg = '';
        }

        $colorFgFooterData = get_theme_mod('color_fg_footer');

        if ($colorFgFooterData) {
            $footerStyleColorFg = ' color: ' . $colorFgFooterData . ';';
        } else {
            $footerStyleColorFg = '';
        }
        return array(
            'footerStyleColorBg' => $footerStyleColorBg,
            'footerStyleColorFg' => $footerStyleColorFg
        );
    }

}
