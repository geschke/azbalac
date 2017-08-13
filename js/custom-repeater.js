/* global jQuery */
/* global wp */




(function ($) {

/* Generate unique id, taken from https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
*/
function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

//var elementData = {}; // todo: better naming

wp.customize.controlConstructor.tikva_repeater = wp.customize.Control.extend( {

    

    ready: function() {
        var control = this;
        //this.elementData = {};



        this.container.on( 'change', function() {
            console.log("change detected!");
            control.setting.set( "laaaaaaaaaaaaaaaaaaaaaaaa"+ uuidv4() );
            console.log($(control.container).find('#tikva_repeater_section_theme_options_intro').val());
            
        });
    
        control.initRepeaterControl();
        
    },

    initRepeaterControl: function() {
        var control = this;
        var elementData = {};


        var element = $(this.container).find('.customize-control-repeater-element');

     


        //console.log(this.container);
        //console.log(element);
        
        // first initialization
        var newId = uuidv4();
        element.attr('id',newId);
        elementData[newId] = {
                elements: {}
            };


        console.log(element.attr('id'));
        /*this.container.on( 'change', 'select',
            function() {
                control.setting.set( jQuery( this ).val() );
            }
        );*/
        // initialize button events
        var newButton = $(this.container).find('.customize-repeater-new-field');
        newButton.on('click',function() {
            var newElement = element.clone();
            var newId = uuidv4();

            newElement.attr('id',newId);
            // clear input fields, maybe replace with default (later, when saving is functional)
            newElement.find('.customize-repeater-input-text').val('');

            newElement.appendTo($('.customize-control-repeater-element-container'));
            elementData[newId] = {
                elements: {}

            };
          
        });

        $(document).on('click', '.customize-repeater-row-remove', function () {
            // todo: count elements, don't remove last element

            console.log("clicked remove");
            var removeElem = $(this).parent();
            var removeId = removeElem.attr('id');
            console.log("elementId: " + removeId);
            removeElem.remove();
            console.log(elementData);
            elementData = _.omit(elementData,removeId);
        
            console.log("after remove:");
            console.log(elementData);
            // todo: find id in elementData and remove

        });

        // initialize key events to handle input fields
        $(document).on('keyup', '.customize-repeater-input-text', function () {
            console.log("on keyup store the whole stuff");
            elementId = $(this).parents('.customize-control-repeater-element').attr('id');
            if (elementData[elementId] != undefined) {
                console.log(elementData[elementId]);
                var dataField = ($(this).attr('data-field'));
                var dataType = ($(this).attr('data-type'));
                if (dataType == 'text') {
                    console.log("data type text");
                    var newValue = $(this).val();
                    if (elementData[elementId]["elements"][dataField] == undefined) {
                        elementData[elementId]["elements"][dataField] = {}; 
                    }
                    elementData[elementId]["elements"][dataField]['type'] = dataType;
                    elementData[elementId]["elements"][dataField]['name'] = dataField;
                    elementData[elementId]["elements"][dataField]['value'] = newValue;

                } else if (dataType == 'url') {

                } //...
                
            }
            else {
                console.log("something went wrong here!");
            }
            console.log(elementData);

            //control.setting.set("foooooo");
            var dataField = $(control.container).find('.tikva_repeater_collector');
            
            //console.log("FOOOOOOOOOOOOOOO container?");
            var dataFieldId = dataField.attr('id');

            //var dataField = $(document).find('#tikva_customize_container');
            
            //dataField = $(document).find('#' + dataFieldId);
            console.log("dataField:");
            console.log(dataField);
            //dataField.val( encodeURI( JSON.stringify( elementData )));
            $(control.container).find('#tikva_repeater_section_theme_options_intro').val( "foooooo");
            //$('document').find('#tikva_repeater_section_theme_options_intro').attr( "data-hm","ooooooo");
            
            dataField.trigger('change');
            //control.setting.set( encodeURI( JSON.stringify( elementData ) ) );
            
        });

    },

    /**
	 * Get the current value of the setting
	 *
	 * @return Object
	 */
	getValue: function() {
        
                'use strict';
        
                // The setting is saved in JSON
                return JSON.parse( decodeURI( this.setting.get() ) );
        
            },


} );
  

})(jQuery);