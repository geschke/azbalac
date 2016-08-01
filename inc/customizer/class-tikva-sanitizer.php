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
class Tikva_Sanitizer
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

    public function sanitizeLayout($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3)
            return 2;
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
        $stylesheets = getAvailableStylesheets();
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
