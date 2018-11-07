Ext.define('Shopware.apps.OstCogitoSoapApi.store.Printer', {
    alternateClassName: 'OstCogitoSoapApi.store.Printer',
    extend: 'Ext.data.Store',
    storeId: 'OstCogitoSoapApi.Printer',
    autoLoad: true,
    remoteSort: false,
    remoteFilter: false,
    model: 'Shopware.apps.OstCogitoSoapApi.model.Printer',
    proxy: {
        type: 'ajax',
        url: '{url controller="OstCogitoSoapApi" action="printerList"}',
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
}).create();