jQuery(document).ready(function() {
	
	/* If there are required actions, add an icon with the number of required actions in the About tikva page -> Actions required tab */
    var Tikva_nr_actions_required = tikvaWelcomeScreenObject.nr_actions_required;

    if ( (typeof Tikva_nr_actions_required !== 'undefined') && (Tikva_nr_actions_required != '0') ) {
        jQuery('li.tikva-w-red-tab a').append('<span class="tikva-actions-count">' + Tikva_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".tikva-dismiss-required-action").click(function(){

        var id= jQuery(this).attr('id');
        console.log(id);
        jQuery.ajax({
            type       : "GET",
            data       : { action: 'Tikva_dismiss_required_action',dismiss_id : id },
            dataType   : "html",
            url        : tikvaWelcomeScreenObject.ajaxurl,
            beforeSend : function(data,settings){
				jQuery('.tikva-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + tikvaWelcomeScreenObject.template_directory + '/inc/admin/info-screen/img/ajax-loader.gif" /></div>');
            },
            success    : function(data){
				jQuery("#temp_load").remove(); /* Remove loading gif */
                jQuery('#'+ data).parent().remove(); /* Remove required action box */

                var Tikva_actions_count = jQuery('.tikva-actions-count').text(); /* Decrease or remove the counter for required actions */
                if( typeof Tikva_actions_count !== 'undefined' ) {
                    if( Tikva_actions_count == '1' ) {
                        jQuery('.tikva-actions-count').remove();
                        jQuery('.tikva-tab-pane#actions_required').append('<p>' + tikvaWelcomeScreenObject.no_required_actions_text + '</p>');
                    }
                    else {
                        jQuery('.tikva-actions-count').text(parseInt(Tikva_actions_count) - 1);
                    }
                }
            },
            error     : function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });
	
	/* Tabs in welcome page */
	function Tikva_welcome_page_tabs(event) {
		jQuery(event).parent().addClass("active");
        jQuery(event).parent().siblings().removeClass("active");
        var tab = jQuery(event).attr("href");
        jQuery(".tikva-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
	}
	
	var Tikva_actions_anchor = location.hash;
	
	if( (typeof Tikva_actions_anchor !== 'undefined') && (Tikva_actions_anchor != '') ) {
		Tikva_welcome_page_tabs('a[href="'+ Tikva_actions_anchor +'"]');
	}
	
    jQuery(".tikva-nav-tabs a").click(function(event) {
        event.preventDefault();
		Tikva_welcome_page_tabs(this);
    });

});