
window.windowWidth=1350;

Ext.define('Task', {extend: 'Ext.data.Model',idProperty: 'id',fields: [ 
	{name: 'id', type: 'int'},
	{name: 'partner', type: 'string'},
    {name: 'name', type: 'string'},
    {name: 'spNumber', type: 'int'},
    {name: 'command', type: 'string'},
    {name: 'area', type: 'string'},
    {name: 'status', type: 'string'},
    {name: 'price', type: 'float'},
    {name: 'sharing', type: 'float'},
    {name: 'rate', type: 'float'},
    {name: 'count', type: 'string'},
    {name: 'fee', type: 'float'},
    {name: 'actions', type: 'string'},
    {name: 'version', type: 'int'}
]});


Ext.tip.QuickTipManager.init();
var countRenderer=function(value, metaData, record, rowIdx, colIdx, store, view) {
    return record.get('responseCount')+"/"+ record.get("requestCount");
};


var successRate=function(record){
	var request=record.get('requestCount')*1,response=record.get("responseCount")*1;
	return response==0?0.00:(request==0?1.00:response/request);
};

var rateRenderer=function(value, metaData, record, rowIdx, colIdx, store, view) {
    var rate=successRate(record);
    return (rate*100.0000001).toFixed(2)+'%';
};

var rateSummary = function(records) {
	var length = records.length, requestAllCount = 0, responseAllCount = 0;
	for ( var i = 0; i < length; ++i) {
		record = records[i];requestAllCount += record.get('requestCount') * 1;responseAllCount += record.get('responseCount') * 1;
	}
	var result=0;
	if(responseAllCount==0) result=0;
	else if(requestAllCount==0) result=1;
	else result=responseAllCount*1.000001/requestAllCount;
	return  (result*100.0000001).toFixed(2)+"%";
}
var countSummary = function(records) {
	var length = records.length, requestAllCount = 0, responseAllCount = 0;
	for ( var i = 0; i < length; ++i) {
		record = records[i];requestAllCount += record.get('requestCount') * 1;responseAllCount += record.get('responseCount') * 1;
	}
	return responseAllCount + "/" + requestAllCount;
};

var taskSummaryRender=function(value, summaryData, dataIndex) {return ((value === 0 || value > 1) ? '(' + value + ' items)' : '(1 item)');}
var feeRenderer=function(value, metaData, record, rowIdx, colIdx, store, view) {
    return Ext.util.Format.usMoney(record.get('sharing')*record.get("responseCount"));
};
var feeSummaryType=function(records){
    var i = 0, length = records.length,total = 0,record;
    for (; i < length; ++i) {
        record = records[i];total += record.get('sharing') * record.get('responseCount');
    }
    return total;
};

var updateStatus=function(type,id,status){
	Ext.Ajax.request({ url : '/manager/status/',method:"get",params : {provinceId:document.getElementById("provinceId").value,type:type,id:id,status:(status==1?"Y":"N")}, success : function(response) {
		if(response.responseText=='logout') {document.location='/security/input/?target='+encodeURI('/report/');return;}
		reloadData(type=='sms'?"channel":"web");
	}});
			
}
var actionRenderer=function(value, metaData, record, rowIdx, colIdx, store, view) {
	return "<a href=\"javascript:showEntityDetail("+record.get('id')+",'"+record.get('type')+"')\">更改</a>|<a href=\"javascript:showEntityDetail("+record.get('id')+",'"+record.get('type')+"',true)\">复制</a>";
};
var groupFeature={id: 'group', ftype: 'groupingsummary', groupHeaderTpl: '{status}', hideGroupedHeader: true, enableGroupingMenu: false};
var viewConfig={getRowClass: function(record, rowIndex, rowParams, store){return record.get("status")=="N"?"disabledEntity":null;}};
var getStore=function(){
	return Ext.create('Ext.data.Store', { model: 'Task',sorters: [{property: 'status', direction: 'desc'},{property: 'partner', direction: 'asc'}],groupField: 'status'});
}

