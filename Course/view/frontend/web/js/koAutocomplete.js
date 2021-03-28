define([
    'uiComponent',
    'jquery',
    'mage/url'
], function (
    Component,
    $,
    urlBuilder
) {
    return Component.extend({
        searchText: '',
        searchResult: [],
        emptyResult: [],
        searchUrl: urlBuilder.build('amcourse/index/search'),
        initObservable: function () {
            this._super();
            this.observe(['searchText', 'searchResult']);
            return this;
        },
        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this)); //при изменении searchtext вызываем нашу функцию handleAutocomplete
        },
        handleAutocomplete: function (searchValue) {
            if (searchValue.length >= 3) {
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
});
