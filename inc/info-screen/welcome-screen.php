<?php
/**
 * Welcome Screen Class
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Tikva_Welcome')) {

    class Tikva_Welcome
    {

        /**
         * Constructor for the welcome screen
         */
        public function __construct()
        {

            /* create dashbord page */
            add_action('admin_menu', array($this, 'Tikva_welcome_register_menu'));


            /* enqueue script and style for welcome screen */
            add_action('admin_enqueue_scripts', array($this, 'Tikva_welcome_style_and_scripts'));

            /* enqueue script for customizer */
            // strange - if called, header image in customizer don't work anymore...
          // add_action('customize_controls_enqueue_scripts', array($this, 'Tikva_welcome_scripts_for_customizer'));

            /* load welcome screen */
            add_action('Tikva_welcome', array($this, 'Tikva_welcome_getting_started'), 10);

            add_action('Tikva_welcome', array($this, 'Tikva_welcome_changelog'), 50);
        }

        /**
         * Creates the dashboard page
         * @see  add_theme_page()
         * @since 0.4.3
         */
        public function Tikva_welcome_register_menu()
        {
            add_theme_page('About Tikva', 'About Tikva', 'activate_plugins', 'tikva-welcome', array($this, 'Tikva_welcome_screen'));
        }

        /**
         * Load welcome screen css and javascript
         * @since  0.4.3
         */
        public function Tikva_welcome_style_and_scripts($hook_suffix)
        {

            if ('appearance_page_tikva-welcome' == $hook_suffix) {
                wp_enqueue_style('tikva-welcome-screen-css', get_template_directory_uri() . '/inc/info-screen/css/welcome.css');
                wp_enqueue_script('tikva-welcome-screen-js', get_template_directory_uri() . '/inc/info-screen/js/welcome.js', array('jquery'));
            }
        }

        /**
         * Load scripts for customizer page
         * @since  0.4.3
         */
        public function Tikva_welcome_scripts_for_customizer()
        {
         //   wp_enqueue_style('tikva-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/info-screen/css/welcome_customizer.css');
       /*     wp_enqueue_script('tikva-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/info-screen/js/welcome_customizer.js', array('jquery'), '20120206', true);

            global $Tikva_required_actions;

            $nr_actions_required = 0;

            wp_localize_script('tikva-welcome-screen-customizer-js', 'tikvaWelcomeScreenCustomizerObject', array(
                'nr_actions_required' => $nr_actions_required,
                'aboutpage' => esc_url(admin_url('themes.php?page=tikva-welcome#getting_started')),
                'customizerpage' => esc_url(admin_url('customize.php#actions_required')),
                'themeinfo' => __('View Theme Info', 'tikva'),
            ));
            */
        }

        /**
         * Welcome screen content
         * @since 0.4.3
         */
        public function Tikva_welcome_screen()
        {

            require_once( ABSPATH . 'wp-load.php' );
            require_once( ABSPATH . 'wp-admin/admin.php' );
            require_once( ABSPATH . 'wp-admin/admin-header.php' );
            ?>

            <ul class="tikva-nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#getting_started" aria-controls="getting_started" role="tab" data-toggle="tab"><?php esc_html_e('Getting started', 'tikva'); ?></a></li>
                <li role="presentation"><a href="#changelog" aria-controls="changelog" role="tab" data-toggle="tab"><?php esc_html_e('Changelog', 'tikva'); ?></a></li>
            </ul>

            <div class="tikva-tab-content">

            <?php
            /**
             * @hooked Tikva_welcome_getting_started - 10
             * @hooked Tikva_welcome_actions_required - 20
             * @hooked Tikva_welcome_changelog - 50
             */
            do_action('Tikva_welcome');
            ?>

            </div>
                <?php
            }

            /**
             * Getting started
             * @since 0.4.3
             */
            public function Tikva_welcome_getting_started()
            {
                require_once( get_template_directory() . '/inc/info-screen/sections/getting-started.php' );
            }

            /**
             * Changelog
             * @since 0.4.3
             */
            public function Tikva_welcome_changelog()
            {
                require_once( get_template_directory() . '/inc/info-screen/sections/changelog.php' );
            }

        }

        $GLOBALS['Tikva_Welcome'] = new Tikva_Welcome();
    }
    ?>