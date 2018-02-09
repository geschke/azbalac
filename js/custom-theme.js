/* global jQuery */
/* global wp */


/**
 * Customizer Control: JavaScript part of font control
 *
 * @package     Azbalac Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2018, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.1
 */

(function ($) {

   
wp.customize.controlConstructor.azbalac_theme = wp.customize.Control.extend( {


    ready: function() {
        var control = this;
       
        this.container.on( 'event_theme_updated', function() {
            var dataField = $(control.container).find('.azbalac_theme_collector');
            var settingData = dataField.val();
            
            control.setting.set( settingData );
            return true;
        });
    
        control.initControl();
        
    },

   

    /**
     * Find and update hidden data field with collection of values by submitting new elementData array.
     * At the end, this method triggers an event, so WordPress recognizes the changes.
     * 
     */
    updateCurrentDataField: function(elementData) {
        var control = this;
        var dataField = $(control.container).find('.azbalac_theme_collector');
        var dataFieldId = dataField.attr('id');

        $(control.container).find('#' + dataFieldId).val( encodeURI( JSON.stringify( elementData ) ));
        dataField.trigger('event_theme_updated'); 
    },

   
    onChangeSelectUpdate: function( event, element, elementData ) {
        var control = this;
        elementId = element.parents('.customize-control-theme-element').attr('id');
        
        var newValue = element.val();

        elementData['theme'] = newValue;

        console.log(elementData);
        if (parseInt(newValue) != 0) { // theme selected

           
            // get variants from backend and trigger another event
            // if no variant is chosen, nothing will be stored
            // default is 'regular'
           
            var requestData = {
                action: "azbalac_get_theme_data_action",
                searchtheme: newValue
            };
     
            $.ajax({
                type: "POST",
                url: ajaxurl,
     
                dataType: "json",
                data: requestData,
                success: function (data, textStatus, jqXHR) {
                    
                    if (data != null) {
                     
                        console.log(data);
                        elementData['data'] = data.value; // we only need values, theme id is set before
                        control.updateCurrentDataField(elementData, element);
                    }

                },
                error: function (errorMessage) {
                    // maybe later: write error message
                }
             
            });      
        
        } else { // fallback to default theme (bootstrap)
            
            // no ggl font, remove ggl font contents
            elementData['theme'] = 0;
            if (typeof elementData['data'] != 'undefined' ) {
                elementData['data'] = null;
            }
            control.updateCurrentDataField(elementData, element);
        }
    
                
    },


    


    initControl: function() {
        var control = this;
        var elementData = {};

       
        var element = $(this.container).find('.customize-control-theme-element');

        var elementId = element.attr('id');
        var prevValue = $(control.container).find('.azbalac_theme_collector').val();
     
        if (prevValue != '') {
            elementData = JSON.parse(decodeURI(prevValue));
            // todo: if gglfont, get variants and select chosen variant
        } else {
            elementData = {};
        }


        
        // initialize key events to handle select fields
        $(this.container).on('change', '.customize-theme-input-select', function (event) {
            control.onChangeSelectUpdate(event, $(this), elementData);
        });

        /*$(this.container).on('event_font_gglfont_selected', function(event, element, elementId, data) {

            var selectField = $('#' + elementId).find('.customize-font-input-select-variant');
            
            var selectOption = $(selectField).children()[0]; // string "-- select --"
            selectField.empty().append(selectOption); 
            
            _.each(data.variants, function(choiceOption, choiceValue) {
                // choiceOption is the identifier string
                var variantData =  {
                    'value': choiceOption,
                    'text': choiceOption                                      
                };

                if (choiceOption == 'regular') { // regular is the default value
                    // but 'regular' is not stored as default, because it's identically
                    // to an empty string
                    variantData['selected'] = 'selected';
                }
                $('<option/>', variantData).appendTo(selectField);
            });

        });
        */

        /*$(this.container).on('change', '.customize-font-input-select-variant', function (event) {
            control.onChangeSelectVariantUpdate(event, $(this), elementData);
        });
*/

        /*var sizeDefault = $('[id="input_size_' + elementId + '"]').attr('data-default');
        if (!sizeDefault) {
            sizeDefault = 0; // it has to be initialized with some value, fallback if no default size is submitted, 0 means nothing set, use size defined by theme
        }
        // if available, load current size from stored data
        if (typeof elementData['size'] != 'undefined') {
            sizeDefault = elementData['size'];
        } 

        $('[id="slider_size_' + elementId + '"]').slider({
            value: sizeDefault, min: 0, max: 120, step: 1,
            slide: function (event, ui) {
                $('[id="input_size_' + elementId + '"]').val(ui.value).keyup();
                
                control.onChangeSizeUpdate(event, $(this), elementData, ui.value);
                
            }
        });
        $('[id="input_size_' + elementId + '"]').val($('[id="slider_size_' + elementId + '"]').slider("value"));
  */
       
     
    }


} );
  

})(jQuery);