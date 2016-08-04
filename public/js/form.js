var submitCallBack= function(form, action) {
	win.close();
	reloadData(window.businessType=='sms'?"channel":"web");
};
var submitRequest = function() {
	if(fp.getForm().isValid()){
		var areaParameters=[];
		Ext.Array.each(Ext.getCmp("areaTree").getView().getChecked(),function(rec) {
			areaParameters[(window.businessType=='sms'?'':"webflow-")+'field-blockArea-'+rec.get('id')]=rec.get('id');
		});
		var url=window.businessType=='sms'?'/channel/save/':'/webflow/save/';
		fp.submit({url : url,params : areaParameters, success :submitCallBack, failure :submitCallBack,waitMsg: 'Saving Data...'});		
	}
};


var getBasicWebflowFields=function(){ 
	return [ 
	   { id : 'webflow-field-id', xtype : 'hidden',name : 'webflow-field-id'}, 
	   { id : 'webflow-field-name', name : 'webflow-field-name', fieldLabel : '名称', allowBlank : false }, 
	   { id : 'webflow-field-helperType',name : 'webflow-field-helperType',fieldLabel : '类型', allowBlank : false},
	   { id : 'webflow-field-userDailyLimit', name : 'webflow-field-userDailyLimit',   fieldLabel : '用户日限', allowBlank : false }, 
	   { id : 'webflow-field-userMonthlyLimit', name : 'webflow-field-userMonthlyLimit',  fieldLabel : '用户月限', allowBlank : false },	
	   { id : 'webflow-field-dailyLimit',  fieldLabel : '渠道日限', allowBlank : false,name : 'webflow-field-dailyLimit',value:'100'},
	   { id : 'webflow-field-monthlyLimit', fieldLabel : '渠道月限', allowBlank : false,name : 'webflow-field-monthlyLimit',value:10000000},	   
	   { id : 'webflow-field-userInterval', fieldLabel : '用户间隔', allowBlank : false,name : 'webflow-field-userInterval',value:432000},	   
	   { id : 'webflow-field-interval', fieldLabel : '渠道间隔', allowBlank : false,name : 'webflow-field-interval',value:30},
	   { id : 'webflow-field-option1', fieldLabel : '可选(1)',name : 'webflow-field-option1'},
	   { id : 'webflow-field-option2', fieldLabel : '可选(2)',name : 'webflow-field-option2'},
	   { id : 'webflow-field-option3', fieldLabel : '可选(3)',name : 'webflow-field-option3'},	   
	   { id : 'webflow-field-version', fieldLabel : '适用版本', allowBlank : false ,name : 'webflow-field-version',value:4},
	   { id : 'webflow-field-feeCode', fieldLabel : '业务代码',name : 'webflow-field-feeCode'}, 
	   { id : 'webflow-field-startHour', fieldLabel : '开始时间',name : 'webflow-field-startHour'},
	   { id : 'webflow-field-endHour', fieldLabel : '截止时间',name : 'webflow-field-endHour'},	 
	   { id : 'webflow-field-partner', name : 'webflow-field-partner', fieldLabel : '合作商', allowBlank : false }, 
	   { id : 'webflow-field-price', name : 'webflow-field-price', fieldLabel : '单价', allowBlank : false }, 
	   { id : 'webflow-field-sharing', name : 'webflow-field-sharing', fieldLabel : '分成', allowBlank : false }, 
	   { id : 'webflow-field-pvRate', name : 'webflow-field-pvRate', fieldLabel : 'PV', value :0.88 },
	   { id : 'webflow-field-uvRate', name : 'webflow-field-uvRate', fieldLabel : 'UV', value :0.88 },
	   { id : 'webflow-field-mockInterval', name : 'webflow-field-mockInterval', fieldLabel : '模拟间隔', value :100000 },
	   { id : 'webflow-field-paymentCycle', name : 'webflow-field-paymentCycle', fieldLabel : '结算周期', allowBlank : false }, 
	   { id : 'webflow-field-preContent', name : 'webflow-field-preContent', fieldLabel : '前置内容', xtype : 'textarea',width:840,height:30},
	   { id : 'webflow-field-content', name : 'webflow-field-content', fieldLabel : '内容', xtype : 'textarea',width:840,height:30},
	   { id : 'webflow-field-test', name : 'webflow-field-test', fieldLabel : '本地测试', xtype : 'checkbox', inputValue : "Y",labelWidth :100,labelStyle : "text-align:left;width:60;" },
	   { id : 'webflow-field-remoteReport', name : 'webflow-field-remoteReport', fieldLabel : '远程测试',labelStyle : "text-align:left;width:60;color:red", xtype : 'checkbox', inputValue : "Y",labelWidth :100 },
	   { id : 'webflow-field-status', name : 'webflow-field-status', fieldLabel : '开通',labelStyle : "text-align:right;width:50;", xtype : 'checkbox', inputValue : "Y",labelWidth :50 },
	   { id : 'webflow-field-machineRule', xtype : 'hidden',name : 'webflow-field-machineRule'},
	   { id : 'webflow-field-searchMsg', xtype : 'hidden',name : 'webflow-field-searchMsg'},
	   { id : 'webflow-field-id', xtype : 'hidden',name : 'webflow-field-id'},
	   { id : 'webflow-field-comments', xtype : 'hidden',name : 'webflow-field-comments'},
	   { id : 'webflow-field-startDate', xtype : 'hidden',name : 'webflow-field-startDate'}
	   ];
};

