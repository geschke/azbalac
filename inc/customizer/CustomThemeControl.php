<?php


if (! class_exists( 'WP_Customize_Control' )) {
    return null;
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
        global $wpdb; // this is how you get access to the database
        
        $searchfont = $_POST['searchfont'];

        $gglfonts = $GLOBALS['azbalacGoogleFonts']; 
        
        $fontData = null;
        foreach ($gglfonts['items'] as $gglfont) {
            if ($gglfont['family'] == $searchfont) {
                $fontData = $gglfont;
                break;
            }
        }
        
        echo json_encode($fontData);
        
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function getDefaultThemeDataAction()
    {
        global $wpdb; // this is how you get access to the database
        
        
        
        echo json_encode(Azbalac_Custom_Font_List::FONTS);
        
        wp_die(); // this is required to terminate immediately and return a proper response
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
        global $wp_scripts;

		wp_enqueue_script( 'customizer-theme-script', get_template_directory_uri().'/js/custom-theme.js', array( 'jquery'), '', true );

        wp_enqueue_script('underscore');
        
       

    }


    public function getThemeData()
    {
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once ( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
        }


        $themes = $wp_filesystem->get_contents(get_template_directory() . '/css/themes.json');
        return json_decode($themes);
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
    
        // Default font list from https://www.w3schools.com/cssref/css_websafe_fonts.asp
        $themes[] = array('k' => 0, 'v' => __( '&mdash; Select &mdash;', 'azbalac' ));

        $themeData = $this->getThemeData();
        
        foreach ($themeData as $key => $value) {
            $themes[] = array('k' => $key, 'v' => $value->name);
            
        }


        
    
        // build gglfonts options
/*        $gglfonts = $GLOBALS['azbalacGoogleFonts']; 
        $gglfontsItems = $gglfonts['items'];
   
        $cnt = count($gglfontsItems);
      
        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Google Webfonts');
        
         foreach ($gglfontsItems as $item) {
            $fonts[] = array('k' => $item['family'], 'v' => $item['family']);
         
        }
        $fonts[] = array('c' => 'optgroup_end');
  */      
      

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
            var elementData = JSON.parse(decodeURI(data.value));
            

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
