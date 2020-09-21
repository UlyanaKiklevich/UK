define([], function () {
    'use strict';

    /**
     * Reverse string
     * @return {String} label
     */
    return function (label) {
        return label.split('').reverse().join('');
    };
});
