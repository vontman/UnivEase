define("SOUND",["CScript","Rectangle","CStopTypeInfiniteLoop","SoundAsset","CTextFormatUtil","CAudioPlayer"],function(b,l,g,i,m,j){var c=null;var k=null;var a=0;var d=false;var e=0;var f=null;function h(D,u,p,B,E,t,r,z,v,y,x,q,w,o,A,n,C,s){this.object=D;this.iVolume=u||-1;this.iNoUse1=p||0;this.iLoop=B||0;this.iStartPos=E||0;this.iEndPos=t||-1;this.iDisplayIcon=r||0;this.iAutoPlay=(z==0)?0:z||1;this.iIconFunction=v||0;this.iIconX=y||0;this.iIconY=x||0;this.iIconWidth=q==0?0:(q||24);this.iIconHeight=w==0?0:(w||24);this.bitmapAssetPlayIcon=o||null;this.bitmapAssetPauseIcon=A||null;this.bSyncObject=n||0;this.iInTime=C||-1;this.iOutTime=s||Number.MAX_VALUE;this.soundAsset;this.sndAsset;if(this.iLoop==1){this.iLoopCount=16777215}else{this.iLoopCount=0}if(u==-1){this.iVolume=u=50}if(u>=0){this.nSoundVolume=u/100}}h.prototype=new b();h.prototype.onLoadComplete=function(o){var n=this.me;this.soundAsset=this.sndAsset;if(main.GetCurrentSlideNo()==n.iCurrentSlideNo){n.Display()}};h.prototype.onLoadError=function(n){this.soundAsset=null};h.prototype.Run=function(o){var n=-1;if(this.iDisplayIcon==1||this.iDisplayIcon==2){n=main.GetFreeButtonNo(30000)}this.iSyncObject=this.CheckSyncObject(o,"SOUND","",this.iInTime,this.iOutTime,n);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}if(this.iAutoPlay){this.StopCurrent()}if(this.object instanceof i){this.soundAsset=this.object;this.Display()}else{this.sndAsset=new Audio();this.iCurrentSlideNo=main.GetCurrentSlideNo();this.sndAsset.addEventListener("canplay",this.onLoadComplete);this.sndAsset.addEventListener("error",this.onLoadError);this.sndAsset.src(this.object)}};h.prototype.Display=function(){if(null==this.soundAsset){return}c=this.soundAsset;e=this.iLoopCount;if(this.iAutoPlay){main.StopPreSoundIcon(-999)}if(this.iDisplayIcon==1||this.iDisplayIcon==2){if(this.iDisplayIcon==2&&!this.bitmapAssetPlayIcon&&!this.bitmapAssetPauseIcon){this.iDisplayIcon=1}if(this.iDisplayIcon==1){this.bitmapAssetPlayIcon=Viewer._SoundOn_;this.bitmapAssetPauseIcon=Viewer._SoundOff_;this.iIconWidth=24;this.iIconHeight=24}var o;o=main.GetFreeButtonNo(30000);var p=this.bitmapAssetPlayIcon;var n=this.bitmapAssetPauseIcon;var q;q=n;n=p;p=q;var s=new l(this.iIconX,this.iIconY,this.iIconWidth,this.iIconHeight);var u=m.parseFontMacro("","center","center");main.AddButton(o,"",s,p,null,n,2,"",6,"","",c,0,u,-1,-1,this.iIconFunction,this.nSoundVolume,this.iLoop,-1,-1,"");var t=main.GetButtonInfo(o);t.SetSoundButton(true);if(this.iAutoPlay){main.StopButtonSound();t.Action()}t.DrawOut();return}main.StopButtonSound();if(this.iVolume>=0){var r=this.iVolume/100;this.soundAsset.soundData.volume=r}k=this.soundAsset.soundData;if(k.currentTime){k.currentTime=0}k.loop=this.iLoopCount;if(this.iLoop==2||this.iLoop==1){k.me=this;k.addEventListener("ended",this.soundCompleteHandler)}if(this.iDisplayIcon==3||this.iDisplayIcon==4){f=new j(this.object);f.AutoPlay=false;f.x=this.iIconX;f.y=this.iIconY;if(Viewer.isIE){f.width=this.iIconWidth==0?0:this.iIconWidth<273?273:this.iIconWidth||273;f.height=this.iIconHeight==0?0:this.iIconHeight==64?45:this.iIconHeight||45}else{f.width=this.iIconWidth;f.height=this.iIconHeight==64?32:this.iIconHeight||32}f.ControlBarVisible=true;f.Loop=this.iLoop==1?1:0;f.SetSound(c,k,this.iLoop==1,c.length);f.OnCreationComplete();main.Draw(f)}k.play()};h.prototype.StopType=function(){if(this.iLoop==2){return new g()}return null};h.prototype.soundCompleteHandler=function(){if(this.me.iLoop==2){k.removeEventListener("ended",this.me.soundCompleteHandler,false);main.Continue()}if(this.me.iLoop==1){k=this.me.soundAsset.soundData;k.loop=this.me.iLoopCount;k.play()}};h.prototype.SlideStart=function(){this.StopCurrent();main.StopSoundButton();if(f){if(main.Contains(f.divDisplay)){f.Pause();f.Close();main.Clear(f);if(Viewer.isIOS&&f&&f.Renew){f.Renew()}}}};h.prototype.StopCurrent=function(){if(null!=k){k.pause();if(k.currentTime){k.currentTime=0}if(this.iDisplayIcon==3||this.iDisplayIcon==4){main.Clear(k.parentElement);if(Viewer.isIOS&&f&&f.Renew){f.Renew()}}}c=null;k=null;a=0;d=false};h.prototype.Pause=function(){if(null==k){return}a=k.position;k.bPaused=k.paused;k.pause();d=true};h.prototype.Resume=function(){if(null==c){return}if(d==true){if(Viewer.isAnApp||Viewer.isIOS){if(!k.bPaused){k.play()}}else{k.play()}d=false}};return h});