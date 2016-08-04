var compare=function(a,b){
	if(a>b) return 1;
	if(a==b) return 0;
	if(a<b) return -1;
}
var showPartners=function(){
	window.partnerBusinesses=new Array();
	Ext.Array.sort(window.businesses,function(a,b) {
        var result=compare(b.status,a.status);
        if(result!=0) return result;
        return compare(a.name,b.name);
	});
	for(var i in window.businesses){
		var business=window.businesses[i];
		business.index=i;
		var partner=business.partner;
		if(!partner) continue;
		partner=partner.toUpperCase();
		var tempArray=partnerBusinesses[partner];
		if(!tempArray){
			tempArray=new Array();
			partnerBusinesses[partner]=tempArray;
		}
		tempArray.push(business);
	}
	var obj=document.getElementById('partnerSelect');
	var enalbedPartners=["石榴","中天","卖血养猪","上海潮信","彩梦科技","心动科技","杭州品书","葫芦","海阔龙腾","王子科技","北京中青"];
    for(var partner in window.partnerBusinesses){
        //if(partner && partner.indexOf("null")<0 && partner.indexOf("测试")<0 && partner.indexOf("test")<0)
    	//if(Ext.Array.contains(enalbedPartners,partner)){
    		obj.add(new Option(partner,partner));
    	//}
    }
    showBusiness(obj.value);
}

var showBusiness=function(partner){
	var channelSelect=document.getElementById('channelSelect');
	var webflowSelect=document.getElementById('webflowSelect');
	channelSelect.innerHTML="";
	webflowSelect.innerHTML="";
	var businesses=window.partnerBusinesses[partner];
	for(var i in businesses){
		var business=businesses[i];
		var name=business.name;
		if(business.status!="Y"){
			name="【"+name+"】";
		}
		if(business.type=='sms') channelSelect.add(new Option(name,business.index)); 
		else webflowSelect.add(new Option(name,business.index));
		
	}
	initChannelRequest();
	initWebflowRequest();
}

var initReportRequest=function(type){
	var divId=(type=="sms"?"channelDiv":"webflowDiv");
	document.getElementById(divId).innerHTML="Loading....";	
	var selectId=(type=="sms"?"channelSelect":"webflowSelect");
	var index=document.getElementById(selectId).value;
	if(index==""){
		document.getElementById(divId).innerHTML="无数据！";	
	}else{
		var business=window.businesses[index];
		getReportData(type=="sms"?'/checking/channel/':'/checking/webflow/',business.id);		
	}
}

var initChannelRequest=function(){
	initReportRequest('sms');
};

var initWebflowRequest=function(){
	initReportRequest('webflow');
};

var showReport=function(result){
	var jsonObj=Ext.decode(result);
	var countArray=jsonObj.counts;
	var business=jsonObj.business;
	var html="<table><thead><tr><th width=280>业务名称</th><th>价格</th><th>分成</th><th>结算日期</th><th>计费条数</th><th>结算金额</th><th>合作方结算条数</th><th>合作方结算金额</th><th>转化率</th></tr></thead>";
	html+="<tbody>";
	var index=0;
	var countStat=0;
	var checkingStat=0;
	var checkingAmountStat=0;
	for(var key in countArray){
		var responseCount=countArray[key].response*1;
		if(responseCount<1) continue;
		var checking=countArray[key].checking*1;
		var amount=business.sharing*responseCount;
		var rate=(checking/(amount+0.1)*100).toFixed(2)+"%";
		var checkingAmount=checking/business.sharing;
		checkingAmountStat+=checkingAmount;
		html+="<tr "+((index++)%2==0?"class='alt'":"")+">";
		html+="<td>"+business.name+"</td>";
		html+="<td>"+business.price+"</td>";
		html+="<td>"+business.sharing+"</td>";
		html+="<td style='background:green;color:white;border:1px solid white'>"+key+"</td>";
		html+="<td>"+responseCount+"</td>";
		html+="<td>"+amount.toFixed(2)+"</td>";
		html+="<td><a href='javascript:setAmount(\""+business.type+'",'+business.id+',"'+key+"\","+business.sharing+")'>"+checkingAmount.toFixed(0)+"</a></td>";
		html+="<td><a href='javascript:setChecking(\""+business.type+"\","+business.id+",\""+key+"\")'>"+checking.toFixed(2)+"</a></td>";
		html+="<td style='background:yellow;color:black;border:1px solid white'>"+rate+ "</td>";
		html+="</tr>";
		countStat+=(countArray[key].response*1);
		checkingStat+=countArray[key].checking*1;
	}
	var totoalAmount=business.sharing*countStat;
	var rate=(checkingStat/(totoalAmount+0.1)*100).toFixed(2)+"%";
	html+="<tfoot><tr>";
	html+="<th colspan=3 align=right>合计：</th>";
	html+="<th>"+index+"天</th>";
	html+="<th>"+countStat+"条</th>";
	html+="<th>"+totoalAmount.toFixed(2)+"元</th>";
	html+="<th>"+checkingAmountStat.toFixed(0)+"条</th>";
	html+="<th>"+checkingStat.toFixed(2)+"元</th>";
	html+="<th>"+rate+"</th>";
	html+="</tr></tfoot>";
	html+="</tbody>";
	html+="</table>";
	var divId=business.type=="sms"?"channelDiv":"webflowDiv";
	document.getElementById(divId).innerHTML=html;	
}


var updateChecking=function(businessType,businessId,date,amount){
	Ext.Ajax.request({ 
		url : "/checking/save/",
		method:"post",
		params : { id:businessId, type:businessType,date:date,amount:amount}, 
		success : function(response) {
			if(businessType=='sms') initChannelRequest();
			else initWebflowRequest();
		}
	});		
}
var setAmount=function(businessType,businessId,date,sharing){
	var amount=prompt("请输入结算条数:");
	if(amount*1!=amount) return;
	amount=amount*sharing;
	updateChecking(businessType,businessId,date,amount);
}
var setChecking=function(businessType,businessId,date){
	var amount=prompt("请输入金额:");
	if(amount*1!=amount) return;
	updateChecking(businessType,businessId,date,amount);
}

var getReportData=function(url,id){
	//document.getElementById("dataDiv").innerHTML="Loading....";	
	Ext.Ajax.request({ 
		url : url,
		method:"get",
		params : { from:document.getElementById("fromDate").value, to:document.getElementById("toDate").value,id:id}, 
		success : function(response) {
		showReport(response.responseText);
	}});
}

Ext.onReady(function(){
	showPartners();
	//showChannelData();
});