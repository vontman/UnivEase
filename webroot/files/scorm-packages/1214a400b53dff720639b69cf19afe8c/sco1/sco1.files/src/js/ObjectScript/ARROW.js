define("ARROW",["CScript","CUIComponentFactory","CStopTypeAfterNSec","CEffectMacro","AnimationPackage"],function(c,b,a,f,e){function d(s,j,r,i,x,v,h,m,p,l,k,t,o,q,u,g,w,n){this.x1=s;this.y1=j;this.x2=r;this.y2=i;this.Color=x||0;this.Width=v==0?0:v||1;this.Style=h||0;this.ArrowType=m||0;this.ArrowSize=p==0?0:p||6;this.Rops=l||0;this.sHyperLink=k||"";this.sHyperLinkToolTip=t||"";this.sEffectMacro=o||"";this.disappear=q||0;this.disappearGroupID=u||-1;this.sID=g||"";this.iInTime=w||-1;this.iOutTime=n||Number.MAX_VALUE;this.iSyncObject=0;this.iIndex=0;this.EM=new f();this.EM.parseEffectMacro(this.sEffectMacro)}d.prototype=new c();d.prototype.StopType=function(){if(this.EM.IsAnimation()){return new a(0)}return null};d.prototype.Run=function(j){j=j||false;this.iSyncObject=this.CheckSyncObject(j,"ARROW",this.sID,this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}var h=b.Arrow(this.x1,this.y1,this.x2,this.y2,this.Color,this.Width,this.Style,this.ArrowType,this.ArrowSize,this.Rops);main.Draw(h);if(this.sID){h.setID(this.sID)}if(this.disappear==1){var g=main.GetFreeButtonNo(10000);main.AddBitmapCloseButton(h,this.sID,g,this.disappearGroupID);h.addStyle("cursor","pointer");h.addStyle("cursor","cursor");h.addEvent("onclick","main.RemoveBitmapClose(this, "+g+", "+this.disappearGroupID+")")}if(this.sHyperLink.length>0){h.addHyperLink(this.sHyperLink,this.sHyperLinkToolTip)}if(this.sEffectMacro.length>0){if(this.EM.IsAnimation()){if(!this.sID){h.setID("E"+h.zIndex)}var i=new e(h.divShape);i.setmacro(this.sEffectMacro.split(","));i.setcontainer();i.start()}}};return d});