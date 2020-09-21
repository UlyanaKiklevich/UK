define([
    'mage/url'
], function(urlBuilder) {
    'use strict';

    return function (target) {
        return target.extend({
            /**
             * @inheritDoc
             */
            setShippingInformation: function () {
                var url = urlBuilder.build("checkout/cart");
                window.location.href = url;
            }
        });
    }
});
