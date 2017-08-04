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



/********************************************
 *** Generate unique id ***
 *********************************************/
function customizer_repeater_uniqid(prefix, more_entropy) {
    'use strict';
    if (typeof prefix === 'undefined') {
        prefix = '';
    }

    var retId;
    var php_js;
    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10)
            .toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return new Array(1 + (reqWidth - seed.length))
                    .join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!php_js) {
        php_js = {};
    }
    // END REDUNDANT
    if (!php_js.uniqidSeed) { // init seed with big random int
        php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date()
            .getTime() / 1000, 10), 8);
    retId += formatSeed(php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10)
            .toFixed(8)
            .toString();
    }

    return retId;
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
    theme_conrols.on('click', '.customizer-repeater-customize-control-title', function () {
        $(this).next().slideToggle('medium', function () {
            if ($(this).is(':visible')){
                $(this).css('display', 'block');
            }
        });
    });

 


    /**
     * This adds a new box to repeater
     *
     */
    theme_conrols.on('click', '.customizer-repeater-new-field', function () {
        console.log("new field clicked");
        var th = $(this).parent();
        var id = 'customizer-repeater-' + customizer_repeater_uniqid();
        if (typeof th !== 'undefined') {
            /* Clone the first box*/
            var field = th.find('.customizer-repeater-general-control-repeater-container:first').clone();

            if (typeof field !== 'undefined') {
                /*Set the default value for choice between image and icon to icon*/
                //field.find('.customizer-repeater-image-choice').val('customizer_repeater_icon');

            

                /*Show delete box button because it's not the first box*/
                field.find('.social-repeater-general-control-remove-field').show();

               

                /*Remove all repeater fields except first one*/

                field.find('.customizer-repeater-social-repeater').find('.customizer-repeater-social-repeater-container').not(':first').remove();
                field.find('.customizer-repeater-social-repeater-link').val('');
                field.find('.social-repeater-socials-repeater-colector').val('');

                /*Remove value from icon field*/
                // field.find('.icp').val('');

              
             
                /*Set box id*/
                //field.find('.social-repeater-box-id').val(id);

              
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


   theme_conrols.on('click', '.social-repeater-general-control-remove-field', function () {
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

  

    /*Drag and drop to change icons order*/

    $('.customizer-repeater-general-control-droppable').sortable({
        update: function () {
            customizer_repeater_refresh_general_control_values();
        }
    });





})(jQuery);