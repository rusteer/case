Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', '/static/extjs/examples/ux');
Ext.require(['Ext.form.*','Ext.tab.*','Ext.grid.*', 'Ext.data.*', 'Ext.tip.QuickTipManager']);
Ext.define('Task', {extend: 'Ext.data.Model',fields: [ 
	{name: 'id', type: 'int'}
]});

var refreshUser=function(){
	id=document.getElementById("provinceId").value;
	Ext.Ajax.request({url : '/vendor/statistics/',method:"get",params:{"provinceId":id},success : function(response) {
		if(response.responseText=='logout') {document.location='/vendor/input/';return;}
		Ext.getCmp("userGrid").getStore().loadData(Ext.decode(response.responseText));
	}});
};

Ext.onReady(function(){
	Ext.create('Ext.grid.Panel', {id:"userGrid",width: 400,frame: true, title: '用户统计',iconCls: 'icon-grid',renderTo:document.body,
		store:Ext.create('Ext.data.Store', { model: 'Task',sorters: [{property: 'submitDate', direction: 'desc'}]}),
    	columns:[{header: '日期',flex: 1  , sortable: true, dataIndex: 'submitDate'},
		 {header: '新增用户数', width: 160, sortable: true, dataIndex: 'count'}
		]
    });
	refreshUser();
});	
	