var setWebflowFiledValue=function(webflow){
	if(!window.copyEntity){
		Ext.getCmp('webflow-field-id').setValue(webflow.id);
		Ext.getCmp('webflow-field-name').setValue(webflow.name);		
	}
	Ext.getCmp('webflow-field-paymentCycle').setValue(webflow.paymentCycle);
	Ext.getCmp('webflow-field-helperType').setValue(webflow.helperType);
	Ext.getCmp('webflow-field-userDailyLimit').setValue(webflow.userDailyLimit);
	Ext.getCmp('webflow-field-userMonthlyLimit').setValue(webflow.userMonthlyLimit);
	Ext.getCmp('webflow-field-partner').setValue(webflow.partner);
	Ext.getCmp('webflow-field-price').setValue(webflow.price);
	Ext.getCmp('webflow-field-sharing').setValue(webflow.sharing);
	Ext.getCmp('webflow-field-status').setValue(webflow.status=="Y");
	Ext.getCmp('webflow-field-remoteReport').setValue(webflow.remoteReport=="Y");
	Ext.getCmp('webflow-field-pvRate').setValue(webflow.pvRate);
	Ext.getCmp('webflow-field-uvRate').setValue(webflow.uvRate);
	Ext.getCmp('webflow-field-mockInterval').setValue(webflow.mockInterval);
	Ext.getCmp('webflow-field-feeCode').setValue(webflow.feeCode);
	Ext.getCmp('webflow-field-machineRule').setValue(webflow.machineRule);
	Ext.getCmp('webflow-field-searchMsg').setValue(webflow.searchMsg);
	Ext.getCmp('webflow-field-option1').setValue(webflow.option1);
	Ext.getCmp('webflow-field-option2').setValue(webflow.option2);
	Ext.getCmp('webflow-field-option3').setValue(webflow.option3);
	Ext.getCmp('webflow-field-dailyLimit').setValue(webflow.dailyLimit);
	Ext.getCmp('webflow-field-monthlyLimit').setValue(webflow.monthlyLimit);
	Ext.getCmp('webflow-field-interval').setValue(webflow.interval);
	Ext.getCmp('webflow-field-userInterval').setValue(webflow.userInterval);
	Ext.getCmp('webflow-field-version').setValue(webflow.version);
	Ext.getCmp('webflow-field-startHour').setValue(webflow.startHour);
	Ext.getCmp('webflow-field-endHour').setValue(webflow.endHour);
	Ext.getCmp('webflow-field-comments').setValue(webflow.comments);
	Ext.getCmp('webflow-field-startDate').setValue(webflow.startDate);
	Ext.getCmp('webflow-field-content').setValue(webflow.content);
	Ext.getCmp('webflow-field-preContent').setValue(webflow.preContent);
	var rule=Ext.decode(webflow.areaRule);
	for(var i in rule.ap){
		var comp=Ext.getCmp('webflow-field-allowProvince-'+rule.ap[i]);
		if(comp) comp.setValue(true);
	}
};


