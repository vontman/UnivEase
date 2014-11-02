define("CEBoardControlPanel",["Point","Timer","CCompileOption","CEBoardAction","CEBoardActionElectronicBoardClearScreen","CUIComponentFactory","CEBoardButton","CEBoardProgress","Shape"],function(g,j,d,c,h,b,e,i,f){function a(u,t){var l=document.getElementById("eBoardControlPanel");if(l){this.divShape=l}else{this.divShape=document.createElement("div");this.divShape.className="item eboard panel";this.divShape.style.left=u+"px";this.divShape.style.top=t+"px";this.divShape.id="eBoardControlPanel";this.divShape.style.position="relative";this.divShape.style.zIndex="99999";var n=new Array("Play","Pause","Stop","ProgressBar");var p=new Array(21,21,21,301);for(var m=0;m<3;++m){var r=document.createElement("canvas");r.id=n[m];r.setAttribute("width",p[m]+"px");r.setAttribute("height","21px");var q=document.createElement("div");q.className="eboardControlBar "+n[m];q.setAttribute("title",n[m]);q.appendChild(r);this.divShape.appendChild(q)}var q=document.createElement("div");q.className="eboardControlBar "+n[3];q.id=n[3];var k=document.createElement("div");k.className="eboardControlBar Stick";k.id=n[3]+"Stick";q.appendChild(k);var s=document.createElement("div");s.className="eboardControlBar Text";s.id=n[3]+"Text";this.divShape.appendChild(q);this.divShape.appendChild(s)}}a.prototype={divShape:null,Init:function(n,k,l){this.timer=n;this.iTotalTime=k;this.eboardInfo=l;var m=document.getElementById("eBoardControlPanel");if(!m){main.AddEBoardControlPanel(this.divShape)}else{m.style.display="block"}this.PauseButton=new e("Pause",this.buttonPause_OnClick,Viewer._EBoardPause_);this.PlayButton=new e("Play",this.buttonPlay_OnClick,Viewer._EBoardPlay_);this.StopButton=new e("Stop",this.buttonStop_OnClick,Viewer._EBoardStop_);this.ProgressBar=new i("ProgressBar",this.hslider_OnChange);this.PauseButton.me=this;this.PlayButton.me=this;this.StopButton.me=this;this.ProgressBar.me=this;this.PauseButton.init();this.PlayButton.init();this.StopButton.init();this.ProgressBar.init(this.hslider_OnChange);this.OnCreationComplete()},OnCreationComplete:function(){this.ProgressBar.setMaxTime(this.iTotalTime);this.buttonPlay_OnClick()},UpdateTime:function(k,l){if(!this.bIsDragging){this.ProgressBar.setPosTime(k)}if(this.iTotalTime!=l/1000){this.ProgressBar.setMaxTime(l);this.iTotalTime=l}},buttonPlay_OnClick:function(){var k=this.me?this.me:this;k.eboardInfo.Resume()},buttonPause_OnClick:function(){var k=this.me?this.me:this;k.eboardInfo.Pause()},buttonStop_OnClick:function(){var k=this.me?this.me:this;k.eboardInfo.Stop()},hslider_OnChange:function(l){var k=this.me?this.me:this;k.bIsDragging=false;if(!k.eboardInfo.timer.running){k.eboardInfo.timer.start()}k.eboardInfo.SetPos(l);if(k.eboardInfo.iPlayStatus!=1){k.eboardInfo.Pause()}},Show:function(){this.divShape.style.visible=true},Hide:function(){this.divShape.style.visible=false}};return a});