modxMinify.grid.Groups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'modxminify-grid-groups'
        ,url: modxMinify.config.connectorUrl
        ,baseParams: {
            action: 'mgr/group/getlist'
        }
        ,save_action: 'mgr/group/updatefromgrid'
        ,autosave: true
        ,fields: ['id','name','description',]
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
        },{
            header: _('modxminify.group.name')
            ,dataIndex: 'name'
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('modxminify.group.description')
            ,dataIndex: 'description'
            ,width: 250
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar: [{
            text: _('modxminify.global.create')+' '+_('modxminify.group').toLowerCase()
            ,handler: this.createGroup
            ,scope: this
        },'->',{
            xtype: 'textfield'
            ,emptyText: _('modxminify.global.search') + '...'
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    modxMinify.grid.Groups.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.grid.Groups,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('modxminify.group.update')
            ,handler: this.updateGroup
        });
        m.push('-');
        m.push({
            text: _('modxminify.group.remove')
            ,handler: this.removeGroup
        });
        this.addContextMenuItem(m);
    }
    
    ,createGroup: function(btn,e) {

        var createGroup = MODx.load({
            xtype: 'modxminify-window-group'
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        createGroup.show(e.target);
    }

    ,updateGroup: function(btn,e,isUpdate) {
        if (!this.menu.record || !this.menu.record.id) return false;

        var updateGroup = MODx.load({
            xtype: 'modxminify-window-group'
            ,title: _('modxminify.group.update')
            ,action: 'mgr/group/update'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        updateGroup.fp.getForm().reset();
        updateGroup.fp.getForm().setValues(this.menu.record);
        updateGroup.show(e.target);
    }
    
    ,removeGroup: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('modxminify.group.remove')
            ,text: _('modxminify.group.remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/group/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }

    ,search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    
});
Ext.reg('modxminify-grid-groups',modxMinify.grid.Groups);

modxMinify.window.Group = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('modxminify.group.create')
        ,closeAction: 'close'
        ,url: modxMinify.config.connectorUrl
        ,action: 'mgr/group/create'
        ,fields: [{
            xtype: 'textfield'
            ,name: 'id'
            ,hidden: true
        },{
            xtype: 'textfield'
            ,fieldLabel: _('modxminify.group.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('modxminify.group.description')
            ,name: 'description'
            ,anchor: '100%'
        }]
    });
    modxMinify.window.Group.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.window.Group,MODx.Window);
Ext.reg('modxminify-window-group',modxMinify.window.Group);

