

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

    wp.customize('header_textcolor', function (value) {
        value.bind(function (col) {
            $('#header').css('color', col);
            $('.header-url').css('color', col);
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

    wp.customize('setting_typography_headline', function (value) {
        value.bind(function (data) {
            //$('#primary-sidebar > div').css('background-color', col);
            fontData = JSON.parse(decodeURI(data));
            console.log(fontData);
            var sizeBase = 16; // defined in Bootstrap
            if (fontData['size'] != 0) {
                var sizeBase = fontData['size'];
            } 

            var sizeH1 = Math.floor(sizeBase * 2.6).toString() + 'px';
            var sizeH2 = Math.floor(sizeBase * 2.15).toString() + 'px';
            var sizeH3 = Math.ceil(sizeBase * 1.7).toString() + 'px';
            var sizeH4 = Math.ceil(sizeBase * 1.28).toString() + 'px';
            var sizeH5 = sizeBase.toString() + 'px';
            var sizeH6 = Math.ceil(sizeBase * 0.85).toString() + 'px';
            var sizeJumbotronHeading = Math.ceil(sizeBase * 4.5).toString() + 'px';
            var sizeSubtitle = Math.floor(sizeBase * 1.5).toString() + 'px';

            $('h1').not(".tikva-jumbotron").css('font-size', sizeH1);
            $('.jumbotron h1').css('font-size', sizeJumbotronHeading);
            $('h2').css('font-size', sizeH2);
            $('h3').css('font-size', sizeH3);
            $('h4').css('font-size', sizeH4);
            $('h5').css('font-size', sizeH5);
            $('h6').css('font-size', sizeH6);
            $('#site-description').css('font-size',sizeSubtitle);
        
            console.log(parseInt(fontData['font']));
            if (fontData['gglfont'] == true || isNaN(parseInt(fontData['font']))) { // ggl font


                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-headline-font').length) {

                    console.log($('#typography-headline-font').attr('href'));
                    
                    $('#typography-headline-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    console.log("add typography headline-font"); 
                    var linkData = {
                        'id': 'typography-headline-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('h1,h2,h3,h4,h5,h6').css('font-family', fontData['font']);
            
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                console.log("nothing");
                $('h1,h2,h3,h4,h5,h6').css('font-family','');
                if ($('#typography-headline-font').length) {
                    console.log("something to do");
                    $('#typography-headline-font').remove();
                }
                if ($('#typography-headline').length) {
                    console.log("something to do with headline");
                    $('#typography-headline').remove();
                }
                

            } else { // default font
                console.log(fontData['font']);

                var requestData = {
                    action: "tikva_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: tikvaAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        //console.log(res);
                        if (res != null) {
                            //console.log(res[fontData['font']]);
                            $('h1,h2,h3,h4,h5,h6').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

        });
        //console.log(value);
    });



    wp.customize('setting_typography_body', function (value) {
        value.bind(function (data) {
            
            console.log("in setting typo body");
            //$('#primary-sidebar > div').css('background-color', col);
            fontData = JSON.parse(decodeURI(data));
            console.log(fontData);
            var sizeBase = 16; // defined in Bootstrap
            if (fontData['size'] != 0) {
                var sizeBase = fontData['size'];
            } 

            var sizeJumbotron = Math.ceil(sizeBase * 1.5).toString() + 'px';

            $('body').css('font-size', sizeBase);
            $('body .jumbotron').css('font-size', sizeJumbotron);
            
        
            console.log(parseInt(fontData['font']));
            if (fontData['gglfont'] == true || isNaN(parseInt(fontData['font']))) { // ggl font


                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-body-font').length) {

                    console.log($('#typography-body-font').attr('href'));
                    
                    $('#typography-body-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    console.log("add typography body-font"); 
                    var linkData = {
                        'id': 'typography-body-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('body').css('font-family', fontData['font']);
            
    
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                console.log("nothing");
                $('body').css('font-family','');
                if ($('#typography-body-font').length) {
                    console.log("something to do");
                    $('#typography-body-font').remove();
                }
                if ($('#typography-body').length) {
                    console.log("something to do with body");
                    $('#typography-body').remove();
                }
                

            } else { // default font
                console.log(fontData['font']);

                var requestData = {
                    action: "tikva_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: tikvaAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        //console.log(res);
                        if (res != null) {
                            //console.log(res[fontData['font']]);
                            $('body').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

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