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
	private $customizer_repeater_subtitle_control = false;
	private $customizer_repeater_text_control = false;
	private $customizer_repeater_link_control = false;
	//private $customizer_repeater_repeater_control = false;

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

		if ( ! empty( $args['customizer_repeater_subtitle_control'] ) ) {
			$this->customizer_repeater_subtitle_control = $args['customizer_repeater_subtitle_control'];
		}

		if ( ! empty( $args['customizer_repeater_text_control'] ) ) {
			$this->customizer_repeater_text_control = $args['customizer_repeater_text_control'];
		}

		if ( ! empty( $args['customizer_repeater_link_control'] ) ) {
			$this->customizer_repeater_link_control = $args['customizer_repeater_link_control'];
		}

		if ( ! empty( $args['customizer_repeater_shortcode_control'] ) ) {
			$this->customizer_repeater_shortcode_control = $args['customizer_repeater_shortcode_control'];
		}

		if ( ! empty( $args['customizer_repeater_repeater_control'] ) ) {
			$this->customizer_repeater_repeater_control = $args['customizer_repeater_repeater_control'];
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
						if(!empty($item->subtitle)){
							$subtitle =  $item->subtitle;
						}
						if(!empty($item->text)){
							$text = $item->text;
						}
						if(!empty($item->link)){
							$link = $item->link;
						}
					
					
						
						if($this->customizer_repeater_title_control==true){
							$this->input_control(array(
								'label' => __('Title','your-textdomain'),
								'class' => 'customizer-repeater-title-control',
							), $title);
						}
						if($this->customizer_repeater_subtitle_control==true){
							$this->input_control(array(
								'label' => __('Subtitle','your-textdomain'),
								'class' => 'customizer-repeater-subtitle-control',
							), $subtitle);
						}
						if($this->customizer_repeater_text_control==true){
							$this->input_control(array(
								'label' => __('Text','your-textdomain'),
								'class' => 'customizer-repeater-text-control',
								'type'  => 'textarea'
							), $text);
						}
						if($this->customizer_repeater_link_control){
							$this->input_control(array(
								'label' => __('Link','your-textdomain'),
								'class' => 'customizer-repeater-link-control',
								'sanitize_callback' => 'esc_url'
							), $link);
						}
					
						/*if($this->customizer_repeater_repeater_control==true){
							$this->repeater_control($repeater);
						} */ ?>

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
					if ( $this->customizer_repeater_subtitle_control == true ) {
						$this->input_control( array(
							'label' => __( 'Subtitle', 'your-textdomain' ),
							'class' => 'customizer-repeater-subtitle-control'
						) );
					}
					if ( $this->customizer_repeater_text_control == true ) {
						$this->input_control( array(
							'label' => __( 'Text', 'your-textdomain' ),
							'class' => 'customizer-repeater-text-control',
							'type'  => 'textarea'
						) );
					}
					if ( $this->customizer_repeater_link_control == true ) {
						$this->input_control( array(
							'label' => __( 'Link', 'your-textdomain' ),
							'class' => 'customizer-repeater-link-control'
						) );
					}
				
					/*if($this->customizer_repeater_repeater_control==true){
						$this->repeater_control();
					} */?>
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


	/*private function repeater_control($value = ''){
		$social_repeater = array();
		$show_del        = 0; ?>
		<span class="customize-control-title"><?php esc_html_e( 'Social icons', 'your-textdomain' ); ?></span>
		<?php
		if(!empty($value)) {
			$social_repeater = json_decode( html_entity_decode( $value ), true );
		}
		if ( ( count( $social_repeater ) == 1 && '' === $social_repeater[0] ) || empty( $social_repeater ) ) { ?>
			<div class="customizer-repeater-social-repeater">
				<div class="customizer-repeater-social-repeater-container">
					<div class="customizer-repeater-rc input-group icp-container">
						<input data-placement="bottomRight" class="icp icp-auto" value="<?php if(!empty($value)) { echo esc_attr( $value ); } ?>" type="text">
						<span class="input-group-addon"></span>
					</div>

					<input type="text" class="customizer-repeater-social-repeater-link"
					       placeholder="<?php esc_html_e( 'Link', 'your-textdomain' ); ?>">
					<input type="hidden" class="customizer-repeater-social-repeater-id" value="">
					<button class="social-repeater-remove-social-item" style="display:none">
						<?php esc_html_e( 'X', 'your-textdomain' ); ?>
					</button>
				</div>
				<input type="hidden" id="social-repeater-socials-repeater-colector" class="social-repeater-socials-repeater-colector" value=""/>
			</div>
			<button class="social-repeater-add-social-item"><?php esc_html_e( 'Add icon', 'your-textdomain' ); ?></button>
			<?php
		} else { ?>
			<div class="customizer-repeater-social-repeater">
				<?php
				foreach ( $social_repeater as $social_icon ) {
					$show_del ++; ?>
					<div class="customizer-repeater-social-repeater-container">
						<div class="customizer-repeater-rc input-group icp-container">
							<input data-placement="bottomRight" class="icp icp-auto" value="<?php if( !empty($social_icon['icon']) ) { echo esc_attr( $social_icon['icon'] ); } ?>" type="text">
							<span class="input-group-addon"></span>
						</div>
						<input type="text" class="customizer-repeater-social-repeater-link"
						       placeholder="<?php esc_html_e( 'Link', 'your-textdomain' ); ?>"
						       value="<?php if ( ! empty( $social_icon['link'] ) ) {
							       echo esc_url( $social_icon['link'] );
						       } ?>">
						<input type="hidden" class="customizer-repeater-social-repeater-id"
						       value="<?php if ( ! empty( $social_icon['id'] ) ) {
							       echo esc_attr( $social_icon['id'] );
						       } ?>">
						<button class="social-repeater-remove-social-item"
						        style="<?php if ( $show_del == 1 ) {
							        echo "display:none";
						        } ?>"><?php esc_html_e( 'X', 'your-textdomain' ); ?></button>
					</div>
					<?php
				} ?>
				<input type="hidden" id="social-repeater-socials-repeater-colector"
				       class="social-repeater-socials-repeater-colector"
				       value="<?php echo esc_textarea( html_entity_decode( $value ) ); ?>" />
			</div>
			<button class="social-repeater-add-social-item"><?php esc_html_e( 'Add icon', 'your-textdomain' ); ?></button>
			<?php
		}
	}*/
}