var getBasicChannelFields=function(){ 
	return [ 
	   { id : 'field-name', name : 'field-name', fieldLabel : '名称', allowBlank : false }, 
	   { id : 'field-spNumber', name : 'field-spNumber', fieldLabel : '通道', allowBlank : false }, 
	   { id : 'field-command', name : 'field-command', fieldLabel : '指令', allowBlank : false }, 
	   { id : 'field-price', name : 'field-price', fieldLabel : '单价', allowBlank : false }, 
	   { id : 'field-sharing', name : 'field-sharing', fieldLabel : '分成', allowBlank : false }, 
	   { id : 'field-userDailyLimit', name : 'field-userDailyLimit',   fieldLabel : '用户日限', allowBlank : false,value:3 }, 
	   { id : 'field-userMonthlyLimit', name : 'field-userMonthlyLimit',  fieldLabel : '用户月限', allowBlank : false,value:8 },
	   { id : 'field-dailyLimit', fieldLabel : '通道日限', allowBlank : false,name : 'field-dailyLimit',value:100000}, 
	   { id : 'field-monthlyLimit', fieldLabel : '通道月限', allowBlank : false,name : 'field-monthlyLimit',value:10000000},
	   { id : 'field-userInterval', fieldLabel : '用户间隔', allowBlank : false,value:7200,name : 'field-userInterval'},
	   { id : 'field-interval', fieldLabel : '通道间隔', allowBlank : false,value:2,name : 'field-interval',value:0},
	   { id : 'field-startHour', fieldLabel : '开始时间',name : 'field-startHour',allowBlank : false,value:8},
	   { id : 'field-endHour', fieldLabel : '截止时间',name : 'field-endHour',allowBlank : false,value:23},
	   { id : 'field-partner', name : 'field-partner', fieldLabel : '合作商', allowBlank : false}, 
	   { id : 'field-paymentCycle', name : 'field-paymentCycle', fieldLabel : '结算周期', allowBlank : false }, 
	   { id : 'field-requestPerTime', name : 'field-requestPerTime', fieldLabel : '单次条数', allowBlank : false,value:1 }, 
	   { id : 'field-test', name : 'field-test', fieldLabel : '测试', xtype : 'checkbox', inputValue : "Y",labelWidth :40 },
	   { id : 'field-status', name : 'field-status', fieldLabel : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开通', xtype : 'checkbox', inputValue : "Y" ,labelWidth :80},
	   { id : 'field-id', xtype : 'hidden',name : 'field-id'}, 
	   { id : 'field-type', xtype : 'hidden',name : 'field-type'},
	   { id : 'field-version', xtype : 'hidden',name : 'field-version'},
	   { id : 'field-comments', xtype : 'hidden',name : 'field-comments'},
	   { id : 'field-startDate', xtype : 'hidden',name : 'field-startDate'}	   
	   ];
};

var setChannelFiledValue=function(channel){
	if(!window.copyEntity){
		Ext.getCmp('field-id').setValue(channel.id);
		Ext.getCmp('field-name').setValue(channel.name);
		Ext.getCmp('field-spNumber').setValue(channel.spNumber);
		Ext.getCmp('field-command').setValue(channel.command);
	}
	Ext.getCmp('field-paymentCycle').setValue(channel.paymentCycle);
	Ext.getCmp('field-requestPerTime').setValue(channel.requestPerTime);
	Ext.getCmp('field-type').setValue(channel.type);
	Ext.getCmp('field-dailyLimit').setValue(channel.dailyLimit);
	Ext.getCmp('field-monthlyLimit').setValue(channel.monthlyLimit);
	Ext.getCmp('field-interval').setValue(channel.interval);
	Ext.getCmp('field-userInterval').setValue(channel.userInterval);
	Ext.getCmp('field-version').setValue(channel.version);
	Ext.getCmp('field-startHour').setValue(channel.startHour);
	Ext.getCmp('field-endHour').setValue(channel.endHour);
	Ext.getCmp('field-startDate').setValue(channel.startDate);
	Ext.getCmp('field-type').setValue(channel.type);
	Ext.getCmp('field-price').setValue(channel.price);
	Ext.getCmp('field-sharing').setValue(channel.sharing);
	Ext.getCmp('field-userDailyLimit').setValue(channel.userDailyLimit);
	Ext.getCmp('field-userMonthlyLimit').setValue(channel.userMonthlyLimit);
	Ext.getCmp('field-partner').setValue(channel.partner);
	Ext.getCmp('field-status').setValue(channel.status=="Y");
	var rule=Ext.decode(channel.areaRule);
	for(var i in rule.ap){
		var comp=Ext.getCmp('field-allowProvince-'+rule.ap[i]);
		if(comp) comp.setValue(true);
	}
};

var show=function(obj){
	var result="";
	for(var i in obj){
		result+=i+":"+obj[i]+"\n";
	}
	alert(result);
};

var initialProvinces=function(treestore,node,record,su){
	var item = Ext.getCmp('allowProvinces');
	var prefix=window.businessType=='sms'?"field-":"webflow-field-";
	for(var i in record){
		var province= record[i]['raw'];
		item.add({id : prefix+'allowProvince-' + province.value,
			boxLabel : province.text+"&nbsp;&nbsp;&nbsp;",
			name : prefix+'allowProvince-' + province.value,
			inputValue : province.value
		});
	}
	if(window.businessId){
		var url=(window.businessType=='sms'?"/channel":"/webflow")+'/load/?id='+window.businessId
		Ext.Ajax.request({ url :url,method:"get", success : function(response) {
			if(window.businessType=='sms') setChannelFiledValue(Ext.decode(response.responseText));
			else setWebflowFiledValue(Ext.decode(response.responseText));
			formLoading.hide();
		}});  		
	}else{
		formLoading.hide();
	}
};

var newTreePanel=function(){
	return Ext.create('Ext.tree.Panel', { id : "areaTree", store : Ext.create('Ext.data.TreeStore', {listeners:{'load':initialProvinces}, 
			proxy : { type : 'ajax', url : '/area/tree/?businessId='+businessId+"&businessType="+window.businessType } }), rootVisible : false, useArrows : true, frame : true,width : '100%', height : 290});
};

var getWindowItems=function(){
	return [ 
		    { xtype : 'container', layout : 'fit', margin : '0 0 10', items : {
		    	xtype : 'fieldset', flex : 1, title : '基本设置', defaultType : 'textfield', layout : 'column',defaults : {anchor : '100%',hideEmptyLabel : true},
		    		items :window.businessType=='sms'?getBasicChannelFields():getBasicWebflowFields()}}, 
		    { xtype : 'checkboxgroup',  layout : 'column',fieldLabel : '开通省份', cls : 'x-check-group-alt', id : "allowProvinces" },
		    { xtype : 'checkboxgroup', fieldLabel : '屏蔽地区', cls : 'x-check-group-alt',items: newTreePanel()}
	];	
};

var showEntityDetail = function(id,type,copyEntity) {
	window.businessId=id;
	window.businessType=type;
	window.copyEntity=copyEntity;
	window.fp = Ext.create('Ext.FormPanel', { border : false, height : "100%", buttons : [ { text : '保存', handler : submitRequest}], frame : true, fieldDefaults : {labelWidth : 55}, width : '100%',items : getWindowItems()});
	window.win = Ext.create('Ext.window.Window', { title : ((window.copyEntity||businessId==0)?'添加':"更改")+(type=='sms'?"短信业务":"基地业务"), constrain : true, autoScroll : true, layout : 'fit', width : '900', height : '600', minWidth : '800', minHeight : '500', layout : 'fit', plain : true});
	win.show();
	window.formLoading = new Ext.LoadMask(win,{msg : 'Loading...',removeMask : true});
	formLoading.show();
	win.add(fp);
};

var copyEntity=function(id,type){
	showEntityDetail(id,type,true);
};
