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
        
        console.log(typeof newValue);
        if (isNaN(parseInt(newValue))) { // no number, so we have Google Fonts
            console.log("google font!!!");
            // get variants from backend or trigger another event
            console.log(ajaxurl);

            var mydata = {
                action: "tikva_get_font_data_action",
                whatever: 100
            };
     
            $.ajax({
                type: "POST",
                url: ajaxurl,
     
                dataType: "json",
                data: mydata,
                success: function (data, textStatus, jqXHR) {
                    console.log("success");
                    console.log(data);
                    
                    /*var name = data.name;
                    var age = data.age;
                    var color = data.favorite_color;
                     
                    $('#display').html('<p>Name: '+name+' Age: '+age+' Favorite Color: '+color+' </p>');
                    */

                },
                error: function (errorMessage) {
     
                    console.log(errorMessage);
                }
             
            });      
         
        
        }
        control.updateCurrentDataField(elementData, element);
                
    },

    onChangeSizeUpdate: function( event, element, elementData, newValue ) {
        var control = this;
        console.log("in onChangeSizeUpdate");
        elementId = element.parents('.customize-control-font-element').attr('id');
       
        elementData['size'] = newValue;
        console.log("fontsize:");
        console.log(elementData);
        
        control.updateCurrentDataField(elementData, element);
                
    },


    initFontControl: function() {
        var control = this;
        var elementData = {};

       
        console.log("in initFontControl");
        var element = $(this.container).find('.customize-control-font-element');

        var elementId = element.attr('id');
       
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

        var sizeDefault = 16;
        if (typeof elementData['size'] != 'undefined') {
            sizeDefault = elementData['size'];
        } 

        $('[id="slider_size_' + elementId + '"]').slider({
            value: sizeDefault, min: 2, max: 120, step: 1,
            slide: function (event, ui) {
                $('[id="input_size_' + elementId + '"]').val(ui.value).keyup();
                
                control.onChangeSizeUpdate(event, $(this), elementData, ui.value);
                
            }
        });
        $('[id="input_size_' + elementId + '"]').val($('[id="slider_size_' + elementId + '"]').slider("value"));
  
       
     
    }


} );
  

})(jQuery);