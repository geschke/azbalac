<?php

/**
 * Implements Sanitizer functionality.
 *
 *
 * @package Azbalac_One
 * @since 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Customizer_Sanitizer
{

    public function sanitizeCheckbox($input)
    {
        return in_array($input, array(true, 1, '1'), true);
    }

    public function sanitizeInteger($input)
    {
        $input = absint($input);
        if (is_numeric($input)) {
            return intval($input);
        }
        return 0;
    }

    public function validateSliderPage($validity, $value)
    {
        return $this->validateSliderPostReference(
            $validity,
            $value,
            'page',
            __('The selected slider page does not exist or is not a valid page.', 'azbalac-one')
        );
    }

    public function validateSliderPost($validity, $value)
    {
        return $this->validateSliderPostReference(
            $validity,
            $value,
            'post',
            __('The selected slider post does not exist or is not a valid post.', 'azbalac-one')
        );
    }

    private function validateSliderPostReference($validity, $value, $postType, $message)
    {
        if ($value === '' || $value === null || $value === 0 || $value === '0') {
            return $validity;
        }

        $postId = filter_var(
            $value,
            FILTER_VALIDATE_INT,
            array('options' => array('min_range' => 1))
        );

        if ($postId === false) {
            $validity->add('invalid_slider_reference', $message);
            return $validity;
        }

        $post = get_post($postId);

        if (
            !($post instanceof WP_Post)
            || $post->post_type !== $postType
            || in_array($post->post_status, array('trash', 'auto-draft'), true)
        ) {
            $validity->add('invalid_slider_reference', $message);
        }

        return $validity;
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

    public function sanitizeNavbarMenuAlignment($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 3) {
            return 2;
        }
        return $input;
    }

    public function sanitizeNavbarWhitespace($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 5) {
            return 1;
        }
        return $input;
    }

    public function sanitizeNavbarTopSpacing($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 30) { // rem is value / 2, so 15 rem should be enough
            return 9; // 4.5 rem
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
        if ($input < 0 || $input > 4) {
            return 0;
        }
        return $input;
    }

    public function sanitizeSocialButtonBorderWidth($input)
    {
        $input = absint($input);
        if ($input < 1 || $input > 5) {
            return "3";
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

    public function sanitizeNavbarBg($input)
    {
        $colors = ['bg-primary','bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 
            'bg-dark', 'bg-white'];

        if (!in_array($input, $colors)) {
                return 'default';
            }
        return $input;
    }

    public function sanitizeBootstrapColorSet($input)
    {
        $colors = ['primary','secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'white'];
        if (!in_array($input, $colors)) {
                return 'default';
            }
        return $input;
    }


    public function sanitizeNavbarFixed($input)
    {
        if ($input == 'fixed-top' || $input == 'top-aligned') {
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
        return wp_kses_post($input); // everything what is allowed in post type should be allowed here
        /*return wp_kses( $input, array( 
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'i' => array(),
            'p' => array(),
            'strong' => array(),
            'small' => array(),
            'li' => array(),
            'ul' => array(),
            'div' => array(
                'class' => array(),
                'id' => array(),
                'style' => array(),
            )
        ) );*/
    }

    /**
     * Sanitize the nested data produced by the introduction-area repeater.
     *
     * @param string $input URI-encoded JSON repeater data.
     * @return string Sanitized URI-encoded JSON repeater data.
     */
    public function sanitizeRepeater($input)
    {
        if (!is_string($input) || $input === '') {
            return '';
        }

        $decoded_input = rawurldecode($input);
        $input_decoded = json_decode($decoded_input, true);

        if (
            json_last_error() !== JSON_ERROR_NONE
            || !is_array($input_decoded)
        ) {
            return '';
        }

        $allowed_fields = array(
            'title' => 'text',
            'content' => 'textarea',
            'icon' => 'select',
            'image' => 'image',
            'page' => 'dropdown-pages',
            'post' => 'dropdown-pages',
            'url' => 'text',
            'color_icon' => 'colorpicker',
            'image_shape' => 'radiobutton',
        );

        $sanitized_elements = array();

        foreach ($input_decoded as $element_id => $element) {
            if (
                !is_array($element)
                || !isset($element['elements'])
                || !is_array($element['elements'])
            ) {
                continue;
            }

            $sanitized_element_id = sanitize_key($element_id);

            if ($sanitized_element_id === '') {
                continue;
            }

            $sanitized_elements[$sanitized_element_id] = array(
                'elements' => array(),
            );

            foreach ($element['elements'] as $field_name => $field) {
                if (
                    !isset($allowed_fields[$field_name])
                    || !is_array($field)
                    || !array_key_exists('value', $field)
                    || !is_scalar($field['value'])
                ) {
                    continue;
                }

                $field_value = (string) $field['value'];

                switch ($field_name) {
                    case 'title':
                        $field_value = sanitize_text_field($field_value);
                        break;

                    case 'content':
                        $field_value = wp_kses_post($field_value);
                        break;

                    case 'icon':
                        $field_value = $this->sanitizeBootstrapIcon($field_value);
                        break;

                    case 'image':
                    case 'page':
                    case 'post':
                        $field_value = absint($field_value);
                        break;

                    case 'url':
                        $field_value = esc_url_raw($field_value);
                        break;

                    case 'color_icon':
                        $field_value = sanitize_hex_color($field_value);

                        if ($field_value === null) {
                            $field_value = '';
                        }
                        break;

                    case 'image_shape':
                        if (
                            !in_array(
                                $field_value,
                                array('1', '2', '3', '4'),
                                true
                            )
                        ) {
                            $field_value = '2';
                        }
                        break;
                }

                $sanitized_elements[$sanitized_element_id]['elements'][$field_name] = array(
                    'type' => $allowed_fields[$field_name],
                    'name' => $field_name,
                    'value' => $field_value,
                );
            }
        }

        $sanitized_json = wp_json_encode($sanitized_elements);

        if ($sanitized_json === false) {
            return '';
        }

        return rawurlencode($sanitized_json);
    }

    private function sanitizeBootstrapIcon($input)
    {
        $icon = sanitize_key($input);

        if ($icon === '' || $icon === '0') {
            return '0';
        }

        $iconFile = get_template_directory() . '/css/icons/bootstrap-icons.json';

        if (!is_readable($iconFile)) {
            return '0';
        }

        $iconJson = file_get_contents($iconFile);

        if ($iconJson === false) {
            return '0';
        }

        $icons = json_decode($iconJson, true);

        if (!is_array($icons) || !array_key_exists($icon, $icons)) {
            return '0';
        }

        return $icon;
    }




    public function sanitizeFont($input)
    {
        if (!is_string($input) || $input === '') {
            return '';
        }

        $fontSetting = json_decode(rawurldecode($input), true);

        if (
            !is_array($fontSetting)
            || !array_key_exists('font', $fontSetting)
            || !is_scalar($fontSetting['font'])
        ) {
            return '';
        }

        $font = (string) $fontSetting['font'];
        $sanitizedFont = array(
            'font' => 0,
            'size' => isset($fontSetting['size']) ? min(absint($fontSetting['size']), 120) : 0,
            'gglfont' => false,
        );

        if ($font === '' || $font === '0') {
            return rawurlencode(wp_json_encode($sanitizedFont));
        }

        if (ctype_digit($font)) {
            if (!array_key_exists($font, Azbalac_Custom_Font_List::FONTS)) {
                return '';
            }

            $sanitizedFont['font'] = absint($font);
            return rawurlencode(wp_json_encode($sanitizedFont));
        }

        $webfonts = isset($GLOBALS['azbalacGoogleFonts']) && is_array($GLOBALS['azbalacGoogleFonts'])
            ? $GLOBALS['azbalacGoogleFonts']
            : require get_template_directory() . '/inc/customizer/webfonts.php';
        $fontData = null;

        if (!empty($webfonts['items']) && is_array($webfonts['items'])) {
            foreach ($webfonts['items'] as $webfont) {
                if (
                    is_array($webfont)
                    && isset($webfont['family'])
                    && $webfont['family'] === $font
                ) {
                    $fontData = $webfont;
                    break;
                }
            }
        }

        if ($fontData === null) {
            return '';
        }

        $variant = 'regular';
        if (
            isset($fontSetting['gglfontdata'])
            && is_array($fontSetting['gglfontdata'])
            && isset($fontSetting['gglfontdata']['variant'])
            && is_scalar($fontSetting['gglfontdata']['variant'])
            && isset($fontData['variants'])
            && is_array($fontData['variants'])
            && in_array((string) $fontSetting['gglfontdata']['variant'], $fontData['variants'], true)
        ) {
            $variant = (string) $fontSetting['gglfontdata']['variant'];
        }

        $sanitizedFont['font'] = $fontData['family'];
        $sanitizedFont['gglfont'] = true;
        $sanitizedFont['gglfontdata'] = array(
            'variant' => $variant,
            'file' => isset($fontData['files'][$variant]) ? esc_url_raw($fontData['files'][$variant]) : '',
        );

        return rawurlencode(wp_json_encode($sanitizedFont));
    }

    public function sanitizeTheme($input)
    {
        if (!is_string($input)) {
            return '';
        }

        $themeSetting = json_decode(rawurldecode($input), true);

        if (!is_array($themeSetting) || !array_key_exists('theme', $themeSetting)) {
            return '';
        }

        $themeId = sanitize_text_field((string) $themeSetting['theme']);

        if ($themeId === '' || $themeId === '0') {
            return rawurlencode(wp_json_encode(array(
                'theme' => 0,
            )));
        }

        $themeData = Azbalac_Custom_Theme_Data::getTheme($themeId);

        if ($themeData === null) {
            return '';
        }

        return rawurlencode(wp_json_encode(array(
            'theme' => $themeId,
            'data' => $themeData,
        )));
    }
}
