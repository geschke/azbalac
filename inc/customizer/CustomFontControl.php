<?php

if (! class_exists( 'WP_Customize_Control' )) {
    return null;
}
/**
 * Customizer Control: Font
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       2.0
 */
class Tikva_Custom_Font_Control extends WP_Customize_Control
{


    const FONT_01 = 'Georgia, serif';
    const FOMT_02 ='"Palatino Linotype", "Book Antiqua", Palatino, serif"';
    const LALA = array(1,'lala');
    /*
    $fonts[3] = '"Times New Roman", Times, serif';
    $fonts[4] = 'Arial, Helvetica, sans-serif';
    $fonts[5] = '"Arial Black", Gadget, sans-serif';
    $fonts[6] = '"Comic Sans MS", cursive, sans-serif';
    $fonts[7] = 'Impact, Charcoal, sans-serif';
    $fonts[8] = '"Lucida Sans Unicode", "Lucida Grande", sans-serif';
    $fonts[9] = 'Tahoma, Geneva, sans-serif';
    $fonts[10] = '"Trebuchet MS", Helvetica, sans-serif';
    $fonts[11] = 'Verdana, Geneva, sans-serif';
    $fonts[12] = '"Courier New", Courier, monospace';
    $fonts[13] = '"Lucida Console", Monaco, monospace';
*/
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
    
    public $id;

    /*Class constructor*/
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct( $manager, $id, $args );
    
        // fields could be empty due to initialization by WP_Customize_Manager in print_template()
		/*if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
			$args['fields'] = array();
		}
		$this->fields = $args['fields'];
        */
       

        if (! empty( $args['id'] )) {
            $this->id = $args['id'];
        }
    }

    /**
     * Enqueue resources for the control
     */
    public function enqueue()
    {
      
		wp_enqueue_script( 'customizer-font-script', get_template_directory_uri().'/js/custom-font.js', array( 'jquery'), '', true );

        wp_enqueue_script('underscore');
		
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
        $fonts[] = array('k' => 1, 'v' => 'Georgia, serif');
        $fonts[] = array('k' => 2, 'v' => '"Palatino Linotype", "Book Antiqua", Palatino, serif"');
        $fonts[] = array('k' => 3, 'v' => '"Times New Roman", Times, serif');
        $fonts[] = array('c' => 'optgroup_end');

        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Sans Serif Fonts');
        $fonts[] = array('k' => 10, 'v' => 'Arial, Helvetica, sans-serif');
        $fonts[] = array('k' => 11, 'v' => '"Arial Black", Gadget, sans-serif');
        $fonts[] = array('k' => 12, 'v' => '"Comic Sans MS", cursive, sans-serif');
        $fonts[] = array('k' => 13, 'v' => 'Impact, Charcoal, sans-serif');
        $fonts[] = array('k' => 14, 'v' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif');
        $fonts[] = array('k' => 15, 'v' => 'Tahoma, Geneva, sans-serif');
        $fonts[] = array('k' => 16, 'v' => '"Trebuchet MS", Helvetica, sans-serif');
        $fonts[] = array('k' => 17, 'v' => 'Verdana, Geneva, sans-serif');
        $fonts[] = array('c' => 'optgroup_end');

        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Monospace Fonts');
        $fonts[] = array('k' => 30, 'v' => '"Courier New", Courier, monospace');
        $fonts[] = array('k' => 31, 'v' => '"Lucida Console", Monaco, monospace');
        
        $fonts[] = array('c' => 'optgroup_end');
        
    
        
        $gglfonts = $GLOBALS['tikvaGoogleFonts']; 
       // print_r($gglfonts);
        $x = $gglfonts['items'];
        //print_r($x);
        $cnt = count($x);
      
        $fonts[] = array('c' => 'optgroup_start', 'v' => 'Google Webfonts');
        
         foreach ($x as $item) {
            $fonts[] = array('k' => $item['family'], 'v' => $item['family']);
         
        }
        $fonts[] = array('c' => 'optgroup_end');
        
      

        // add font choices to json array
        $this->json['choices'] = $fonts;
        $this->json['value'] = $json;
    
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
        console.log("in content_template");
        console.log(data);
        console.log(data.choices);
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
                    console.log("vor select");
                    console.log(elementData);

                    if (typeof elementData.font != 'undefined' && elementData.font != 0) {
                        selectValue = elementData.font;
                    } else { 
                        selectValue = data.default; // todo use more complex way to get value if there is more than one element in the custom field
                    }
                    console.log("Bestimmung selectValue:");
                    console.log(selectValue);
                    #>
                    <select class="customize-font-input-select" data-field="{{{ data.identifier }}}" data-default="{{{ data.default }}}" >
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
            </div>    
		
		</div>
        <input type="hidden" value="{{{ data.value }}}" class="tikva_font_collector" id="tikva_font_{{{ data.identifier }}}" name="tikva_font_{{{ data.identifier }}}"/>
       
        <?php
    }

  
}
