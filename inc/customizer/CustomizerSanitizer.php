<?php

/**
 * Implements Sanitizer functionality.
 *
 *
 * @package   WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Customizer_Sanitizer
{

    public function sanitizeCheckbox($input)
    {
        if ($input == 1) {
            return 1;
        } else {
            return '';
        }
    }

    public function sanitizeInteger($input)
    {
        $input = absint($input);
        if (is_numeric($input)) {
            return intval($input);
        }
        return 0;
    }

    public function sanitizeFeaturedArticles($input)
    {
        $input = intval($input);

        if ($input < 0 || $input > 100) {
            return 10;
        }
        return $input;
    }

    public function sanitizeSocialMediaPosition($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }

    public function sanitizeSocialMediaAlignment($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }
    
    public function sanitizeSocialButtonSize($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }
    
    public function sanitizeSocialButtonType($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 2) {
            return 1;
        }
        return $input;
    }

    public function sanitizeLayout($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }
    
    public function sanitizeIntroductionElements($input)
    {
        return $this->sanitizeRange($input, 0, 0, 6);
    }
    
    public function sanitizeFooterLayout($input)
    {
        return $this->sanitizeRange($input, 3, 1, 18);
    }

    public function sanitizeRange($input, $default, $start, $end)
    {
        $input = absint($input);
        if ($input < $start || $input > $end) {
            return $default;
        }
        return $input;
    }
    
    public function sanitizeNavbarStyle($input)
    {
        if ($input == 'dark') {
            return $input;
        }
        return 'light';
    }

    public function sanitizeNavbarFixed($input)
    {
        if ($input == 'fixed-top') {
            return $input;
        }
        return 'default';
    }

    public function sanitizeLogoPosition($input)
    {
        // default == 1 == left
        return $this->sanitizeRange($input, 1, 1, 3);
    }

    public function sanitizeStylesheet($input)
    {
        $stylesheets = Azbalac_Customizer::getAvailableStylesheets();
        if (!in_array($input, $stylesheets)) {
            return 'slate_accessibility_ready.min.css';
        }
        return $input;
    }

    public function sanitizeSliderTextPosition($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }

    public function sanitizeSliderPosition($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 4) {
            return 2;
        }
        return $input;
    }

    public function sanitizeHtml($input)
    {
        return wp_kses( $input, array( 
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'i' => array(),
            'p' => array(),
            'strong' => array(),
            'li' => array(),
            'ul' => array(),
            'div' => array(
                'class' => array(),
                'id' => array(),
            )
        ) );
    }

    /**
    * Sanitizer function from
    * https://github.com/cristian-ungureanu/customizer-repeater/blob/production/inc/customizer.php
    * This does not really sanitize the input values, only guarantees allowed HTML tags for post.
    * Maybe this will be removed in a future version.
    *
    * @var $input Input string
    */
    public function sanitizeRepeater($input)
    {
        $input_decoded = json_decode($input, true);
       
        if (empty($input_decoded)) {
            return $input;
        }
        foreach ($input_decoded as $boxk => $box) {
            foreach ($box as $key => $value) {
                $input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
            }
        }
        return json_encode($input_decoded);
        
    }


    public function sanitizeFont($input)
    {
        return $input;
/*        $input_decoded = json_decode($input, true);
       
        if (empty($input_decoded)) {
            return $input;
        }
        foreach ($input_decoded as $boxk => $box) {
            foreach ($box as $key => $value) {
                $input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
            }
        }
        return json_encode($input_decoded);
 */       
    }
}