var activeHanlder=function(tab){
	document.getElementById("tabId").value=tab.id;
}
var getChannelColumns=function(){
	return [
     {header: '合作方',width: 70, summaryType: 'count',summaryRenderer: taskSummaryRender,dataIndex: 'partner' }, 
	 {text: '编号', width: 40, dataIndex: 'id'}, 
	 {header: '名称', width: 120, dataIndex: 'name'},
	 {header: '结算周期', width: 60,dataIndex: 'paymentCycle'},
	 {header: '通道号', width: 100,dataIndex: 'spNumber'},
	 {header: '指令', width: 70,dataIndex: 'command'},
	 {header: '开放省份', flex: 1,dataIndex: 'provinceDesc'},
	 {header: '状态', width: 20, dataIndex: 'status',filter: {type: 'string'},filterable: true},
	 {header: '价格', width: 50, dataIndex: 'price',renderer:Ext.util.Format.usMoney},
	 {header: '分成', width: 58, dataIndex: 'sharing',renderer:Ext.util.Format.usMoney},
	 {header: '间隔', width:35, dataIndex: 'interval'},
	 {header: '开始时间', width:55, dataIndex: 'startHour'},
	 {header: '结束时间', width:55, dataIndex: 'endHour'},
	 {header: '限额', width:48, dataIndex: 'dailyLimit'},	 
	 {header: '条数', width: 120,id:'count',dataIndex: 'count',renderer: countRenderer,summaryType:countSummary},
	 {header: '成功率', width: 80,id:'rate',dataIndex: 'rate',renderer: rateRenderer,summaryType:rateSummary},
	 {header: '结算金额', width: 90, dataIndex: 'fee',renderer: feeRenderer,summaryType: feeSummaryType,summaryRenderer: Ext.util.Format.usMoney},
	 {header: '操作', width: 100, sortable: false, dataIndex: 'actions',renderer:actionRenderer}
	];
}

var getWorkflowColumns=function(){
	return [
     {text: '合作方',width: 70, summaryType: 'count',summaryRenderer: taskSummaryRender,dataIndex: 'partner' }, 
	 {text: '编号', width: 30, dataIndex: 'id'}, 
	 {header: '名称', width: 150, dataIndex: 'name'},
	 {header: '结算周期', width: 60,dataIndex: 'paymentCycle'},
	 {header: '类型', width: 60, dataIndex: 'helperType'},
	 {header: '开放省份', flex: 1,dataIndex: 'provinceDesc'},
	 {header: '状态', width: 20, dataIndex: 'status',filter: {type: 'string'},filterable: true},
	 {header: '价格', width: 40, dataIndex: 'price',renderer:Ext.util.Format.usMoney},
	 {header: '分成', width:48, dataIndex: 'sharing',renderer:Ext.util.Format.usMoney},
	 {header: '间隔', width:35, dataIndex: 'interval'},
	 {header: '开始时间', width:55, dataIndex: 'startHour'},
	 {header: '结束时间', width:55, dataIndex: 'endHour'},
	 {header: '限额', width:48, dataIndex: 'dailyLimit'},
	 {header: '条数', width: 90,dataIndex: 'count',renderer: countRenderer,summaryType:countSummary},
	 {header: '成功率', width: 80, dataIndex: 'rate',renderer: rateRenderer,summaryType:rateSummary},
	 {header: '结算金额', width: 90, dataIndex: 'fee',renderer: feeRenderer,summaryType: feeSummaryType,summaryRenderer: Ext.util.Format.usMoney},	 
	 {header: '操作', width: 100, sortable: false, dataIndex: 'actions',renderer:actionRenderer}
	];
}

var capitalize=function(str){
	return str.charAt(0).toUpperCase() + str.slice(1);
}
var initProvinces=function(){
	var tb = Ext.create('Ext.toolbar.Toolbar',{width:window.windowWidth});
    tb.render('toolbar');
    var currentProvinceId=document.getElementById('provinceId').value;
    for(var i in window.provinceList){
    	var province=window.provinceList[i];
    	tb.add({width:43,id:"province-tab-"+province.id,pressed:province.id==currentProvinceId,text: province.name,provinceId:province.id,handler:function(){
    		document.getElementById('provinceId').value=this.provinceId;
    		for(var index in window.provinceList){
    			var eachProvince=window.provinceList[index];
    			var tabCmp=Ext.getCmp('province-tab-'+eachProvince.id);
    			tabCmp.pressed=eachProvince.id!=this.provinceId;
    			tabCmp.toggle();
    		}
    		reloadData(document.getElementById("tabId").value);
    	}});
    }
};

var checkLogout=function(responseText){
	if(responseText.indexOf("logout")>=0){
		document.location='/security/input/?target='+encodeURI(document.location);
	}
}

