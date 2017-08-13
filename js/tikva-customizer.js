


(function ($) {

    // Realtime view of site name
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('#site-header-text a').text(to);
        });
    });

    // Realtime view of description
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('#site-description').text(to);
        });
    });

    wp.customize('color_bg_header', function (value) {
        value.bind(function (col) {
            $('#header').css('background-color', col);
        });
    });

    wp.customize('color_fg_footer', function (value) {
        value.bind(function (col) {
            $('.site-footer-1').css('color', col);
        });
    });

    wp.customize('color_bg_footer', function (value) {
        value.bind(function (col) {
            $('.site-footer-1').css('background-color', col);
        });
    });

    wp.customize('color_fg_sidebar', function (value) {
        value.bind(function (col) {
            $('#primary-sidebar > div').css('color', col);
        });
    });

    wp.customize('color_bg_sidebar', function (value) {
        value.bind(function (col) {
            $('#primary-sidebar > div').css('background-color', col);
        });
    });

    //wp.customize('setting_introduction_area_elements', function (value) {
    //    console.log("in postMessage");
    //    console.log(value);

        /*value.bind(function (col) {
            $('#primary-sidebar > div').css('background-color', col);
        });*/
    //});
    

})(jQuery);