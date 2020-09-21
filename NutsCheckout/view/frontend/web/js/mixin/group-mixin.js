define([
    'UK_NutsCheckout/js/action/reverse-label'
], function(reverseLabelAction) {
    'use strict';

    return function (target) {
        return target.extend({
            /**
             * Extends this with defaults and config.
             * Then calls initObservable, iniListenes and extractData methods.
             */
            initialize: function () {
                this._super();
                if (this.label) {
                    this.label = reverseLabelAction(this.label);
                }

                return this;
            },
        });
    }
});
