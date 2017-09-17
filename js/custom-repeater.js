/* global jQuery */
/* global wp */


/**
 * Preload image when using image type in repeater
 * 
 * @param {*} id 
 * @param {*} payload 
 * @param {*} callback 
 */
function tikvaRepeaterPreloadAttachment(id, payload, callback) {
    // if it doesn't have URL we probably have to preload it
    console.log("in preloadAttachment");
    if (!wp.media.attachment(id).get('url')) {
      wp.media.attachment(id).fetch().then(function () {
          console.log("in plA - calle back");
        callback(wp.media.attachment(id), payload);
      });
      // was:, but what did I want here? element.children('')
      return;
    }
  
    callback(wp.media.attachment(id), payload);
  }


function tikvaRepeaterPreviewImage(payload, attachment) {
    console.log("in tikvaRepeaterPreviewImage");
    console.log(payload);
    console.log(attachment.id);
    console.log(wp.media.attachment(attachment.id).get('url'));
    var elementId = payload['elementId'];
    var elementName = payload['elementName'];
    
    var mediaView = jQuery('#' + elementId).find("div[data-field='" + elementName + "']");

    var placeholder = jQuery(mediaView).find('.placeholder');
    console.log(placeholder.length);
    if (placeholder) {
        // placeholder element is available
        console.log("placeholder available");
        mediaView.empty();
        var imageTemplate = '<div class="thumbnail thumbnail-image"><img class="attachment-thumb" src="" draggable="false" alt=""></div>';
        imageTemplate += '<div class="actions"><button type="button" class="button remove-button tikva-repeater-custom-remove-button">Entfernen</button> <button type="button" class="button upload-button tikva-repeater-custom-upload-button" id="">Bild wechseln</button>  </div>';
        var imageUrl = wp.media.attachment(attachment.id).get('url');
        mediaView.append(imageTemplate);
        mediaView.find('.attachment-thumb').attr('src',imageUrl).css('display','block'); 
        // todo: add remove and replace buttons
    } else {
        // image was set before
        console.log("image exists");
    }
    

    console.log(wp.media.attachment(attachment.id).get('url'));
    //var element = $('#' + elementId);


    /*$('#setting_content_image').removeClass('placeholder');   
    var imageTemplate = '<div class="thumbnail thumbnail-image"><img id="setting_content_image_test" class="attachment-thumb" src="" draggable="false" alt=""></div>';
    $('#setting_content_image').append(imageTemplate);
    
    $('#setting_content_image_test').attr('src',attachment.url).css('display','block'); 
    console.log("Mein Bild: ");
    console.log(attachment.id);  
*/

}

