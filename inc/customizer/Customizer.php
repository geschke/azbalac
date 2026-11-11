<?php

/**
 * Implements Customizer functionality.
 *
 * Add custom sections and settings to the Customizer.
 *
 * @package Azbalac_One
 * @since 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Customizer
{

    /**
     * Sanitizer used by the theme's Customizer settings.
     *
     * @var Azbalac_Customizer_Sanitizer
     */
    private $sanitizer;

    /**
     * azbalac_Customizer constructor.
     *
     * @access public
     * @since  0.1
     * @return void
     */
    public function __construct()
    {

        add_action('customize_register', array($this, 'customizeRegister'));
        $this->sanitizer = new Azbalac_Customizer_Sanitizer();
    }

    public function customizeRegister($wp_customize)
    {
        $customAddOn = new Azbalac_Customizer_Addon($wp_customize);
        
        $this->addCustomizerThemePanel($wp_customize);
        $this->addCustomizerSocialButtons($wp_customize);
        $this->addCustomizerSliderOptions($wp_customize);
        $this->addCustomizerColors($wp_customize);

        $this->addCustomizerGeneralSettings($wp_customize);
        $this->addCustomizerNavigationSettings($wp_customize);
        $this->addCustomizerHeaderSettings($wp_customize);
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
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Theme Options', 'azbalac-one'),
            'description' => __('Configuration of the theme', 'azbalac-one'),
        ));

        $wp_customize->add_section('section_theme_options_general', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('General Settings', 'azbalac-one'),
            'description' => __('Edit general settings:  colors, main layout, navigation bar.', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_header', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Header Settings', 'azbalac-one'),
            'description' => __('Edit options of header.', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));


        $wp_customize->add_section('section_theme_options_navbar', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Navigation Bar Settings', 'azbalac-one'),
            'description' => __('Edit options of main navigation bar.', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_typography', array(
            'priority' => 200, 
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Typography Settings', 'azbalac-one'),
            'description' => __('Edit typography settings: font settings for titles and body text.', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_home', array(
            'priority' => 390,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Home Options', 'azbalac-one'),
            'description' => __('Edit homepage settings', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_header_image_options', array(
            'priority' => 400,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Header Image Options', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_posts', array(
            'priority' => 500,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Posts Settings', 'azbalac-one'),
            'description' => __('Edit posts settings', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_options', array(
            'priority' => 600,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Options', 'azbalac-one'),
            'description' => __('Edit Lead Section Options', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_content', array(
            'priority' => 700,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Content', 'azbalac-one'),
            'description' => __('Edit Lead Section Content', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

     
        $wp_customize->add_section('section_theme_options_footer', array(
            'priority' => 800,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Footer Options', 'azbalac-one'),
            'description' => __('Set options of Footer', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_subfooter', array(
            'priority' => 900,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Subfooter Options', 'azbalac-one'),
            'description' => __('Set options of Subfooter, i.e. the area under the footer', 'azbalac-one'),
            'panel' => 'panel_theme_options',
        ));


    }

    public function addSliderOptions($wp_customize, $slider)
    {
        $wp_customize->add_section('section_slider_' . $slider, array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => sprintf(__('Slider #%d', 'azbalac-one'), $slider),
            'description' => sprintf(__('Configure Slider #%d', 'azbalac-one'), $slider),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_image', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'azbalac_control_slider_' . $slider . '_image', array(
            'label' => __('Slider image', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_image',
            'flex_width' => true, // Allow any width, making the specified value recommended. False by default.
            'flex_height' => true, // Require the resulting image to be exactly as tall as the height attribute (default).
            'width' => 1920,
            'height' => 500,
            'mime_type' => 'image',
            'description' => __('Image displayed on slider', 'azbalac-one')
        )));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_title', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_title', array(
            'label' => __('Title', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_title')
        );

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_description', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );

        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_description', array(
            'label' => __('Description', 'azbalac-one'),
            'type' => 'textarea',
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_description'
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_text_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderTextPosition')
        ));

        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_text_position', array(
            'label' => __('Position of Slider text', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_text_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac-one'),
                '2' => __('Center', 'azbalac-one'),
                '3' => __('Right', 'azbalac-one')
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_text_color', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_slider_' . $slider . '_text_color', array(
            'label' => __('Slider Text Color', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_text_color',
            'description' => __('Pick a color for the title and description text of this slide (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_page', array(
            // note - works with or without capability & type set
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'default' => 0,
            'validate_callback' => array($this->sanitizer, 'validateSliderPage'),
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_page', array(
            'label' => __('Link to Page', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'type' => 'dropdown-pages',
            'settings' => 'azbalac_setting_slider_' . $slider . '_page',
        ));


        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_post', array(
            // note - works with or without capability & type set
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'default' => 0,
            'validate_callback' => array($this->sanitizer, 'validateSliderPost'),
            'sanitize_callback' => 'absint',
        ));

        $result = null;
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_post', array(
            'label' => __('&hellip;or Link to Post', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'type' => 'select',
            'settings' => 'azbalac_setting_slider_' . $slider . '_post',
            'choices' => call_user_func(function() {
                $c = Azbalac_Custom_Repeater_Helper::getPostDropdownOptions();
                foreach ($c as $value) {
                    $result[$value['value']] = $value['name'];
                }
                return $result;
            })
        ));


        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw')
        );
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_url', array(
            'label' => __('&hellip;or enter URL to link to', 'azbalac-one'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_url')
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
            'title' => __('Slider Integration', 'azbalac-one'),
            'description' => __('Configuration of Slider', 'azbalac-one'),
        ));




        $wp_customize->add_section('section_slider_options', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Slider Options', 'azbalac-one'),
            'description' => __('Set generic slider options', 'azbalac-one'),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_activate', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_activate', array(
            'label' => __('Show slider', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_activate',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderPosition')
        ));

        $wp_customize->add_control('azbalac_control_slider_position', array(
            'label' => __('Slider Position', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Above navigation (if navbar position is not fixed)', 'azbalac-one'),
                '2' => __('Between navigation and featured articles', 'azbalac-one'),
                '3' => __('Between featured articles and content', 'azbalac-one'),
                '4' => __('Between content and footer', 'azbalac-one'),
            ),
        ));
        $wp_customize->add_setting('azbalac_setting_slider_interval', array(
            'default' => '5000',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control('azbalac_control_slider_interval', array(
            'label' => __('Transition delay', 'azbalac-one'),
            'description' => __('Number of milliseconds a photo is displayed for (enter 0 for no automatically cycling).', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_interval',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger'))
        );

        $wp_customize->add_setting('azbalac_setting_slider_pause', array(
            'default' => true,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_pause', array(
            'label' => __('Pause sliding on mouseenter', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_pause',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_keyboard', array(
            'default' => true,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_keyboard', array(
            'label' => __('Slider reacts to keyboard events', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_keyboard',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_wrap', array(
            'default' => true,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_wrap', array(
            'label' => __('Cycle continuously', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_wrap',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_indicators', array(
            'default' => true,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_indicators', array(
            'label' => __('Show slider indicators', 'azbalac-one'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_indicators',
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
            'discord' => array('settings_id' => 'azbalac_social_media_discord',
                'label' => __('Discord', 'azbalac-one'),
                'description' => __('Enter the complete Discord profile page URL (please include http or https!)', 'azbalac-one'),
            ),
            'facebook' => array('settings_id' => 'azbalac_social_media_facebook',
                'label' => __('Facebook', 'azbalac-one'),
                'description' => __('Enter the complete Facebook profile page URL (please include http or https!)', 'azbalac-one'),
            ),
            'github' => array('settings_id' => 'azbalac_social_media_github',
                'label' => __('GitHub', 'azbalac-one'),
                'description' => __('Enter the complete GitHub profile page URL (please include http or https!)', 'azbalac-one'),
            ),
            'google' => array('settings_id' => 'azbalac_social_media_google',
                'label' => __('Google', 'azbalac-one'),
                'description' => __('Enter the complete Google profile page URL (please include http or https!)', 'azbalac-one'),
            ),
            'instagram' => array('settings_id' => 'azbalac_social_media_instagram',
                'label' => __('Instagram', 'azbalac-one'),
                'description' => __('Enter the complete Instagram page URL (please include http or https!)', 'azbalac-one'),
            ),
            'linkedin' => array('settings_id' => 'azbalac_social_media_linkedin',
                'label' => __('LinkedIn', 'azbalac-one'),
                'description' => __('Enter the complete LinkedIn page URL (please include http or https!)', 'azbalac-one'),
            ),
            'mastodon' => array('settings_id' => 'azbalac_social_media_mastodon',
                'label' => __('Mastodon', 'azbalac-one'),
                'description' => __('Enter the complete Mastodon page URL (please include http or https!)', 'azbalac-one'),
            ),
            'slideshare' => array('settings_id' => 'azbalac_social_media_slideshare',
                'label' => __('SlideShare', 'azbalac-one'),
                'description' => __('Enter the complete SlideShare page URL (please include http or https!)', 'azbalac-one'),
            ),
            'skype' => array('settings_id' => 'azbalac_social_media_skype',
                'label' => __('Skype', 'azbalac-one'),
                'description' => __('Enter the complete Skype page URL (please include http or https!)', 'azbalac-one'),
            ),
            'slack' => array('settings_id' => 'azbalac_social_media_slack',
                'label' => __('Slack', 'azbalac-one'),
                'description' => __('Enter the complete Slack page URL (please include http or https!)', 'azbalac-one'),
            ),
            'snapchat' => array('settings_id' => 'azbalac_social_media_snapchat',
                'label' => __('Snapchat', 'azbalac-one'),
                'description' => __('Enter the complete Snapchat page URL (please include http or https!)', 'azbalac-one'),
            ),
            'telegram' => array('settings_id' => 'azbalac_social_media_telegram',
                'label' => __('Telegram', 'azbalac-one'),
                'description' => __('Enter the Telegram profile page URL (please include http!)', 'azbalac-one'),
            ),
            'twitch' => array('settings_id' => 'azbalac_social_media_twitch',
                'label' => __('Twitch', 'azbalac-one'),
                'description' => __('Enter the Twitch profile page URL (please include http!)', 'azbalac-one'),
            ),
            'twitter' => array('settings_id' => 'azbalac_social_media_twitter',
                'label' => __('Twitter', 'azbalac-one'),
                'description' => __('Enter the Twitter profile page URL (please include http!)', 'azbalac-one'),
            ),
            'vine' => array('settings_id' => 'azbalac_social_media_vine',
                'label' => __('Vine', 'azbalac-one'),
                'description' => __('Enter the complete Vine page URL (please include http or https!)', 'azbalac-one'),
            ),
            'xing' => array('settings_id' => 'azbalac_social_media_xing',
                'label' => __('Xing', 'azbalac-one'),
                'description' => __('Enter the complete Xing profile page URL (please include http or https!)', 'azbalac-one')
            ),
            'whatsapp' => array('settings_id' => 'azbalac_social_media_whatsapp',
                'label' => __('WhatsApp', 'azbalac-one'),
                'description' => __('Enter the WhatsApp profile page URL (please include http!)', 'azbalac-one'),
            ),
            'youtube' => array('settings_id' => 'azbalac_social_media_youtube',
                'label' => __('YouTube', 'azbalac-one'),
                'description' => __('Enter the complete YouTube channel page URL (please include http or https!)', 'azbalac-one')
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
            'title' => __('Social Media Integration', 'azbalac-one'),
            'description' => __('Configuration of Social Media Buttons', 'azbalac-one'),
        ));

        $wp_customize->add_section('section_social_media_buttons', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons', 'azbalac-one'),
            'description' => __('Configure URLs of your Social Media Buttons', 'azbalac-one'),
            'panel' => 'panel_social_media_integration',
        ));

        $wp_customize->add_section('section_social_media_position', array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons Options', 'azbalac-one'),
            'description' => __('Set options of Social Media Buttons', 'azbalac-one'),
            'panel' => 'panel_social_media_integration',
        ));


        $wp_customize->add_setting('azbalac_setting_social_media_activate', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_social_media_activate', array(
            'label' => __('Show Social Media Buttons', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_media_activate',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_social_media_position', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialMediaPosition')
        ));

        $wp_customize->add_control('azbalac_control_social_media_position', array(
            'label' => __('Button Position', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_media_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Above header (with standard navigation)', 'azbalac-one'),
                '2' => __('Between Content and Footer', 'azbalac-one'),
                '3' => __('Below Footer', 'azbalac-one'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_media_alignment', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialMediaAlignment')
        ));

        $wp_customize->add_control('azbalac_control_social_media_alignment', array(
            'label' => __('Button Alignment', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_media_alignment',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac-one'),
                '2' => __('Centered', 'azbalac-one'),
                '3' => __('Right', 'azbalac-one'),
            ),
            'description' => __('Hint: Left and centered alignment are only available when no other elements are displayed in the same row beside the social media buttons. If, for example, the site title is displayed on the left, the social media buttons retain their default alignment.','azbalac-one')
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_size', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonSize')
        ));

        $wp_customize->add_control('azbalac_control_social_button_size', array(
            'label' => __('Button Size', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_size',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Small', 'azbalac-one'),
                '2' => __('Medium', 'azbalac-one'), // lg
                '3' => __('Large', 'azbalac-one'), // 2x
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_type', array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonType')
        ));

        $wp_customize->add_control('azbalac_control_social_button_type', array(
            'label' => __('Button Type', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_type',
            'type' => 'select',
            'choices' => array(
                // default no styling
                '0' => __('Default style', 'azbalac-one'),
                //'1' => __('Button', 'azbalac-one'), // currently not supported, maybe add in future
                '2' => __('Border Square', 'azbalac-one'),
                '3' => __('Border Rounded', 'azbalac-one'),
                '4' => __('Border Circle', 'azbalac-one'),
                
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_border_width', array(
            'default' => '3',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonBorderWidth')
        ));

        $wp_customize->add_control('azbalac_control_social_button_border_width', array(
            'label' => __('Border Width', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_border_width',
            
            'type' => 'select',
            'choices' => array(
                // default no styling
                '1' => __('Width 1', 'azbalac-one'),
                '2' => __('Width 2', 'azbalac-one'),
                '3' => __('Width 3 (Default)', 'azbalac-one'),
                '4' => __('Width 4', 'azbalac-one'),
                '5' => __('Width 5', 'azbalac-one'),
                
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_border_color', array(
            'default' => 'default', // default is light or dark, according to navbar_style setting
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeBootstrapColorSet')
        ));

        $wp_customize->add_control('azbalac_control_social_button_border_color', array(
            'label' => __('Border Color (if chosen border type)', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_border_color',
            'type' => 'select',
            'choices' => array(
                'default' => __( '&mdash; Select &mdash;', 'azbalac-one' ),
                'primary' => __('primary', 'azbalac-one'),
                'secondary' => __('secondary', 'azbalac-one'),
                'success' => __('success', 'azbalac-one'),
                'danger' => __('danger', 'azbalac-one'),
                'warning' => __('warning', 'azbalac-one'),
                'info' => __('info', 'azbalac-one'),
                'light' => __('light', 'azbalac-one'),
                'dark' => __('dark', 'azbalac-one'),
                'white' => __('white', 'azbalac-one'),
            ),
            'description' => __('Pick a border color from the theme stylesheet or choose your own.', 'azbalac-one'),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_border_color_custom', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_border_color_custom', array(
            'label' => __('Custom Border Color (overwrites previous setting)', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_border_color_custom',
            'description' => __('Pick a border color for the Social Media icon (default: transparent, i.e. use color from previous setting or defined in the theme stylesheet).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_social_button_bg_color', array(
            'default' => 'default', // default is light or dark, according to navbar_style setting
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeBootstrapColorSet')
        ));

        $wp_customize->add_control('azbalac_control_social_button_bg_color', array(
            'label' => __('Background Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_bg_color',
            'type' => 'select',
            'choices' => array(
                'default' => __( '&mdash; Select &mdash;', 'azbalac-one' ),
                'primary' => __('primary', 'azbalac-one'),
                'secondary' => __('secondary', 'azbalac-one'),
                'success' => __('success', 'azbalac-one'),
                'danger' => __('danger', 'azbalac-one'),
                'warning' => __('warning', 'azbalac-one'),
                'info' => __('info', 'azbalac-one'),
                'light' => __('light', 'azbalac-one'),
                'dark' => __('dark', 'azbalac-one'),
                'white' => __('white', 'azbalac-one'),
            ),
            'description' => __('Pick a background color from the theme stylesheet or choose your own.', 'azbalac-one'),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_bg_color_custom', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_bg_color_custom', array(
            'label' => __('Custom Background Color (overwrites previous setting)', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_bg_color_custom',
            'description' => __('Pick a background color for the Social Media icon (default: transparent, i.e. use color from previous setting or defined in the theme stylesheet).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_social_button_fg_color', array(
            'default' => 'default', // default is light or dark, according to navbar_style setting
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeBootstrapColorSet')
        ));

        $wp_customize->add_control('azbalac_control_social_button_fg_color', array(
            'label' => __('Icon (Foreground) Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_fg_color',
            'type' => 'select',
            'choices' => array(
                'default' => __( '&mdash; Select &mdash;', 'azbalac-one' ),
                'primary' => __('primary', 'azbalac-one'),
                'secondary' => __('secondary', 'azbalac-one'),
                'success' => __('success', 'azbalac-one'),
                'danger' => __('danger', 'azbalac-one'),
                'warning' => __('warning', 'azbalac-one'),
                'info' => __('info', 'azbalac-one'),
                'light' => __('light', 'azbalac-one'),
                'dark' => __('dark', 'azbalac-one'),
                'white' => __('white', 'azbalac-one'),
            ),
            'description' => __('Pick an icon color from the theme stylesheet or choose your own.', 'azbalac-one'),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_fg_color_custom', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_fg_color_custom', array(
            'label' => __('Custom Icon (Foreground) Color (overwrites previous setting)', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_fg_color_custom',
            'description' => __('Pick an icon color for the Social Media icon (default: transparent, i.e. use color from previous setting or defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        // maybe todo: use another option (ligther, darker?) when hovered?

        $wp_customize->add_setting('azbalac_setting_social_button_fg_color_custom_hover', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_fg_color_custom_hover', array(
            'label' => __('Custom Icon Mouseover Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_fg_color_custom_hover',
            'description' => __('Pick an icon color for the Social Media icon when hovered (default: transparent, i.e. use color from previous setting or defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        
/*        $wp_customize->add_setting('azbalac_setting_social_button_color_fg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_fg', array(
            'label' => __('Button Foreground (Icon) Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_fg',
            'description' => __('Pick a foreground color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_bg', array(
            'label' => __('Button Background Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_bg',
            'description' => __('Pick a background color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_color_bg_hover', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_bg_hover', array(
            'label' => __('Button Background Mouseover Color', 'azbalac-one'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_bg_hover',
            'description' => __('Pick a background color for the Social Media icon when hovered (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));*/
    }

    /**
     * Add Customizable color options
     *
     * @param type $wp_customize
     */
    public function addCustomizerColors($wp_customize)
    {
        $wp_customize->remove_control('header_textcolor'); // remove default option, it is replaced by color setting for title and subtitle

        $wp_customize->add_setting(
                'azbalac_setting_color_bg_header', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'azbalac_control_color_bg_header', array(
            'label' => __('Header Background Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_header',
            'description' => __('Pick a background color for the header (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_color_fg_title', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_title', array(
            'label' => __('Title Font Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_title',
            'description' => __('Pick a foreground color for the title (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_fg_subtitle', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_subtitle', array(
            'label' => __('Subtitle Font Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_subtitle',
            'description' => __('Pick a foreground color for the subtitle (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_fg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_footer', array(
            'label' => __('Footer Font Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_footer',
            'description' => __('Pick a foreground color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_bg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_bg_footer', array(
            'label' => __('Footer Background Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_footer',
            'description' => __('Pick a background color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_color_fg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'azbalac_control_color_fg_sidebar', array(
            'label' => __('Sidebar Font Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_sidebar',
            'description' => __('Pick a foreground color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_bg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_bg_sidebar', array(
            'label' => __('Sidebar Background Color', 'azbalac-one'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_sidebar',
            'description' => __('Pick a background color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
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


        $wp_customize->add_setting('azbalac_setting_layout', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeLayout')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Radio_Image_Control($wp_customize, 'azbalac_control_layout', array(
            'label' => __('Layout', 'azbalac-one'),
            'description' => __('Set layout of your site.', 'azbalac-one'),
            'section' => 'section_theme_options_general',
            'settings' => 'azbalac_setting_layout',
            'choices' => array(
                '1' => get_template_directory_uri() . '/images/admin/1c.png',
                '2' => get_template_directory_uri() . '/images/admin/2cr.png',
                '3' => get_template_directory_uri() . '/images/admin/2cl.png',
            )
        )));


        /*$wp_customize->add_setting('azbalac_stylesheet', array(
            'default' => 'slate_accessibility_ready.min.css',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeStylesheet')
        ));

        $wp_customize->add_control('azbalac_stylesheet', array(
            'settings' => 'azbalac_stylesheet',
            'label' => __('Theme Stylesheet', 'azbalac-one'),
            'section' => 'section_theme_options_general',
            'description' => __('Select your themes alternative color scheme.', 'azbalac-one'),
            'type' => 'select',
            'choices' => $this->getAvailableStylesheets()
        ));*/


        $wp_customize->add_setting('azbalac_setting_general_theme', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeTheme')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Theme_Control($wp_customize, 
        'azbalac_control_general_theme', array(
            'label' => __('Theme', 'azbalac-one'),
            'description' => __('Select your theme.', 'azbalac-one'),
            'section' => 'section_theme_options_general',
            'settings' => 'azbalac_setting_general_theme',
            /*'defaults' => array('font' => 17, // use numerical from Azbalac_Custom_Font_List or Ggl font string
            'size' => 16)*/
        )));

        $wp_customize->add_setting('azbalac_setting_general_logo_position', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeLogoPosition')
        ));

        $wp_customize->add_control('azbalac_control_general_logo_position', array(
            'label' => __('Custom Logo Position', 'azbalac-one'),
            'section' => 'section_theme_options_general',
            'settings' => 'azbalac_setting_general_logo_position',
            'type' => 'radio',
            'choices' => array(
                1 => __('Left', 'azbalac-one'),
                //2 => __('Center', 'azbalac-one'), // disabled due to right widget issues, maybe activate later again
                3 => __('Right', 'azbalac-one'),
            ),
        ));

    }


    /**
     * Add Navigation bar options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerNavigationSettings($wp_customize)
    {


        $wp_customize->add_setting('azbalac_setting_navbar_fixed', array(
            'default' => 'default',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarFixed')
        ));

        $wp_customize->add_control('azbalac_control_navbar_fixed', array(
            'label' => __('Navbar fixed options', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_fixed',
            'type' => 'radio',
            'choices' => array(
                'default' => __('Default', 'azbalac-one'),
                'top-aligned' => __('Top-Aligned', 'azbalac-one'),
                'fixed-top' => __('Top-Aligned, fixed to top', 'azbalac-one')
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_navbar_top_spacing', array(
            'default' => 9,
            'capability' => 'edit_theme_options',
            'type' => 'option', // necessary!!!
            'transport' => 'refresh',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarTopSpacing')
        ));


        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_navbar_top_spacing', array(
            'label' => __('Top Spacing (only available with fixed-top navigation bar)', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_top_spacing',
            'description' => __('When using fixed-top navigation with larger header font size, you can adjust the spacing to the page content here.', 'azbalac-one'),
            //'type' => 'slider',
            'choices' => array(
                'min' => 1,
                'max' => 30,
                'step' => 1)
        )));


        $wp_customize->add_setting('azbalac_setting_navbar_menu_alignment', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarMenuAlignment')
        ));

        $wp_customize->add_control('azbalac_control_navbar_menu_alignment', array(
            'label' => __('Menu Alignment', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'description' => __('This setting works only if there is no content defined in the navigation widget area. Otherwise, the alignment will fall back to the default value (left).', 'azbalac-one'),
            'settings' => 'azbalac_setting_navbar_menu_alignment',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac-one'),
                '2' => __('Centered', 'azbalac-one'),
                '3' => __('Right', 'azbalac-one'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_navbar_menu_whitespace', array(
            'default' => 1,
            'capability' => 'edit_theme_options',
            'type' => 'option', // necessary!!!
            'transport' => 'refresh',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarWhitespace')
        ));


        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_navbar_menu_whitespace', array(
            'label' => __('Whitespace settings in Navigation', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_menu_whitespace',
            'description' => __('A higher value means more whitespace.', 'azbalac-one'),
            //'type' => 'slider',
            'choices' => array(
                'min' => 1,
                'max' => 5,
                'step' => 1)
        )));


        $wp_customize->add_setting('azbalac_setting_navbar_style', array(
            'default' => 'light',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarStyle')
        ));

        $wp_customize->add_control('azbalac_control_navbar_style', array(
            'label' => __('Navbar style', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_style',
            'type' => 'radio',
            'choices' => array(
                'light' => __('Light', 'azbalac-one'),
                'dark' => __('Dark', 'azbalac-one'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_navbar_bg', array(
            'default' => 'default', // default is light or dark, according to navbar_style setting
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarBg')
        ));

        $wp_customize->add_control('azbalac_control_navbar_bg', array(
            'label' => __('Navigation Background Color', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_bg',
            'type' => 'select',
            'choices' => array(
                'default' => __( '&mdash; Select &mdash;', 'azbalac-one' ),
                'bg-primary' => __('bg-primary', 'azbalac-one'),
                'bg-secondary' => __('bg-secondary', 'azbalac-one'),
                'bg-success' => __('bg-success', 'azbalac-one'),
                'bg-danger' => __('bg-danger', 'azbalac-one'),
                'bg-warning' => __('bg-warning', 'azbalac-one'),
                'bg-info' => __('bg-info', 'azbalac-one'),
                'bg-light' => __('bg-light', 'azbalac-one'),
                'bg-dark' => __('bg-dark', 'azbalac-one'),
                'bg-white' => __('bg-white', 'azbalac-one'),
            ),
        ));

        $wp_customize->add_setting(
            'azbalac_setting_navbar_bg_custom', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_navbar_bg_custom', 
            array('label' => __('Custom Navigation Background Color', 'azbalac-one'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_bg_custom',
            'description' => __('This is optional. If color is set here, the previous option will be overwritten. To disable this option, set to transparent color.', 'azbalac-one'),)
        ));

      

    }

    
    /**
     * Add Header options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerHeaderSettings($wp_customize)
    {

        $wp_customize->add_setting('azbalac_setting_header_show_title_image', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('azbalac_control_header_title_image', array(
            'label' => __('Show title and subtitle on header image', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_show_title_image',
            'type' => 'checkbox',
         ));


         $wp_customize->add_setting('azbalac_setting_header_move_title_small', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('azbalac_control_header_move_title_small', array(
            'label' => __('If the title is positioned as an overlay on the header image, move the title and subtitle above the header image on small screens', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_move_title_small',
            'type' => 'checkbox',
         ));



         $wp_customize->add_setting('azbalac_setting_header_color_bg', array(
            'default' => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_header_color_bg',      
            array('label' => __('Transparency Background Color', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_color_bg',
            'description' => __('Pick a background color of transparency title and subtitle area (default: black).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_header_background_transp', array(
            'default' => 70,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_header_background_transp', array(
            'label' => __('Set transparency of title and subtitle background', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_background_transp',
            //'type' => 'slider',
            'choices' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1)
        )));
      

        $wp_customize->add_setting('azbalac_setting_header_alignment', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger') // maybe restrict later
        ));

        for ($i = 1; $i <= 6; $i++) {
            $headerPositions[$i] = get_template_directory_uri() . sprintf("/images/admin/header/option%02d.png", $i);
        }


        $wp_customize->add_control(new Azbalac_Custom_Radio_Image_Control($wp_customize, 'azbalac_control_header_alignment', array(
            'label' => __('Alignment', 'azbalac-one'),
            'description' => __('Set position of title and subtitle when displayed on header image.', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_alignment',
            'choices' => $headerPositions
        )));

        $wp_customize->add_setting('azbalac_setting_header_distance_top', array(
            'default' => 10,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_header_distance_top', array(
            'label' => __('Set distance to top/bottom margin', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_distance_top',
            //'type' => 'slider',
            'choices' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1)
        )));

        $wp_customize->add_setting('azbalac_setting_header_distance_left', array(
            'default' => 20,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_header_distance_left', array(
            'label' => __('Set distance to left/right border', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_distance_left',
            //'type' => 'slider',
            'choices' => array(
                'min' => 0,
                'max' => 800,
                'step' => 1)
        )));

        $wp_customize->add_setting('azbalac_setting_header_distance_between', array(
            'default' => 10,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_header_distance_between', array(
            'label' => __('Set distance between title and subtitle', 'azbalac-one'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_distance_between',
            //'type' => 'slider',
            'choices' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1)
        )));

    }



  /**
     * Add Typography options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerTypographySettings($wp_customize)
    {

        $wp_customize->add_setting('azbalac_setting_typography_title', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Font_Control($wp_customize, 
        'azbalac_control_typography_title', array(
            'label' => __('Title Font', 'azbalac-one'),
            'description' => __('Set font of website title. Choose a size of 0 (zero) to use the default font size of the theme', 'azbalac-one'),
            'section' => 'section_theme_options_typography',
            'settings' => 'azbalac_setting_typography_title',
            /*'defaults' => array('font' => 17, // use numerical from Azbalac_Custom_Font_List or Ggl font string
            'size' => 16)*/
        )));

        $wp_customize->add_setting('azbalac_setting_typography_subtitle', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Font_Control($wp_customize, 
        'azbalac_control_typography_subtitle', array(
            'label' => __('Subtitle Font', 'azbalac-one'),
            'description' => __('Set font of website subtitle. Choose a size of 0 (zero) to use the default font size of the theme', 'azbalac-one'),
            'section' => 'section_theme_options_typography',
            'settings' => 'azbalac_setting_typography_subtitle',
            /*'defaults' => array('font' => 17, // use numerical from Azbalac_Custom_Font_List or Ggl font string
            'size' => 16)*/
        )));


       $wp_customize->add_setting('azbalac_setting_typography_headline', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Font_Control($wp_customize, 
        'azbalac_control_typography_headline', array(
            'label' => __('Headline Base Font', 'azbalac-one'),
            'description' => __('Set base font of headlines. The real size of H1 - H6 will be calculated based on this size with the same resize factors as in the CSS framework. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac-one'),
            'section' => 'section_theme_options_typography',
            'settings' => 'azbalac_setting_typography_headline',
            /*'defaults' => array('font' => 17, // use numerical from Azbalac_Custom_Font_List or Ggl font string
            'size' => 16)*/
        )));


        $wp_customize->add_setting('azbalac_setting_typography_navbar', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Font_Control($wp_customize, 
        'azbalac_control_typography_navbar', array(
            'label' => __('Navigation Header Font', 'azbalac-one'),
            'description' => __('Set font of navigation header, the navbar. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac-one'),
            'section' => 'section_theme_options_typography',
            'settings' => 'azbalac_setting_typography_navbar',
           
        )));



        $wp_customize->add_setting('azbalac_setting_typography_body', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Font_Control($wp_customize, 
        'azbalac_control_typography_body', array(
            'label' => __('Body Font', 'azbalac-one'),
            'description' => __('Set font of body content. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac-one'),
            'section' => 'section_theme_options_typography',
            'settings' => 'azbalac_setting_typography_body',
           
        )));


      

    }

    /**
     * Add Styling posts options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerPostsSettings($wp_customize)
    {
        $wp_customize->add_setting('azbalac_setting_posts_featured_date', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_posts_featured_date', array(
            'label' => __('Show date and author of featured posts on homepage', 'azbalac-one'),
            'section' => 'section_theme_options_posts',
            'settings' => 'azbalac_setting_posts_featured_date',
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


        $wp_customize->add_setting('azbalac_setting_footer_activate', array(
            'default' => true,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_footer_activate', array(
            'label' => __('Show footer', 'azbalac-one'),
            'section' => 'section_theme_options_footer',
            'settings' => 'azbalac_setting_footer_activate',
            'type' => 'checkbox',
        ));


        $wp_customize->add_setting('azbalac_setting_footer_layout', array(
            'default' => '3',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFooterLayout')
        ));

        for ($i = 1; $i <= 18; $i++) {
            $footerLayouts[$i] = get_template_directory_uri() . sprintf("/images/admin/footer/option%02d.png", $i);
        }


        $wp_customize->add_control(new Azbalac_Custom_Radio_Image_Control($wp_customize, 'azbalac_control_footer_layout', array(
            'label' => __('Footer Layout', 'azbalac-one'),
            'description' => __('Set layout of the footer.', 'azbalac-one'),
            'section' => 'section_theme_options_footer',
            'settings' => 'azbalac_setting_footer_layout',
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

 
         $wp_customize->add_setting('azbalac_setting_subfooter_activate', array(
             'default' => true,
             'capability' => 'edit_theme_options',
             'type' => 'option',
             'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
             'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
 
         $wp_customize->add_control('azbalac_control_subfooter_activate', array(
             'label' => __('Show Subfooter', 'azbalac-one'),
             'section' => 'section_theme_options_subfooter',
             'settings' => 'azbalac_setting_subfooter_activate',
             'type' => 'checkbox'
         ));

         $wp_customize->add_setting(
            'azbalac_setting_subfooter_color_fg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_subfooter_color_fg', 
            array('label' => __('Subfooter Foreground Color', 'azbalac-one'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'azbalac_setting_subfooter_color_fg',
            'description' => __('Pick a foreground color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting(
            'azbalac_setting_subfooter_color_link', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_subfooter_color_link', 
            array('label' => __('Subfooter Link Color', 'azbalac-one'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'azbalac_setting_subfooter_color_link',
            'description' => __('Pick a link color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting(
            'azbalac_setting_subfooter_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_subfooter_color_bg',      
            array('label' => __('Subfooter Background Color', 'azbalac-one'),
            'section' => 'section_theme_options_subfooter',
        'settings' => 'azbalac_setting_subfooter_color_bg',
        'description' => __('Pick a background color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));


        $wp_customize->add_setting('azbalac_setting_subfooter_content', array(
            'default' => __('Powered by <a href="https://wordpress.org">WordPress</a>. Theme Azbalac One by <a href="https://www.geschke.net">Ralf Geschke</a>.','azbalac-one'),
            'sanitize_callback' => array($this->sanitizer, 'sanitizeHtml')
        ));

        $wp_customize->add_control('azbalac_control_subfooter_content', array(
            'label' => __('Subfooter content', 'azbalac-one'),
            'type' => 'textarea',
            'section' => 'section_theme_options_subfooter',
            'settings' => 'azbalac_setting_subfooter_content'
        ));
 

     }

    /**
     * Add Homepage options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerHomeOptions($wp_customize)
    {


        $wp_customize->add_setting('azbalac_setting_featured_articles_max', array(
            'default' => 10,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFeaturedArticles')
        ));


        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_featured_articles_max', array(
            'label' => __('Maximum number of featured articles on homepage', 'azbalac-one'),
            'section' => 'section_theme_options_home',
            'settings' => 'azbalac_setting_featured_articles_max',
            //'type' => 'slider',
            'choices' => array(
                'min' => 1,
                'max' => 100,
                'step' => 1)
        )));

        $wp_customize->add_setting('azbalac_setting_homepage_hide_empty', array(
            'capability' => 'edit_theme_options',
            'default' => false,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_homepage_hide_empty', array(
            'settings' => 'azbalac_setting_homepage_hide_empty',
            'label' => __('Hide "Nothing found" message on homepage if chosen last blog entries and no blog entry is available', 'azbalac-one'),
            'section' => 'section_theme_options_home',
            'type' => 'checkbox',
            //'description' => __('You can switch off this option, so no image will be displayed.', 'azbalac-one'),
        ));


    }

    /**
     * Add Header Image options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerHeaderImageSettings($wp_customize)
    {

        $wp_customize->add_setting('azbalac_setting_header_image_example', array(
            'capability' => 'edit_theme_options',
            'default' => true,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_example', array(
            'settings' => 'azbalac_setting_header_image_example',
            'label' => __('Use the example image from the theme if no default header image is set.', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('You can switch off this option, so no image will be displayed.', 'azbalac-one'),
        ));



        $wp_customize->add_setting('azbalac_setting_header_image_large_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => false,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_large_dontscale', array(
            'settings' => 'azbalac_setting_header_image_large_dontscale',
            'label' => __('Do not resize automatically the default header image', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the default header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac-one'),
        ));


        $wp_customize->add_setting('azbalac_setting_header_image_medium', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_medium', array(
            'label' => __('Header Image (medium screen)', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_medium',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with medium devices (desktops, 992px and up). Please use a minimal width of 912px. It is available when chosen default navbar.', 'azbalac-one')
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_medium_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => false,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_medium_dontscale', array(
            'settings' => 'azbalac_setting_header_image_medium_dontscale',
            'label' => __('Do not resize automatically the medium screen header image', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the medium screen header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac-one'),
        ));


        $wp_customize->add_setting('azbalac_setting_header_image_small', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_small', array(
            'label' => __('Header Image (small screen)', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_small',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with small devices (tablets, 768px and up). Please use a minimal width of 690px. It is available when chosen default navbar.', 'azbalac-one')
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_small_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => false,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_small_dontscale', array(
            'settings' => 'azbalac_setting_header_image_small_dontscale',
            'label' => __('Do not resize automatically the small screen header image', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the small screen header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac-one'),
        ));



        $wp_customize->add_setting('azbalac_setting_header_image_xsmall', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_xsmall', array(
            'label' => __('Header Image (extra small screen)', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_xsmall',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with extra small devices (phones, less than 768px). Please use a minimal width of 690px. It is available when chosen default navbar.', 'azbalac-one'),
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_xsmall_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => false,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_xsmall_dontscale', array(
            'settings' => 'azbalac_setting_header_image_xsmall_dontscale',
            'label' => __('Do not resize automatically the extra small header image', 'azbalac-one'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the extra small header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac-one'),
        ));
    }



 /**
     * Add Introduction section options to Customizer
     *
     * @param type $wp_customize
     */
    public function addCustomizerIntroductionSectionOptions($wp_customize)
    {
 
        $wp_customize->add_setting('azbalac_setting_introduction_area_activate', array(
           'default' => false,
           'capability' => 'edit_theme_options',
           'type' => 'option',
           'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
           'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));
 
        $wp_customize->add_control('azbalac_control_introduction_area_activate', array(
           'label' => __('Show Lead Section', 'azbalac-one'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_area_activate',
           'type' => 'checkbox',
        ));
 
        $wp_customize->add_setting('azbalac_setting_introduction_position', array(
           'default' => '2',
           'capability' => 'edit_theme_options',
           'type' => 'option',
           'sanitize_callback' => array($this->sanitizer, 'sanitizeSliderPosition')
        ));
 
        $wp_customize->add_control('azbalac_control_introduction_position', array(
           'label' => __('Lead Position', 'azbalac-one'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_position',
           'type' => 'radio',
           'choices' => array(
               '1' => __('Above navigation (if navbar position is not fixed)', 'azbalac-one'),
               '2' => __('Between navigation and featured articles', 'azbalac-one'),
               '3' => __('Between featured articles and content', 'azbalac-one'),
               '4' => __('Between content and footer', 'azbalac-one'),
           ),
        ));
 
 
        $wp_customize->add_setting('azbalac_setting_introduction_area_title', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_introduction_area_title', array(
           'label' => __('Section Title', 'azbalac-one'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_area_title')
        );
     
        $wp_customize->add_setting('azbalac_setting_introduction_area_subtitle', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_introduction_area_subtitle', array(
           'label' => __('Subtitle', 'azbalac-one'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_area_subtitle')
        );
        $wp_customize->add_setting('azbalac_setting_introduction_area_color_bg', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_introduction_area_color_bg', array(
        'label' => __('Section Background Color', 'azbalac-one'),
        'section' => 'section_theme_options_intro_options',
        'settings' => 'azbalac_setting_introduction_area_color_bg',
        'description' => __('Pick a background color for the Lead Section (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac-one'),)
        ));

        $wp_customize->add_setting('azbalac_setting_introduction_area_readmore', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox'),
            'sanitize_js_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('azbalac_control_introduction_area_readmore', array(
            'label' => __('Remove "Read more" Buttons', 'azbalac-one'),
            'section' => 'section_theme_options_intro_options',
            'settings' => 'azbalac_setting_introduction_area_readmore',
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
      
   
        $wp_customize->add_setting( 'azbalac_setting_introduction_area_elements', array(
         'sanitize_callback' => array($this->sanitizer, 'sanitizeRepeater'),
         'capability' => 'edit_theme_options'
        ));

        $wp_customize->add_control( new Azbalac_Custom_Repeater_Control( $wp_customize, 'azbalac_control_introduction_area_elements', array(
        'label'   => esc_html__('Lead Section Content', 'azbalac-one'),
        'description' => esc_html__('Add as many elements as you want.','azbalac-one'),
       
        'section' => 'section_theme_options_intro_content',
    //'priority' => 100,
        'settings' => 'azbalac_setting_introduction_area_elements',
        'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Title', 'azbalac-one' ),
            //'description' => esc_attr__( 'This will be the label for your link', 'azbalac-one' ),
            'default'     => esc_attr__( 'Title', 'azbalac-one' ),
        ),
        /*'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'azbalac-one' ),
			'description' => esc_attr__( 'This will be the link URL', 'azbalac-one' ),
			'default'     => 'another default test for text',
        ),*/
        /*'color_fg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Foreground color', 'azbalac-one' ),
			'description' => esc_attr__( 'Description of foreground color', 'azbalac-one' ),
			'default'     => '#554433',
        ),*/
        /*'color_bg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Background color', 'azbalac-one' ),
			'description' => esc_attr__( 'Description of background color', 'azbalac-one' ),
			'default'     => '#000000',
        ),*/
        'content' => array(
            'type'        => 'textarea',
            'label'       => esc_attr__( 'Text', 'azbalac-one' ),
            //'default'     => 'Default value in textarea',
        ),
        'icon' => array(
            'type'        => 'select',
            'label'       =>  __('Select Icon or&hellip;', 'azbalac-one'),
            'description' => __('Select Icon or&hellip;', 'azbalac-one'),
            'choices' => $this->getBootstrapIcons(),
            'default' => '0',
        ),
        'image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use Image', 'azbalac-one'),
            'mime_type' => 'image',
            'description' => __('Use Image instead of Icon', 'azbalac-one')
        ),

        'page' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Page or&hellip;', 'azbalac-one'),
            'choices' => Azbalac_Custom_Repeater_Helper::getPageDropdownOptions()
        ),
        'post' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Post or&hellip;', 'azbalac-one'),
            'choices' => Azbalac_Custom_Repeater_Helper::getPostDropdownOptions()
        ),
        'url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link to any URL', 'azbalac-one' ),
            //'description' => esc_attr__( 'This will be the link URL', 'azbalac-one' ),
            //'default'     => 'another default test for text',
        ),
        'color_icon' => array(
            'type'        => 'colorpicker',
            'label'       => esc_attr__( 'Icon Color', 'azbalac-one' ),
            //'description' => esc_attr__( 'Description of background color', 'azbalac-one' ),
            //'default'     => '#000000',
        ),

        'image_shape' => array(
            'type'      => 'radiobutton',
            'label' => __('Image Shape', 'azbalac-one'),
            'description' => __('Use image shape for uploaded image:', 'azbalac-one'),
            'default' => '2',
            'choices' => array(
                '1' => __('Rounded Corners', 'azbalac-one'),
                '2' => __('Circle', 'azbalac-one'),
                '3' => __('Thumbnail', 'azbalac-one'),
                '4' => __('No Image Shape', 'azbalac-one'),
                
            ),
        ),
        /*


        'azbalac_setting_content_area_image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use image', 'azbalac-one'),
            'mime_type' => 'image',
            'description' => __('Image displayed on section background', 'azbalac-one')
        ),
        
      
        ),
        'image_show' => array(
            'label' => __('Show checkbox', 'azbalac-one'),
            'type' => 'checkbox',
            //'default' => 'checked',
            'description' => __('Check to activate!', 'azbalac-one')
        ),
        */
        )
        ) ) );

        // todo: sanitize?
    }

    public function getBootstrapIcons()
    {
        $iconList = array(
            0 => __('Choose Icon', 'azbalac-one'),
        );
        $iconsFile = get_template_directory() . '/css/icons/bootstrap-icons.json';

        if (!is_readable($iconsFile)) {
            return $iconList;
        }

        $iconsJson = file_get_contents($iconsFile);

        if ($iconsJson === false) {
            return $iconList;
        }

        $icons = json_decode($iconsJson, true);

        if (!is_array($icons)) {
            return $iconList;
        }

        foreach ($icons as $key => $icon) {
            $iconList[$key] = $key;
        }
        ksort($iconList);
        return $iconList;
    }
}
