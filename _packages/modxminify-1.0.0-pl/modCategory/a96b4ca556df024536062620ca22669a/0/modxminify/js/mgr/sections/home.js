Ext.onReady(function() {
    MODx.load({ xtype: 'modxminify-page-home'});
});

modxMinify.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modxminify-panel-home'
            ,renderTo: 'modxminify-panel-home-div'
        }]
    });
    modxMinify.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.page.Home,MODx.Component);
Ext.reg('modxminify-page-home',modxMinify.page.Home);