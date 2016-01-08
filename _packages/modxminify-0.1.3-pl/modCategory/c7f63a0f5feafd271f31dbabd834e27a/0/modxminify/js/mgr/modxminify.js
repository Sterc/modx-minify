var modxMinify = function(config) {
    config = config || {};
modxMinify.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('modxminify',modxMinify);
modxMinify = new modxMinify();