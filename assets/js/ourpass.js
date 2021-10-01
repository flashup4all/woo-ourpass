jQuery(function ($) {

    let ourpass_submit = false;

    $('#wc-ourpass-form').hide();

    wcOurpassFormHandler();

    jQuery('#ourpass-payment-button').click(function () {
        return wcOurpassFormHandler();
    });

    jQuery('#ourpass_form form#order_review').submit(function () {
        return wcOurpassFormHandler();
    });

    function wcOurpassFormHandler() {

        $('#wc-ourpass-form').hide();

        if (ourpass_submit) {
            ourpass_submit = false;
            return true;
        }

        let $form = $('form#payment-form, form#order_review');
        let ourpass_reference = $form.find('input.ourpass_reference');
        ourpass_reference.val('');

        const clientInfo = wc_ourpass_params;

        clientInfo.onClose = function () {
            $('#wc-ourpass-form').show();
            $(this.el).unblock();
        }

        clientInfo.onSuccess = function () {
            $form.append('<input type="hidden" class="ourpass_reference" name="ourpass_reference" value="' + clientInfo.reference + '"/>');
            ourpass_submit = true;

            $form.submit();

            $('body').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                },
                css: {
                    cursor: "wait"
                }
            });
        }

        OurpassCheckout.openIframe(clientInfo)

        return false;
    }
});