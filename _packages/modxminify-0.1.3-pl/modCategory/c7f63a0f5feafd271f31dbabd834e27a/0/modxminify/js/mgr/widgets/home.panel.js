modxMinify.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('modxminify')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeTab: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('modxminify.file.files')
                ,items: [{
                    html: '<p>'+_('modxminify.file.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'modxminify-grid-files'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            },{
                title: _('modxminify.group.groups')
                ,items: [{
                    html: '<p>'+_('modxminify.group.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'modxminify-grid-groups'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            }]
        }]
    });
    modxMinify.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.panel.Home,MODx.Panel);
Ext.reg('modxminify-panel-home',modxMinify.panel.Home);
