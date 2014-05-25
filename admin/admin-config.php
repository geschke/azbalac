<?php
/**
 * tikva Theme ReduxFramework Config File
For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 */

if (!class_exists("Redux_Framework_tikva_config")) {

    class Redux_Framework_tikva_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;


        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {


            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }


        /**

        Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

        Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }


        public function setSections() {

            /**
            Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'tikva'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
                <?php if ($screenshot) : ?>
                    <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                    <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4>
                    <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'tikva'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'tikva'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'tikva') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                    <?php
                    if ($this->theme->parent()) {
                        printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'tikva'), $this->theme->parent()->display('Name'));
                    }
                    ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();


            $designStylesheetPath = get_template_directory() . '/css/design/';
            $designStylesheets = array();

            if ( is_dir($designStylesheetPath) )
            {
                if ($alt_stylesheet_dir = opendir($designStylesheetPath) )
                {
                    while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false )
                    {
                        if(stristr($alt_stylesheet_file, ".css"))
                        {
                            $designStylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;
                        }
                    }
                }
            }
            asort($designStylesheets);



            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] =  array(
                'title' => __('Home Settings', 'tikva'),
                //'desc' => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'tikva'),
                'icon' => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id'=>'featured_articles_max',
                        'type' => 'slider',
                        'title' => __('Maximum number of featured articles on homepage', 'tikva'),
                        //'desc'=> __('JQuery UI slider description. Min: 1, max: 500, step: 3, default value: 45', 'tikva'),
                        "default" 		=> "5",
                        "min" 		=> "0",
                        "step"		=> "1",
                        "max" 		=> "100",
                    ),

                ),
            );



            $this->sections[] = array(
                'type' => 'divide',
            );


            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Styling Options', 'tikva'),
                'fields' => array(


                    array(
                        'id'=>'layout',
                        'type' => 'image_select',
                        'title' => __('Layout', 'tikva'),
                        //'subtitle' => __('No validation can be done on this field type', 'tikva'),
                        'desc' => __('Set layout or your site.', 'tikva'),
                        'options' => array(
                            '1' => array('alt' => '1 Column', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column, Content left, Sidebar right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                            '3' => array('alt' => '2 Column, Content right, Sidebar left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                            //'4' => array('alt' => '3 Column Middle', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                            //'5' => array('alt' => '3 Column Left', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                            //'6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url.'assets/img/3cr.png')
                        ),//Must provide key => value(array:title|img) pairs for radio options
                        'default' => '2'
                    ),

                    array(
                        'id'=>'stylesheet',
                        'type' => 'select',
                        'title' => __('Theme Stylesheet', 'tikva'),
                        'subtitle' => __('Select your themes alternative color scheme.', 'tikva'),
                        'options' => $designStylesheets, //array('bootstrap.min.css'=>'bootstap.css',
                        //'united.min.css'=>'united.css'),
                        'default' => 'bootstap.css',
                    ),
                    array(
                        'id'=>'navbar-fixed',
                        'type' => 'button_set',
                        'title' => __('Navbar fixed options', 'tikva'),
                        //'subtitle' => __('No validation can be done on this field type', 'tikva'),
                        //'desc' => __('This is the description field, again good for additional info.', 'tikva'),
                        'options' => array('default' => 'Default','fixed-top' => 'Fixed to top'),
                        //Must provide key => value pairs for radio options
                        'default' => 'default'
                    ),
                    array(
                        'id'=>'navbar-style-inverse',
                        'type' => 'button_set',
                        'title' => __('Navbar style', 'tikva'),
                        //'subtitle' => __('No validation can be done on this field type', 'tikva'),
                        //'desc' => __('This is the description field, again good for additional info.', 'tikva'),
                        'options' => array('default' => 'Default','inverse' => 'Inverse'),
                        //Must provide key => value pairs for radio options
                        'default' => 'default'
                    ),
              /*          'id'=>'header-image',
                        'type' => 'media',
                        'url'=> true,
                        'title' => __('Header Image', 'tikva'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'=> __('Use header image when chosen default navbar.', 'tikva'),
                        //'subtitle' => __('Upload header imageany media using the WordPress native uploader', 'tikva'),
                        'default'=>array('url'=>'')
                    ),
               */
                    array(
                        'id'=>'color-fg-header',
                        'type' => 'color',
                        //'output' => array('.site-title'),
                        'title' => __('Header Font Color', 'tikva'),
                        'subtitle' => __('Pick a foreground color for the theme (default: #fff).', 'tikva'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                    ),
                    array(
                        'id'=>'color-bg-header',
                        'type' => 'color',
                        'title' => __('Header Background Color', 'tikva'),
                        'subtitle' => __('Pick a background color for the footer (default: #666666).', 'tikva'),
                        'default' => '#666666',
                        'validate' => 'color',
                    ),
                    array(
                        'id'=>'color-fg-footer',
                        'type' => 'color',
                        //'output' => array('.site-title'),
                        'title' => __('Footer Font Color', 'tikva'),
                        'subtitle' => __('Pick a foreground color for the theme (default: #fff).', 'tikva'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                    ),
                    array(
                        'id'=>'color-bg-footer',
                        'type' => 'color',
                        'title' => __('Footer Background Color', 'tikva'),
                        'subtitle' => __('Pick a background color for the footer (default: #666666).', 'tikva'),
                        'default' => '#666666',
                        'validate' => 'color',
                    )
                ));





            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'tikva') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'tikva') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'tikva') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'tikva') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                // ugly stuff! A local file should be readable without going remote!
                // And the WP_Filesystem API is not really senseful, there is no need for credentials from a formular!!!
                $readmeContent = wp_remote_retrieve_body( wp_remote_get( get_template_directory_uri() . '/README.md' )); //$wp_filesystem->get_contents(dirname(__FILE__) . '/../README.md');
                $this->sections['theme_docs'] = array(
                    'icon' => 'el-icon-list-alt',
                    'title' => __('Documentation', 'tikva'),
                    'fields' => array(
                        array(
                            'id' => '17',
                            'type' => 'raw',
                            'markdown' => true,
                            'content' => $readmeContent
                        ),
                    ),
                );
            }//if
            // You can append a new section at any time.


            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon' => 'el-icon-info-sign',
                'title' => __('Theme Information', 'tikva'),
                //'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'tikva'),
                'fields' => array(
                    array(
                        'id' => 'raw_new_info',
                        'type' => 'raw',
                        'content' => $item_info,
                    )
                ),
            );


        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('Theme Information 1', 'tikva'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'tikva')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('Theme Information 2', 'tikva'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'tikva')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'tikva');
        }

        /**

        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'tikva_theme', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('tikva Theme Options', 'tikva'),
                'page' => __('tikva Theme Options', 'tikva'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyAuAl40BlKHKsDEYeHbVMbJpD1ygXc0-8Q', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => true, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/rgeschke',
                'title' => 'Like us on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/geschke',
                'title' => 'Follow me on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://de.linkedin.com/in/geschke/',
                'title' => 'Find me on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );



            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'tikva'), $v);
            } else {
                //$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'tikva');
            }

            // Add content after the form.
           // $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'tikva');
        }

    }

    new Redux_Framework_tikva_config();
}


/**

Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
