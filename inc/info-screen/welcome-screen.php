<?php
/**
 * Welcome Screen Class
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Azbalac_Welcome')) {

    class Azbalac_Welcome
    {

        /**
         * Constructor for the welcome screen
         */
        public function __construct()
        {

            /* create dashbord page */
            add_action('admin_menu', array($this, 'azbalac_welcome_register_menu'));


            /* enqueue script and style for welcome screen */
            add_action('admin_enqueue_scripts', array($this, 'azbalac_welcome_style_and_scripts'));


            /* activation notice */
            //add_action( 'load-themes.php', array( $this, 'activation_admin_notice' ) );
            $this->activation_admin_notice();

            /* load welcome screen */
            add_action('azbalac_welcome', array($this, 'azbalac_welcome_getting_started'), 10);

            add_action('azbalac_welcome', array($this, 'azbalac_welcome_changelog'), 50);

            add_action('wp_ajax_azbalac_dismiss_welcome_notice', array($this, 'dismissWelcomeNoticeCallback'));


          
        }

        /**
         * Creates the dashboard page
         * @see  add_theme_page()
         * @since 0.4.4
         */
        public function azbalac_welcome_register_menu()
        {
            add_theme_page('About Azbalac', 'About Azbalac', 'activate_plugins', 'azbalac-welcome', array($this, 'azbalac_welcome_screen'));
        }

        /**
         * Adds an admin notice upon successful activation.
         * @since 0.4.4
         */
        public function activation_admin_notice()
        {
           $azbalac = wp_get_theme('azbalac');

            //echo $azbalac['Version'];
            $dismissedNotice = get_option('azbalac_notice_dismissed_version');
            //$dismissedNotice = 1;
            if (is_admin() && (empty($dismissedNotice) || $azbalac['Version'] != $dismissedNotice)) {
                //  !function_exists( 'the_field' ) ) {
                add_action('admin_notices', array($this, 'welcome_admin_notice'));
            }
            //if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
//			add_action( 'admin_notices', array( $this, 'Awada_lite_welcome_admin_notice' ), 99 );
//		}
        }

        /**
         * Display an admin notice linking to the welcome screen
         * @since 0.4.4
         */
        public function welcome_admin_notice()
        {
            ?>
            <div class="updated notice azbalac-admin-notice is-dismissible">
                <p><?php echo sprintf(esc_html__('Welcome! Thank you for choosing azbalac Theme! Please have a look at the new %swelcome page%s. You will find some information about new or updated features there.', 'azbalac'), '<a href="' . esc_url(admin_url('themes.php?page=azbalac-welcome')) . '">', '</a>'); ?></p>
                
            </div>
            <?php
        }

        /**
         * Ajax callback function to set option to dismiss admin notice of new or updated theme installation
         * @since 0.4.4
         */
        public function dismissWelcomeNoticeCallback()
        {
            //echo "OK!";
            $azbalac = wp_get_theme('azbalac');

            
            // $dismissedNotice = get_option( 'azbalac_notice_dismissed_version');
            // just overwrite with current theme version
            update_option('azbalac_notice_dismissed_version', $azbalac['Version']);


            die(); // this is required to return a proper result
        }

        /**
         * Load welcome screen css and javascript
         * @since  0.4.4
         */
        public function azbalac_welcome_style_and_scripts($hook_suffix)
        {
            //echo "hook_suffix: " . $hook_suffix;
            
            wp_enqueue_script('azbalac-welcome-screen-js', get_template_directory_uri() . '/inc/info-screen/js/welcome.js', array('jquery'));
            if ('appearance_page_azbalac-welcome' == $hook_suffix) {
                wp_enqueue_script('azbalac-admin-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.7', true);
                wp_enqueue_style('azbalac-admin-bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '2016082101');
                wp_enqueue_style('azbalac-welcome-screen-css', get_template_directory_uri() . '/inc/info-screen/css/welcome.css', array(), '2016082101');
            

               
            }
        }

     

        /**
         * Welcome screen content
         * @since 0.4.4
         */
        public function azbalac_welcome_screen()
        {
            require_once( ABSPATH . 'wp-load.php' );
            require_once( ABSPATH . 'wp-admin/admin.php' );
            require_once( ABSPATH . 'wp-admin/admin-header.php' );
            ?>

            <!-- Nav tabs -->
            <div class="azbalac-wrap">
                <ul class="azbalac-nav-tabs nav nav-tabs" role="tablist">
                    <li class="active"><a href="#azbalac-tab-getting-started" aria-controls="azbalac-tab-getting-started" role="tab" data-toggle="tab">Getting started</a></li>
                    <li><a href="#azbalac-tab-changelog" aria-controls="azbalac-tab-changelog" role="tab" data-toggle="tab">Changelog</a></li>

                </ul>



                <div class="tab-content">

            <?php
            /**
             * @hooked azbalac_welcome_getting_started - 10
             * @hooked azbalac_welcome_actions_required - 20
             * @hooked azbalac_welcome_changelog - 50
             */
            do_action('azbalac_welcome');
            ?>

                </div>
            </div>
            <?php
        }

        /**
         * Getting started
         * @since 0.4.4
         */
        public function azbalac_welcome_getting_started()
        {
            get_template_part('/inc/info-screen/sections/getting-started' );
        }

        /**
         * Changelog
         * @since 0.4.4
         */
        public function azbalac_welcome_changelog()
        {
            get_template_part('inc/info-screen/sections/changelog');
        }

    }
 //new azbalac_Welcome();
    $GLOBALS['azbalac_Welcome'] = new Azbalac_Welcome();
}
?>