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
     * Get all variant select fields with selected variant, load font data content, build options array and 
     * show selected option. In case of no ggl font chosen, hide variant select element.
     * 
     */
    displaySelectVariants: function() {
        var control = this;
        $(control.container).find('.customize-font-input-select-variant').each(function(idx) {
            var selectField = this;
            var variantSelected = $(selectField).attr('data-default-selected');
            if (variantSelected != '') {
                console.log("show this!");
              
                $(selectField).parents('.font-input-select-variant').show();
                var fontSelected = $(selectField).parents('.customize-control-font-element').find('.customize-font-input-select').attr('data-default-selected');

                var requestData = {
                    action: "tikva_get_font_data_action",
                    searchfont: fontSelected
                };
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (data, textStatus, jqXHR) {
                        console.log("success");
                        console.log(data);
                        if (data == null) {
                            console.log("no font found");
                        } else {
                            console.log("write options field");

                            if (typeof data.variants != 'undefined') {
                         
                    
                                var selectOption = $(selectField).children()[0]; // string "-- select --"
                                $(selectField).empty().append(selectOption); 
                                
                                _.each(data.variants, function(choiceOption, choiceValue) {
                                    var variantData =  {
                                        'value': choiceOption,
                                        'text': choiceOption                                      
                                    };

                                    if (choiceOption == variantSelected) {
                                        console.log("variantSELECTED!!!" + variantSelected);
                                        variantData['selected'] = 'selected';
                                    }
                                    // choiceOption is the identifier string
                                    $('<option/>', variantData).appendTo(selectField);
                                 
                                });
                            }

                        }
    
                    },
                    error: function (errorMessage) {
         
                        console.log(errorMessage);
                    }
                 
                });      



            } else {
                $(this).parents('.font-input-select-variant').hide();
                console.log("hide this");
            }
         

        });

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
            $('#' + elementId).find('.font-input-select-variant').show();
            
            // get variants from backend or trigger another event
            elementData['gglfont'] = true;
            
            console.log(ajaxurl);

            var requestData = {
                action: "tikva_get_font_data_action",
                searchfont: newValue
            };
     
            $.ajax({
                type: "POST",
                url: ajaxurl,
     
                dataType: "json",
                data: requestData,
                success: function (data, textStatus, jqXHR) {
                    console.log("success");
                    console.log(data);
                    if (data == null) {
                        console.log("no font found");
                    } else {
                        console.log("trigger Action");
                        element.trigger('event_font_gglfont_selected', [ element, elementId, data ]);

                        // this does not work due to asynchronous request
                        // get default (first) first variant to store into elementData
                        if (typeof data.variants != 'undefined') {
                            var defaultVariant = data.variants[0];
                            console.log("defaultVariant and file::");
                            console.log(defaultVariant);
                            console.log(data.files[defaultVariant]);
                            elementData['gglfontdata'] = {'variant': defaultVariant,
                                'file': data.files[defaultVariant]
                            };
                        }
                    }
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
         
        
        } else {
            $('#' + elementId).find('.font-input-select-variant').hide();
            
            // no ggl font, remove ggl font contents
            elementData['gglfont'] = false;
            if (typeof elementData['gglfontdata'] != 'undefined') {
                elementData['gglfontdata'] = null;
            }
        }
        control.updateCurrentDataField(elementData, element);
                
    },


    onChangeSelectVariantUpdate: function( event, element, elementData ) {
        var control = this;
        console.log("in onChangeSelectVariantUpdate");
        elementId = element.parents('.customize-control-font-element').attr('id');
        console.log(element);
        console.log(elementId);
        
        var newValue = element.val();
        var variant = newValue;
        console.log(newValue);
        console.log(elementData);


        var requestData = {
            action: "tikva_get_font_data_action",
            searchfont: elementData['font']
        };
 
        $.ajax({
            type: "POST",
            url: ajaxurl,
 
            dataType: "json",
            data: requestData,
            success: function (data, textStatus, jqXHR) {
                console.log("success");
                console.log(data);
                if (data == null) {
                    console.log("no font found");
                } else {
                    console.log("search variant and store filename into elementData array");
                    //element.trigger('event_font_gglfont_selected', [ element, elementId, data ]);

                    // this does not work due to asynchronous request
                    // get default (first) first variant to store into elementData
                    
                    if (typeof data.variants != 'undefined') {
                        if (typeof data.files[variant] != 'undefined') {
                            // variant found
                            var file = data.files[variant];

                        } else {
                            var file = data.files[data.variants[0]];

                        }
                        console.log("variant and file:");
                        console.log(variant);
                        console.log(file);
                        elementData['gglfontdata'] = {'variant': variant,
                            'file': file
                        };
                        control.updateCurrentDataField(elementData);
                        // todo: call update function to store elementData
                    }
                }
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
     
        // todo: if nothing chosen, use first option and store into elementData array
/*
        elementData['font'] = newValue;

        console.log("fontdata:");
        console.log(elementData);
        
        console.log(typeof newValue);
        if (isNaN(parseInt(newValue))) { // no number, so we have Google Fonts
            console.log("google font!!!");
            // get variants from backend or trigger another event
            console.log(ajaxurl);

         
         
        
        }
        
        control.updateCurrentDataField(elementData, element);
        */        
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
            // todo: if gglfont, get variants and select chosen variant
        } else {
            elementData = {};
        }


        control.displaySelectVariants();

        // initialize key events to handle select fields
        $(this.container).on('change', '.customize-font-input-select', function (event) {
            control.onChangeSelectUpdate(event, $(this), elementData);
        });

        $(this.container).on('event_font_gglfont_selected', function(event, element, elementId, data) {
            console.log("action received with");
            
            console.log(element);
            console.log(data);

            var variantSelect = $('#' + elementId).find('.customize-font-input-select-variant');
            console.log(variantSelect);

            var selectOption = $(variantSelect).children()[0]; // string "-- select --"
            variantSelect.empty().append(selectOption); 
            
            _.each(data.variants, function(choiceOption, choiceValue) {
                // choiceOption this is the identifier string
                $('<option/>', {
                    'value': choiceOption,
                    'text': choiceOption
                }).appendTo(variantSelect);
                console.log(choiceValue);
            });
        });


        $(this.container).on('change', '.customize-font-input-select-variant', function (event) {
            control.onChangeSelectVariantUpdate(event, $(this), elementData);
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