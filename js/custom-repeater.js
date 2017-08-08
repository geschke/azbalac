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

//var elementdata = {}; // todo: better naming

wp.customize.controlConstructor.tikva_repeater = wp.customize.Control.extend( {

    

    ready: function() {
        var control = this;
        //this.elementdata = {};

    
        control.initRepeaterControl();
        
    },

    initRepeaterControl: function() {
        var control = this;
        var elementdata = {};


        var element = $(this.container).find('.customize-control-repeater-element');
        //console.log(this.container);
        //console.log(element);
        
        // first initialization
        var newId = uuidv4();
        element.attr('id',newId);
        elementdata[newId] = {
                placeholder: true
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
            newElement.appendTo($('.customize-control-repeater-element-container'));
            elementdata[newId] = {
                placeholder: true
            };
          
        });

        $(document).on('click', '.customize-repeater-row-remove', function () {
            // todo: count elements, don't remove last element

            console.log("clicked remove");
            var removeElem = $(this).parent();
            var removeId = removeElem.attr('id');
            console.log(elementdata);
            removeElem.remove();
            // todo: find id in elementdata and remove

        });

        // initialize key events to handle input fields
        $(document).on('keyup', '.customize-repeater-input-text', function () {
            console.log("on keyup store the whole stuff");
            
        });

    }
} );
  

})(jQuery);