define("CScriptManager",["CScript","SLIDESTART","CStopTypeAfterNSec","CStopTypeFromStart","CAssertUtil","CSlideHistory","Timer","VIDEOOPEN","MyEventDispatcher","CMasterInfo","QUIZ_OBJECTIVE","QUIZ_SUBJECTIVE"],function(b,g,a,c,h,d,l,f,k,j,m,i){function e(n){this.arrayScript=n||[];this.slideHistory=new d();this.timer=l.New();this.timer.addEventListener(this.timerHandler);this.myEvent=k.getInstance()}e.prototype={iIndexScript:0,bTimerFromStart:false,nTime:0,GetScriptIndex:function(){return this.iIndexScript},ScriptCount:function(){return this.arrayScript.length},IndexCurrentSlideStart:function(){for(var o=this.iIndexScript-1;0<=o;o--){var n=this.GetScript(o);var p=n instanceof g?n:null;if(null!=p){return o}}return 0},SlideStart:function(){this.slideHistory.Push(this.GetCurrentSlideNo());if(this.timer){this.timer.stop()}if(Viewer.isAnApp){window.ABridge.cancelNGo("bRunMaster");window.ABridge.cancelNGo("bTimeControl")}},GetSlideCount:function(){var o=0;for(var n=0;n<this.ScriptCount();n++){if(null!=this.GetScriptAsSlideStart(n)){o++}}return o},GetCurrentSlideNo:function(){var o=0;for(var n=0;n<this.ScriptCount();n++){if(null!=this.GetScriptAsSlideStart(n)){o++}if(this.iIndexScript==n+1){break}}return o},GetScriptAsSlideStart:function(o){var n=this.GetScript(o);return n instanceof g?n:null},GetScript:function(o){h.IsTrue(o<this.ScriptCount());var n=this.arrayScript[o];n=n instanceof b?n:null;h.IsNotNull(n);return n},PreRun:function(){while(this.iIndexScript<this.ScriptCount()){var n=this.GetScript(this.iIndexScript);this.iIndexScript++;if(n instanceof f){n.PreRun()}}this.iIndexScript=0},SetQuizInfo:function(){var q=0;while(this.iIndexScript<this.ScriptCount()){var p=this.GetScript(this.iIndexScript);this.iIndexScript++;if(p instanceof m){var o=p;main.quizNumber[q]=o.iQuizNumber;main.quizPoint[q]=o.iPoint;q++}else{if(p instanceof i){var n=p;main.quizNumber[q]=n.iQuizNumber;main.quizPoint[q]=n.iPoint;q++}}}this.iIndexScript=0},Run:function(){while(this.iIndexScript<this.ScriptCount()){this.timer.me=this;if(main.bRunMaster){if(!this.timer.running){if(Viewer.isAnApp){window.ABridge.sleepNGo("bRunMaster","main.Resume()",100)}else{this.timer.start()}return}else{return}}var o=this.GetScript(this.iIndexScript);this.iIndexScript++;o.Run();var n;if(o.arrayScripts&&o.arrayScripts.length>0){new j("",o).Run(o.x,o.y);n=o.arrayScripts[o.arrayScripts.length-1].StopType()}else{n=o.StopType()}if(null!=n){main.SetStopType(n);var p;if(n instanceof a){p=n.nTime;this.bTimerFromStart=false;if(Viewer.isAnApp&&o.bTimeControl){window.ABridge.sleepNGo("bTimeControl","main.Resume()",p);window.ABridge.sleepNGo("main.Continue()",p);window.ABridge.loopNGo("main.scripManager.timerHandler(main.scripManager.timer)",p)}else{this.timer.delay=p;this.timer.start()}}if(n instanceof c){p=n.nTime;this.bTimerFromStart=true;this.nTime=p;this.timer.delay=100;this.timer.start()}return}}},timerHandler:function(p){var o=p.me;if(main.bRunMaster){return}if(o.myEvent.AnimationStatus=="incomplete"){return}else{if(o.myEvent.ButtonStatus){o.myEvent.ButtonStatus=false;this.stop();main.Continue();return}}if(o.bTimerFromStart){var n=main.getTimer();if(n-main.nSlideStartTime<o.nTime){return}}this.stop();main.Continue()},GotoSlideStartFirst:function(){for(var n=0;n<this.ScriptCount();n++){if(null!=this.GetScriptAsSlideStart(n)){this.iIndexScript=n;return}}h.Failed()},GotoSlideStartLast:function(){for(var n=this.ScriptCount()-1;0<=n;n--){if(null!=this.GetScriptAsSlideStart(n)){this.iIndexScript=n;return}}h.Failed()},GotoSlideStartRelative:function(o,n){if(o==0){return}this.GotoSlideStartNo(this.GetCurrentSlideNo()+o,n)},GotoSlideStartNext:function(){for(var n=this.iIndexScript;n<this.ScriptCount();n++){if(null!=this.GetScriptAsSlideStart(n)){this.iIndexScript=n;return}}},GotoSlideStartPrev:function(){this.iIndexScript=this.IndexCurrentSlideStart();for(var n=this.iIndexScript-1;0<=n;n--){if(this.GetScriptAsSlideStart(n)){this.iIndexScript=n;return}}},GotoSlideStartBefore:function(){var n=this.slideHistory.Pop();this.slideHistory.Push(this.GetCurrentSlideNo());this.GotoSlideStartNo(n)},GotoSlideStartCurrent:function(){this.iIndexScript=this.IndexCurrentSlideStart()},GotoSlideStart:function(p){for(var n=0;n<this.ScriptCount();n++){var o=this.GetScriptAsSlideStart(n);if(null!=this.GetScriptAsSlideStart(n)){if(o.EqualsSlideName(p)){this.iIndexScript=n;return true}}}return false},FindSlide:function(p){for(var n=0;n<this.ScriptCount();n++){var o=this.GetScriptAsSlideStart(n);if(null!=this.GetScriptAsSlideStart(n)){if(o.EqualsSlideName(p)){return true}}}return false},GetCurrentSlideName:function(){var n=this.GetScriptAsSlideStart(this.IndexCurrentSlideStart());return n.SlideName()},GetArraySlideName:function(){var p=[];for(var o=0;o<this.ScriptCount();o++){var n=this.GetScriptAsSlideStart(o);if(!n){continue}n.PushSlideNameToArray(p)}return p},GotoSlideStartNo:function(o,p){var q=0;for(var n=0;n<this.ScriptCount();n++){if(null!=this.GetScriptAsSlideStart(n)){q++;if(q==o){this.iIndexScript=n;return}}}}};return e});