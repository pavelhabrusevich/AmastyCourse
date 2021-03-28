define([
    'uiComponent',
    'jquery',
    'mage/url'
], function (
    Component,
    $,
    urlBuilder
) {
    return function (Component) {
        return Component.extend({
            initialize: function () {
                this._super();
            },
            handleAutocomplete: function (searchValue) {
                if (searchValue.length >= 4) {
                    $.getJSON(this.searchUrl, {
                        sku: searchValue
                    }, function (data) {
                        this.searchResult(data);
                    }.bind(this));
                } else {
                    this.searchResult(this.emptyResult);
                }
            }
        });
    }
});
