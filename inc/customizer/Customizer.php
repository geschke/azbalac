<?php

/**
 * Implements Customizer functionality.
 *
 * Add custom sections and settings to the Customizer.
 *
 * @package   WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Customizer
{

    /**
     * azbalac_Customizer constructor.
     *
     * @access public
     * @since  Azbalac 0.1
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
            'title' => __('Theme Options', 'azbalac'),
            'description' => __('Configuration of the theme', 'azbalac'),
        ));

        $wp_customize->add_section('section_theme_options_general', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('General Settings', 'azbalac'),
            'description' => __('Edit general settings:  colors, main layout, navigation bar.', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_header', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Header Settings', 'azbalac'),
            'description' => __('Edit options of header.', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));


        $wp_customize->add_section('section_theme_options_navbar', array(
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Navigation Bar Settings', 'azbalac'),
            'description' => __('Edit options of main navigation bar.', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_typography', array(
            'priority' => 200, 
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Typography Settings', 'azbalac'),
            'description' => __('Edit typography settings:  fonts settings of title and body elements.', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_home', array(
            'priority' => 390,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Home Options', 'azbalac'),
            'description' => __('Edit homepage settings', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_header_image_options', array(
            'priority' => 400,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Header Image Options', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_posts', array(
            'priority' => 500,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Posts Settings', 'azbalac'),
            'description' => __('Edit posts settings', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_options', array(
            'priority' => 600,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Options', 'azbalac'),
            'description' => __('Edit Lead Section Options', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_intro_content', array(
            'priority' => 700,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Lead Area Content', 'azbalac'),
            'description' => __('Edit Lead Section Content', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

     
        $wp_customize->add_section('section_theme_options_footer', array(
            'priority' => 800,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Footer Options', 'azbalac'),
            'description' => __('Set options of Footer', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));

        $wp_customize->add_section('section_theme_options_subfooter', array(
            'priority' => 900,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Subfooter Options', 'azbalac'),
            'description' => __('Set options of Subfooter, i.e. the area under the footer', 'azbalac'),
            'panel' => 'panel_theme_options',
        ));


    }

    public function addSliderOptions($wp_customize, $slider)
    {
        $wp_customize->add_section('section_slider_' . $slider, array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => sprintf(__('Slider #%d', 'azbalac'), $slider),
            'description' => sprintf(__('Configure Slider #%d', 'azbalac'), $slider),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_image', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'azbalac_control_slider_' . $slider . '_image', array(
            'label' => __('Slider image', 'azbalac'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_image',
            'flex_width' => true, // Allow any width, making the specified value recommended. False by default.
            'flex_height' => true, // Require the resulting image to be exactly as tall as the height attribute (default).
            'width' => 1920,
            'height' => 500,
            'mime_type' => 'image',
            'description' => __('Image displayed on slider', 'azbalac')
        )));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_title', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_title', array(
            'label' => __('Title', 'azbalac'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_title')
        );

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_description', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field')
        );

        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_description', array(
            'label' => __('Description', 'azbalac'),
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
            'label' => __('Position of Slider text', 'azbalac'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_text_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac'),
                '2' => __('Center', 'azbalac'),
                '3' => __('Right', 'azbalac')
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_text_color', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_slider_' . $slider . '_text_color', array(
            'label' => __('Slider Text Color', 'azbalac'),
            'section' => 'section_slider_' . $slider,
            'settings' => 'azbalac_setting_slider_' . $slider . '_text_color',
            'description' => __('Pick a color for the title and description text of this slide (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_page', array(
            // note - works with or without capability & type set
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'default' => 0,
            'sanitize_callback' => 'sanitize_post',
        ));

        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_page', array(
            'label' => __('Link to Page', 'azbalac'),
            'section' => 'section_slider_' . $slider,
            'type' => 'dropdown-pages',
            'settings' => 'azbalac_setting_slider_' . $slider . '_page',
        ));


        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_post', array(
            // note - works with or without capability & type set
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'default' => 0,
            'sanitize_callback' => 'sanitize_post',
        ));


/*        $res = function() {
            $c = Azbalac_Custom_Repeater_Helper::getPostDropdownOptions();
            foreach ($c as $value) {
                $result[$value['value']] = $value['name'];
            }
            return $result;
        };   
  */     
        $result = null;
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_post', array(
            'label' => __('&hellip;or Link to Post', 'azbalac'),
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
            // $res()
        ));


        $wp_customize->add_setting('azbalac_setting_slider_' . $slider . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw')
        );
        $wp_customize->add_control('azbalac_control_slider_' . $slider . '_url', array(
            'label' => __('&hellip;or enter URL to link to', 'azbalac'),
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
            'title' => __('Slider Integration', 'azbalac'),
            'description' => __('Configuration of Slider', 'azbalac'),
        ));




        $wp_customize->add_section('section_slider_options', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Slider Options', 'azbalac'),
            'description' => __('Set generic slider options', 'azbalac'),
            'panel' => 'panel_slider_integration',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_activate', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_activate', array(
            'label' => __('Show slider', 'azbalac'),
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
            'label' => __('Slider Position', 'azbalac'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_position',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Above navigation (if navbar position is not fixed)', 'azbalac'),
                '2' => __('Between navigation and featured articles', 'azbalac'),
                '3' => __('Between featured articles and content', 'azbalac'),
                '4' => __('Between content and footer', 'azbalac'),
            ),
        ));
        $wp_customize->add_setting('azbalac_setting_slider_interval', array(
            'default' => '5000',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control('azbalac_control_slider_interval', array(
            'label' => __('Transition delay', 'azbalac'),
            'description' => __('Number of milliseconds a photo is displayed for (enter 0 for no automatically cycling).', 'azbalac'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_interval',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger'))
        );

        $wp_customize->add_setting('azbalac_setting_slider_pause', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_pause', array(
            'label' => __('Pause sliding on mouseenter', 'azbalac'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_pause',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_keyboard', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_keyboard', array(
            'label' => __('Slider reacts to keyboard events', 'azbalac'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_keyboard',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_wrap', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_wrap', array(
            'label' => __('Cycle continuously', 'azbalac'),
            'section' => 'section_slider_options',
            'settings' => 'azbalac_setting_slider_wrap',
            'type' => 'checkbox',
        ));

        $wp_customize->add_setting('azbalac_setting_slider_indicators', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_slider_indicators', array(
            'label' => __('Show slider indicators', 'azbalac'),
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
            'facebook' => array('settings_id' => 'azbalac_social_media_facebook',
                'label' => __('Facebook', 'azbalac'),
                'description' => __('Enter the complete Facebook profile page URL (please include http or https!)', 'azbalac'),
            ),
            'github' => array('settings_id' => 'azbalac_social_media_github',
                'label' => __('GitHub', 'azbalac'),
                'description' => __('Enter the complete GitHub profile page URL (please include http or https!)', 'azbalac'),
            ),
            'googleplus' => array('settings_id' => 'azbalac_social_media_google',
                'label' => __('Google+', 'azbalac'),
                'description' => __('Enter the complete Google+ page URL (please include http or https!)', 'azbalac'),
            ),
            'instagram' => array('settings_id' => 'azbalac_social_media_instagram',
                'label' => __('Instagram', 'azbalac'),
                'description' => __('Enter the complete Instagram page URL (please include http or https!)', 'azbalac'),
            ),
            'linkedin' => array('settings_id' => 'azbalac_social_media_linkedin',
                'label' => __('LinkedIn', 'azbalac'),
                'description' => __('Enter the complete LinkedIn page URL (please include http or https!)', 'azbalac'),
            ),
            'slideshare' => array('settings_id' => 'azbalac_social_media_slideshare',
                'label' => __('SlideShare', 'azbalac'),
                'description' => __('Enter the complete SlideShare page URL (please include http or https!)', 'azbalac'),
            ),
            'snapchat' => array('settings_id' => 'azbalac_social_media_snapshat',
                'label' => __('Snapchat', 'azbalac'),
                'description' => __('Enter the complete Snapchat page URL (please include http or https!)', 'azbalac'),
            ),
            'twitter' => array('settings_id' => 'azbalac_social_media_twitter',
                'label' => __('Twitter', 'azbalac'),
                'description' => __('Enter the Twitter profile page URL (please include http!)', 'azbalac'),
            ),
            'vine' => array('settings_id' => 'azbalac_social_media_vine',
                'label' => __('Vine', 'azbalac'),
                'description' => __('Enter the complete Vine page URL (please include http or https!)', 'azbalac'),
            ),
            'xing' => array('settings_id' => 'azbalac_social_media_xing',
                'label' => __('Xing', 'azbalac'),
                'description' => __('Enter the complete Xing profile page URL (please include http or https!)', 'azbalac')
            ),
            'youtube' => array('settings_id' => 'azbalac_social_media_youtube',
                'label' => __('YouTube', 'azbalac'),
                'description' => __('Enter the complete YouTube channel page URL (please include http or https!)', 'azbalac')
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
            'title' => __('Social Media Integration', 'azbalac'),
            'description' => __('Configuration of Social Media Buttons', 'azbalac'),
        ));

        $wp_customize->add_section('section_social_media_buttons', array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons', 'azbalac'),
            'description' => __('Configure URLs of your Social Media Buttons', 'azbalac'),
            'panel' => 'panel_social_media_integration',
        ));

        $wp_customize->add_section('section_social_media_position', array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Social Media Buttons Options', 'azbalac'),
            'description' => __('Set options of Social Media Buttons', 'azbalac'),
            'panel' => 'panel_social_media_integration',
        ));


        $wp_customize->add_setting('azbalac_setting_social_media_activate', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_social_media_activate', array(
            'label' => __('Show Social Media Buttons', 'azbalac'),
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
            'label' => __('Button Position', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_media_position',
            'type' => 'radio',
            'choices' => array(
                // '1' => __('Don\'t show', 'azbalac'),
                '2' => __('Between Content and Footer', 'azbalac'),
                '3' => __('Below Footer', 'azbalac'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_media_alignment', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialMediaAlignment')
        ));

        $wp_customize->add_control('azbalac_control_social_media_alignment', array(
            'label' => __('Button Alignment', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_media_alignment',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac'),
                '2' => __('Centered', 'azbalac'),
                '3' => __('Right', 'azbalac'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_size', array(
            'default' => '2',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonSize')
        ));

        $wp_customize->add_control('azbalac_control_social_button_size', array(
            'label' => __('Button Size', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_size',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Small', 'azbalac'),
                '2' => __('Medium', 'azbalac'), // lg
                '3' => __('Large', 'azbalac'), // 2x
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_type', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeSocialButtonType')
        ));

        $wp_customize->add_control('azbalac_control_social_button_type', array(
            'label' => __('Button Type', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_type',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Circle', 'azbalac'),
                '2' => __('Square (rounded corners)', 'azbalac'),
            ),
        ));


        $wp_customize->add_setting('azbalac_setting_social_button_color_fg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_fg', array(
            'label' => __('Button Foreground (Icon) Color', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_fg',
            'description' => __('Pick a foreground color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_bg', array(
            'label' => __('Button Background Color', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_bg',
            'description' => __('Pick a background color for the Social Media icon (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_social_button_color_bg_hover', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_social_button_color_bg_hover', array(
            'label' => __('Button Background Mouseover Color', 'azbalac'),
            'section' => 'section_social_media_position',
            'settings' => 'azbalac_setting_social_button_color_bg_hover',
            'description' => __('Pick a background color for the Social Media icon when hovered (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));
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
            'label' => __('Header Background Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_header',
            'description' => __('Pick a background color for the header (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));


        $wp_customize->add_setting('azbalac_setting_color_fg_title', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_title', array(
            'label' => __('Title Font Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_title',
            'description' => __('Pick a foreground color for the title (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_fg_subtitle', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_subtitle', array(
            'label' => __('Subtitle Font Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_subtitle',
            'description' => __('Pick a foreground color for the subtitle (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_fg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_fg_footer', array(
            'label' => __('Footer Font Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_footer',
            'description' => __('Pick a foreground color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_bg_footer', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_bg_footer', array(
            'label' => __('Footer Background Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_footer',
            'description' => __('Pick a background color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));


        $wp_customize->add_setting('azbalac_setting_color_fg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, 'azbalac_control_color_fg_sidebar', array(
            'label' => __('Sidebar Font Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_fg_sidebar',
            'description' => __('Pick a foreground color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_color_bg_sidebar', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(
                new WP_Customize_Color_Control($wp_customize, 'azbalac_control_color_bg_sidebar', array(
            'label' => __('Sidebar Background Color', 'azbalac'),
            'section' => 'colors',
            'settings' => 'azbalac_setting_color_bg_sidebar',
            'description' => __('Pick a background color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
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
            'label' => __('Layout', 'azbalac'),
            'description' => __('Set layout of your site.', 'azbalac'),
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
            'label' => __('Theme Stylesheet', 'azbalac'),
            'section' => 'section_theme_options_general',
            'description' => __('Select your themes alternative color scheme.', 'azbalac'),
            'type' => 'select',
            'choices' => $this->getAvailableStylesheets()
        ));*/


        $wp_customize->add_setting('azbalac_setting_general_theme', array(
            'capability' => 'edit_theme_options',
            //'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeFont')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Theme_Control($wp_customize, 
        'azbalac_control_general_theme', array(
            'label' => __('Theme', 'azbalac'),
            'description' => __('Select your theme.', 'azbalac'),
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
            'label' => __('Custom Logo Position', 'azbalac'),
            'section' => 'section_theme_options_general',
            'settings' => 'azbalac_setting_general_logo_position',
            'type' => 'radio',
            'choices' => array(
                1 => __('Left', 'azbalac'),
                //2 => __('Center', 'azbalac'), // disabled due to right widget issues, maybe activate later again
                3 => __('Right', 'azbalac'),
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
            'label' => __('Navbar fixed options', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_fixed',
            'type' => 'radio',
            'choices' => array(
                'default' => __('Default', 'azbalac'),
                'fixed-top' => __('Fixed to top', 'azbalac')
            ),
        ));


        $wp_customize->add_setting('azbalac_setting_navbar_menu_alignment', array(
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarMenuAlignment')
        ));

        $wp_customize->add_control('azbalac_control_navbar_menu_alignment', array(
            'label' => __('Menu Alignment', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'description' => __('This setting works only if there is no content defined in the navigation widget area. Otherwise the alignment will be fallback to the default value (left).', 'azbalac'),
            'settings' => 'azbalac_setting_navbar_menu_alignment',
            'type' => 'radio',
            'choices' => array(
                '1' => __('Left', 'azbalac'),
                '2' => __('Centered', 'azbalac'),
                '3' => __('Right', 'azbalac'),
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
            'label' => __('Whitespace settings in Navigation', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_menu_whitespace',
            'description' => __('A higher value means more whitespace.', 'azbalac'),
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
            'label' => __('Navbar style', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_style',
            'type' => 'radio',
            'choices' => array(
                'light' => __('Light', 'azbalac'),
                'dark' => __('Dark', 'azbalac'),
            ),
        ));

        $wp_customize->add_setting('azbalac_setting_navbar_bg', array(
            'default' => 'default', // default is light or dark, according to navbar_style setting
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeNavbarBg')
        ));

        $wp_customize->add_control('azbalac_control_navbar_bg', array(
            'label' => __('Navigation Background Color', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_bg',
            'type' => 'select',
            'choices' => array(
                'default' => __( '&mdash; Select &mdash;', 'azbalac' ),
                'bg-primary' => __('bg-primary', 'azbalac'),
                'bg-secondary' => __('bg-secondary', 'azbalac'),
                'bg-success' => __('bg-success', 'azbalac'),
                'bg-danger' => __('bg-danger', 'azbalac'),
                'bg-warning' => __('bg-warning', 'azbalac'),
                'bg-info' => __('bg-info', 'azbalac'),
                'bg-light' => __('bg-light', 'azbalac'),
                'bg-dark' => __('bg-dark', 'azbalac'),
                'bg-white' => __('bg-white', 'azbalac'),
            ),
        ));

        $wp_customize->add_setting(
            'azbalac_setting_navbar_bg_custom', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_navbar_bg_custom', 
            array('label' => __('Custom Navigation Background Color', 'azbalac'),
            'section' => 'section_theme_options_navbar',
            'settings' => 'azbalac_setting_navbar_bg_custom',
            'description' => __('This is optional. If color is set here, the previous option will be overwritten. To disable this option, set to transparent color.', 'azbalac'),)
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
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('azbalac_control_header_title_image', array(
            'label' => __('Show title and subtitle on header image', 'azbalac'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_show_title_image',
            'type' => 'checkbox',
         ));

         $wp_customize->add_setting('azbalac_setting_header_color_bg', array(
            'default' => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_header_color_bg',      
            array('label' => __('Transparency Background Color', 'azbalac'),
            'section' => 'section_theme_options_header',
            'settings' => 'azbalac_setting_header_color_bg',
            'description' => __('Pick a background color of transparency title and subtitle area (default: black).', 'azbalac'),)
        ));


        $wp_customize->add_setting('azbalac_setting_header_background_transp', array(
            'default' => 70,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new Azbalac_Custom_Slider_Control($wp_customize, 'azbalac_control_header_background_transp', array(
            'label' => __('Set transparency of title and subtitle background', 'azbalac'),
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
            'label' => __('Alignment', 'azbalac'),
            'description' => __('Set position of title and subtitle when displayed on header image.', 'azbalac'),
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
            'label' => __('Set distance to top/bottom margin', 'azbalac'),
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
            'label' => __('Set distance to left/right border', 'azbalac'),
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
            'label' => __('Set distance between title and subtitle', 'azbalac'),
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
            'label' => __('Title Font', 'azbalac'),
            'description' => __('Set font of website title. Choose a size of 0 (zero) to use the default font size of the theme', 'azbalac'),
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
            'label' => __('Subtitle Font', 'azbalac'),
            'description' => __('Set font of website subtitle. Choose a size of 0 (zero) to use the default font size of the theme', 'azbalac'),
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
            'label' => __('Headline Base Font', 'azbalac'),
            'description' => __('Set base font of headlines. The real size of H1 - H6 will be calculated based on this size with the same resize factors as in the CSS framework. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac'),
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
            'label' => __('Navigation Header Font', 'azbalac'),
            'description' => __('Set font of navigation header, the navbar. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac'),
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
            'label' => __('Body Font', 'azbalac'),
            'description' => __('Set font of body content. Choose a size of 0 (zero) to use the default font size of the theme.', 'azbalac'),
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
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_posts_featured_date', array(
            'label' => __('Show date and author of featured posts on homepage', 'azbalac'),
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
            'default' => '1',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_footer_activate', array(
            'label' => __('Show footer', 'azbalac'),
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
            'label' => __('Footer Layout', 'azbalac'),
            'description' => __('Set layout of the footer.', 'azbalac'),
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
             'default' => '1',
             'capability' => 'edit_theme_options',
             'type' => 'option',
             'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
 
         $wp_customize->add_control('azbalac_control_subfooter_activate', array(
             'label' => __('Show Subfooter', 'azbalac'),
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
            array('label' => __('Subfooter Foreground Color', 'azbalac'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'azbalac_setting_subfooter_color_fg',
            'description' => __('Pick a foreground color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting(
            'azbalac_setting_subfooter_color_link', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_subfooter_color_link', 
            array('label' => __('Subfooter Link Color', 'azbalac'),
            'section' => 'section_theme_options_subfooter',
            'settings' => 'azbalac_setting_subfooter_color_link',
            'description' => __('Pick a link color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting(
            'azbalac_setting_subfooter_color_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_subfooter_color_bg',      
            array('label' => __('Subfooter Background Color', 'azbalac'),
            'section' => 'section_theme_options_subfooter',
        'settings' => 'azbalac_setting_subfooter_color_bg',
        'description' => __('Pick a background color for the subfooter (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));


        $wp_customize->add_setting('azbalac_setting_subfooter_content', array(
            'default' => __('Powered by <a href="https://wordpress.org">WordPress</a>. Theme Azbalac by <a href="https://www.geschke.net">Ralf Geschke</a>.','azbalac'),
            'sanitize_callback' => array($this->sanitizer, 'sanitizeHtml')
        ));

        $wp_customize->add_control('azbalac_control_subfooter_content', array(
            'label' => __('Subfooter content', 'azbalac'),
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
            'label' => __('Maximum number of featured articles on homepage', 'azbalac'),
            'section' => 'section_theme_options_home',
            'settings' => 'azbalac_setting_featured_articles_max',
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

        $wp_customize->add_setting('azbalac_setting_header_image_example', array(
            'capability' => 'edit_theme_options',
            'default' => 1,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_example', array(
            'settings' => 'azbalac_setting_header_image_example',
            'label' => __('Use the example image from the theme if no default header image is set.', 'azbalac'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('You can switch off this option, so no image will be displayed.', 'azbalac'),
        ));



        $wp_customize->add_setting('azbalac_setting_header_image_large_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_large_dontscale', array(
            'settings' => 'azbalac_setting_header_image_large_dontscale',
            'label' => __('Do not resize automatically the default header image', 'azbalac'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the default header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac'),
        ));


        $wp_customize->add_setting('azbalac_setting_header_image_medium', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_medium', array(
            'label' => __('Header Image (medium screen)', 'azbalac'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_medium',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with medium devices (desktops, 992px and up). Please use a minimal width of 912px. It is available when chosen default navbar.', 'azbalac')
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_medium_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_medium_dontscale', array(
            'settings' => 'azbalac_setting_header_image_medium_dontscale',
            'label' => __('Do not resize automatically the medium screen header image', 'azbalac'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the medium screen header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac'),
        ));


        $wp_customize->add_setting('azbalac_setting_header_image_small', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeInteger')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_small', array(
            'label' => __('Header Image (small screen)', 'azbalac'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_small',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with small devices (tablets, 768px and up). Please use a minimal width of 690px. It is available when chosen default navbar.', 'azbalac')
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_small_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_small_dontscale', array(
            'settings' => 'azbalac_setting_header_image_small_dontscale',
            'label' => __('Do not resize automatically the small screen header image', 'azbalac'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the small screen header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac'),
        ));



        $wp_customize->add_setting('azbalac_setting_header_image_xsmall', array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'azbalac_control_header_image_xsmall', array(
            'label' => __('Header Image (extra small screen)', 'azbalac'),
            'section' => 'section_header_image_options',
            'settings' => 'azbalac_setting_header_image_xsmall',
            'mime_type' => 'image',
            'description' => __('If available, this image will be used with extra small devices (phones, less than 768px). Please use a minimal width of 690px. It is available when chosen default navbar.', 'azbalac'),
        )));

        $wp_customize->add_setting('azbalac_setting_header_image_xsmall_dontscale', array(
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));

        $wp_customize->add_control('azbalac_control_header_image_xsmall_dontscale', array(
            'settings' => 'azbalac_setting_header_image_xsmall_dontscale',
            'label' => __('Do not resize automatically the extra small header image', 'azbalac'),
            'section' => 'section_header_image_options',
            'type' => 'checkbox',
            'description' => __('If checked, the extra small header image will <b>not</b> be resized to fit the width of the screen.', 'azbalac'),
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
           'default' => '1',
           'capability' => 'edit_theme_options',
           'type' => 'option',
           'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
        ));
 
        $wp_customize->add_control('azbalac_control_introduction_area_activate', array(
           'label' => __('Show Lead Section', 'azbalac'),
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
           'label' => __('Lead Position', 'azbalac'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_position',
           'type' => 'radio',
           'choices' => array(
               '1' => __('Above navigation (if navbar position is not fixed)', 'azbalac'),
               '2' => __('Between navigation and featured articles', 'azbalac'),
               '3' => __('Between featured articles and content', 'azbalac'),
               '4' => __('Between content and footer', 'azbalac'),
           ),
        ));
 
 
        $wp_customize->add_setting('azbalac_setting_introduction_area_title', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_introduction_area_title', array(
           'label' => __('Section Title', 'azbalac'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_area_title')
        );
     
        $wp_customize->add_setting('azbalac_setting_introduction_area_subtitle', array(
           'default' => '',
           'sanitize_callback' => 'sanitize_text_field')
        );
        $wp_customize->add_control('azbalac_control_introduction_area_subtitle', array(
           'label' => __('Subtitle', 'azbalac'),
           'section' => 'section_theme_options_intro_options',
           'settings' => 'azbalac_setting_introduction_area_subtitle')
        );
        $wp_customize->add_setting('azbalac_setting_introduction_area_color_bg', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'azbalac_control_introduction_area_color_bg', array(
        'label' => __('Section Background Color', 'azbalac'),
        'section' => 'section_theme_options_intro_options',
        'settings' => 'azbalac_setting_introduction_area_color_bg',
        'description' => __('Pick a background color for the Lead Section (default: transparent, i.e. use color defined in the theme stylesheet).', 'azbalac'),)
        ));

        $wp_customize->add_setting('azbalac_setting_introduction_area_readmore', array(
            'default' => false,
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => array($this->sanitizer, 'sanitizeCheckbox')
         ));
  
         $wp_customize->add_control('azbalac_control_introduction_area_readmore', array(
            'label' => __('Remove "Read more" Buttons', 'azbalac'),
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
        'label'   => esc_html__('Lead Section Content', 'azbalac'),
        'description' => esc_html__('Add as many elements as you want.','azbalac'),
       
        'section' => 'section_theme_options_intro_content',
    //'priority' => 100,
        'settings' => 'azbalac_setting_introduction_area_elements',
        'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Title', 'azbalac' ),
            //'description' => esc_attr__( 'This will be the label for your link', 'azbalac' ),
            'default'     => esc_attr__( 'Title', 'azbalac' ),
        ),
        /*'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'azbalac' ),
			'description' => esc_attr__( 'This will be the link URL', 'azbalac' ),
			'default'     => 'another default test for text',
        ),*/
        /*'color_fg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Foreground color', 'azbalac' ),
			'description' => esc_attr__( 'Description of foreground color', 'azbalac' ),
			'default'     => '#554433',
        ),*/
        /*'color_bg' => array(
			'type'        => 'colorpicker',
			'label'       => esc_attr__( 'Background color', 'azbalac' ),
			'description' => esc_attr__( 'Description of background color', 'azbalac' ),
			'default'     => '#000000',
        ),*/
        'content' => array(
            'type'        => 'textarea',
            'label'       => esc_attr__( 'Text', 'azbalac' ),
            //'default'     => 'Default value in textarea',
        ),
        'icon' => array(
            'type'        => 'select',
            'label'       =>  __('Select Font Awesome Icon or&hellip;', 'azbalac'),
            'description' => __('Select Icon or&hellip;', 'azbalac'),
            'choices' => $this->getFaIcons(),
            //'default' => 'fa-car'
        ),
        'image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use Image', 'azbalac'),
            'mime_type' => 'image',
            'description' => __('Use Image instead of Icon', 'azbalac')
        ),

        'page' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Page or&hellip;', 'azbalac'),
            'choices' => Azbalac_Custom_Repeater_Helper::getPageDropdownOptions()
        ),
        'post' => array(
            'type'        => 'dropdown-pages',
            'label'       =>  __('Link to Post or&hellip;', 'azbalac'),
            'choices' => Azbalac_Custom_Repeater_Helper::getPostDropdownOptions()
        ),
        'url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link to any URL', 'azbalac' ),
            //'description' => esc_attr__( 'This will be the link URL', 'azbalac' ),
            //'default'     => 'another default test for text',
        ),
        'color_icon' => array(
            'type'        => 'colorpicker',
            'label'       => esc_attr__( 'Icon Color', 'azbalac' ),
            //'description' => esc_attr__( 'Description of background color', 'azbalac' ),
            //'default'     => '#000000',
        ),

        'image_shape' => array(
            'type'      => 'radiobutton',
            'label' => __('Image Shape', 'azbalac'),
            'description' => __('Use image shape for uploaded image:', 'azbalac'),
            'default' => '2',
            'choices' => array(
                '1' => __('Rounded Corners', 'azbalac'),
                '2' => __('Circle', 'azbalac'),
                '3' => __('Thumbnail', 'azbalac'),
                '4' => __('No Image Shape', 'azbalac'),
                
            ),
        ),
        /*


        'azbalac_setting_content_area_image' => array(
            'type'        => 'image',
            'label' => __('&hellip;use image', 'azbalac'),
            'mime_type' => 'image',
            'description' => __('Image displayed on section background', 'azbalac')
        ),
        
      
        ),
        'image_show' => array(
            'label' => __('Show checkbox', 'azbalac'),
            'type' => 'checkbox',
            //'default' => 'checked',
            'description' => __('Check to activate!', 'azbalac')
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
        $icons[0] = __('Choose Icon', 'azbalac');
        foreach ($lines as $line) {
            if ($line) {
                $icons[$line] = $line;
            }
        }
        return $icons;
    }
}