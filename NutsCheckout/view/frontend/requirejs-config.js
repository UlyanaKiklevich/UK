var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'UK_NutsCheckout/js/mixin/shipping-mixin': true
            },
            'Magento_Ui/js/form/element/abstract': {
                'UK_NutsCheckout/js/mixin/abstract-mixin': true
            },
            'Magento_Ui/js/form/components/group': {
                'UK_NutsCheckout/js/mixin/group-mixin': true
            }
        }
    }
};