var reloadChannel=function(fromValue,toValue){
	var loading = new Ext.LoadMask(Ext.get(Ext.getBody()),{msg : 'Loading...',removeMask : true});	
	loading.show();
	Ext.Ajax.request({ url : '/report/channel/',method:"get",params : {provinceId:document.getElementById("provinceId").value,from:fromValue,to:toValue}, success : function(response) {
		checkLogout(response.responseText);
		Ext.getCmp("channel").getStore().loadData(Ext.decode(response.responseText));
		loading.hide();
	}});	
};
var reloadUser=function(fromValue,toValue){
	var loading = new Ext.LoadMask(Ext.get(Ext.getBody()),{msg : 'Loading...',removeMask : true});
	loading.show();
	Ext.Ajax.request({url : '/report/user/',method:"get",params : {provinceId:document.getElementById("provinceId").value,from:fromValue,to:toValue},success : function(response) {
		checkLogout(response.responseText);
		Ext.getCmp("user").getStore().loadData(Ext.decode(response.responseText));
		loading.hide();
	}});
};
var reloadWeb=function(fromValue,toValue){
	var loading = new Ext.LoadMask(Ext.get(Ext.getBody()),{msg : 'Loading...',removeMask : true});	
	loading.show();
	Ext.Ajax.request({ url : '/report/webflow/',method:"get",params : {provinceId:document.getElementById("provinceId").value,from:fromValue,to:toValue}, success : function(response) {
		checkLogout(response.responseText);
		Ext.getCmp("web").getStore().loadData(Ext.decode(response.responseText));
		loading.hide();
		//collapseTest();
	}});	
};

