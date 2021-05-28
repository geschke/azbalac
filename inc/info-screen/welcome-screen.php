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

//            update_option('azbalac_notice_version_dismissed','foooo');

        }

        /**
         * Creates the dashboard page
         * @see  add_theme_page()
         * @since 0.1
         */
        public function azbalac_welcome_register_menu()
        {
            add_theme_page('About Azbalac', 'About Azbalac', 'activate_plugins', 'azbalac-welcome', array($this, 'azbalac_welcome_screen'));
        }

        /**
         * Adds an admin notice upon successful activation.
         * @since 0.1
         */
        public function activation_admin_notice()
        {
           $azbalac = wp_get_theme('azbalac');

            //echo $azbalac['Version'];
            $dismissedNotice = get_option('azbalac_notice_version_dismissed');
            //var_dump(get_option( 'azbalac_lala'));
            //var_dump($dismissedNotice);
            //die;
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
         * @since 0.1
         */
        public function welcome_admin_notice()
        {
            ?>
            <div class="updated notice azbalac-admin-notice is-dismissible">
                <p><?php echo sprintf(esc_html__('Welcome! Thank you for choosing Azbalac Theme! Please have a look at the new %swelcome page%s. You will find some information about new or updated features there.', 'azbalac'), '<a href="' . esc_url(admin_url('themes.php?page=azbalac-welcome')) . '">', '</a>'); ?></p>
                
            </div>
            <?php
        }

        /**
         * Ajax callback function to set option to dismiss admin notice of new or updated theme installation
         * @since 0.1
         */
        public function dismissWelcomeNoticeCallback()
        {
            $azbalac = wp_get_theme('azbalac');

            
            if (get_option( 'azbalac_notice_version_dismissed') !== false) {
                // just overwrite with current theme version
                
                update_option('azbalac_notice_version_dismissed', $azbalac['Version'], false);
            } else { // create, if doesn't exist
                add_option( 'azbalac_notice_version_dismissed', $azbalac['Version'], false);
            }
            wp_die(); // this is required to terminate immediately and return a proper response

        }

        /**
         * Load welcome screen css and javascript
         * @since  0.1
         */
        public function azbalac_welcome_style_and_scripts($hook_suffix)
        {
            //echo "hook_suffix: " . $hook_suffix;
            
            wp_enqueue_script('azbalac-welcome-screen-js', get_template_directory_uri() . '/inc/info-screen/js/welcome.js', array('jquery'));
            if ('appearance_page_azbalac-welcome' == $hook_suffix) {
                
                wp_enqueue_script('azbalac-admin-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '5.0.1', true);
                wp_enqueue_style('azbalac-admin-bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), AZBALAC_DATEVERSION );
                wp_enqueue_style('azbalac-welcome-screen-css', get_template_directory_uri() . '/inc/info-screen/css/welcome.css', array(), AZBALAC_DATEVERSION );
            

               
            }
        }

     

        /**
         * Welcome screen content
         * @since 0.1
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
                    <li class="active"><a class="nav-link active" id="tab-getting-started" href="#azbalac-tab-getting-started" aria-controls="azbalac-tab-getting-started" role="tab" data-toggle="tab">Getting started</a></li>
                    <li><a class="nav-link" id="tab-changelog" href="#azbalac-tab-changelog" aria-controls="azbalac-tab-changelog" role="tab" data-toggle="tab">Changelog</a></li>

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
         * @since 0.1
         */
        public function azbalac_welcome_getting_started()
        {
            get_template_part('/inc/info-screen/sections/getting-started' );
        }

        /**
         * Changelog
         * @since 0.1
         */
        public function azbalac_welcome_changelog()
        {
            get_template_part('inc/info-screen/sections/changelog');
        }

    }
 //new Azbalac_Welcome();
    $GLOBALS['Azbalac_Welcome'] = new Azbalac_Welcome();
}
?>