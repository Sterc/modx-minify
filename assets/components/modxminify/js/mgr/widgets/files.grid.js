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
        ,fields: ['id','filename','group','group_name','last_modified']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,ddGroup: 'modxminifyItemDDGroup'
        ,enableDragDrop: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 40
        },{
            header: _('modxminify.file.name')
            ,dataIndex: 'filename'
            ,width: 240
        },{
            header: _('last_modified')
            ,dataIndex: 'last_modified'
            ,width: 180
        },{
            header: _('modxminify.group')
            ,dataIndex: 'group_name'
            ,width: 80
        }]
        ,tbar: [{
            text: _('modxminify.global.add')+' '+_('modxminify.file').toLowerCase()
            ,handler: this.createFile
            ,scope: this
            ,cls:'primary-button'
            ,id: 'btn-add-file'
            ,listeners: {
			    render: function(c) {
			    	// getting the total groups count via ajax 
			    	MODx.Ajax.request({
                        url: modxMinify.config.connectorUrl
                        ,params: {
                            action: 'mgr/group/getlist'
                        }
                        ,listeners: {
                            'success': {
                                fn: function(r) {
                                    var groupsCount = parseInt(r.total);
                                    if(!groupsCount) {
                                    	Ext.getCmp('btn-add-file').disable();
                                    	Ext.QuickTips.register({
								            target: c,
								            text: _('modxminify.file.nogroups'),
								            showDelay: 40,
								            trackMouse: false
								        });
                                    }

                                }
                             }
                         }
                    });
			    }
			}
        }]
        ,listeners: {
            'render': function(g) {
                var ddrow = new Ext.ux.dd.GridReorderDropTarget(g, {
                    copy: false
                    ,listeners: {
                        'beforerowmove': function(objThis, oldIndex, newIndex, records) {

                            Ext.getCmp('modxminify-grid-files').setDisabled(true);

                        }

                        ,'afterrowmove': function(objThis, oldIndex, newIndex, records) {

                            MODx.Ajax.request({
                                url: modxMinify.config.connectorUrl
                                ,params: {
                                    action: 'mgr/file/reorder'
                                    ,idItem: records.pop().id
                                    ,oldIndex: oldIndex
                                    ,newIndex: newIndex
                                }
                                ,listeners: {
                                    'success': {
                                        fn: function(r) {
                                            Ext.getCmp('modxminify-grid-files').setDisabled(false);
                                            Ext.getCmp('modxminify-grid-files').refresh();
                                        }
                                     }
                                 }
                            });

                        }

                        ,'beforerowcopy': function(objThis, oldIndex, newIndex, records) {
                        }

                        ,'afterrowcopy': function(objThis, oldIndex, newIndex, records) {
                        }
                    }
                });

                Ext.dd.ScrollManager.register(g.getView().getEditorParent());
            }
            ,beforedestroy: function(g) {
                Ext.dd.ScrollManager.unregister(g.getView().getEditorParent());
            }

        }
    });
    modxMinify.grid.Files.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.grid.Files,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('modxminify.global.update')+' '+_('modxminify.file').toLowerCase()
            ,handler: this.updateFile
        });
        m.push('-');
        m.push({
            text: _('modxminify.global.remove')+' '+_('modxminify.file').toLowerCase()
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
            ,title: _('modxminify.global.update')+' '+_('modxminify.file').toLowerCase()
            ,action: 'mgr/file/update'
            ,record: this.menu.record
            ,isUpdate: true
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
            title: _('modxminify.global.remove')+' '+_('modxminify.file').toLowerCase()
            ,text: _('modxminify.global.remove_confirm')+' '+_('modxminify.file').toLowerCase()
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
        title: _('modxminify.global.add')+' '+_('modxminify.file').toLowerCase()
        ,closeAction: 'close'
        ,width: 600
        ,url: modxMinify.config.connectorUrl
        ,action: 'mgr/file/createmultiple'
        ,fields: [{
            xtype: 'textfield'
            ,name: 'id'
            ,hidden: true
        },{
            xtype: 'label'
            ,text: _('modxminify.file.description')
            ,cls: 'desc-under'
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
            xtype: (config.isUpdate) ? 'textfield' : 'textarea'
            ,fieldLabel: _('modxminify.file.name')
            ,name: 'filename'
            ,anchor: '100%'
            ,height: (config.isUpdate) ? 'auto' : 200
        },{
            xtype: 'label'
            ,text: _('modxminify.file.name.description')
            ,cls: 'desc-under'
            ,hidden: (config.isUpdate) ? true : false
        }]
    });
    modxMinify.window.File.superclass.constructor.call(this,config);
};
Ext.extend(modxMinify.window.File,MODx.Window);
Ext.reg('modxminify-window-file',modxMinify.window.File);