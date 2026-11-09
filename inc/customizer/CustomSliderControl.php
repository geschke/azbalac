<?php
if (!class_exists('WP_Customize_Control'))
    return NULL;

/**
 * Create a numeric Slider control
 * 
 * This class incorporates code from the Kirki Customizer Framework
 * 
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 * 
 * @link https://github.com/aristath/kirki
 */
class Azbalac_Custom_Slider_Control extends WP_Customize_Control
{

    /**
     * Additional control fields.
     *
     * @var array
     */
    public $fields = array();

    /**
    * Define the control type
    */
    public $type = 'azbalac_slider';


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

    public function enqueue()
    {
        wp_enqueue_script(
            'customizer-slider-script',
            get_template_directory_uri() . '/js/custom-slider.js',
            array('jquery', 'customize-controls'),
            AZBALAC_DATEVERSION,
            true
        );
    }


    
    public function to_json()
    {
        
        parent::to_json();
/*
        // Get default options 
        $this->json['default'] = ( isset( $this->default ) ) ? $this->default : $this->setting->default;

        // shortcut to use as identifier for the current control in underscore template
        $this->json['identifier'] = $this->json['settings']['default'];

        $values = $this->value();
        $json = json_decode( $values );

        if (! is_array( $json )) {
            $json = array( $values );
        }
    
      
        $this->json['value'] = $json;
        $this->json['defaults'] = $this->defaults;
  */  
    }


    public function render_content()
    {
        $minimum = isset($this->choices['min']) ? $this->choices['min'] : 0;
        $maximum = isset($this->choices['max']) ? $this->choices['max'] : 100;
        $step = isset($this->choices['step']) ? $this->choices['step'] : 1;
        ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html($this->label); ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif; ?>
            </span>
            <input
                class="customize-control-slider-value"
                type="number"
                min="<?php echo esc_attr($minimum); ?>"
                max="<?php echo esc_attr($maximum); ?>"
                step="<?php echo esc_attr($step); ?>"
                value="<?php echo esc_attr($this->value()); ?>"
            />
        </label>
        <div style="padding-top: 10px;">
            <input
                class="customize-control-slider-range"
                type="range"
                min="<?php echo esc_attr($minimum); ?>"
                max="<?php echo esc_attr($maximum); ?>"
                step="<?php echo esc_attr($step); ?>"
                value="<?php echo esc_attr($this->value()); ?>"
            />
        </div>
        <?php
    }

}
