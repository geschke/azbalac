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
     * The fields that each container row will contain.
     *
     * @access public
     * @var array
     */
    public $fields = array();
    
    public $id;

    /*Class constructor*/
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct( $manager, $id, $args );
    
        // fields could be empty due to initialization by WP_Customize_Manager in print_template()
		if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
			$args['fields'] = array();
		}
		$this->fields = $args['fields'];

        

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
		
        wp_localize_script( 'customizer-font-script', 'objectL10n', array(
            'select_image' => esc_html__( 'Select Image', 'tikva' ),
            'remove' => esc_html__( 'Remove', 'tikva' ),
            'change_image' => esc_html__( 'Change Image', 'tikva' ),
            'no_image_selected' => esc_html__( 'No Image selected', 'tikva' ),
            'choose_image' => esc_html__( 'Choose Image', 'tikva' )
            
            

        ) );

    }


    public function to_json()
    {
        
        parent::to_json();

 /* Get default options */
//        $defaultValues = json_decode( $this->setting->default );
    
        $this->json['default'] = ( isset( $this->default ) ) ? $this->default : $this->setting->default;

        $values = $this->value();
        $this->json['fields'] = $this->fields;
        $json = json_decode( $values );

        if (! is_array( $json )) {
            $json = array( $values );
        }
      
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
/*        if (data.value && data.value[0] != "") {
            // predefined values from database
            var elementData = JSON.parse(decodeURI(data.value));
            

        } else {
            // initialize empty elements with dummy data
            var newElementId = uuidv4();
            var elementData = {};
            elementData[newElementId] = true;
        }*/
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
                
           
			
		
		</div>
        <input type="hidden" value="{{{ data.value }}}" class="tikva_font_collector" id="tikva_font_{{{ data.section }}}" name="tikva_font_{{{ data.section }}}"/>
       
        <?php
    }

  
}
