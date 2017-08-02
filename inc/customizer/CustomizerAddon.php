<?php

/**
 * Add-ons for Customizer
 *
 * @package   WordPress
 * @subpackage tikva
 * @since tikva 0.4.6
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Customizer_Addon
{

    private $customizer;

    public function __construct($wp_customize)
    {
        $this->customizer = $wp_customize;
    }

    public function initPreview()
    {
        $this->customizer->get_setting( 'blogname' )->transport = 'postMessage';
        $this->customizer->get_setting( 'blogdescription' )->transport = 'postMessage';

        $this->customizer->get_setting( 'color_bg_header' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_fg_footer' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_bg_footer' )->transport = 'postMessage';

        $this->customizer->get_setting( 'color_fg_sidebar' )->transport = 'postMessage';
        $this->customizer->get_setting( 'color_bg_sidebar' )->transport = 'postMessage';


         add_action('customize_preview_init', array($this, 'customizeRegisterLivePreview'));
    }

    /**
    * Used by hook: 'customize_preview_init'
    *
    * @see add_action('customize_preview_init',$func)
    */
    public function customizeRegisterLivePreview()
    {
        wp_enqueue_script(
            'tikva-themecustomizer',            //Give the script an ID
            get_template_directory_uri().'/js/tikva-customizer.js', //Point to file
            array( 'jquery','customize-preview' ),  //Define dependencies
            '',                         //Define a version (optional)
            true                        //Put script in footer?
        );
    }
}


if (!class_exists('WP_Customize_Control'))
    return NULL;

/* Multi Input field */
 
class Multi_Input_Custom_control extends WP_Customize_Control
{
    public $type = 'multi_input';
    public function enqueue()
    {
        wp_enqueue_script( 'custom_controls', get_template_directory_uri().'/js/custom_controls.js', array( 'jquery' ), '', true );
        //wp_enqueue_style( 'custom_controls_css', get_template_directory_uri().'/css/custom-controls.css');
    }

    /**
		 * Control method
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			?>
			<label class="customize_multi_input">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<p><?php echo esc_html( $this->description ); ?></p>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize_multi_value_field" <?php $this->link(); ?> />
				<div class="customize_multi_fields">
					<div class="set">
						<input type="text" value="" class="customize_multi_single_field"/>
						<span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
					</div>
				</div>
				<a href="#" class="button button-primary customize_multi_add_field"><?php esc_html_e( 'Add More', 'tikva' ) ?></a>
			</label>
			<?php
		}


   
}
