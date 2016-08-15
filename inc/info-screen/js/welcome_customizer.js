jQuery(document).ready(function() {
    var Tikva_aboutpage = tikvaWelcomeScreenCustomizerObject.aboutpage;
    var Tikva_nr_actions_required = tikvaWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof Tikva_aboutpage !== 'undefined') && (typeof Tikva_nr_actions_required !== 'undefined') && (Tikva_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + Tikva_aboutpage + '"><span class="tikva-actions-count">' + Tikva_nr_actions_required + '</span></a>');
    }

    /* Upsell in Customizer (Link to Welcome page) */
    if ( !jQuery( ".tikva-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section tikva-upsells">');
    }
    if (typeof Tikva_aboutpage !== 'undefined') {
        jQuery('.tikva-upsells').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="' + Tikva_aboutpage + '" class="button" target="_blank">{themeinfo}</a>'.replace('{themeinfo}', tikvaWelcomeScreenCustomizerObject.themeinfo));
    }
    if ( !jQuery( ".tikva-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('</li>');
    }
});