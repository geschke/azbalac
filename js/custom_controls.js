/* global jQuery */
/* global wp */


(function ($) {



var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    '\'': '&#39;',
    '/': '&#x2F;'
};

function escapeHtml(string) {
    'use strict';
    //noinspection JSUnresolvedFunction
    string = String(string).replace(new RegExp('\r?\n', 'g'), '<br />');
    string = String(string).replace(/\\/g, '&#92;');
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });

}

/* Generate unique id, taken from https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
*/
function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}




/********************************************
 *** General Repeater ***
 *********************************************/


function customizer_repeater_refresh_general_control_values() {
    'use strict';
    $('.customizer-repeater-general-control-repeater').each(function () {
        var values = [];
        var th = $(this);
        th.find('.customizer-repeater-general-control-repeater-container').each(function () {

            var title = $(this).find('.customizer-repeater-title-control').val();

            if (title !== ''  ) {
                values.push({
                    'title': escapeHtml(title)
                });
            }

        });
        th.find('.customizer-repeater-colector').val(JSON.stringify(values));
        th.find('.customizer-repeater-colector').trigger('change');
    });
}


 'use strict';
 var theme_conrols = $('#customize-theme-controls');
 

    /**
     * This adds a new box to repeater
     *
     */
    theme_conrols.on('click', '.customizer-repeater-new-field', function () {
        console.log("new field clicked");
        var th = $(this).parent();
        var id = 'customizer-repeater-' + uuidv4();
        if (typeof th !== 'undefined') {
            /* Clone the first box*/
            var field = th.find('.customizer-repeater-general-control-repeater-container:first').clone();

            if (typeof field !== 'undefined') {

                /*Show delete box button because it's not the first box*/
                field.find('.customizer-repeater-general-control-remove-field').show();
              
             
                /*Set box id*/
                field.find('.customizer-repeater-box-id').val(id);

              
                /*Remove value from title field*/
                field.find('.customizer-repeater-title-control').val('');

             
                /*Append new box*/
                th.find('.customizer-repeater-general-control-repeater-container:first').parent().append(field);

                /*Refresh values*/
                customizer_repeater_refresh_general_control_values();
            }

        }
        return false;
    });


   theme_conrols.on('click', '.customizer-repeater-general-control-remove-field', function () {
       console.log("delete field clicked");
        if (typeof    $(this).parent() !== 'undefined') {
            $(this).parent().parent().remove();
            customizer_repeater_refresh_general_control_values();
        }
        return false;
    });


    theme_conrols.on('keyup', '.customizer-repeater-title-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

  

})(jQuery);