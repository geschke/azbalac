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

		wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri().'/js/custom-repeater.js', array( 'jquery' ), '', true );

        wp_enqueue_script('underscore');
		

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
        //echo "in " . __METHOD__;
        ?>
        <label>

            <span class="customize-control-repeater">
        <?php
        // The label has already been sanitized in the Fields class, no need to re-sanitize it.
        ?>
                <?php echo esc_html_e($this->label, 'tikva'); ?>
                <?php if (!empty($this->description)) : ?>
                    <?php
                    // The description has already been sanitized in the Fields class, no need to re-sanitize it.
                    ?>
                    <span class="description customize-control-description"><?php echo esc_html_e($this->description, 'tikva'); ?></span>
                <?php endif; ?>
            </span>
        Content here...
        </label>

       
        <div class="customizer-repeater-general-control-repeater">
            <?php
            if (( count( $json ) == 1 && '' === $json[0] ) || empty( $json )) {
                if (! empty( $this_default )) {
                    $this->iterate_array( $this_default ); ?>
                    <input type="hidden"
                           id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                           class="customizer-repeater-colector"
                           value="<?php echo esc_textarea( json_encode( $this_default ) ); ?>"/>
                    <?php
                } else {
                    $this->iterate_array(); ?>
                    <input type="hidden"
                           id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                           class="customizer-repeater-colector"/>
                    <?php
                }
            } else {
                $this->iterate_array( $json ); ?>
                <input type="hidden" id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                       class="customizer-repeater-colector" value="<?php echo esc_textarea( $this->value() ); ?>"/>
                <?php
            } ?>
            </div>
        <button type="button" class="button add_field customizer-repeater-new-field">
            <?php esc_html_e( 'Add new field', 'your-textdomain' ); ?>
        </button>
        <?php
    }


    public function content_template()
    {

        ?>
    
        <#
        console.log("foo");
        console.log(data.value);
       
		//console.log(data.fields);
		var tikvaRepeaterContainer = {};
       
        #>
		<div class="customize-control-repeater-element-container">
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
						<# if ( field.type === 'text' ) { #>
						<div class="repeater-row-label">
							{{{ field.label }}}
						</div>
						<div class="repeater-row-field">
							<input class="customize-repeater-input-text" type="{{field.type}}" name="" value="{{{ field.default }}}" data-type="{{{ field.type }}}" data-field="{{{ name }}}">
							</div>
						<# } else if (field.type === 'url') { #>
							field: url // {{{ name }}}
						<# } #>

					<# }); #>
					
				</div>	
				<button type="button" class="button customize-repeater-row-remove"><?php esc_attr_e( 'Remove', 'tikva' ); ?></button>
				
			</div> <!-- customize-control-repeater-element -->
			
		</div>
		<button type="button" class="button add-field customize-repeater-new-field">
				<?php esc_html_e( 'Add new field', 'tikva' ); ?>
		</button>

        <?php
    }

    public function pre_render_content()
    {

        /*Get default options*/
        $this_default = json_decode( $this->setting->default );

        /*Get values (json format)*/
        $values = $this->value();

        /*Decode values*/
        $json = json_decode( $values );

        if (! is_array( $json )) {
            $json = array( $values );
        } ?>

        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <div class="customizer-repeater-general-control-repeater">
            <?php
            if (( count( $json ) == 1 && '' === $json[0] ) || empty( $json )) {
                if (! empty( $this_default )) {
                    $this->iterate_array( $this_default ); ?>
                    <input type="hidden"
                           id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                           class="customizer-repeater-colector"
                           value="<?php echo esc_textarea( json_encode( $this_default ) ); ?>"/>
                    <?php
                } else {
                    $this->iterate_array(); ?>
                    <input type="hidden"
                           id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                           class="customizer-repeater-colector"/>
                    <?php
                }
            } else {
                $this->iterate_array( $json ); ?>
                <input type="hidden" id="customizer-repeater-<?php echo $this->id; ?>-colector" <?php $this->link(); ?>
                       class="customizer-repeater-colector" value="<?php echo esc_textarea( $this->value() ); ?>"/>
                <?php
            } ?>
            </div>
        <button type="button" class="button add_field customizer-repeater-new-field">
            <?php esc_html_e( 'Add new field', 'your-textdomain' ); ?>
        </button>
        <?php
    }

    private function iterate_array($array = array())
    {
        /*Counter that helps checking if the box is first and should have the delete button disabled*/
        $it = 0;
        if (!empty($array)) {
            foreach ($array as $item) { ?>
                <div class="customizer-repeater-general-control-repeater-container">
                    <div class="customizer-repeater-customize-control-title">
                        <?php esc_html_e( $this->boxtitle, 'your-textdomain' ) ?>
                    </div>
                    <div class="customizer-repeater-box-content-hidden">
                        <?php
                        $title = '';
                        
                        if (!empty($item->title)) {
                            $title = $item->title;
                        }
                        
                        if ($this->customizer_repeater_title_control==true) {
                            $this->input_control(array(
                                'label' => __('Title', 'your-textdomain'),
                                'class' => 'customizer-repeater-title-control',
                            ), $title);
                        }
                        ?>
                        <input type="hidden" class="customizer-repeater-box-id" value="<?php if (! empty( $this->id )) {
                            echo esc_attr( $this->id );
} ?>">
                        <button type="button" class="customizer-repeater-general-control-remove-field button" <?php if ($it == 0) {
                            echo 'style="display:none;"';
} ?>>
                            <?php esc_html_e( 'Delete field', 'your-textdomain' ); ?>
                        </button>

                    </div>
                </div>

                <?php
                $it++;
            }
        } else { ?>
            <div class="customizer-repeater-general-control-repeater-container">
                <div class="customizer-repeater-customize-control-title">
                    <?php esc_html_e( $this->boxtitle, 'your-textdomain' ) ?>
                </div>
                <div class="customizer-repeater-box-content-hidden">
                    <?php
                    
                    if ($this->customizer_repeater_title_control == true) {
                        $this->input_control( array(
                            'label' => __( 'Title', 'your-textdomain' ),
                            'class' => 'customizer-repeater-title-control',
                        ) );
                    }
                
                    ?>
                    <input type="hidden" class="customizer-repeater-box-id">
                    <button type="button" class="customizer-repeater-general-control-remove-field button" style="display:none;">
                        <?php esc_html_e( 'Delete field', 'your-textdomain' ); ?>
                    </button>
                </div>
            </div>
            <?php
        }
    }

    private function input_control($options, $value = '')
    {
    ?>
        <span class="customize-control-title"><?php echo $options['label']; ?></span>
            <input type="text" value="<?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?>" class="<?php echo esc_attr($options['class']); ?>" placeholder="<?php echo $options['label']; ?>"/>
            <?php
    }
}
