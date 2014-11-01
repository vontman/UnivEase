define("CIRCLE",["CScript","CTextFormatUtil","Rectangle","CStopTypeAfterNSec","CEffectMacro","AnimationPackage"],function(c,b,d,a,g,f){function e(v,s,u,A,m,l,G,r,q,E,i,t,j,o,k,D,w,B,n,z,C,h,F,p){this.x=v;this.y=s;this.xr=u;this.yr=A;this.start=m;this.end=l;this.Color=G;this.Pattern=r||"";this.BkColor=q||16777215;this.Width=E==0?0:E||1;this.Style=i||0;this.CircleType=t||0;this.RotateDegree=j||0;this.Rops=o||0;this.sHyperLink=k||"";this.sHyperLinkToolTip=D||"";this.sEffectMacro=w||"";this.diagramText=B||"";this.fontMacro=n||"";this.disappear=z||0;this.disappearGroupID=C||-1;this.sID=h||"";this.iInTime=F||-1;this.iOutTime=p||Number.MAX_VALUE;this.format=b.parseFontMacro(n,"center","center",24);this.iSyncObject=0;this.iIndex=0;this.EM=new g();this.EM.parseEffectMacro(this.sEffectMacro)}e.prototype=new c();e.prototype.StopType=function(){if(this.EM.IsAnimation()){return new a(0)}return null};e.prototype.Run=function(k){k=k||false;this.iSyncObject=this.CheckSyncObject(k,"CIRCLE",this.sID,this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}var i=CUIComponentFactory.Circle(this.x,this.y,this.xr,this.yr,this.start,this.end,this.Color,this.Pattern,this.BkColor,this.Width,this.Style,this.CircleType,this.RotateDegree,this.Rops);main.Draw(i);if(this.diagramText.length>0){var l=new d(0,0,i.divCanvas.width,i.divCanvas.height);l.inflate(-8,0);main.Draw(CUIComponentFactory.Text(i,this.diagramText,l,this.format))}if(this.sID){i.setID(this.sID)}if(this.disappear==1){var h=main.GetFreeButtonNo(10000);main.AddBitmapCloseButton(i,this.sID,h,this.disappearGroupID);i.addStyle("cursor","pointer");i.addStyle("cursor","cursor");i.addEvent("onclick","main.RemoveBitmapClose(this, "+h+", "+this.disappearGroupID+")")}if(this.sHyperLink.length>0){i.addHyperLink(this.sHyperLink,this.sHyperLinkToolTip)}if(this.sEffectMacro.length>0){if(this.EM.IsAnimation()){if(!this.sID){i.setID("E"+i.zIndex)}var j=new f(i.divShape);j.setmacro(this.sEffectMacro.split(","));j.setcontainer();j.start()}}};return e});