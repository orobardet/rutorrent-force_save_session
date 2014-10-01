plugin.loadMainCSS();
plugin.loadLang(true);

theWebUI.saveSession = function(){
	log(theUILang.forcesavesessionLogSaving);
	var AjaxReq = jQuery.ajax(
	{
		type: "GET",
		timeout: theWebUI.settings["webui.reqtimeout"],
			async : true,
			cache: false,
		url : "plugins/force_save_session/action.php",
		dataType : "json",
		cache: false,
		success : function(data)
		{
			if (data.status)
				noty(theUILang.forcesavesessionLogSaved + '(' + data.msg + ')', 'success');
			else
				noty(theUILang.forcesavesessionLogFailed + ' (' + data.error + ')', 'error');
		},
		error : function(data, errorText, errorThrown)
		{
			noty(theUILang.forcesavesessionLogFailed + ' (' + errorText+' : '+errorThrown + ')', 'error');
		},
	});
}

plugin.onLangLoaded = function()
{
	this.addButtonToToolbar("webuiSaveSession", theUILang.forcesavesessionSave, "theWebUI.saveSession()", "help");
	this.addSeparatorToToolbar("help");
}

plugin.onRemove = function()
{
	theWebUI.update();
	this.removeSeparatorFromToolbar("webuiSaveSession");
	this.removeButtonFromToolbar("webuiSaveSession");
}
