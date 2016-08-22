(function ($) {


    $(function () {

        $('body').on('click', '.tikva-admin-notice .notice-dismiss', function () {
            
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'tikva_dismiss_welcome_notice'
                },
                success: function (data) {
                    //console.log("success");
                    //console.log(data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });

        });

    });

})(jQuery);