/* global jQuery */
/* global wp */


/**
 * Customizer Control: JavaScript part of font control
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       2.0
 */

(function ($) {

   
wp.customize.controlConstructor.tikva_font = wp.customize.Control.extend( {


    ready: function() {
        var control = this;
       
        this.container.on( 'event_font_updated', function() {
            var dataField = $(control.container).find('.tikva_font_collector');
            var settingData = dataField.val();
            
            control.setting.set( settingData );
            return true;
        });
    
        control.initFontControl();
        
    },


    /**
     * Find and update hidden data field with collection of values by submitting new elementData array.
     * At the end, this method triggers an event, so WordPress recognizes the changes.
     * 
     */
    updateCurrentDataField: function(elementData) {
        console.log("in updateCurrentDataField");
        var control = this;
        var dataField = $(control.container).find('.tikva_font_collector');
        console.log(dataField);
        var dataFieldId = dataField.attr('id');
        console.log(dataFieldId);

        $(control.container).find('#' + dataFieldId).val( encodeURI( JSON.stringify( elementData ) ));
        console.log("written value:");
        console.log($(control.container).find('#' + dataFieldId).val());
        dataField.trigger('event_font_updated'); 

    },

   
    onChangeSelectUpdate: function( event, element, elementData ) {
        var control = this;
        console.log("in onChangeSelectUpdate");
        elementId = element.parents('.customize-control-font-element').attr('id');
        console.log(element);
        console.log(elementId);
        
        var newValue = element.val();

        elementData['font'] = newValue;
        console.log("fontdata:");
        console.log(elementData);
        
        control.updateCurrentDataField(elementData, element);
                
    },


    initFontControl: function() {
        var control = this;
        var elementData = {};

       
        console.log("in initFontControl");
        var element = $(this.container).find('.customize-control-font-element');

       
        var prevValue = $(control.container).find('.tikva_font_collector').val();
     
        if (prevValue != '') {
            elementData = JSON.parse(decodeURI(prevValue));
        } else {
            elementData = {};
        }

        // initialize key events to handle select fields
        $(this.container).on('change', '.customize-font-input-select', function (event) {
            control.onChangeSelectUpdate(event, $(this), elementData);
        });
       
     
    }


} );
  

})(jQuery);