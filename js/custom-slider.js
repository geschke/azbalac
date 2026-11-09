/* global jQuery */
/* global wp */


/**
 * Customizer Control: JavaScript part of slider control
 *
 * @package     Azbalac Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2018, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.1
 */

(function ($) {

   
wp.customize.controlConstructor.azbalac_slider = wp.customize.Control.extend( {


    ready: function() {
        var control = this;
        var numberInput = $(this.container).find('.customize-control-slider-value');
        var rangeInput = $(this.container).find('.customize-control-slider-range');
        var minimum = parseFloat(rangeInput.attr('min'));
        var maximum = parseFloat(rangeInput.attr('max'));

        function normalizeValue(value) {
            value = parseFloat(value);

            if (isNaN(value)) {
                return null;
            }

            return Math.min(maximum, Math.max(minimum, value));
        }

        function updateValue(value) {
            value = normalizeValue(value);

            if (value === null) {
                return;
            }

            numberInput.val(value);
            rangeInput.val(value);
            control.setting.set(value);
        }

        rangeInput.on('input change', function() {
            updateValue($(this).val());
        });

        numberInput.on('input change', function() {
            updateValue($(this).val());
        });

        control.setting.bind(function(value) {
            value = normalizeValue(value);

            if (value !== null) {
                numberInput.val(value);
                rangeInput.val(value);
            }
        });
    },

   

} );
  

})(jQuery);
