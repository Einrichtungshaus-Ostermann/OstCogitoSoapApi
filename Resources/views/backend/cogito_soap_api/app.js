Ext.define('Shopware.apps.OstCogitoSoapApi', {
    extend: 'Enlight.app.SubApplication',

    name: 'Shopware.apps.OstCogitoSoapApi',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [],

    views: [],

    models: ['Printer'],
    stores: ['Printer'],

    launch: function () {
        return;
    }
});