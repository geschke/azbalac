<?php

if (! class_exists( 'WP_Customize_Control' )) {
    return null;
}
/**
 * Customizer Control: repeater.
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       2.0
 */
class Tikva_Custom_Repeater_Control extends WP_Customize_Control
{

    /**
    * Define the control type
    */
    public $type = 'tikva_repeater';


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
        //wp_enqueue_style( 'customizer-repeater-font-awesome', get_template_directory_uri().'/customizer-repeater/css/font-awesome.min.css','1.0.0' );

        //wp_enqueue_style( 'customizer-repeater-admin-stylesheet', get_template_directory_uri().'/customizer-repeater/css/admin-style.css','1.0.0' );

        //wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri().'/js/custom_controls.js', array( 'jquery' ), '', true );

		wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri().'/js/custom-repeater.js', array( 'jquery'), '', true );

        wp_enqueue_script('underscore');
		
        wp_localize_script( 'customizer-repeater-script', 'objectL10n', array(
            'select_image' => esc_html__( 'Select Image', 'tikva' ),
            'remove' => esc_html__( 'Remove', 'tikva' ),
            'change_image' => esc_html__( 'Change Image', 'tikva' ),
            'no_image_selected' => esc_html__( 'No image selected', 'tikva' ),
            'choose_image' => esc_html__( 'Choose Image', 'tikva' )
            
            

        ) );

        //wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri() . '/customizer-repeater/js/customizer_repeater.js', array('jquery', 'jquery-ui-draggable' ), '1.0.1', true  );
    }


    public function to_json()
    {
        //echo "in " . __METHOD__;

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
        var elementData = [];
        if (data.value && data.value[0] != "") {
            // predefined values from database
            var elementData = JSON.parse(decodeURI(data.value));
            

        } else {
            // initialize empty elements with dummy data
            var newElementId = uuidv4();
            var elementData = {};
            elementData[newElementId] = true;
        }
        #>
		<div class="customize-control-repeater-element-container">

        <label>
				<?php
				// The label has already been sanitized in the Fields class, no need to re-sanitize it.
				?>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
					<# } #>

					<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
					<# } #>
						
                </label>
                
            <# _.each(elementData, function (elementItem, elementName) { #>
            <div class="customize-control-repeater-element" id="{{{ elementName }}}">
				
				<div class="repeater-row-content">
					<# _.each( data.fields, function( field, name ) { #>
					
						<div class="repeater-row-label">
                        <span class="customize-control-title">{{{ field.label }}}</span>
						<# if ( field.description ) { #>
					        <span class="description customize-control-description">{{{ field.description }}}</span>
					    <# } #>
						</div>
                        <# if ( field.type === 'text' ) { #>
						
                        <div class="repeater-row-field">

							<input class="customize-repeater-input-text" type="{{field.type}}" name="" 
                            value="<# if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#} #>" 
                            data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
							</div>
						<# } else if (field.type === 'textarea') { #>
                            <div class="repeater-row-field">

							<textarea class="customize-repeater-input-textarea" type="{{field.type}}" name="" 
                            data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}"><# if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#}#></textarea>
                            </div>
                        <# } else if (field.type === 'select') { #>
                            <div class="repeater-row-field">
                            <#
                            var selectValue = '';
                            if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') {
                                selectValue = elementItem.elements[name].value;
                            } else { 
                                selectValue = field.default; 
                            }
                           
                            #>
                            <select class="customize-repeater-input-select" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}" data-customize-setting-link="{{{ name }}}">
                            <# var selectString = '';
                                _.each(field.choices, function(choiceOption, choiceValue) {
                                selectString = '';
                                if (choiceValue == selectValue) {
                                    selectString = 'selected="selected"';
                                }
                                #>
                                <option {{{ selectString }}} value="{{{ choiceValue }}}"  >{{{ choiceOption }}}</option>
                            <#
                            });    
                            #>
                    		</select>

							</div>    
						<# } else if (field.type === 'dropdown-pages') { #>
                            <div class="repeater-row-field">
                            <#
                            var selectValue = '';
                            if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') {
                                selectValue = elementItem.elements[name].value;
                            } else { 
                                selectValue = field.default; 
                            }
                           
                            #>
                            <select class="customize-repeater-input-dropdownpages" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}" data-customize-setting-link="{{{ name }}}">
                            <# var selectString = '';
                                _.each(field.choices, function(choiceContent, choiceIndex) {
                                selectString = '';
                                if (choiceContent.value == selectValue) {
                                    selectString = 'selected="selected"';
                                }
                                #>
                                <option {{{ selectString }}} value="{{{ choiceContent.value }}}"  >{{{ choiceContent.name }}}</option>
                            <#
                            });    
                            #>
                    		</select>

                            </div>
                            <# } else if (field.type === 'colorpicker') { #>
                            <div class="repeater-row-field">
                                  <input type="text" value="<# if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#} #>" class="tikva-repeater-color-field" data-default-color="{{{ field.default }}}" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}"/>

                            </div>
                            <# } else if (field.type === 'radiobutton') { #>
                            <div class="repeater-row-field">
                                  
                                <li class="customize-control-repeater-radio-{{{ name }}} customize-control-radio-container" style="display: list-item;" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
                                <div class="__customize-control-notifications-container" style=""><ul>
                                
                            </ul></div>
                                
                                <# var selectString = '';
                                if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') {
                                    selectValue = elementItem.elements[name].value;
                                } else { 
                                    selectValue = field.default; 
                                }
                               
                                _.each(field.choices, function(choiceOption, choiceValue) {
                                    selectString = '';
                                    if (choiceValue == selectValue) {
                                        selectString = 'checked="checked"';
                                    }
                                #>
                                <label>
						        <input type="radio" {{{ selectString }}} class="tikva-customize-repeater-input-radio" value="{{{ choiceValue }}}" name="_customize-control-repeater-radio-{{{ name }}}-{{{ elementName }}}">{{{ choiceOption }}}<br>
					            </label>

                                <# }); #>
							    </li>

                            </div>
                            <# } else if (field.type === 'checkbox') { #>
                            <div class="repeater-row-field">
                                  
                                <# var selectString = '';
                                if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') {
                                    selectValue = elementItem.elements[name].value;
                                } else { 
                                    selectValue = field.default; 
                                }
                                if (selectValue == '1') {
                                    selectString = 'checked="checked"';
                                }
                                #>

                                <li id="customize-control-repeater-checkbox-{{{ name }}}" class="" style="display: list-item;">
							        <label>

					                    <input type="checkbox" class="tikva-customize-repeater-input-checkbox" value="1" {{{ selectString }}} data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}"/>
                                        <# if (field.description) { #>{{{ field.description }}}<# } #>
                                    </label>
						        </li>


                            </div>

                            <# } else if (field.type === 'image') { #>
                            <div class="repeater-row-field">

                            <#
                           
                            if (typeof elementItem.elements != 'undefined' && typeof elementItem.elements[name] != 'undefined') {
                                
                                var imageId = elementItem.elements[name].value;
                              
                                var payload = [];
                                payload['elementId'] = elementName;
                                payload['elementName'] = name;
                                tikvaRepeaterPreloadAttachment(imageId, payload, function (attachment, elementPayload) {
                                    tikvaRepeaterPreviewImage(elementPayload, attachment);
                                });


                             } // else empty
                           #>


                                <div class="attachment-media-view" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
                                    <div class="placeholder">
                                    <?php esc_attr_e( 'No image selected', 'tikva' ); ?>
                                    </div>
                                    <div class="actions">
                                         <button type="button" class="button tikva-repeater-custom-upload-button"><?php esc_attr_e( 'Select Image', 'tikva' ); ?></button>
                        
                                    </div>
                                </div>
                            </div>
                          
                        <# } // end of "if field type" #>     
					<# }); #>
				
				</div>	
          
                <div class="customize-button-repeater-row-remove">
				    <button type="button" class="button button-remove-new-element remove-new-menu-item customize-repeater-row-remove"><?php esc_attr_e( 'Remove element', 'tikva' ); ?></button>
                </div>
			</div> <!-- customize-control-repeater-element -->
            <# });
            #>
			
		
		</div>
        <input type="hidden" value="{{{ data.value }}}" class="tikva_repeater_collector" id="tikva_repeater_{{{ data.section }}}" name="tikva_repeater_{{{ data.section }}}"/>
		<div class="button-add-new-element"><button type="button" class="button add-field add-new-menu-item customize-repeater-new-field">
				<?php esc_html_e( 'Add new element', 'tikva' ); ?>
        </button>
        </div>
       
        <?php
    }

  
}
