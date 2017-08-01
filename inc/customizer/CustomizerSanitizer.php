<?php

/**
 * Implements Sanitizer functionality.
 *
 * 
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4
 * @copyright Copyright (c) 2016, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Customizer_Sanitizer
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
        if ($input < 1 || $input > 3)
            return 2;
        return $input;
    }

    public function sanitizeSocialMediaAlignment($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3)
            return 2;
        return $input;
    }
    
    public function sanitizeSocialButtonSize($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3)
            return 2;
        return $input;
    }
    
    public function sanitizeSocialButtonType($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 2)
            return 1;
        return $input;
    }

    public function sanitizeLayout($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3)
            return 2;
        return $input;
    }
    
    public function sanitizeIntroductionElements($input) {
        return $this->sanitizeRange($input, 0, 0, 6);
    }
    
    public function sanitizeFooterLayout($input)
    {
        return $this->sanitizeRange($input,3, 1,18);
    }

    public function sanitizeRange($input, $default, $start, $end)
    {
        $input = absint($input);
        if ($input < $start || $input > $end) {
            return $default;
        }
        return $input;
    }
    
    public function sanitizeNavbarStyleInverse($input)
    {
        if ($input == 'inverse')
            return $input;
        return 'default';
    }

    public function sanitizeNavbarFixed($input)
    {
        if ($input == 'fixed-top') {
            return $input;
        }
        return 'default';
    }

    public function sanitizeStylesheet($input)
    {
        $stylesheets = Tikva_Customizer::getAvailableStylesheets();
        if (!in_array($input, $stylesheets)) {
            return 'slate_accessibility_ready.min.css';
        }
        return $input;
    }

    public function sanitizeSliderTextPosition($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3)
            return 2;
        return $input;
    }

    public function sanitizeSliderPosition($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 4)
            return 2;
        return $input;
    }

}