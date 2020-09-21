define([
    'UK_NutsCheckout/js/action/reverse-label'
], function(reverseLabelAction) {
    'use strict';

    return function (target) {
        return target.extend({
            /**
             * Initializes regular properties of instance.
             *
             * @returns {Abstract} Chainable.
             */
            initConfig: function () {
                this._super();
                if (this.label) {
                    this.label = reverseLabelAction(this.label);
                }
                return this;
            },
        });
    }
});
