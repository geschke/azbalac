(function ($) {


    $(function () {

        $('body').on('click', '.azbalac-admin-notice .notice-dismiss', function () {
            
            $.ajax({
                type: 'POST',
                url: azbalacWelcome.ajaxurl,
                data: {
                    action: 'azbalac_dismiss_welcome_notice',
                    nonce: azbalacWelcome.nonce
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
