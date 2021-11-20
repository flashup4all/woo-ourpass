jQuery(function ($) {
    'use strict';

    // $.ajax({
    //     type: 'POST',
    //     dataType: 'json',
    //     url: wc_checkout_params.ajax_url,
    //     data: {
    //         action: "ourpass_cart_data",
    //     },
    //     success: function (response) {
    //         if (console && console.log) {
    //             console.log("Sample of data:", response);
    //         }
    //     }
    // });

    $.ajax({
        url: "/wp-json/wc/ourpass/v1/cart-data",
    }).done(function (data) {
        if (console && console.log) {
            console.log("Sample of data:", data);
        }
    }).fail(function () {
        alert("error");
    })
});
