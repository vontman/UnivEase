define("BROWSER",["CScript","Rectangle"],function(a,b){function c(o,e,r,d,q,n,p,l,f,s,m,i,g,h,k,j){this.sURL=o||"";this.iX1=e||0;this.iY1=r||0;this.iX2=d==0?0:d||-1;this.iY2=q==0?0:q||-1;this.iOpenClose=n||0;this.sID=p||null;this.iBorder=l||0;this.iScrollBar=f==0?0:f||3;this.iURLType=s||0;this.iInTime=h||-1;this.iOutTime=k||Number.MAX_VALUE;this.iMessageHooking=j||0}c.prototype=new a();c.prototype.Run=function(e){e=e||false;var d=this.sID==null?"":this.sID.toString();if(this.sID instanceof String){this.iID=main.FindBrowserNo(d)}else{this.iID=Number(this.sID)}var h;if(this.iID==-1){h=main.GetFreeBrowserNo(0)}else{h=this.iID}this.iSyncObject=this.CheckSyncObject(e,"BROWSER",d,this.iInTime,this.iOutTime);if(this.iSyncObject==-1){return}var f=main.BrowserManager();if(this.sURL==""||this.sURL==null){f.Remove(h);return}if(this.iX1>main.iSlideWidth||this.iY1>main.iSlideHeight){this.iX2=this.iX1;this.iY2=this.iY2}var g=f.AddBrowser(h,this.sURL,this.iX1,this.iY1,this.iX2-this.iX1,this.iY2-this.iY1,d,this.iBorder,this.iScrollBar,this.iURLType)};return c});