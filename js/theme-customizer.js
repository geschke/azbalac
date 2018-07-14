

(function ($) {


    $.setSocialMediaButtonColors = function(colors) {

        var inlineText = '';
        if (colors.social_button_color_bg_hover) {
            inlineText +=  ".socialhover { color: " + colors.social_button_color_bg_hover + ' !important; } ';
        }
        if (colors.social_button_color_bg) {
            inlineText += " .innersocialbg { color: " + colors.social_button_color_bg + '; }';

        }
        if (colors.social_button_color_fg) {
            inlineText += " .innersocial { color: " + colors.social_button_color_fg + '; }';

        }
        $('#azbalac-default-style-socialmediabuttons-inline-css').text(inlineText);

    };

    // todo later
    // Realtime view of site name
    /*wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('#site-header-text a').text(to);
        });
    });
*/
    // Realtime view of description
/*    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('#site-description').text(to);
        });
    });
*/
/*    wp.customize('header_textcolor', function (value) {
        value.bind(function (col) {
            $('#header').css('color', col);
            $('.header-url').css('color', col);
        });
    });
*/

    wp.customize('azbalac_color_bg_header', function (value) {
        value.bind(function (col) {
            $('#header').css('background-color', col);
        });
    });

    wp.customize('azbalac_color_fg_footer', function (value) {
        value.bind(function (col) {
            $('.site-footer-1').css('color', col);
        });
    });

    wp.customize('azbalac_color_bg_footer', function (value) {
        value.bind(function (col) {
            $('.site-footer-1').css('background-color', col);
        });
    });

    wp.customize('azbalac_color_fg_sidebar', function (value) {
        value.bind(function (col) {
            $('#primary-sidebar > div > div').css('color', col);
        });
    });

    wp.customize('azbalac_color_bg_sidebar', function (value) {
        value.bind(function (col) {
            $('#primary-sidebar > div > div').css('background-color', col);
        });
    });

    wp.customize('azbalac_setting_color_fg_title', function (value) {
        value.bind(function (col) {
            $('#site-header-text a').css('color', col);
        });
    });

    wp.customize('azbalac_setting_color_fg_subtitle', function (value) {
        value.bind(function (col) {
            $('#site-description').css('color', col);
        });
    });

    wp.customize('azbalac_setting_social_button_color_fg', function (value) {
        value.bind(function (col) {
            //$('.innersocial').css('color', col);
            objectSocialMediaButtons.social_button_color_fg = col;
            $.setSocialMediaButtonColors(objectSocialMediaButtons);

        });
    });

    wp.customize('azbalac_setting_social_button_color_bg', function (value) {
        value.bind(function (col) {
            //$('.innersocialbg').css('color', col);
            objectSocialMediaButtons.social_button_color_bg = col;
            $.setSocialMediaButtonColors(objectSocialMediaButtons);
        });
    });

    wp.customize('azbalac_setting_social_button_color_bg_hover', function (value) {
        value.bind(function (col) {
            //$('.socialhover').css('color', col);
            objectSocialMediaButtons.social_button_color_bg_hover = col;
            $.setSocialMediaButtonColors(objectSocialMediaButtons);
        });
    });

    wp.customize('azbalac_setting_header_color_bg', function (value) {
        value.bind(function (color) {
            //console.log(color);
            //console.log()
            var percentValue = objectAdminHeader.header_background_transp;
            objectAdminHeader.header_color_bg = color;
            var colorNew = color + percentValue.toString(16);
            
            $('#site-header-text a').css('background', colorNew);
            $('#site-description').css('background', colorNew);

            //console.log(objectAdminHeader.header_color_bg);
            //console.log(objectAdminHeader.header_background_transp);
        });
    });

    wp.customize('azbalac_setting_header_background_transp', function (value) {
        value.bind(function (percent) {
            var percentValue = parseInt(Math.round(255 / 100 * percent),10);
            objectAdminHeader.header_background_transp = percent;
            var color = objectAdminHeader.header_color_bg;
            var colorNew = color + percentValue.toString(16);
            //console.log(percentValue);
            //console.log(percentValue.toString(16));
            //console.log(colorNew);
            $('#site-header-text a').css('background', colorNew);
            $('#site-description').css('background', colorNew);
           
           /* $('#site-header-text a').css('opacity', col / 100);
            $('#site-description').css('opacity', col / 100);*/
            //$('#site-description').css('color', col);
        });
    });

/*  currently not used, reload page
  wp.customize('azbalac_setting_header_alignment', function (value) {
        value.bind(function (pos) {
            //$('#site-description').css('color', col);
            // 1 = top left
            //2 = top center
            //3 = top right
            //4 = bottom left
            //5 = bottom center
            //6 = bottom right
            
            if (pos == 2) { 

            } else if (pos == 3) {
                $('#site-header-container-overlay').css('left', '');
                $('#site-header-container-overlay').css('right', '100px');

                    
            } else if (pos == 4) {

            } else if (pos == 5) {

            } else if (pos == 6) {

            } else { // 1 is default
                $('#site-header-container-overlay').css('right', '');
                $('#site-header-container-overlay').css('left', '100px');
            }
        });
    });
*/
    wp.customize('azbalac_setting_header_distance_top', function (value) {
        value.bind(function (dist) {
            if ($.inArray( parseInt(objectAdminHeader.header_alignment,10) , [1,2,3]) !== -1) {
                //console.log("hier");
                $('#site-header-container-overlay').css('top', dist +  'px');
            } else {
                //console.log("da");
                $('#site-header-container-overlay').css('bottom', dist +  'px');
            }
        });
    });

    wp.customize('azbalac_setting_header_distance_left', function (value) {
        value.bind(function (dist) {
            //console.log("alignment?");
                //console.log(objectAdminHeader.header_alignment);
            if ($.inArray( objectAdminHeader.header_alignment, ['1','4']) !== -1) {
                //console.log("warum in 1 und 4?");
                $('#site-header-container-overlay').css('left', dist +  'px');
            } else if ($.inArray( objectAdminHeader.header_alignment, ['3','6']) !== -1) {
                //console.log("in 3 und 6");
                $('#site-header-container-overlay').css('right', dist +  'px');
            } else {
                //console.log("don't know");
            }

            //$('#site-description').css('color', col);
        });
    });

    
    wp.customize('azbalac_setting_header_distance_between', function (value) {
        value.bind(function (dist) {
                //console.log(objectAdminHeader.header_alignment);
            $('#site-header-box-title').css('margin-bottom', dist +  'px');
        });
    });


    wp.customize('azbalac_setting_typography_headline', function (value) {
        value.bind(function (data) {
            fontData = JSON.parse(decodeURI(data));
           
            var sizeBase = 16; // defined in Bootstrap
            if (typeof fontData['size'] != 'undefined' && fontData['size'] != 0) {
               
                var sizeBase = fontData['size'];
            } 

            var sizeH1 = Math.floor(sizeBase * 2.6).toString() + 'px';
            var sizeH2 = Math.floor(sizeBase * 2.15).toString() + 'px';
            var sizeH3 = Math.ceil(sizeBase * 1.7).toString() + 'px';
            var sizeH4 = Math.ceil(sizeBase * 1.28).toString() + 'px';
            var sizeH5 = sizeBase.toString() + 'px';
            var sizeH6 = Math.ceil(sizeBase * 0.85).toString() + 'px';
            var sizeJumbotronHeading = Math.ceil(sizeBase * 4.5).toString() + 'px';
            //var sizeSubtitle = Math.floor(sizeBase * 1.5).toString() + 'px';

            $('h1').not(".azbalac-jumbotron").not("#site-header-text").css('font-size', sizeH1);
            $('.jumbotron h1').css('font-size', sizeJumbotronHeading);

            $('h2').not("#site-description").css('font-size', sizeH2);
            
            $('h3').css('font-size', sizeH3);
            $('h4').css('font-size', sizeH4);
            $('h5').css('font-size', sizeH5);
            $('h6').css('font-size', sizeH6);
            //$('#site-description').css('font-size',sizeSubtitle);
        
            if (typeof fontData['gglfont'] != 'undefined' && (fontData['gglfont'] == true || isNaN(parseInt(fontData['font'])))) { // ggl font

                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-headline-font').length) {

                    $('#typography-headline-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    var linkData = {
                        'id': 'typography-headline-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('h1,h2,h3,h4,h5,h6').css('font-family', fontData['font']);
            
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                $('h1,h2,h3,h4,h5,h6').css('font-family','');
                if ($('#typography-headline-font').length) {
                    $('#typography-headline-font').remove();
                }
                if ($('#typography-headline').length) {
                    $('#typography-headline').remove();
                }
                

            } else { // default font
                var requestData = {
                    action: "azbalac_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: azbalacAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        if (res != null) {
                            $('h1,h2,h3,h4,h5,h6').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

        });
    
    });



    wp.customize('azbalac_setting_typography_body', function (value) {
        value.bind(function (data) {
            
            fontData = JSON.parse(decodeURI(data));
            var sizeBase = 16; // defined in Bootstrap
            if (typeof fontData['size'] != 'undefined' && fontData['size'] != 0) {
                var sizeBase = fontData['size'];
            } 

            var sizeJumbotron = Math.ceil(sizeBase * 1.5).toString() + 'px';

            $('body').css('font-size', sizeBase);
            $('body .jumbotron').css('font-size', sizeJumbotron);
        
            if (typeof fontData['gglfont'] != 'undefined' && (fontData['gglfont'] == true || isNaN(parseInt(fontData['font'])))) { // ggl font

                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-body-font').length) {

                    $('#typography-body-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    var linkData = {
                        'id': 'typography-body-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('body').css('font-family', fontData['font']);
            
    
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                $('body').css('font-family','');
                if ($('#typography-body-font').length) {
                    $('#typography-body-font').remove();
                }
                if ($('#typography-body').length) {
                    $('#typography-body').remove();
                }
                

            } else { // default font
                
                var requestData = {
                    action: "azbalac_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: azbalacAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        if (res != null) {
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


    wp.customize('azbalac_setting_typography_navbar', function (value) {
        value.bind(function (data) {
            
            fontData = JSON.parse(decodeURI(data));
            if (typeof fontData['size'] != 'undefined' && fontData['size'] != 0) {
                $('nav#navbarMain').css('font-size', fontData['size']);
            } else {
                $('nav#navbarMain').css('font-size', '');
            }
        
            if (typeof fontData['gglfont'] != 'undefined' && (fontData['gglfont'] == true || isNaN(parseInt(fontData['font'])))) { // ggl font

                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-navbar-font').length) {

                    $('#typography-navbar-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    var linkData = {
                        'id': 'typography-navbar-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('nav#navbarMain').css('font-family', fontData['font']);
            
    
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                $('nav#navbarMain').css('font-family','');
                if ($('#typography-navbar-font').length) {
                    $('#typography-navbar-font').remove();
                }
                if ($('#typography-navbar').length) {
                    $('#typography-navbar').remove();
                }
                

            } else { // default font
                
                var requestData = {
                    action: "azbalac_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: azbalacAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        if (res != null) {
                            $('nav#navbarMain').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

        });
       
    });


    wp.customize('azbalac_setting_typography_title', function (value) {
        value.bind(function (data) {
            
            fontData = JSON.parse(decodeURI(data));
            if (typeof fontData['size'] != 'undefined' && fontData['size'] != 0) {
                $('#site-header-text a').css('font-size', fontData['size']);
            } else {
                $('#site-header-text a').css('font-size', '');
            }

           
            if (typeof fontData['gglfont'] != 'undefined' && (fontData['gglfont'] == true || isNaN(parseInt(fontData['font'])))) { // ggl font

                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-title-font').length) {

                    $('#typography-title-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    var linkData = {
                        'id': 'typography-title-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('#site-header-text a').css('font-family', fontData['font']);
            
    
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                $('#site-header-text a').css('font-family','');
                //$('#site-header-text a').css('font-size','');
                if ($('#typography-title-font').length) {
                    $('#typography-title-font').remove();
                }
                if ($('#typography-title').length) {
                    $('#typography-title').remove();
                }
                

            } else { // default font
                
                var requestData = {
                    action: "azbalac_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: azbalacAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        if (res != null) {
                            $('#site-header-text a').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

        });
       
    });


    wp.customize('azbalac_setting_typography_subtitle', function (value) {
        value.bind(function (data) {
            
            fontData = JSON.parse(decodeURI(data));
            if (typeof fontData['size'] != 'undefined' && fontData['size'] != 0) {
                $('#site-description').css('font-size', fontData['size']);
            } else {
                $('#site-description').css('font-size', '');
            }
                  
            if (typeof fontData['gglfont'] != 'undefined' && (fontData['gglfont'] == true || isNaN(parseInt(fontData['font'])))) { // ggl font

                var fontVariant = '';
                if (typeof fontData['gglfontdata'] != 'undefined' && fontData['gglfontdata'] != null && typeof fontData['gglfontdata']['variant'] != 'undefined' && fontData['gglfontdata']['variant'] != 'regular') {
                    fontVariant = ':' + fontData['gglfontdata']['variant'];
                }

                if ($('#typography-subtitle-font').length) {

                    $('#typography-subtitle-font').attr('href','https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font'])+ fontVariant);
                } else {
                    var linkData = {
                        'id': 'typography-subtitle-font',
                        'href':'https://fonts.googleapis.com/css?family=' + encodeURI(fontData['font']) + fontVariant,
                        'rel': 'stylesheet'
                    };
                    $('<link/>',linkData).appendTo("head");

                }
                $('#site-description').css('font-family', fontData['font']);
            
    
            } else if (parseInt(fontData['font']) == 0) { // no font selected, switch to theme stylesheet font 
                $('#site-description').css('font-family','');
                //$('#site-description').css('font-size','');
                
                if ($('#typography-subtitle-font').length) {
                    $('#typography-subtitle-font').remove();
                }
                if ($('#typography-subtitle').length) {
                    $('#typography-subtitle').remove();
                }
                

            } else { // default font
                
                var requestData = {
                    action: "azbalac_get_default_font_data_action"
                }
    
                $.ajax({
                    type: "POST",
                    url: azbalacAjax.ajaxurl,
         
                    dataType: "json",
                    data: requestData,
                    success: function (res, textStatus, jqXHR) {
                        if (res != null) {
                            $('#site-description').css('font-family', res[fontData['font']]);
                        }
                    },
                    error: function (errorMessage) {
                        // later: show error?
                    }
                 
                });     
            }

          
          

        });
       
    });


})(jQuery);