<?php


if (! class_exists( 'WP_Customize_Control' )) {
    return null;
}

class Azbalac_Custom_Theme_Data
{

    public static function getThemeData()
    {
        $themesFile = get_template_directory() . '/css/themes.json';

        if (!is_readable($themesFile)) {
            return new stdClass();
        }

        $themes = file_get_contents($themesFile);

        if ($themes === false) {
            return new stdClass();
        }

        $themeData = json_decode($themes);

        return is_object($themeData) ? $themeData : new stdClass();
    }

    public static function getTheme($themeId)
    {
        $themeId = (string) $themeId;
        $themes = self::getThemeData();

        if (!isset($themes->{$themeId})) {
            return null;
        }

        return $themes->{$themeId};
    }

}

/**
 * todo
 */
class Azbalac_Custom_Theme_Request 
{
    public function __construct() 
    {
        add_action( 'wp_ajax_azbalac_get_theme_data_action', array($this,'getThemeDataAction' ));
        add_action( 'wp_ajax_azbalac_get_default_theme_data_action', array($this,'getDefaultThemeDataAction' ));
        

    }

    public function getThemeDataAction()
    {
        check_ajax_referer('azbalac_customizer_ajax', 'nonce');

        if (!current_user_can('edit_theme_options')) {
            wp_send_json_error(array('message' => __('Permission denied.', 'azbalac')), 403);
        }

        if (!isset($_POST['searchtheme'])) {
            wp_send_json_error(array('message' => __('Missing theme name.', 'azbalac')), 400);
        }

        $searchtheme = sanitize_text_field(wp_unslash($_POST['searchtheme']));

        $themeData = Azbalac_Custom_Theme_Data::getThemeData();

        $themeResult = null;
        foreach ($themeData as $key => $value) {
            if ($key === $searchtheme) {
                $themeResult['key'] = $key;
                $themeResult['value'] = $value;
                break;
            }
        }

        if ($themeResult === null) {
            wp_send_json_error(array('message' => __('Theme not found.', 'azbalac')), 404);
        }

        wp_send_json_success($themeResult);
    }

    public function getDefaultThemeDataAction()
    {
        check_ajax_referer('azbalac_customizer_ajax', 'nonce');

        if (!current_user_can('edit_theme_options')) {
            wp_send_json_error(array('message' => __('Permission denied.', 'azbalac')), 403);
        }

        wp_send_json_success(Azbalac_Custom_Font_List::FONTS);
    }

}


/**
 * Customizer Control: Font
 *
 * @package     Azbalac Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2018, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.1
 */
class Azbalac_Custom_Theme_Control extends WP_Customize_Control
{


    
   
    /**
    * Define the control type
    */
    public $type = 'azbalac_theme';


    /**
     * Label for the control.
     * Needed for accessing label

     * @access public
     * @var string
     */
    public $label = '';
    
    /**
    * Description for the control.
    *

    * @access public
    * @var string
    */
    public $description = '';

    /**
     * To access this variable, just define it here.
     * @access public
     * @var array
     */
    public $default = '';
    
    public $defaults;

    public $id;

    /**
     * Class constructor
    */
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct( $manager, $id, $args );
    
        // fields could be empty due to initialization by WP_Customize_Manager in print_template()
		if ( empty( $args['defaults'] ) || ! is_array( $args['defaults'] ) ) {
			$args['defaults'] = array();
		}
		$this->defaults = $args['defaults'];
        
       

        if (! empty( $args['id'] )) {
            $this->id = $args['id'];
        }
    }

    /**
     * Enqueue resources for the control
     */
    public function enqueue()
    {
		wp_enqueue_script(
            'customizer-theme-script',
            get_template_directory_uri() . '/js/custom-theme.js',
            array('jquery', 'customize-controls'),
            AZBALAC_DATEVERSION,
            true
        );

        wp_localize_script('customizer-theme-script', 'azbalacThemeAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('azbalac_customizer_ajax'),
        ));
    }


  

    public function to_json()
    {
        
        parent::to_json();

        /* Get default options */
        $this->json['default'] = ( isset( $this->default ) ) ? $this->default : $this->setting->default;

        // shortcut to use as identifier for the current control in underscore template
        $this->json['identifier'] = $this->json['settings']['default'];

        $values = $this->value();
        $json = json_decode( $values );

        if (! is_array( $json )) {
            $json = array( $values );
        }
    
        // Add the default Bootstrap entry.
        $themes[] = array('k' => 0, 'v' => __( '&mdash; Select &mdash;', 'azbalac' ));

        $themeData = Azbalac_Custom_Theme_Data::getThemeData();
        
        foreach ($themeData as $key => $value) {
            $themes[] = array('k' => $key, 'v' => $value->name);
            
        }
        // add font choices to json array
        $this->json['choices'] = $themes;
        $this->json['value'] = $json;
        $this->json['defaults'] = $this->defaults;
    
    }

    /**
    * This has to be empty to use underscore JavaScript templates
    */
    protected function render_content()
    {
    }


    /**
    * Render customizer element content with Underscore's JavaScript template engine
    */
    public function content_template()
    {
        
        ?>
        <#
      
      
        if (data.value && data.value[0] != "") {
            // predefined values from database
            var elementData = JSON.parse(decodeURIComponent(data.value[0]));
            

        } else {
            // initialize empty elements with dummy data
            var elementData = {};
            elementData['theme'] = 0; // default nothing chosen
        }
        #>
		<div class="customize-control-theme-element-container">

            <label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
					<# } #>

					<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
					<# } #>
						
            </label>
            
            <div class="customize-control-theme-element" id="{{{ data.identifier }}}">
				
			    <div class="theme-row-content">
			
                    <div class="theme-row-field">
                    <#
                    var selectValue = '';
                 

                    if (typeof elementData.theme != 'undefined' && elementData.theme != 0) {
                        selectValue = elementData.theme;
                    } else { 
                        selectValue = data.defaults.theme; 
                    }
                
                    #>
                    <select class="customize-theme-input-select" data-field="{{{ data.identifier }}}" data-default="{{{ data.defaults.theme }}}" data-default-selected="{{{ selectValue }}}" >
                    <# var selectString = '';
                        _.each(data.choices, function(choiceOption, choiceValue) {
                        
                        selectString = '';

                        if (choiceOption.k == selectValue) {
                            selectString = 'selected="selected"';
                        }
                        #>
                        <option {{{ selectString }}} value="{{{ choiceOption.k }}}"  >{{{ choiceOption.v }}}</option>
                        <#
                    });    
                    #>
                    </select>

                    </div>
                </div>
         
                
	  
           

            <input type="hidden" value="{{{ data.value }}}" class="azbalac_theme_collector" id="azbalac_theme_{{{ data.identifier }}}" name="azbalac_theme_{{{ data.identifier }}}"/>
        
            </div>    
		
        </div>
    
        <?php
    }

  
}
