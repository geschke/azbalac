(function ($) {


    $(function () {

        /*$('.tikva-admin-notice').on('click', function() {
         console.log("clicked 1");
         });
         */
        $('body').on('click', '.tikva-admin-notice .notice-dismiss', function () {
            //$('.tikva-admin-notice .notice-dismiss').on('click', function() {
            console.log("clicked");

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'tikva_dismiss_welcome_notice'
                },
                success: function (data) {
                    console.log("success");
                    console.log(data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });

        });

    });

})(jQuery);