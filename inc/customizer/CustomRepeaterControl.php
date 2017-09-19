<?php

if (! class_exists( 'WP_Customize_Control' )) {
    return null;
}

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
    private $boxtitle = array();
    private $customizer_repeater_title_control = false;


    /*Class constructor*/
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct( $manager, $id, $args );
    
        /*Get options from customizer.php*/
        $this->boxtitle   = __('Customizer Repeater', 'tikva');
        /*if (! empty( $this->label )) {
            $this->boxtitle = $this->label;
        }*/
    
        // fields could be empty due to initialization by WP_Customize_Manager in print_template()
		if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
			$args['fields'] = array();
		}
		$this->fields = $args['fields'];

        

        if (! empty( $args['id'] )) {
            $this->id = $args['id'];
        }
    }

    /*Enqueue resources for the control*/
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
            'no_image_selected' => esc_html__( 'No image selected', 'tikva' )
            

        ) );

        #wp_enqueue_script( 'customizer-repeater-underscorescript', get_template_directory_uri().'/js/underscore-min.js', array( ), '1.8.3', true );

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


    protected function render_content()
    {
    }


    public function content_template()
    {

        ?>
    
        <#
        console.log("foo");
        console.log(data.section);
       
		//console.log(data.fields);
        //var elementData = [];
        console.log(data.value);
        console.log(_.size(data.value));
        console.log(typeof data.value);
        if (data.value && data.value[0] != "") {
            var elementData = JSON.parse(decodeURI(data.value));
            //console.log(elementData);
           

        }
        console.log("elementData?");
       console.log(elementData);
       console.log(typeof elementData);
      
       console.log(_.size(elementData));
        #>
		<div class="customize-control-repeater-element-container">

            <# if (_.size(elementData)) { #>
            <# _.each(elementData, function (elementItem, elementName) { #>
                <#
                console.log("name?")
                console.log(elementItem);
                console.log(data.fields.name);
                #>
            <#    console.log(elementName); #>
            <div class="customize-control-repeater-element" id="{{{ elementName }}}">
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
				<div class="repeater-row-content">
					<# _.each( data.fields, function( field, name ) { #>
					<#	
                        //console.log(field.type);
                        console.log("current field:");
						console.log(field);
						#>
						<div class="repeater-row-label">
							{{{ field.label }}}
						</div>
                        <# if ( field.type === 'text' ) { #>
						
                        <div class="repeater-row-field">

							<input class="customize-repeater-input-text" type="{{field.type}}" name="" 
                            value="<# if (typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#} #>" 
                            data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
							</div>
						<# } else if (field.type === 'textarea') { #>
                            <div class="repeater-row-field">

							<textarea class="customize-repeater-input-textarea" type="{{field.type}}" name="" 
                            data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}"><# if (typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#}#></textarea>
                            </div>
                        <# } else if (field.type === 'select') { #>
                            <div class="repeater-row-field">
                            <#
                            var selectValue = '';
                            if (typeof elementItem.elements[name] != 'undefined') {
                                selectValue = elementItem.elements[name].value;
                            } else { 
                                selectValue = field.default; 
                            }
                            console.log("select value?");
                            console.log(selectValue);
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
                            if (typeof elementItem.elements[name] != 'undefined') {
                                selectValue = elementItem.elements[name].value;
                            } else { 
                                selectValue = field.default; 
                            }
                            console.log("dropdown-page value?");
                            console.log(selectValue);
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
                        <# } else if (field.type === 'image') { #>
                            <div class="repeater-row-field">

                            <#
                            console.log("element image!!!!!!!!!!!!!!!!!!!!!!!");
                            if (typeof elementItem.elements[name] != 'undefined') {
                                console.log(elementItem.elements[name].value);
                                var imageId = elementItem.elements[name].value;
                                //console.log(wp.media.attachment(imageId).get('url'));
                                var payload = [];
                                payload['elementId'] = elementName;
                                payload['elementName'] = name;
                                tikvaRepeaterPreloadAttachment(imageId, payload, function (attachment, elementPayload) {
                                    console.log("in call of preloadAttachment");
                                    console.log(elementPayload);
                                  console.log(attachment.get('url'));
                                    console.log(wp.media.attachment(imageId).get('url')); 
                                    tikvaRepeaterPreviewImage(elementPayload, attachment);
                                });


                             } else { 
                                 console.log("empty");
                             } 
                           #>


                                <div class="attachment-media-view" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
                                    <div class="setting_content_image placeholder">
                                    <?php esc_attr_e( 'No image selected', 'tikva' ); ?>
                                    </div>
                                    <div class="actions">
                                        <input type="text" value="<# if (typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#} #>" class="setting_content_upload"/>
                                        <button type="button" class="button tikva-repeater-custom-upload-button"><?php esc_attr_e( 'Select Image', 'tikva' ); ?></button>
                        
                                    </div>
                                </div>
                            </div>
                          
                        <# } // end of "if field type" #>     
					<# }); #>
				
				</div>	

             




				<button type="button" class="button customize-repeater-row-remove"><?php esc_attr_e( 'Remove', 'tikva' ); ?></button>
				
			</div> <!-- customize-control-repeater-element -->
            <# });
            #>
            <# } else { #>
			<div class="customize-control-repeater-element" id="">
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
				<div class="repeater-row-content">
					<# _.each( data.fields, function( field, name ) { #>
					<#	
						//console.log(field.type);
						console.log(field);
						#>
						<div class="repeater-row-label">
							{{{ field.label }}}
						</div>
                        <# if ( field.type === 'text' ) { #>
						
                        <div class="repeater-row-field">
							<input class="customize-repeater-input-text" type="{{field.type}}" name="" value="{{{ field.default }}}" data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}">
							</div>
                        <# } else if (field.type === 'textarea') { #>
                        <div class="repeater-row-field">

							<textarea class="customize-repeater-input-textarea" type="{{field.type}}" name="" 
                            data-type="{{{ field.type }}}" data-field="{{{ name }}}" data-default="{{{ field.default }}}"><# if (typeof elementItem.elements[name] != 'undefined') { #>{{{ elementItem.elements[name].value }}}<# } else { #>{{{ field.default }}}<#}#></textarea>
							</div>
						<# } #>

					<# }); #>
					
				</div>	
				<button type="button" class="button customize-repeater-row-remove"><?php esc_attr_e( 'Remove', 'tikva' ); ?></button>
				
			</div> <!-- customize-control-repeater-element -->
            <# } #>
		
		</div>
        <input type="text" value="{{{ data.value }}}" class="tikva_repeater_collector" id="tikva_repeater_{{{ data.section }}}" name="tikva_repeater_{{{ data.section }}}"/>
		<button type="button" class="button add-field customize-repeater-new-field">
				<?php esc_html_e( 'Add new element', 'tikva' ); ?>
		</button>

        <?php
    }

  
}