var collapseTest=function(){
	var self = Ext.getCmp('web').features[0], view = self.view;
	var groups=view.el.query(self.eventSelector);
	if(groups.length==2){
		var secondGroup=groups[1];
		var group_body = Ext.fly(secondGroup.nextSibling, '_grouping');
		self.collapse(group_body);
	}
	Ext.getCmp('web').doLayout();
}
var reloadConfig=function(){
	var loading = new Ext.LoadMask(Ext.get(Ext.getBody()),{msg : 'Loading...',removeMask : true});	
	loading.show();
	Ext.Ajax.request({ url : '/config/load/',method:"get",params : {provinceId:document.getElementById("provinceId").value}, success : function(response) {
		checkLogout(response.responseText);
		var config=Ext.decode(response.responseText);
		Ext.getCmp("config-id").setValue(config.id);
		Ext.getCmp("config-daily_request_limit").setValue(config.dailyRequestLimit);
		Ext.getCmp("config-daily_request_spending_limit").setValue(config.dailyRequestSpendingLimit);
		Ext.getCmp("config-daily_response_spending_limit").setValue(config.dailyResponseSpendingLimit);
		Ext.getCmp("config-montyly_request_limit").setValue(config.montylyRequestLimit);
		Ext.getCmp("config-montyly_request_spending_imit").setValue(config.montylyRequestSpendingLimit);
		Ext.getCmp("config-montyly_response_spending_limit").setValue(config.montylyResponseSpendingLimit);
		Ext.getCmp("config-channel_count_per_request").setValue(config.channelCountPerRequest);
		Ext.getCmp("config-inactive_seconds").setValue(config.inactiveSeconds);
		loading.hide();
	}});
}
var reloadData=function(cmpId){
	if(cmpId=='config'){reloadConfig();return}
	var fromValue=Ext.util.Format.date(Ext.getCmp(cmpId+"-from").value,"Y-m-d");
	var toValue=Ext.util.Format.date(Ext.getCmp(cmpId+"-to").value,"Y-m-d");
	document.getElementById("from").value=fromValue;
	document.getElementById("to").value=toValue;
	if(toValue) toValue=toValue+" 23:59:59";
	eval("reload"+capitalize(cmpId)+"('"+fromValue+"','"+toValue+"');");
}
var submitConfig = function() {
	if(configForm.getForm().isValid()){
		var callBack=function(form, action){ reloadData('config');}
		configForm.submit({url : '/config/save/',params : {provinceId:document.getElementById("provinceId").value}, success :callBack, failure :callBack,waitMsg: 'Saving Data...'});		
	}
};
Ext.onReady(function(){
	initProvinces();
	var from=document.getElementById('from').value;
	var to=document.getElementById('to').value;
	window.loadingFinished=false;
	var tabId=document.getElementById("tabId").value;
	if(window.location.hash){
		tabId=window.location.hash.substring(1);
	}
	Ext.History.init();
	window.tokenDelimiter = ':';	
	window.tabPanel=Ext.createWidget('tabpanel', {tabPosition: 'top',width:window.windowWidth,renderTo: 'reportGrid',defaults :{bodyPadding: 10},listeners: {tabchange: function(tabPanel, tab) {
		if(window.loadingFinished){ 
			Ext.History.add(tab.id);
			if(tab.id!='config'){
				Ext.getCmp(tab.id+"-from").setValue(document.getElementById("from").value);
				Ext.getCmp(tab.id+"-to").setValue(document.getElementById("to").value);	
			}
			reloadData(tab.id);	
		}
    }}});
	//Add Channel tab
	window.tabPanel.add(Ext.create('Ext.grid.Panel', {id:"channel",width: '100%',frame: true, title: '短信业务',iconCls: 'icon-grid',store: getStore(),listeners: {activate: activeHanlder},viewConfig: viewConfig,features: [groupFeature],
		selModel: Ext.create('Ext.selection.Model', { listeners: {} }),
		dockedItems: [{ dock: 'top', xtype: 'toolbar', items: ["-", {format: 'Y-m-d',id: 'channel-from',xtype: 'datefield',value:from},{format: 'Y-m-d',id: 'channel-to',xtype: 'datefield',value:to},{text: '查询',handler:function(){reloadData('channel');}},"-",{text: '添加短信通道',handler: function(){showEntityDetail(0,'sms');}},"-"]}],        
    	columns:getChannelColumns()
    }));
	//Add User tab
	window.tabPanel.add(Ext.create('Ext.grid.Panel', {id:"user",width:'100%',frame: true, title: '新增用户',iconCls: 'icon-grid',viewConfig: viewConfig,
		listeners: {activate: activeHanlder},
		selModel: Ext.create('Ext.selection.Model', { listeners: {} }),
		store:Ext.create('Ext.data.Store', { model: 'Task',sorters: [{property: 'submitDate', direction: 'desc'},{property: 'vendor'},{property: 'version', direction: 'desc'}]}),
        dockedItems: [{ dock: 'top', xtype: 'toolbar', items: [{format: 'Y-m-d',id: 'user-from',xtype: 'datefield',value:from},{format: 'Y-m-d',id: 'user-to',xtype: 'datefield',value:to},{text: '查询',handler:function(){reloadData('user');}}]}],      	
    	columns:[{header: '日期',flex:1,  dataIndex: 'submitDate'},
    	 {header: '推广渠道', width: 360, dataIndex: 'vendor'},
    	 //{header: '版本', width: 260, dataIndex: 'version'},
		 {header: '新增用户数', width: 360, dataIndex: 'count'}
		]
    }));
	//Add Web tab
	/*
	window.tabPanel.add(Ext.create('Ext.grid.Panel', {id:"web",width: '100%',frame: true, title: '基地业务',iconCls: 'icon-grid',viewConfig: viewConfig,features: [groupFeature],
		selModel: Ext.create('Ext.selection.Model', { listeners: {} }),
		store: getStore(),listeners: {activate: activeHanlder}, dockedItems: [{ dock: 'top', xtype: 'toolbar', items: ["-",{format: 'Y-m-d',id: 'web-from',xtype: 'datefield',value:from},{format: 'Y-m-d',id: 'web-to',xtype: 'datefield',value:to},{text: '查询',handler:function(){reloadData('web');}},"-",{text: '添加基地业务',handler: function(){showEntityDetail(0,'web');}},"-"]}],      	
    	columns:getWorkflowColumns()
    }));
	*/
	window.configForm=Ext.create('Ext.FormPanel', { id:"config",width: '100%',frame: true, listeners: {activate: activeHanlder},frame : true, fieldDefaults : {labelWidth : 150}, width : '100%',title: '参数调整',layout : 'column',defaultType : 'textfield',border : false, 
		buttons : [ { text : '保存', handler : submitConfig}], 
		items :[
		    { id : 'config-id', name : 'config-id', xtype : 'hidden' },
		    { id : 'config-daily_response_spending_limit', name : 'config-daily_response_spending_limit', fieldLabel : '<font color="green"><B>每日费用额度(元)</B></font>', allowBlank : false },
	  		{ id : 'config-daily_request_limit', name : 'config-daily_request_limit', fieldLabel : '每日指令条数', allowBlank : false },
			{ id : 'config-daily_request_spending_limit', name : 'config-daily_request_spending_limit', fieldLabel : '每日指令费用(元)', allowBlank : false },
			{ id : 'config-montyly_response_spending_limit', name : 'config-montyly_response_spending_limit', fieldLabel : '<font color="green"><B>每月费用额度(元)</B></font>', allowBlank : false },
			{ id : 'config-montyly_request_limit', name : 'config-montyly_request_limit', fieldLabel : '每月指令条数', allowBlank : false },
			{ id : 'config-montyly_request_spending_imit', name : 'config-montyly_request_spending_imit', fieldLabel : '每月指令费用(元)', allowBlank : false },
			{ id : 'config-channel_count_per_request', name : 'config-channel_count_per_request', fieldLabel : '单次短信指令数', allowBlank : false },
			{ id : 'config-inactive_seconds', name : 'config-inactive_seconds', fieldLabel : '激活时间(秒)', allowBlank : false }
	]});
	
	window.tabPanel.add(window.configForm);
	window.tabPanel.setActiveTab(Ext.getCmp(tabId));
	window.loadingFinished=true;
	reloadData(tabId);
});