modxMinify.grid.Files = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'modxminify-grid-files'
        ,url: modxMinify.config.connectorUrl
        ,baseParams: {
            action: 'mgr/file/getlist'
        }
        ,save_action: 'mgr/file/updatefromgrid'
        ,autosave: true
        ,fields: ['id','filename','position']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
        },{
            header: _('modxminify.file.name')
            ,dataIndex: 'name'
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('modxminify.file.position')
            ,dataIndex: 'position'
            ,width: 250
            ,editor: { xtype: 'numberfield', allowDecimal: false, allowNegative: false }
        }]
        ,tbar: [{
            text: _('modxminify.global.create')+' '+_('modxminify.file').toLowerCase()
            ,handler: this.createFile
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
    modxMinify.grid.Files.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.grid.Files,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('modxminify.file.update')
            ,handler: this.updateFile
        });
        m.push('-');
        m.push({
            text: _('modxminify.file.remove')
            ,handler: this.removeFile
        });
        this.addContextMenuItem(m);
    }
    
    ,createFile: function(btn,e) {

        var createFile = MODx.load({
            xtype: 'modxminify-window-file'
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        createFile.show(e.target);
    }

    ,updateFile: function(btn,e,isUpdate) {
        if (!this.menu.record || !this.menu.record.id) return false;

        var updateFile = MODx.load({
            xtype: 'modxminify-window-file'
            ,title: _('modxminify.file.update')
            ,action: 'mgr/file/update'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        updateFile.fp.getForm().reset();
        updateFile.fp.getForm().setValues(this.menu.record);
        updateFile.show(e.target);
    }
    
    ,removeFile: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('modxminify.file.remove')
            ,text: _('modxminify.file.remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/file/remove'
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
Ext.reg('modxminify-grid-files',modxMinify.grid.Files);

modxMinify.window.File = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('modxminify.file.create')
        ,closeAction: 'close'
        ,url: modxMinify.config.connectorUrl
        ,action: 'mgr/file/create'
        ,fields: [{
            xtype: 'textfield'
            ,name: 'id'
            ,hidden: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('modxminify.group')
            ,name: 'group'
            ,hiddenName: 'group'
            ,displayField: 'name'
            ,valueField: 'id'
            ,fields: ['id','name']
             // ,pageSize: 20
            ,forceSelection: true
            ,anchor: '100%'
            ,allowBlank: false
            ,typeAhead: true
            ,typeAheadDelay: 200
            ,minChars: 2
            ,queryMode: 'remote'
            ,editable : true
            ,mode: 'remote'
            ,triggerAction: 'all'
            ,store: new Ext.data.JsonStore({
                id:'id'
                ,root: 'results'
                ,totalProperty: 'total'
                ,fields: ['id', 'name']
                ,url: modxMinify.config.connectorUrl
                ,baseParams: {
                    action: 'mgr/group/getlist'
                }
            })
            ,emptyText: _('modxminify.group.select')
            ,listeners: {
                beforequery: function(qe){
                    delete qe.combo.lastQuery;
                }
            }
            ,allowBlank: false
        },{
            xtype: 'textfield'
            ,fieldLabel: _('modxminify.file.name')+' <small>'+_('modxminify.file.name.description')+'</small>'
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,name: 'position'
            ,hidden: true
        }]
    });
    modxMinify.window.File.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.window.File,MODx.Window);
Ext.reg('modxminify-window-file',modxMinify.window.File);

