<?php

/**
 * Default Font list as constant array
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.5.3
 */
class Tikva_Custom_Font_List
{
    const FONTS = array(
        '1' => 'Georgia, serif',
        '2' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
        '3' => '"Times New Roman", Times, serif',
        '10' => 'Arial, Helvetica, sans-serif',
        '11' => '"Arial Black", Gadget, sans-serif',
        '12' => '"Comic Sans MS", cursive, sans-serif',
        '13' => 'Impact, Charcoal, sans-serif',
        '14' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
        '15' => 'Tahoma, Geneva, sans-serif',
        '16' => '"Trebuchet MS", Helvetica, sans-serif',
        '17' => 'Verdana, Geneva, sans-serif',
        '30' => '"Courier New", Courier, monospace',
        '31' => '"Lucida Console", Monaco, monospace'
      

    );

    const DEFAULT_SIZE = 14;
}

if (! class_exists( 'WP_Customize_Control' )) {
    return null;
}



class Tikva_Custom_Font_Request 
{
    public function __construct() 
    {
        add_action( 'wp_ajax_tikva_get_font_data_action', array($this,'getFontDataAction' ));
        add_action( 'wp_ajax_tikva_get_default_font_data_action', array($this,'getDefaultFontDataAction' ));
        

    }

    public function getFontDataAction()
    {
        global $wpdb; // this is how you get access to the database
        
        $searchfont = $_POST['searchfont'];

        $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
        
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

    public function getDefaultFontDataAction()
    {
        global $wpdb; // this is how you get access to the database
        
        
        
        echo json_encode(Tikva_Custom_Font_List::FONTS);
        
        wp_die(); // this is required to terminate immediately and return a proper response
    }

}


/**
 * Customizer Control: Font
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.5.3
 */
class Tikva_Custom_Font_Control extends WP_Customize_Control
{


    
   
    /**
    * Define the control type
    */
    public $type = 'tikva_font';


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

		wp_enqueue_script( 'customizer-font-script', get_template_directory_uri().'/js/custom-font.js', array( 'jquery'), '', true );

        wp_enqueue_script('underscore');
        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('jquery-ui-slider');
        
        // taken from: https://snippets.webaware.com.au/snippets/load-a-nice-jquery-ui-theme-in-wordpress/
        $ui = $wp_scripts->query('jquery-ui-core');
        
        // tell WordPress to load the Smoothness theme from Google CDN

        $protocol = is_ssl() ? 'https' : 'http';
        $url = "$protocol://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
        wp_enqueue_style('jquery-ui-smoothness', $url, false, null);

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
        $fonts[] = array('k' => 0, 'v' => __( '&mdash; Select &mdash;', 'tikva' ));
        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Serif Fonts');
        $fonts[] = array('k' => 1, 'v' => Tikva_Custom_Font_List::FONTS['1']);
        $fonts[] = array('k' => 2, 'v' => Tikva_Custom_Font_List::FONTS['2']);
        $fonts[] = array('k' => 3, 'v' => Tikva_Custom_Font_List::FONTS['3']);
        $fonts[] = array('c' => 'optgroup_end');

        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Sans Serif Fonts');
        $fonts[] = array('k' => 10, 'v' => Tikva_Custom_Font_List::FONTS['10']);
        $fonts[] = array('k' => 11, 'v' => Tikva_Custom_Font_List::FONTS['11']);
        $fonts[] = array('k' => 12, 'v' => Tikva_Custom_Font_List::FONTS['12']);
        $fonts[] = array('k' => 13, 'v' => Tikva_Custom_Font_List::FONTS['13']);
        $fonts[] = array('k' => 14, 'v' => Tikva_Custom_Font_List::FONTS['14']);
        $fonts[] = array('k' => 15, 'v' => Tikva_Custom_Font_List::FONTS['15']);
        $fonts[] = array('k' => 16, 'v' => Tikva_Custom_Font_List::FONTS['16']);
        $fonts[] = array('k' => 17, 'v' => Tikva_Custom_Font_List::FONTS['17']);
        $fonts[] = array('c' => 'optgroup_end');

        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Monospace Fonts');
        $fonts[] = array('k' => 30, 'v' => Tikva_Custom_Font_List::FONTS['30']);
        $fonts[] = array('k' => 31, 'v' => Tikva_Custom_Font_List::FONTS['31']);
        
