! function (r) {
    "use strict";
    var t = {
        init: function () {
            t.initTestModeChange(),
            t.initProductSelect(), 
            t.initRedirectPageSelect()
        },
        initTestModeChange: function() {
            // Toggle api key settings.
            r(document.body).on('change', '#ourpasswc_test_mode', function () {
                var test_public_key = r('#ourpasswc_test_public_key').parents('tr').eq(0),
                    test_secret_key = r('#ourpasswc_test_secret_key').parents('tr').eq(0),
                    live_public_key = r('#ourpasswc_live_public_key').parents('tr').eq(0),
                    live_secret_key = r('#ourpasswc_live_secret_key').parents('tr').eq(0);

                if (r(this).is(':checked')) {
                    test_secret_key.show();
                    test_public_key.show();
                    live_secret_key.hide();
                    live_public_key.hide();
                } else {
                    test_secret_key.hide();
                    test_public_key.hide();
                    live_secret_key.show();
                    live_public_key.show();
                }
            });

            r('#ourpasswc_test_mode').change();
        },
        initProductSelect: function () {
            var e = r(".ourpass-select--hide-button-products");
            e.select2({
                ajax: {
                    url: ajaxurl,
                    data: function (t) {
                        return {
                            term: t.term,
                            action: "woocommerce_json_search_products",
                            security: e.attr("data-security")
                        }
                    },
                    processResults: function (t) {
                        var c = [];
                        return t && r.each(t, function (t, e) {
                            c.push({
                                id: t,
                                text: e
                            })
                        }), {
                            results: c
                        }
                    },
                    cache: !0
                }
            })
        },
        initRedirectPageSelect: function () {
            var e = r(".ourpass-select--checkout-redirect-page");
            e.select2({
                ajax: {
                    url: ajaxurl,
                    dataType: "json",
                    data: function (t) {
                        return {
                            term: t.term,
                            action: "ourpasswc_search_pages",
                            security: e.attr("data-security")
                        }
                    },
                    processResults: function (t) {
                        var c = [];
                        return t && r.each(t, function (t, e) {
                            c.push({
                                id: t,
                                text: e
                            })
                        }), {
                            results: c
                        }
                    },
                    cache: !0
                },
                minimumInputLength: 3
            })
        }
    };
    r(document).ready(function () {
        t.init()
    })
}(jQuery);