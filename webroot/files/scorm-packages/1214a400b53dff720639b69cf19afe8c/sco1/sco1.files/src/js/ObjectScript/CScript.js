define("CScript",["CAssertUtil"],function(b){function a(){}a.prototype={StopType:function(){return null},SetXY:function(c,d){},PreRun:function(){b.Abstract()},Run:function(c){},Resume:function(){main.Continue()},CheckSyncObject:function(h,f,d,i,c,e){h=h||false;f=f||"";d=d||"";i=i||-1;c=c||Number.MAX_VALUE;e=e||-1;iScriptIndex=-1;if(!h){if(i>=0||(c>=0&&c<2147483647)){if(main.nVideoNoSyncObject==-1&&main.nSlideSyncObject==0){if(!main.FindVideoSyncObject()){return 0}}if(main.bRunMaster){var g=main.MasterManager().sMasterName;this.iScriptIndex=main.MasterManager().GetScriptIndex(g);main.AddObjectSync(f,d,this.iScriptIndex,i,c,e,g)}else{this.iScriptIndex=main.ScriptManager().GetScriptIndex();main.AddObjectSync(f,d,this.iScriptIndex,i,c,e)}if(i>=0){return -1}return 1}}return 1},HyperLink:function(f,e,d,c){if(c==undefined){c="_blank"}if(e&&e!=""){main.AddHyperLink(f,e,d,c)}},BUTTON_ENABLE:function(c,d){switch(c){case -1:main.SetEnableAll(d);return;case -7:main.SetEnableGeneral(d);return;case -6:main.SetEnableProgress(d);return;case -5:main.SetEnableKeepAlive(d);return;default:main.SetEnable(c,d);return}b.Failed()}};return a});