        $fonts[] = array('c' => 'optgroup_end');
        
    
        // build gglfonts options
        $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
        $gglfontsItems = $gglfonts['items'];
   
        $cnt = count($gglfontsItems);
      
        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Google Webfonts');
        
         foreach ($gglfontsItems as $item) {
            $fonts[] = array('k' => $item['family'], 'v' => $item['family']);
         
        }
        $fonts[] = array('c' => 'optgroup_end');
        
      

        // add font choices to json array
        $this->json['choices'] = $fonts;
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
            elementData['font'] = 0; // default nothing chosen
        }
        #>
		<div class="customize-control-font-element-container">

            <label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
					<# } #>

					<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
					<# } #>
						
            </label>
            
            <div class="customize-control-font-element" id="{{{ data.identifier }}}">
				
			    <div class="font-row-content">
			
                    <div class="font-row-field">
                    <#
                    var selectValue = '';
                 

                    if (typeof elementData.font != 'undefined' && elementData.font != 0) {
                        selectValue = elementData.font;
                    } else { 
                        selectValue = data.defaults.font; 
                    }
                
                    #>
                    <select class="customize-font-input-select" data-field="{{{ data.identifier }}}" data-default="{{{ data.defaults.font }}}" data-default-selected="{{{ selectValue }}}" >
                    <# var selectString = '';
                        _.each(data.choices, function(choiceOption, choiceValue) {
                        
                        selectString = '';

                        if (typeof choiceOption.c != 'undefined') { // command mode
                            if (choiceOption.c == 'optgroup_start') {
                                #>
                                <optgroup label="{{{ choiceOption.v }}}">
                                <#
                            } 
                            if (choiceOption.c == 'optgroup_end') {
                                #>
                                </optgroup>
                                <#
                            }

                        } else { // value mode
                            if (choiceOption.k == selectValue) {
                                selectString = 'selected="selected"';
                            }
                            #>
                            <option {{{ selectString }}} value="{{{ choiceOption.k }}}"  >{{{ choiceOption.v }}}</option>
                            <#
                        }
                        
                    });    
                    #>
                    </select>

                    </div>
                </div>
         
                <div class="font-row-content font-input-select-variant">
                    <label>
                    <?php echo __('Select font variant:', 'tikva'); ?>
                    </label>
                    <div class="font-row-field">
                    <#
                    // if gglfont, fill default variant into data-default
                    var defaultVariant = '';
                    var gglfont = '';
                    
                    if (typeof elementData['gglfont'] != 'undefined' && elementData['gglfont'] == true) {
                        gglfont = 'true'; // in html we only have strings
                        if (typeof elementData['gglfontdata'] != 'undefined' && elementData['gglfontdata'] != null && typeof elementData['gglfontdata']['variant'] != 'undefined') {
                            defaultVariant = elementData['gglfontdata']['variant'];
                        }
                    }
                    #>
                    <select class="customize-font-input-select-variant" data-field="{{{ data.identifier }}}" data-font-variant="{{{ gglfont }}}"  data-default="{{{ data.defaults.variant }}}" data-default-selected="{{{ defaultVariant }}}" >
                   
                            <option value="0"  ><?php echo __( '&mdash; Select &mdash;', 'tikva' ); ?></option>
                     
                    </select>

                    </div>
                </div>
	  
            <label>
                <span class="customize-control-title">
                <?php echo __('Font Size','tikva'); ?>
                </span>
                <input type="text"  id="input_size_{{{ data.identifier }}}" disabled data-default="{{{ data.defaults.size }}}" value=""/>

            </label>

            <div style="padding-top: 10px;">
                <div  id="slider_size_{{{ data.identifier }}}"></div>
            </div>

            <input type="hidden" value="{{{ data.value }}}" class="tikva_font_collector" id="tikva_font_{{{ data.identifier }}}" name="tikva_font_{{{ data.identifier }}}"/>
        
            </div>    
		
        </div>
    
        <?php
    }

  
}
