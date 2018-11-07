Ext.define('Shopware.apps.OstCogitoSoapApi.model.Printer', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'OstCogitoSoapApi'
        };
    },

    fields: [
        {name: 'Printerkey', type: 'string'},
        {name: 'PrinterDescription', type: 'string'},
        {name: 'Printertype', type: 'string'}
    ]
});

