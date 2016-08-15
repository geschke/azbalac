<?php

/**
 * Implements Customizer functionality.
 *
 * Add custom sections and settings to the Customizer.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4.2
 * @copyright Copyright (c) 2016, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Footer
{
    /* Assign function for widget areas */

    private static function initializeFooterWidget($footerNumber)
    {
        echo '<div  class="widget-area">';
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
        echo "footerLayout: $footerLayout // activate: $footerActivate";

        if ($footerActivate == "1" and ! empty($footerLayout)) {
            echo '<div id="footer">';
            if ($footerLayout == 1) {
                echo '<div id="footer-core" class="option1">';
                self::initializeFooterWidget(1);
                echo '</div>';
            } else if ($footerLayout == 2) {
                echo '<div id="footer-core" class="option2">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                echo '</div>';
            } else if ($footerLayout == 3) {
                echo '<div id="footer-core" class="option3">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                echo '</div>';
            } else if ($footerLayout == 4) {
                echo '<div id="footer-core" class="option4">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);
                echo '</div>';
            } else if ($footerLayout == 5) {
                echo '<div id="footer-core" class="option5">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);
                self::initializeFooterWidget(5);
                echo '</div>';
            } else if ($footerLayout == 6) {
                echo '<div id="footer-core" class="option6">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);
                self::initializeFooterWidget(5);
                self::initializeFooterWidget(6);

                echo '</div>';
            } else if ($footerLayout == 7) {
                echo '<div id="footer-core" class="option7">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 8) {
                echo '<div id="footer-core" class="option8">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 9) {
                echo '<div id="footer-core" class="option9">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 10) {
                echo '<div id="footer-core" class="option10">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 11) {
                echo '<div id="footer-core" class="option11">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 12) {
                echo '<div id="footer-core" class="option12">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);

                echo '</div>';
            } else if ($footerLayout == 13) {
                echo '<div id="footer-core" class="option13">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);

                echo '</div>';
            } else if ($footerLayout == 14) {
                echo '<div id="footer-core" class="option14">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);

                echo '</div>';
            } else if ($footerLayout == 15) {
                echo '<div id="footer-core" class="option15">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);

                echo '</div>';
            } else if ($footerLayout == 16) {
                echo '<div id="footer-core" class="option16">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);

                echo '</div>';
            } else if ($footerLayout == 17) {
                echo '<div id="footer-core" class="option17">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);
                self::initializeFooterWidget(5);

                echo '</div>';
            } else if ($footerLayout == 18) {
                echo '<div id="footer-core" class="option18">';
                self::initializeFooterWidget(1);
                self::initializeFooterWidget(2);
                self::initializeFooterWidget(3);
                self::initializeFooterWidget(4);
                self::initializeFooterWidget(5);


                echo '</div>';
            }
            echo '</div>';
        }
    }

}
