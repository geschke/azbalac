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


if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Customizer_Repeater extends WP_Customize_Control {

	public $id;
	private $boxtitle = array();
	private $customizer_repeater_title_control = false;

	/*Class constructor*/
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		/*Get options from customizer.php*/
		$this->boxtitle   = __('Customizer Repeater','your-textdomain');
		if ( ! empty( $this->label ) ){
			$this->boxtitle = $this->label;
		}

		if ( ! empty( $args['customizer_repeater_title_control'] ) ) {
			$this->customizer_repeater_title_control = $args['customizer_repeater_title_control'];
		}

		

		if ( ! empty( $args['id'] ) ) {
			$this->id = $args['id'];
		}
	}

	/*Enqueue resources for the control*/
	public function enqueue() {
		//wp_enqueue_style( 'customizer-repeater-font-awesome', get_template_directory_uri().'/customizer-repeater/css/font-awesome.min.css','1.0.0' );

		//wp_enqueue_style( 'customizer-repeater-admin-stylesheet', get_template_directory_uri().'/customizer-repeater/css/admin-style.css','1.0.0' );

        wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri().'/js/custom_controls.js', array( 'jquery' ), '', true );

		wp_enqueue_script('underscore');
        #wp_enqueue_script( 'customizer-repeater-underscorescript', get_template_directory_uri().'/js/underscore-min.js', array( ), '1.8.3', true );

		//wp_enqueue_script( 'customizer-repeater-script', get_template_directory_uri() . '/customizer-repeater/js/customizer_repeater.js', array('jquery', 'jquery-ui-draggable' ), '1.0.1', true  );

	
	}

	public function render_content() {

		/*Get default options*/
		$this_default = json_decode( $this->setting->default );

		/*Get values (json format)*/
		$values = $this->value();

		/*Decode values*/
		$json = json_decode( $values );

		if ( ! is_array( $json ) ) {
			$json = array( $values );
		} ?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="customizer-repeater-general-control-repeater customizer-repeater-general-control-droppable">
			<?php
			if ( ( count( $json ) == 1 && '' === $json[0] ) || empty( $json ) ) {
				if ( ! empty( $this_default ) ) {
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

	private function iterate_array($array = array()){
		/*Counter that helps checking if the box is first and should have the delete button disabled*/
		$it = 0;
		if(!empty($array)){
			foreach($array as $item){ ?>
				<div class="customizer-repeater-general-control-repeater-container customizer-repeater-draggable">
					<div class="customizer-repeater-customize-control-title">
						<?php esc_html_e( $this->boxtitle, 'your-textdomain' ) ?>
					</div>
					<div class="customizer-repeater-box-content-hidden">
						<?php
						$choice = $title = $subtitle = $text = $link = $shortcode = $repeater = '';
						if(!empty($item->choice)){
							$choice = $item->choice;
						}
					
					
						if(!empty($item->title)){
							$title = $item->title;
						}
					
					
						
						if($this->customizer_repeater_title_control==true){
							$this->input_control(array(
								'label' => __('Title','your-textdomain'),
								'class' => 'customizer-repeater-title-control',
							), $title);
						}
					
					
					 ?>

						<input type="hidden" class="social-repeater-box-id" value="<?php if ( ! empty( $this->id ) ) {
							echo esc_attr( $this->id );
						} ?>">
						<button type="button" class="social-repeater-general-control-remove-field button" <?php if ( $it == 0 ) {
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
					
					if ( $this->customizer_repeater_title_control == true ) {
						$this->input_control( array(
							'label' => __( 'Title', 'your-textdomain' ),
							'class' => 'customizer-repeater-title-control',
						) );
					}
				
				
					?>
					<input type="hidden" class="social-repeater-box-id">
					<button type="button" class="social-repeater-general-control-remove-field button" style="display:none;">
						<?php esc_html_e( 'Delete field', 'your-textdomain' ); ?>
					</button>
				</div>
			</div>
			<?php
		}
	}

	private function input_control( $options, $value='' ){ ?>
		<span class="customize-control-title"><?php echo $options['label']; ?></span>
		<?php
		if( !empty($options['type']) && $options['type'] === 'textarea' ){ ?>
			<textarea class="<?php echo esc_attr($options['class']); ?>" placeholder="<?php echo $options['label']; ?>"><?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?></textarea>
			<?php
		} else { ?>
			<input type="text" value="<?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?>" class="<?php echo esc_attr($options['class']); ?>" placeholder="<?php echo $options['label']; ?>"/>
			<?php
		}
	}


	
}