(function ($) {

/* Generate unique id, taken from https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
*/
function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}



wp.customize.controlConstructor.tikva_repeater = wp.customize.Control.extend( {

    

    ready: function() {
        var control = this;
        //this.elementData = {};



        this.container.on( 'something', function() {
            console.log("change detected!");
            var dataField = $(control.container).find('.tikva_repeater_collector');
            console.log("nach 1")
            console.log(dataField);
            var settingData = dataField.val();
            console.log("nach 2");
            console.log(settingData);
            
            control.setting.set( settingData );
            console.log("nach 3");;
            return true;
            //console.log($(control.container).find('#tikva_repeater_section_theme_options_intro').val());
            
        });
    
        control.initRepeaterControl();
        
    },


    /**
     * The first control element should not be removed, so hide it's remove button and display
     * all but not the first
     */
    displayRemoveButtons: function() {
        var control = this;
        $(control.container).find('.customize-repeater-row-remove').each(function(idx) {
            if (idx == 0) {
                $(this).hide();
            } else {
                $(this).show();
            }

        });

    },

    /**
     * Find and update hidden data field with collection of values by submitting new elementData array.
     * At the end, this method triggers an event, so WordPress recognizes the changes.
     * 
     */
    updateCurrentDataField: function(elementData) {
        var control = this;
        var dataField = $(control.container).find('.tikva_repeater_collector');
        
        var dataFieldId = dataField.attr('id');

        console.log("dataField:");
        console.log(dataField);
        console.log(JSON.stringify( elementData ) );
        $(control.container).find('#' + dataFieldId).val( encodeURI( JSON.stringify( elementData ) ));
        
        dataField.trigger('something');

    },

    emptyTemplateEntrySelect: function(selectFields) {
        _.each( selectFields, function( selectField, selectName ) {
        
            if ($(selectField).attr('data-default') != '') {
                //console.log("selectField default:");
                var selectDefault = $(selectField).attr('data-default');
                $(selectField).children('option').each(function(index, optionElem) {
                    if ($(optionElem).val() == selectDefault) {
                        $(optionElem).attr('selected','selected');
                    }
                });
                //$(selectField).val($(selectField).attr('data-default'));
            } else {
                //console.log("selectField set empty");
                $(selectField).children('option').removeAttr("selected");
            }
        });
    },

    onChangeSelectUpdate: function( event ) {
        var control = event.data.control;
        console.log(this);
        console.log("on dropdownpages store the whole stuff");
      
        elementId = $(this).parents('.customize-control-repeater-element').attr('id');
        var elementData = event.data.elementData;
        console.log("elementid:");
        console.log(elementId);
       
        if (elementData[elementId] != undefined) {
            console.log(elementData[elementId]);
            var dataField = ($(this).attr('data-field'));
            var dataType = ($(this).attr('data-type'));
            if (dataType == 'dropdown-pages' || dataType == 'select') {
                console.log("data type select/dropdown-pages");
                var newValue = $(this).val();
                if (elementData[elementId]["elements"][dataField] == undefined) {
                    elementData[elementId]["elements"][dataField] = {}; 
                }
                elementData[elementId]["elements"][dataField]['type'] = dataType;
                elementData[elementId]["elements"][dataField]['name'] = dataField;
                elementData[elementId]["elements"][dataField]['value'] = newValue;

            }
            
        }
        else {
            console.log("something went wrong here!");
        }
        console.log(elementData);

        control.updateCurrentDataField(elementData);
        control.displayRemoveButtons();
                
    },


    /*media_upload: function( buttonElem) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
        //$('body').on('click',button_class, function(e) {
            var button_id = $(buttonElem).attr('id');
            console.log(button_id); 
            var self = $(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            console.log(button);
            var id = $(buttonElem).attr('id').replace('_button', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                   $('.custom_media_id').val(attachment.id); 
                   $('.custom_media_url').val(attachment.url);
                   $('.custom_media_image').attr('src',attachment.url).css('display','block');   
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(buttonElem);
            return false;
        //});
    },*/

    initRepeaterControl: function() {
        var control = this;
        var elementData = {};


        control.displayRemoveButtons();

        console.log("in initRepeaterControl");
        var element = $(this.container).find('.customize-control-repeater-element');

        console.log("elementDATAAAAAAAAAAAAAA");
       // console.log(elementData);
        // first initialization
        console.log("elements length");
        console.log(element.length);
        if (element.length > 1) {
            console.log("groesser eins");
            // preinitialized elements available?
         
            console.log(element[0]);
            element = $(element[0]); // get first element as template 

            console.log("elementDATAAAAAAAAAAAAAA");
            //console.log(elementData);

        } else {
            console.log("kleiner gleich eins");
            console.log("alte id vorhanden?");
            if (element.attr('id') == '') { // element not loaded from database
                // initialie new element, create new element id
                var newId = uuidv4();
                element.attr('id',newId);
                elementData[newId] = {
                    elements: {}
                };
            }

        }


        console.log("FILL HERE");
        var prevValue = $(control.container).find('.tikva_repeater_collector').val();
        console.log(prevValue);
        if (prevValue != '') {
            elementData = JSON.parse(decodeURI(prevValue));
            console.log("altes elementData:");
            console.log(elementData);

        }

       
      
        // initialize button events
        var newButton = $(this.container).find('.customize-repeater-new-field');
        newButton.on('click',function() {
            var newElement = element.clone();
            var newId = uuidv4();

            newElement.attr('id',newId);

            // clear input fields, replace with default, if available
            var inputFields = newElement.find('.customize-repeater-input-text');
            _.each( inputFields, function( inputField, inputName ) {
             
                if ($(inputField).attr('data-default') != '') {
                    $(inputField).val($(inputField).attr('data-default'));
                } else {
                    $(inputFields).val('');
                }
            });
            // todo: empty textarea content or set default
            
            var selectFields = newElement.find('.customize-repeater-input-select');
            control.emptyTemplateEntrySelect(selectFields);
            selectFields = newElement.find('.customize-repeater-input-dropdownpages');
            control.emptyTemplateEntrySelect(selectFields);


            newElement.appendTo($('.customize-control-repeater-element-container'));
            elementData[newId] = {
                elements: {}

            };
            control.displayRemoveButtons();
          
        });

        $(document).on('click', '.customize-repeater-row-remove', function () {
          
            console.log("clicked remove");
            var removeElem = $(this).parent();
            var removeId = removeElem.attr('id');
            console.log("elementId: " + removeId);


            removeElem.remove();
            console.log(elementData);
            elementData = _.omit(elementData,removeId);
            // todo: clear textareaOldval... maybe clear all temporary variables in another method?
            
        
            console.log("after remove:");
            console.log(elementData);

            control.updateCurrentDataField(elementData);

            control.displayRemoveButtons();
         

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

            control.updateCurrentDataField(elementData);
            control.displayRemoveButtons();
            
        });


        // initialize key events to handle input fields
        var textareaOldval = {};
        $(document).on('change keyup paste', '.customize-repeater-input-textarea', function () {
            console.log("on keyup textarea the whole stuff");
            
            console.log(currentVal);
            elementId = $(this).parents('.customize-control-repeater-element').attr('id');

            console.log("oldval:");
            console.log(textareaOldval);

            var currentVal = $(this).val();
            console.log("currentval:");
            console.log(currentVal);
            if(typeof textareaOldval[elementId] != undefined && currentVal == textareaOldval[elementId]) {
                return; //check to prevent multiple simultaneous triggers
            }
        
            textareaOldval[elementId] = currentVal;

            if (elementData[elementId] != undefined) {
                console.log(elementData[elementId]);
                var dataField = ($(this).attr('data-field'));
                var dataType = ($(this).attr('data-type'));
                if (dataType == 'textarea') {
                    console.log("data type textarea");

                    var newValue = $(this).val();
                    console.log("value:");
                    console.log(newValue);
                    if (elementData[elementId]["elements"][dataField] == undefined) {
                        elementData[elementId]["elements"][dataField] = {}; 
                    }
                    elementData[elementId]["elements"][dataField]['type'] = dataType;
                    elementData[elementId]["elements"][dataField]['name'] = dataField;
                    elementData[elementId]["elements"][dataField]['value'] = newValue;

                } else if (dataType == 'url') {
                        // not necessary here
                } //...
                
            }
            else {
                console.log("something went wrong here!");
            }
            console.log(elementData);

            control.updateCurrentDataField(elementData);
            control.displayRemoveButtons();
            
        });


        /*$(document).on('click','#setting_content_area_0_image_button',function(e) {
            console.log("Image upload, here we go!");
            //control.media_upload( this );
        });
*/
        var custom_uploader;

        $(document).on('click', '.tikva-repeater-custom-upload-button', function(e) {
            console.log("upload button pressed?");
            elementId = $(this).parents('.customize-control-repeater-element').attr('id');
            var mediaView = $(this).parents('.attachment-media-view');
            console.log("elementId: " + elementId);

            if (elementData[elementId] != undefined) {
                console.log(elementData[elementId]);
                var dataField = ($(this).parents('.attachment-media-view').attr('data-field'));
                var dataType = ($(this).parents('.attachment-media-view').attr('data-type'));
                console.log("dataField: ");
                console.log(dataField);
                console.log("dataType:");
                console.log(dataType);
                /*    var newValue = $(this).val();
                    if (elementData[elementId]["elements"][dataField] == undefined) {
                        elementData[elementId]["elements"][dataField] = {}; 
                    }
                    elementData[elementId]["elements"][dataField]['type'] = dataType;
                    elementData[elementId]["elements"][dataField]['name'] = dataField;
                    elementData[elementId]["elements"][dataField]['value'] = newValue;

                } else if (dataType == 'url') {

                } //...
                */
            }
            else {
                console.log("elementData undefined!");
            }
            console.log(elementData);

            e.preventDefault();
    
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
    
            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
    
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                //$('#setting_content_upload_test').val(attachment.url);

                //if ( _custom_media  ) {
                // $('.custom_media_id').val(attachment.id); 
                // $('.custom_media_url').val(attachment.url);
                /*$('#setting_content_image').removeClass('placeholder');   
                var imageTemplate = '<div class="thumbnail thumbnail-image"><img id="setting_content_image_test" class="attachment-thumb" src="" draggable="false" alt=""></div>';
                $('#setting_content_image').append(imageTemplate);
                
                $('#setting_content_image_test').attr('src',attachment.url).css('display','block'); 
                */
                console.log("Mein Bild: ");
                console.log(attachment.id);  
              

                //var mediaView = $('#' . elementId).find('.attachment-media-view');
                mediaView.empty();
                var imageTemplate = '<div class="thumbnail thumbnail-image"><img class="attachment-thumb" src="" draggable="false" alt=""></div>';
                imageTemplate += '<div class="actions"><button type="button" class="button remove-button tikva-repeater-custom-remove-button">Entfernen</button> <button type="button" class="button upload-button tikva-repeater-custom-upload-button" id="">Bild wechseln</button>  </div>';
               
                mediaView.append(imageTemplate);
                mediaView.find('.attachment-thumb').attr('src',attachment.url).css('display','block'); 



                if (elementData[elementId]["elements"][dataField] == undefined) {
                    elementData[elementId]["elements"][dataField] = {}; 
                }
                elementData[elementId]["elements"][dataField]['type'] = dataType;
                elementData[elementId]["elements"][dataField]['name'] = dataField;
                elementData[elementId]["elements"][dataField]['value'] = attachment.id;

                console.log("result?");
                console.log(elementData[elementId]["elements"][dataField]);
                control.updateCurrentDataField(elementData);
                control.displayRemoveButtons();

                //} else {
                //    return _orig_send_attachment.apply( button_id, [props, attachment] );
                //}


            });
    
            //Open the uploader dialog
            custom_uploader.open();
    
        });

        $(document).on('click', '.tikva-repeater-custom-remove-button', function(e) {
            console.log("remove button pressed?");
            elementId = $(this).parents('.customize-control-repeater-element').attr('id');
            var mediaView = $(this).parents('.attachment-media-view');
            console.log("elementId: " + elementId);

            var dataField = ($(this).parents('.attachment-media-view').attr('data-field'));
            var dataType = ($(this).parents('.attachment-media-view').attr('data-type'));
            console.log("dataField: ");
            console.log(dataField);
            console.log("dataType:");
            console.log(dataType);

            mediaView.empty();
            var imageTemplate = '<div class="setting_content_image placeholder">Kein Bild ausgewählt</div><div class="actions"> <button type="button" class="button tikva-repeater-custom-upload-button">Bild auswählen</button>      </div>';
            mediaView.append(imageTemplate);
            // todo: remove from elementData

            elementData[elementId]["elements"][dataField] = {}; 
            control.updateCurrentDataField(elementData);
            

        });
        

        // initialize key events to handle select fields
        $(document).on('change', '.customize-repeater-input-select', 
            { elementData: elementData,
              control: control }, 
            control.onChangeSelectUpdate );
        $(document).on('change', '.customize-repeater-input-dropdownpages', 
            { elementData: elementData,
              control: control }, 
            control.onChangeSelectUpdate );
        

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