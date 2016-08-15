jQuery(document).ready(function() {
	
	/* If there are required actions, add an icon with the number of required actions in the About tikva page -> Actions required tab */
   
   
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