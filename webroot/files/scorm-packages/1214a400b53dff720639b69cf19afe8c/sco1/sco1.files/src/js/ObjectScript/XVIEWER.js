define("XVIEWER",["CScript","CStopTypeInfiniteLoop","BitmapAsset","CStopTypeAfterNSec","CEffectMacro","AnimationPackage"],function(b,d,e,a,g,f){function c(j,s,i,q,h,k,u,o,t,r,n,p,l,m){this.iX1=j||0;this.iY1=s||0;this.iX2=i||-1;this.iY2=q||-1;this.iDataType=h||-1;this.object=k;this.sEffectMacro=u||"";this.sHyperLink=o||"";this.sHyperLinkToolTip=t||"";this.disappear=r||0;this.disappearGroupID=n||-1;this.sID=p||"";this.iInTime=l||-1;this.iOutTime=m||Number.MAX_VALUE;this.iSyncObject=0;this.iIndex=0;this.EM=new g();this.EM.parseEffectMacro(this.sEffectMacro)}c.prototype=new b();c.prototype.StopType=function(){if(typeof this.object=="string"){return new d()}if(this.EM.IsAnimation()){return new a(0)}return null};c.prototype.onLoadComplete=function(i){var h=this.me;h.bitmapAsset=new e(h.Image);if(main.GetCurrentSlideNo()==h.iCurrentSlideNo){h.Display();h.Resume()}};c.prototype.onLoadError=function(i){var h=this.me;h.Resume()};c.prototype.Run=function(h){h=h||false;this.iSyncObject=this.CheckSyncObject(h,"XVIEWER",this.sID,this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}if(typeof this.object=="string"){this.iCurrentSlideNo=main.GetCurrentSlideNo();this.Image=document.createElement("img");this.Image.me=this;this.Image.onload=this.onLoadComplete;this.Image.src=this.object}else{this.bitmapAsset=this.object;this.Display()}};c.prototype.Display=function(){if(!this.bitmapAsset){return}var i=CUIComponentFactory.DrawBitmap(this.bitmapAsset.bitmapData,this.iX1,this.iY1,this.iX2-this.iX1,this.iY2-this.iY1);if(this.sID){i.setID(this.sID)}main.Draw(i);if(this.disappear==1){var h=main.GetFreeButtonNo(10000);main.AddBitmapCloseButton(i,this.sID,h,this.disappearGroupID);i.addStyle("cursor","pointer");i.addStyle("cursor","cursor");i.addEvent("onclick","main.RemoveBitmapClose(this, "+h+", "+this.disappearGroupID+")")}if(this.sHyperLink.length>0){i.addHyperLink(this.sHyperLink,this.sHyperLinkToolTip)}if(this.sEffectMacro.length>0){if(this.EM.IsAnimation()){if(!this.sID){i.setID("E"+i.zIndex)}var j=new f(i.divShape);j.setmacro(this.sEffectMacro.split(","));j.setcontainer();j.start()}}};return c});