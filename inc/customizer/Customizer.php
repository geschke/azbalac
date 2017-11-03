<?php

/**
 * Implements Customizer functionality.
 *
 * Add custom sections and settings to the Customizer.
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4
 * @copyright Copyright (c) 2016, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Customizer
{

    /**
     * Tikva_Customizer constructor.
     *
     * @access public
     * @since  tikva 0.4
     * @return void
     */
    public function __construct()
    {

        add_action('customize_register', array($this, 'customizeRegister'));
        $this->sanitizer = new Tikva_Customizer_Sanitizer();
    }

    public function customizeRegister($wp_customize)
    {
        $customAddOn = new Tikva_Customizer_Addon($wp_customize);
        
        $this->addCustomizerThemePanel($wp_customize);
        $this->addCustomizerSocialButtons($wp_customize);
        $this->addCustomizerSliderOptions($wp_customize);
        $this->addCustomizerColors($wp_customize);

        $this->addCustomizerGeneralSettings($wp_customize);
        $this->addCustomizerTypographySettings($wp_customize);
        $this->addCustomizerPostsSettings($wp_customize);
        $this->addCustomizerIntroductionSectionOptions($wp_customize);
        $this->addCustomizerIntroductionSectionContent($wp_customize);
        
        $this->addCustomizerFooterOptions($wp_customize);
        $this->addCustomizerSubfooterOptions($wp_customize);
        $this->addCustomizerHeaderImageSettings($wp_customize);
        $this->addCustomizerHomeOptions($wp_customize);

        $customAddOn->initPreview();
    }

    /**
     * Add Styling options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerThemePanel($wp_customize)
    {
        $wp_customize->add_panel('panel_theme_options', array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Theme Options', 'tikva'),
            'description' => __('Configuration of the theme', 'tikva'),
        ));

        $wp_customize->add_section('section_theme_options_general', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('General Settings', 'tikva'),
            'description' => __('Edit general settings:  colors, main layout, navigation bar.', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_typography', array(
            'priority' => 200, 
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Typography Settings', 'tikva'),
            'description' => __('Edit typography settings:  fonts settings of title and body elements.', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_home', array(
            'priority' => 390,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Home Options', 'tikva'),
            'description' => __('Edit homepage settings', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_header_image_options', array(
            'priority' => 400,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Header Image Options', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_posts', array(
            'priority' => 500,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Posts Settings', 'tikva'),
            'description' => __('Edit posts settings', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_options', array(
            'priority' => 600,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Options', 'tikva'),
            'description' => __('Edit Lead Section Options', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_content', array(
            'priority' => 700,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Content', 'tikva'),
            'description' => __('Edit Lead Section Content', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

     
        $wp_customize->add_section('section_theme_options_footer', array(
            'priority' => 800,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Footer Options', 'tikva'),
            'description' => __('Set options of Footer', 'tikva'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_subfooter', array(
            'priority' => 900,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Subfooter Options', 'tikva'),
            'description' => __('Set options of Subfooter, i.e. the area under the footer', 'tikva'),
            'panel' => 'panel_theme_options',
        ));


    }

    public function addSliderOptions($wp_customize, $slider)
    {
        $wp_customize->add_section('section_slider_' . $slider, array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => sprintf(__('Slider #%d', 'tikva'), $slider),
            'description' => sprintf(__('Configure Slider #%d', 'tikva'), $slider),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('setting_slider_' . $slider . '_image', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'control_slider_' . $slider . '_image', array(
            'label' => __('Slider image', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_image',
            'flex_width' => true, // Allow any width, making the specified value recommended. False by default.
            'flex_height' => true, // Require the resulting image to be exactly as tall as the height attribute (default).
            'width' => 1920,
            'height' => 500,
            'mime_type' => 'image',
            'description' => __('Image displayed on slider', 'tikva')
        )));

        $wp_customize->add_setting('setting_slider_' . $slider . '_title', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('control_slider_' . $slider . '_title', array(
            'label' => __('Title', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_title')
        );

        $wp_customize->add_setting('setting_slider_' . $slider . '_description', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );

        $wp_customize->add_control('control_slider_' . $slider . '_description', array(
            'label' => __('Description', 'tikva'),
            'type' => 'textarea',
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_description'
        ));

        $wp_customize->add_setting('setting_slider_' . $slider . '_text_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderTextPosition')
        ));

        $wp_customize->add_control('control_slider_' . $slider . '_text_position', array(
            'label' => __('Position of Slider text', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_text_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'tikva'),
                '2' => __('Center', 'tikva'),
                '3' => __('Right', 'tikva')
            ),
        ));

        $wp_customize->add_setting('setting_slider_' . $slider . '_text_color', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'control_slider_' . $slider . '_text_color', array(
            'label' => __('Slider Text Color', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_text_color',
            'description' => __('Pick a color for the title and description text of this slide (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting('setting_slider_' . $slider . '_page', array(
            // note - works with or without capability & type set
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_post',
        ));

        $wp_customize->add_control('control_slider_' . $slider . '_page', array(
            'label' => __('Link to Page', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'type' => 'dropdown-pages',
            'settings' => 'setting_slider_' . $slider . '_page',
        ));

        $wp_customize->add_setting('setting_slider_' . $slider . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw')
        );
        $wp_customize->add_control('control_slider_' . $slider . '_url', array(
            'label' => __('&hellip;or enter URL to link to', 'tikva'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'setting_slider_' . $slider . '_url')
        );
    }

    /**
     * Add Slider Integration options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerSliderOptions($wp_customize)
    {


        $wp_customize->add_panel('panel_slider_integration', array(
            'priority' => 1010,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Slider Integration', 'tikva'),
            'description' => __('Configuration of Slider', 'tikva'),
        ));




        $wp_customize->add_section('section_slider_options', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Slider Options', 'tikva'),
            'description' => __('Set generic slider options', 'tikva'),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('setting_slider_activate', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_slider_activate', array(
            'label' => __('Show slider', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_activate',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('setting_slider_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderPosition')
        ));

        $wp_customize->add_control('control_slider_position', array(
            'label' => __('Slider Position', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Above navigation (if navbar position is not fixed)', 'tikva'),
                '2' => __('Between navigation and featured articles', 'tikva'),
                '3' => __('Between featured articles and content', 'tikva'),
                '4' => __('Between content and footer', 'tikva'),
            ),
        ));
        $wp_customize->add_setting('setting_slider_interval', array(
            'default' => '5000',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control('control_slider_interval', array(
            'label' => __('Transition delay', 'tikva'),
            'description' => __('Number of milliseconds a photo is displayed for (enter 0 for no automatically cycling).', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_interval',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger'))
        );

        $wp_customize->add_setting('setting_slider_pause', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_slider_pause', array(
            'label' => __('Pause sliding on mouseenter', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_pause',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('setting_slider_keyboard', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_slider_keyboard', array(
            'label' => __('Slider reacts to keyboard events', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_keyboard',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('setting_slider_wrap', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_slider_wrap', array(
            'label' => __('Cycle continuously', 'tikva'),
            'section' => 'section_slider_options',
            'settings' => 'setting_slider_wrap',
            'type' => 'checkbox',
        ));

        for ($i = 1; $i <= 6; $i++) {
            $this->addSliderOptions($wp_customize, $i);
        }
    }

    /**
     * Add Social Media Integration options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerSocialButtons($wp_customize)
    {
        $socialData = array(
            'facebook' => array('settings_id' => 'social_media_facebook',
                'label' => __('Facebook', 'tikva'),
                'description' => __('Enter the complete Facebook profile page URL (please include http or https!)', 'tikva'),
            ),
            'github' => array('settings_id' => 'social_media_github',
                'label' => __('GitHub', 'tikva'),
                'description' => __('Enter the complete GitHub profile page URL (please include http or https!)', 'tikva'),
            ),
            'googleplus' => array('settings_id' => 'social_media_google',
                'label' => __('Google+', 'tikva'),
                'description' => __('Enter the complete Google+ page URL (please include http or https!)', 'tikva'),
            ),
            'instagram' => array('settings_id' => 'social_media_instagram',
                'label' => __('Instagram', 'tikva'),
                'description' => __('Enter the complete Instagram page URL (please include http or https!)', 'tikva'),
            ),
            'linkedin' => array('settings_id' => 'social_media_linkedin',
                'label' => __('LinkedIn', 'tikva'),
                'description' => __('Enter the complete LinkedIn page URL (please include http or https!)', 'tikva'),
            ),
            'slideshare' => array('settings_id' => 'social_media_slideshare',
                'label' => __('SlideShare', 'tikva'),
                'description' => __('Enter the complete SlideShare page URL (please include http or https!)', 'tikva'),
            ),
            'snapchat' => array('settings_id' => 'social_media_snapshat',
                'label' => __('Snapchat', 'tikva'),
                'description' => __('Enter the complete Snapchat page URL (please include http or https!)', 'tikva'),
            ),
            'twitter' => array('settings_id' => 'social_media_twitter',
                'label' => __('Twitter', 'tikva'),
                'description' => __('Enter the Twitter profile page URL (please include http!)', 'tikva'),
            ),
            'vine' => array('settings_id' => 'social_media_vine',
                'label' => __('Vine', 'tikva'),
                'description' => __('Enter the complete Vine page URL (please include http or https!)', 'tikva'),
            ),
            'xing' => array('settings_id' => 'social_media_xing',
                'label' => __('Xing', 'tikva'),
                'description' => __('Enter the complete Xing profile page URL (please include http or https!)', 'tikva')
            ),
            'youtube' => array('settings_id' => 'social_media_youtube',
                'label' => __('YouTube', 'tikva'),
                'description' => __('Enter the complete YouTube channel page URL (please include http or https!)', 'tikva')
            )
        );
        foreach ($socialData as $key => $value) {
            $wp_customize->add_setting($value['settings_id'], array(
                'default' => '',
                'sanitize_callback' => 'esc_url'
                    )
            );

            $wp_customize->add_control(
                    new WP_Customize_Control(
                    $wp_customize, $value['settings_id'], array(
                'label' => $value['label'],
                'section' => 'section_social_media_buttons',
                'type' => 'url',
                'settings' => $value['settings_id'],
                'description' => $value['description'])
            ));
        }

        $wp_customize->add_panel('panel_social_media_integration', array(
            'priority' => 1000,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Integration', 'tikva'),
            'description' => __('Configuration of Social Media Buttons', 'tikva'),
        ));

        $wp_customize->add_section('section_social_media_buttons', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons', 'tikva'),
            'description' => __('Configure URLs of your Social Media Buttons', 'tikva'),
            'panel' => 'panel_social_media_integration',
        ));

        $wp_customize->add_section('section_social_media_position', array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons Options', 'tikva'),
            'description' => __('Set options of Social Media Buttons', 'tikva'),
            'panel' => 'panel_social_media_integration',
        ));


        $wp_customize->add_setting('setting_social_media_activate', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_social_media_activate', array(
            'label' => __('Show Social Media Buttons', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_media_activate',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('setting_social_media_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialMediaPosition')
        ));

        $wp_customize->add_control('control_social_media_position', array(
            'label' => __('Button Position', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_media_position',
            'type' => 'radio',
            'choices' => array(
                // '1' => __('Don\'t show', 'tikva'),
                '2' => __('Between Content and Footer', 'tikva'),
                '3' => __('Below Footer', 'tikva'),
            ),
        ));

        $wp_customize->add_setting('setting_social_media_alignment', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialMediaAlignment')
        ));

        $wp_customize->add_control('control_social_media_alignment', array(
            'label' => __('Button Alignment', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_media_alignment',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'tikva'),
                '2' => __('Centered', 'tikva'),
                '3' => __('Right', 'tikva'),
            ),
        ));

        $wp_customize->add_setting('setting_social_button_size', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonSize')
        ));

        $wp_customize->add_control('control_social_button_size', array(
            'label' => __('Button Size', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_button_size',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Small', 'tikva'),
                '2' => __('Medium', 'tikva'), // lg
                '3' => __('Large', 'tikva'), // 2x
            ),
        ));

        $wp_customize->add_setting('setting_social_button_type', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonType')
        ));

        $wp_customize->add_control('control_social_button_type', array(
            'label' => __('Button Type', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_button_type',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Circle', 'tikva'),
                '2' => __('Square (rounded corners)', 'tikva'),
            ),
        ));


        $wp_customize->add_setting('setting_social_button_color_fg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_social_button_color_fg', array(
            'label' => __('Button Foreground (Icon) Color', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_button_color_fg',
            'description' => __('Pick a foreground color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting('setting_social_button_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_social_button_color_bg', array(
            'label' => __('Button Background Color', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_button_color_bg',
            'description' => __('Pick a background color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting('setting_social_button_color_bg_hover', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_social_button_color_bg_hover', array(
            'label' => __('Button Background Mouseover Color', 'tikva'),
            'section' => 'section_social_media_position',
            'settings' => 'setting_social_button_color_bg_hover',
            'description' => __('Pick a background color for the Social Media icon when hovered (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));
    }

    /**
     * Add Customizable color options
     *
     * @param type $wp_customize
     */
    public function addCustomizerColors($wp_customize)
    {
        $wp_customize->add_setting(
                'color_bg_header', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'color_bg_header', array(
            'label' => __('Header Background Color', 'tikva'),
            'section' => 'colors',
            'settings' => 'color_bg_header',
            'description' => __('Pick a background color for the header (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));
        $wp_customize->add_setting(
                'color_fg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'color_fg_footer', array(
            'label' => __('Footer Font Color', 'tikva'),
            'section' => 'colors',
            'settings' => 'color_fg_footer',
            'description' => __('Pick a foreground color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting(
                'color_bg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'color_bg_footer', array(
            'label' => __('Footer Background Color', 'tikva'),
            'section' => 'colors',
            'settings' => 'color_bg_footer',
            'description' => __('Pick a background color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));


        $wp_customize->add_setting(
                'color_fg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'color_fg_sidebar', array(
            'label' => __('Sidebar Font Color', 'tikva'),
            'section' => 'colors',
            'settings' => 'color_fg_sidebar',
            'description' => __('Pick a foreground color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting(
                'color_bg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'color_bg_sidebar', array(
            'label' => __('Sidebar Background Color', 'tikva'),
            'section' => 'colors',
            'settings' => 'color_bg_sidebar',
            'description' => __('Pick a background color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));
    }

    /**
     * Get array of available stylesheets stored in the Bootstrap stylesheer directory.
     * The list can be used directly in a select field.
     *
     * @return array $designStylesheets
     */
    public static function getAvailableStylesheets()
    {
        $designStylesheetPath = get_template_directory() . '/css/design/';
        $designStylesheets = array();
        if (is_dir($designStylesheetPath)) {
            if ($alt_stylesheet_dir = opendir($designStylesheetPath)) {
                while (($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false) {
                    if (stristr($alt_stylesheet_file, ".css")) {
                        $designStylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;
                    }
                }
            }
        }
        asort($designStylesheets);
        return $designStylesheets;
    }

    /**
     * Add Styling options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerGeneralSettings($wp_customize)
    {


        $wp_customize->add_setting('tikva_layout', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeLayout')
        ));

        $wp_customize->add_control(new Tikva_Custom_Radio_Image_Control($wp_customize, 'tikva_layout', array(
            'label' => __('Layout', 'tikva'),
            'description' => __('Set layout of your site.', 'tikva'),
            'section' => 'section_theme_options_general',
            'settings' => 'tikva_layout',
            'choices' => array(
                '1' => get_template_directory_uri() . '/images/admin/1c.png',
                '2' => get_template_directory_uri() . '/images/admin/2cl.png',
                '3' => get_template_directory_uri() . '/images/admin/2cr.png',
            )
        )));


        $wp_customize->add_setting('tikva_stylesheet', array(
            'default' => 'slate_accessibility_ready.min.css',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeStylesheet')
        ));

        $wp_customize->add_control('tikva_stylesheet', array(
            'settings' => 'tikva_stylesheet',
            'label' => __('Theme Stylesheet', 'tikva'),
            'section' => 'section_theme_options_general',
            'description' => __('Select your themes alternative color scheme.', 'tikva'),
            'type' => 'select',
            'choices' => $this->getAvailableStylesheets()
        ));

        $wp_customize->add_setting('navbar_fixed', array(
            'default' => 'default',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarFixed')
        ));

        $wp_customize->add_control('navbar_fixed', array(
            'label' => __('Navbar fixed options', 'tikva'),
            'section' => 'section_theme_options_general',
            'settings' => 'navbar_fixed',
            'type' => 'radio',
            'choices' => array(
                'default' => __('Default', 'tikva'),
                'fixed-top' => __('Fixed to top', 'tikva')
            ),
        ));

        $wp_customize->add_setting('navbar_style_inverse', array(
            'default' => 'default',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarStyleInverse')
        ));

        $wp_customize->add_control('navbar_style_inverse', array(
            'label' => __('Navbar style', 'tikva'),
            'section' => 'section_theme_options_general',
            'settings' => 'navbar_style_inverse',
            'type' => 'radio',
            'choices' => array(
                'default' => __('Default', 'tikva'),
                'inverse' => __('Inverse', 'tikva'),
            ),
        ));
    }


  /**
     * Add Typography options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerTypographySettings($wp_customize)
    {

       $wp_customize->add_setting('setting_typography_headline', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Tikva_Custom_Font_Control($wp_customize, 
        'control_typography_headline', array(
            'label' => __('Headline Base Font', 'tikva'),
            'description' => __('Set base font of headlines. The real size of H1 - H6 will be calculated based on the font size. Choose a size of 0 (zero) to use the default font size of the theme.', 'tikva'),
            'section' => 'section_theme_options_typography',
            'settings' => 'setting_typography_headline',
            'defaults' => array('font' => 17, // use numerical from Tikva_Custom_Font_List or Ggl font string
            'size' => 16)
        )));


        $wp_customize->add_setting('setting_typography_body', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Tikva_Custom_Font_Control($wp_customize, 
        'control_typography_body', array(
            'label' => __('Body Font', 'tikva'),
            'description' => __('Set font of body content. Choose a size of 0 (zero) to use the default font size of the theme.', 'tikva'),
            'section' => 'section_theme_options_typography',
            'settings' => 'setting_typography_body',
           
        )));


      

    }

    /**
     * Add Styling posts options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerPostsSettings($wp_customize)
    {
        $wp_customize->add_setting('setting_posts_featured_date', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_posts_featured_date', array(
            'label' => __('Show date and author of featured posts on homepage', 'tikva'),
            'section' => 'section_theme_options_posts',
            'settings' => 'setting_posts_featured_date',
            'type' => 'checkbox',
        ));
    }

    /**
     * Add Footer options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerFooterOptions($wp_customize)
    {


        $wp_customize->add_setting('setting_footer_activate', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('control_footer_activate', array(
            'label' => __('Show footer', 'tikva'),
            'section' => 'section_theme_options_footer',
            'settings' => 'setting_footer_activate',
            'type' => 'checkbox',
        ));


        $wp_customize->add_setting('setting_footer_layout', array(
            'default' => '3',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFooterLayout')
        ));

        for ($i = 1; $i <= 18; $i++) {
            $footerLayouts[$i] = get_template_directory_uri() . sprintf("/images/admin/footer/option%02d.png", $i);
        }


        $wp_customize->add_control(new Tikva_Custom_Radio_Image_Control($wp_customize, 'control_footer_layout', array(
            'label' => __('Footer Layout', 'tikva'),
            'description' => __('Set layout of the footer.', 'tikva'),
            'section' => 'section_theme_options_footer',
            'settings' => 'setting_footer_layout',
            'choices' => $footerLayouts
        )));
    }


    /**
     * Add Subfooter options to Customizer
     *
     * @param type $wp_customize
     */
     public function addCustomizerSubfooterOptions($wp_customize)
     {

 
         $wp_customize->add_setting('setting_subfooter_activate', array(
             'default' => '1',
             'capability' => 'edit_theme_options',
             'type' => 'option',
             'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
 
         $wp_customize->add_control('control_subfooter_activate', array(
             'label' => __('Show Subfooter', 'tikva'),
             'section' => 'section_theme_options_subfooter',
             'settings' => 'setting_subfooter_activate',
             'type' => 'checkbox'
         ));

         $wp_customize->add_setting(
            'setting_subfooter_color_fg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_subfooter_color_fg', 
            array('label' => __('Subfooter Foreground Color', 'tikva'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'setting_subfooter_color_fg',
            'description' => __('Pick a foreground color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting(
            'setting_subfooter_color_link', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_subfooter_color_link', 
            array('label' => __('Subfooter Link Color', 'tikva'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'setting_subfooter_color_link',
            'description' => __('Pick a link color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting(
            'setting_subfooter_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_subfooter_color_bg',      
            array('label' => __('Subfooter Background Color', 'tikva'),
            'section' => 'section_theme_options_subfooter',
        'settings' => 'setting_subfooter_color_bg',
        'description' => __('Pick a background color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));


        $wp_customize->add_setting('setting_subfooter_content', array(
            'default' => __('Powered by <a href="https://wordpress.org">WordPress</a>. Theme Tikva by <a href="https://www.geschke.net">Ralf Geschke</a>.','tikva'),
            'sanitize_callback' => array($this->sanitizer, 'sanitizeHtml')
        ));

        $wp_customize->add_control('control_subfooter_content', array(
            'label' => __('Subfooter content', 'tikva'),
            'type' => 'textarea',
            'section' => 'section_theme_options_subfooter',
            'settings' => 'setting_subfooter_content'
        ));
 

     }

    /**
     * Add Homepage options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerHomeOptions($wp_customize)
    {


        $wp_customize->add_setting('featured_articles_max', array(
            'default' => 10,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFeaturedArticles')
        ));


        $wp_customize->add_control(new Tikva_Custom_Slider_Control($wp_customize, 'featured_articles_max', array(
            'label' => __('Maximum number of featured articles on homepage', 'tikva'),
            'section' => 'section_theme_options_home',
            'settings' => 'featured_articles_max',
            //'type' => 'slider',
            'choices' => array(
                'min' => 1,
                'max' => 100,
                'step' => 1)
        )));
    }

    /**
     * Add Header Image options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerHeaderImageSettings($wp_customize)
    {

        $wp_customize->add_setting('header_image_example_tikva', array(
            'capability' => 'edit_theme_options',
            'default' => 1,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('header_image_example_tikva', array(
            'settings' => 'header_image_example_tikva',
            'label' => __('Use the example image from the theme if no default header image is set.', 'tikva'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('You can switch off this option, so no image will be displayed.', 'tikva'),
        ));



        $wp_customize->add_setting('header_image_large_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('header_image_large_dontscale', array(
            'settings' => 'header_image_large_dontscale',
            'label' => __('Do not resize automatically the default header image', 'tikva'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the default header image will <b>not</b> be resized to fit the width of the screen.', 'tikva'),
        ));


        $wp_customize->add_setting('header_image_medium', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_image_medium', array(
            'label' => __('Header Image (medium screen)', 'tikva'),
            'section' => 'section_header_image_options',
            'settings' => 'header_image_medium',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with medium devices (desktops, 992px and up). Please use a minimal width of 912px. It is available when chosen default navbar.', 'tikva')
        )));

        $wp_customize->add_setting('header_image_medium_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('header_image_medium_dontscale', array(
            'settings' => 'header_image_medium_dontscale',
            'label' => __('Do not resize automatically the medium screen header image', 'tikva'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the medium screen header image will <b>not</b> be resized to fit the width of the screen.', 'tikva'),
        ));


        $wp_customize->add_setting('header_image_small', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_image_small', array(
            'label' => __('Header Image (small screen)', 'tikva'),
            'section' => 'section_header_image_options',
            'settings' => 'header_image_small',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with small devices (tablets, 768px and up). Please use a minimal width of 690px. It is available when chosen default navbar.', 'tikva')
        )));

        $wp_customize->add_setting('header_image_small_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('header_image_small_dontscale', array(
            'settings' => 'header_image_small_dontscale',
            'label' => __('Do not resize automatically the small screen header image', 'tikva'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the small screen header image will <b>not</b> be resized to fit the width of the screen.', 'tikva'),
        ));



        $wp_customize->add_setting('header_image_xsmall', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_image_xsmall', array(
            'label' => __('Header Image (extra small screen)', 'tikva'),
            'section' => 'section_header_image_options',
            'settings' => 'header_image_xsmall',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with extra small devices (phones, less than 768px). Please use a minimal width of 690px. It is available when chosen default navbar.', 'tikva'),
        )));

        $wp_customize->add_setting('header_image_xsmall_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('header_image_xsmall_dontscale', array(
            'settings' => 'header_image_xsmall_dontscale',
            'label' => __('Do not resize automatically the extra small header image', 'tikva'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the extra small header image will <b>not</b> be resized to fit the width of the screen.', 'tikva'),
        ));
    }



 /**
     * Add Introduction section options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerIntroductionSectionOptions($wp_customize)
    {
 
        $wp_customize->add_setting('setting_introduction_area_activate', array(
           'default' => '1',
           'capability' => 'edit_theme_options',
           'type' => 'option',
           'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));
 
        $wp_customize->add_control('control_introduction_area_activate', array(
           'label' => __('Show Lead Section', 'tikva'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'setting_introduction_area_activate',
           'type' => 'checkbox',
        ));
 
        $wp_customize->add_setting('setting_introduction_position', array(
           'default' => '2',
           'capability' => 'edit_theme_options',
           'type' => 'option',
           'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderPosition')
        ));
 
        $wp_customize->add_control('control_introduction_position', array(
           'label' => __('Lead Position', 'tikva'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'setting_introduction_position',
           'type' => 'radio',
           'choices' => array(
               '1' => __('Above navigation (if navbar position is not fixed)', 'tikva'),
               '2' => __('Between navigation and featured articles', 'tikva'),
               '3' => __('Between featured articles and content', 'tikva'),
               '4' => __('Between content and footer', 'tikva'),
           ),
        ));
 
 
        $wp_customize->add_setting('setting_introduction_area_title', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('control_introduction_area_title', array(
           'label' => __('Section Title', 'tikva'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'setting_introduction_area_title')
        );
     
        $wp_customize->add_setting('setting_introduction_area_subtitle', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('control_introduction_area_subtitle', array(
           'label' => __('Subtitle', 'tikva'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'setting_introduction_area_subtitle')
        );
        $wp_customize->add_setting('setting_introduction_area_color_bg', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'control_introduction_area_color_bg', array(
        'label' => __('Section Background Color', 'tikva'),
        'section' => 'section_theme_options_intro_options',
        'settings' => 'setting_introduction_area_color_bg',
        'description' => __('Pick a background color for the Lead Section (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva'),)
        ));

        $wp_customize->add_setting('setting_introduction_area_readmore', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('control_introduction_area_readmore', array(
            'label' => __('Remove "Read more" Buttons', 'tikva'),
            'section' => 'section_theme_options_intro_options',
            'settings' => 'setting_introduction_area_readmore',
            'type' => 'checkbox',
         ));
  

    }


    /**
     * Add Introduction section options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerIntroductionSectionContent($wp_customize)
    {
      
   
        $wp_customize->add_setting( 'setting_introduction_area_elements', array(
         'sanitize_callback' => array($this->sanitizer, 'sanitizeRepeater'),
         'capability' => 'edit_theme_options'
        ));

        $wp_customize->add_control( new Tikva_Custom_Repeater_Control( $wp_customize, 'setting_introduction_area_elements', array(
        'label'   => esc_html__('Lead Section Content', 'tikva'),
        'description' => esc_html__('Add as many elements as you want.','tikva'),
       
        'section' => 'section_theme_options_intro_content',
    //'priority' => 100,
        'settings' => 'setting_introduction_area_elements',
        'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Title', 'tikva' ),
            //'description' => esc_attr__( 'This will be the label for your link', 'tikva' ),
            'default'     => esc_attr__( 'Title', 'tikva' ),
        ),
        /*'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'tikva' ),
			'description' => esc_attr__( 'This will be the link URL', 'tikva' ),
			'default'     => 'another default test for text',
        ),*/
        /*'color_fg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Foreground color', 'tikva' ),
			'description' => esc_attr__( 'Description of foreground color', 'tikva' ),
			'default'     => '#554433',
        ),*/
        /*'color_bg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Background color', 'tikva' ),
			'description' => esc_attr__( 'Description of background color', 'tikva' ),
			'default'     => '#000000',
        ),*/
        'content' => array(
            'type'        => 'textarea',
            'label'       => esc_attr__( 'Text', 'tikva' ),
            //'default'     => 'Default value in textarea',
        ),
        'icon' => array(
            'type'        => 'select',
            'label'       =>  __('Select Font Awesome Icon or&hellip;', 'tikva'),
            'description' => __('Select Icon or&hellip;', 'tikva'),
            'choices' => $this->getFaIcons(),
            //'default' => 'fa-car'
        ),
        'image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use Image', 'tikva'),
            'mime_type' => 'image',
            'description' => __('Use Image instead of Icon', 'tikva')
        ),

        'page' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Page or&hellip;', 'tikva'),
            'choices' => Tikva_Custom_Repeater_Helper::getPageDropdownOptions()
        ),
        'post' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Post or&hellip;', 'tikva'),
            'choices' => Tikva_Custom_Repeater_Helper::getPostDropdownOptions()
        ),
        'url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link to any URL', 'tikva' ),
            //'description' => esc_attr__( 'This will be the link URL', 'tikva' ),
            //'default'     => 'another default test for text',
        ),
        'color_icon' => array(
            'type'        => 'colorpicker',
            'label'       => esc_attr__( 'Icon Color', 'tikva' ),
            //'description' => esc_attr__( 'Description of background color', 'tikva' ),
            //'default'     => '#000000',
        ),

        'image_shape' => array(
            'type'      => 'radiobutton',
            'label' => __('Image Shape', 'tikva'),
            'description' => __('Use image shape for uploaded image:', 'tikva'),
            'default' => '2',
            'choices' => array(
                '1' => __('Rounded Corners', 'tikva'),
                '2' => __('Circle', 'tikva'),
                '3' => __('Thumbnail', 'tikva'),
                '4' => __('No Image Shape', 'tikva'),
                
            ),
        ),
        /*


        'setting_content_area_image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use image', 'tikva'),
            'mime_type' => 'image',
            'description' => __('Image displayed on section background', 'tikva')
        ),
        
      
        ),
        'image_show' => array(
            'label' => __('Show checkbox', 'tikva'),
            'type' => 'checkbox',
            //'default' => 'checked',
            'description' => __('Check to activate!', 'tikva')
        ),
        */
        )
        ) ) );

        // todo: sanitize?
    }

    public function getFaIcons()
    {
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once ( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
        }

        $faIcons = $wp_filesystem->get_contents(get_template_directory() . '/css/font-awesome/fa-icons.txt');
        $lines = explode(PHP_EOL, $faIcons);
        $icons[0] = __('Choose Icon', 'tikva');
        foreach ($lines as $line) {
            if ($line) {
                $icons[$line] = $line;
            }
        }
        return $icons;
    }
}