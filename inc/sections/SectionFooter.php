<?php

/**
 * Implements Footer functionality.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4.2
 * @copyright Copyright (c) 2016, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Section_Footer
{
    /* Assign function for widget areas */

    private static function initializeFooterWidget($footerNumber, $columns)
    {
        printf('<div class="widget-area col-md-%d col-sm-%d">', $columns, $columns);
        if (!dynamic_sidebar(sprintf("footer-sidebar-%d", $footerNumber))) {
            echo '<h3 class="widget-title">' . __('Please Add Widgets', 'tikva') . '</h3>',
            '<div class="error-icon">',
            '<p>' . sprintf(__('Remove this message by adding widgets to Footer Widget Area #%d.', 'tikva'), $footerNumber) . '</p>',
            '<a href="' . esc_url(admin_url('widgets.php')) . '" title="No Widgets Selected">' . __('Click here to go to Widget area.', 'tikva') . '</a>',
            '</div>';
        };
        echo '</div>';
    }
     

    /* Add Custom Footer Layout */

    public static function build()
    {

        $footerLayout = get_option('setting_footer_layout');
        $footerActivate = get_option('setting_footer_activate');
        //echo "footerLayout: $footerLayout // activate: $footerActivate";

        if ($footerActivate == "1" and ! empty($footerLayout)) {
            echo '<div class="row" style="padding: 10px; 0px; 10px;" id="footer">';
            if ($footerLayout == 1) {
                self::initializeFooterWidget(1, 12);
            } else if ($footerLayout == 2) {

                self::initializeFooterWidget(1, 6);
                self::initializeFooterWidget(2, 6);
            } else if ($footerLayout == 3) {
                self::initializeFooterWidget(1, 4);
                self::initializeFooterWidget(2, 4);
                self::initializeFooterWidget(3, 4);
            } else if ($footerLayout == 4) {
                self::initializeFooterWidget(1, 3);
                self::initializeFooterWidget(2, 3);
                self::initializeFooterWidget(3, 3);
                self::initializeFooterWidget(4, 3);
            } else if ($footerLayout == 5) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 2);
                self::initializeFooterWidget(3, 4);
                self::initializeFooterWidget(4, 2);
                self::initializeFooterWidget(5, 2);
            } else if ($footerLayout == 6) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 2);
                self::initializeFooterWidget(3, 2);
                self::initializeFooterWidget(4, 2);
                self::initializeFooterWidget(5, 2);
                self::initializeFooterWidget(6, 2);
            } else if ($footerLayout == 7) {
                self::initializeFooterWidget(1, 4);
                self::initializeFooterWidget(2, 8);
            } else if ($footerLayout == 8) {
                self::initializeFooterWidget(1, 8);
                self::initializeFooterWidget(2, 4);
            } else if ($footerLayout == 9) {
                self::initializeFooterWidget(1, 3);
                self::initializeFooterWidget(2, 9);
            } else if ($footerLayout == 10) {
                self::initializeFooterWidget(1, 9);
                self::initializeFooterWidget(2, 3);
            } else if ($footerLayout == 11) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 10);
            } else if ($footerLayout == 12) {
                self::initializeFooterWidget(1, 10);
                self::initializeFooterWidget(2, 2);
            } else if ($footerLayout == 13) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 2);
                self::initializeFooterWidget(3, 2);
                self::initializeFooterWidget(4, 6);
            } else if ($footerLayout == 14) {
                self::initializeFooterWidget(1, 6);
                self::initializeFooterWidget(2, 2);
                self::initializeFooterWidget(3, 2);
                self::initializeFooterWidget(4, 2);
            } else if ($footerLayout == 15) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 4);
                self::initializeFooterWidget(3, 6);
            } else if ($footerLayout == 16) {
                self::initializeFooterWidget(1, 6);
                self::initializeFooterWidget(2, 4);
                self::initializeFooterWidget(3, 2);
            } else if ($footerLayout == 17) {
                self::initializeFooterWidget(1, 3);
                self::initializeFooterWidget(2, 3);
                self::initializeFooterWidget(3, 2);
                self::initializeFooterWidget(4, 2);
                self::initializeFooterWidget(5, 2);
            } else if ($footerLayout == 18) {
                self::initializeFooterWidget(1, 2);
                self::initializeFooterWidget(2, 2);
                self::initializeFooterWidget(3, 2);
                self::initializeFooterWidget(4, 3);
                self::initializeFooterWidget(5, 3);
            }
            echo '</div>';
        }
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
