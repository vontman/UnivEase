define("POLYGON",["CScript","CTextFormatUtil","Rectangle","CStopTypeAfterNSec","CEffectMacro","AnimationPackage"],function(d,c,e,b,g,f){function a(m,t,r,s,w,E,q,p,C,i,j,l,k,B,u,z,n,v,A,h,D,o){this.SideCount=m;this.x=t;this.y=r;this.xr=s;this.yr=w;this.Color=E;this.Pattern=q||"";this.BkColor=p||16777215;this.Width=C==0?0:C||1;this.Style=i||0;this.RotateDegree=j||0;this.Rops=l||0;this.sHyperLink=k||"";this.sHyperLinkToolTip=B||"";this.sEffectMacro=u||"";this.diagramText=z||"";this.fontMacro=n||"";this.disappear=v||0;this.disappearGroupID=A||-1;this.sID=h||"";this.iInTime=D||-1;this.iOutTime=o||Number.MAX_VALUE;this.format=c.parseFontMacro(n,"center","center",24);this.iSyncObject=0;this.iIndex=0;this.EM=new g();this.EM.parseEffectMacro(this.sEffectMacro)}a.prototype=new d();a.prototype.StopType=function(){if(this.EM.IsAnimation()){return new b(0)}return null};a.prototype.Run=function(k){k=k||false;this.iSyncObject=this.CheckSyncObject(k,"POLYGON",this.sID,this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}var i=CUIComponentFactory.Polygon(this.SideCount,this.x,this.y,this.xr,this.yr,this.Color,this.Pattern,this.BkColor,this.Width,this.Style,this.RotateDegree,this.Rops);main.Draw(i);if(this.diagramText.length>0){var l=new e(0,0,i.divCanvas.width,i.divCanvas.height);l.inflate(-8,0);main.Draw(CUIComponentFactory.Text(i,this.diagramText,l,this.format))}if(this.sID){i.setID(this.sID)}if(this.disappear==1){var h=main.GetFreeButtonNo(10000);main.AddBitmapCloseButton(i,this.sID,h,this.disappearGroupID);i.addStyle("cursor","pointer");i.addStyle("cursor","cursor");i.addEvent("onclick","main.RemoveBitmapClose(this, "+h+", "+this.disappearGroupID+")")}if(this.sHyperLink.length>0){i.addHyperLink(this.sHyperLink,this.sHyperLinkToolTip)}if(this.sEffectMacro.length>0){if(this.EM.IsAnimation()){if(!this.sID){i.setID("E"+i.zIndex)}var j=new f(i.divShape);j.setmacro(this.sEffectMacro.split(","));j.setcontainer();j.start()}}};return a});