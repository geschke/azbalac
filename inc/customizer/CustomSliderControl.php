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
        global $wp_scripts;
        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('jquery-ui-slider');
        
        // taken from: https://snippets.webaware.com.au/snippets/load-a-nice-jquery-ui-theme-in-wordpress/
        $ui = $wp_scripts->query('jquery-ui-core');
        
// tell WordPress to load the Smoothness theme from Google CDN

        $protocol = is_ssl() ? 'https' : 'http';
        $url = "$protocol://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
        wp_enqueue_style('jquery-ui-smoothness', $url, false, null);


        wp_enqueue_script( 'customizer-slider-script', get_template_directory_uri().'/js/custom-slider.js', array( 'jquery'), '', true );

     
    }

    public function render_content()
    {
        ?>
        <label>

            <span class="customize-control-title">
        <?php
        // The label has already been sanitized in the Fields class, no need to re-sanitize it.
        ?>
                <?php echo $this->label; ?>
                <?php if (!empty($this->description)) : ?>
                    <?php
                    // The description has already been sanitized in the Fields class, no need to re-sanitize it.
                    ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                <?php endif; ?>
            </span>

            <input class="customize-control-slider-value" type="text"  id="input_<?php echo $this->id; ?>" disabled value="<?php echo $this->value(); ?>" <?php $this->link(); ?>/>

        </label>

<div style="padding-top: 10px;">
        <div  id="slider_<?php echo $this->id; ?>"></div>
</div>
        <script>
            jQuery(document).ready(function ($) {

                $('[id="slider_<?php echo $this->id; ?>"]').slider({
                    value: <?php echo $this->value(); ?>,
                    min: <?php echo $this->choices['min']; ?>,
                    max: <?php echo $this->choices['max']; ?>,
                    step: <?php echo $this->choices['step']; ?>,
                    slide: function (event, ui) {
                        $('[id="input_<?php echo $this->id; ?>"]').val(ui.value).keyup();
                    }
                });
                $('[id="input_<?php echo $this->id; ?>"]').val($('[id="slider_<?php echo $this->id; ?>"]').slider("value"));
            });
        </script>
        <?php
    }

}

/**
 * Add CSS for custom controls
 *
 * This function incorporates CSS from the Kirki Customizer Framework
 *
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later)
 *
 * @link https://github.com/aristath/kirki
 */
function azbalac_customizer_custom_control_slider_css()
{
    ?>
    <style>
        /*
                .customize-control-slider input[type=range] {
                    -webkit-appearance: none;
                    -webkit-transition: background .3s;
                    -moz-transition: background .3s;
                    transition: background .3s;
                    background-color: rgba(0, 0, 0, 0.1);
                    height: 5px;
                    width: calc(100% - 70px);
                    padding: 0; }
                .customize-control-slider input[type=range]:focus {
                    box-shadow: none;
                    outline: none; }
                .customize-control-slider input[type=range]:hover {
                    background-color: rgba(0, 0, 0, 0.25); }
                .customize-control-slider input[type=range]::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    width: 15px;
                    height: 15px;
                    border-radius: 50%;
                    -webkit-border-radius: 50%;
                    background-color: #3498D9; }
                .customize-control-slider input[type=range]::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    width: 15px;
                    height: 15px;
                    border: none;
                    border-radius: 50%;
                    background-color: #3498D9; }
                .customize-control-slider input[type=range]::-moz-range-thumb {
                    width: 15px;
                    height: 15px;
                    border: none;
                    border-radius: 50%;
                    background-color: #3498D9; }
                .customize-control-slider input[type=range]::-ms-thumb {
                    width: 15px;
                    height: 15px;
                    border-radius: 50%;
                    border: 0;
                    background-color: #3498D9; }
                .customize-control-slider input[type=range]::-moz-range-track {
                    border: inherit;
                    background: transparent; }
                .customize-control-slider input[type=range]::-ms-track {
                    border: inherit;
                    color: transparent;
                    background: transparent; }
                .customize-control-slider input[type=range]::-ms-fill-lower, .customize-control-slider input[type=range]::-ms-fill-upper {
                    background: transparent; }
                .customize-control-slider input[type=range]::-ms-tooltip {
                    display: none; }
                .customize-control-slider .kirki_range_value {
                    display: inline-block;
                    font-size: 14px;
                    padding: 0 5px;
                    font-weight: 400;
                    position: relative;
                    top: 2px; }
                .customize-control-slider .kirki-slider-reset {
                    color: rgba(0, 0, 0, 0.2);
                    float: right;
                    -webkit-transition: color .5s ease-in;
                    -moz-transition: color .5s ease-in;
                    -ms-transition: color .5s ease-in;
                    -o-transition: color .5s ease-in;
                    transition: color .5s ease-in; }
                .customize-control-slider .kirki-slider-reset span {
                    font-size: 16px;
                    line-height: 22px; }
                .customize-control-slider .kirki-slider-reset:hover {
                    color: red; }
        
            .customize-control-slider .ui-slider .ui-slider-handle{background-color:#555;border-color:000;}
        */
        .ui-slider {
            position: relative;
            text-align: left;
        }
        .ui-slider .ui-slider-handle {
            position: absolute;
            z-index: 2;
            width: 1.2em;
            height: 1.2em;
            cursor: default;
            -ms-touch-action: none;
            touch-action: none;
        }
        .ui-slider .ui-slider-range {
            position: absolute;
            z-index: 1;
            font-size: .7em;
            display: block;
            border: 0;
            background-position: 0 0;
        }

        /* support: IE8 - See #6727 */
        .ui-slider.ui-state-disabled .ui-slider-handle,
        .ui-slider.ui-state-disabled .ui-slider-range {
            filter: inherit;
        }

        .ui-slider-horizontal {
            height: .8em;
        }
        .ui-slider-horizontal .ui-slider-handle {
            top: -.3em;
            margin-left: -.6em;
        }
        .ui-slider-horizontal .ui-slider-range {
            top: 0;
            height: 100%;
        }
        .ui-slider-horizontal .ui-slider-range-min {
            left: 0;
        }
        .ui-slider-horizontal .ui-slider-range-max {
            right: 0;
        }

        .ui-slider-vertical {
            width: .8em;
            height: 100px;
        }
        .ui-slider-vertical .ui-slider-handle {
            left: -.3em;
            margin-left: 0;
            margin-bottom: -.6em;
        }
        .ui-slider-vertical .ui-slider-range {
            left: 0;
            width: 100%;
        }
        .ui-slider-vertical .ui-slider-range-min {
            bottom: 0;
        }
        .ui-slider-vertical .ui-slider-range-max {
            top: 0;
        }

    </style>
    <?php
}
// maybe todo later some customizing, currently it is important to work
//add_action('customize_controls_print_styles', 'azbalac_customizer_custom_control_slider_css');
