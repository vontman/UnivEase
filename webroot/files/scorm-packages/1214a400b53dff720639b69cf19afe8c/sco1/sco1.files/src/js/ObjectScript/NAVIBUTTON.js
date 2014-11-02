define("NAVIBUTTON",["CScript","CTextFormatUtil","Rectangle","CUIComponentFactory","Shape","Capabilities"],function(d,c,e,b,f,a){function g(r,n,m,o,j,h,q,i,p,k,l){this.iButtonType=r||0;this.iButtonX=n||-1;this.iButtonY=m||-1;this.iButtonW=o||30;this.iButtonH=j||20;this.buttonBitmapAsset=h||null;this.iRTL=q||0;this.iDisplaySlideNo=i||0;this.sFontMacro=p||"";this.iInTime=k||-1;this.iOutTime=l||Number.MAX_VALUE;this.format=c.parseFontMacro(p);this.iSyncObject=0;this.iIndex=0;this.bInit=false}g.prototype=new d();g.prototype.Run=function(h){h=h||false;this.iSyncObject=this.CheckSyncObject(h,"NAVIBUTTON","",this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}this.NavigationButton()};g.prototype.NavigationButton=function(){var u,s;var z,v;var J,I;var P=4;var D=0;var B=0;if(this.iDisplaySlideNo){var C=main.GetSlideCount();D=c.GetSlideNumberWidth(C,this.format,this.iButtonW)}for(J=0;J<=5;J++){I=1<<J;if(this.iButtonType&I){B++}}if(this.iButtonX==-1||this.iButtonY==-1||this.iButtonX==-2||this.iButtonY==-2||this.iButtonX==-3||this.iButtonY==-3){var w=(this.iButtonX==-1||this.iButtonY==-1)?10:30;var t=(this.iButtonX==-1||this.iButtonY==-1)?10:14;if(this.iDisplaySlideNo){if(B==0&&this.iButtonW==0){this.iButtonW=80;this.iButtonH=20}}if(this.iButtonX==-3){z=w}else{z=Viewer.SlideWidth-B*(this.iButtonW+P)-w+P-D-P}v=Viewer.SlideHeight-this.iButtonH-t;u=z;s=v}else{u=this.iButtonX;s=this.iButtonY}if(this.iSyncObject){var n=new e(u,s,(this.iButtonW+P)*B+D,this.iButtonH);main.AddBitmapSync(n,this.iIndex,"")}var K=new e(u,s-((Number(this.format.size)-this.iButtonH)/2),D,Number(this.format.size));J=this.iRTL?5:0;while(1){if(this.iRTL){if(J<0){break}}else{if(J>5){break}}I=1<<J;if(this.iButtonType&I){var r=(this.buttonBitmapAsset.width||this.buttonBitmapAsset.bitmapData.width||this.buttonBitmapAsset.bitmapData.naturalWidth)/6;var F=(this.buttonBitmapAsset.height||this.buttonBitmapAsset.bitmapData.height||this.buttonBitmapAsset.bitmapData.naturalHeight)/3;var Q=new e(u,s,this.iButtonW,this.iButtonH);var M=[4,2,3,5,7,16];var o=a.Message(a.Langueges.NaviButtonTooltip);var p=new Array(3);for(var H=0;H<3;H++){p[H]=document.createElement("canvas");p[H].setAttribute("width",r+"px");p[H].setAttribute("height",F+"px");var h=p[H].getContext("2d");h.drawImage(this.buttonBitmapAsset.bitmapData,J*r,F*H,r,F,0,0,r,F)}var L=p[0],R=p[1],O=p[2];main.AddButton(J+80000+main.nNaviButton*6,"",Q,L,R,O,2,"",M[J],o[J],"",null,0,null,-1,-1,-1,-1,-1,-1,-1,"");var q=main.GetButtonInfo(J+80000+main.nNaviButton*6);q.DrawOut();u+=this.iButtonW+P}if(this.iDisplaySlideNo){if((this.iRTL&&(J==2))||(!this.iRTL&&(J==1))){K.x=u;K.y=s-((Number(this.format.size)-this.iButtonH)/2);K.width=D;K.height=Number(this.format.size);u+=D+P}}if(this.iRTL){J--}else{J++}}if(this.iButtonType){main.nNaviButton++}if(this.iDisplaySlideNo){var N=K.height;if(Number(this.format.size)>N){K.y-=(Number(this.format.size)-N)/2;K.bottom+=(Number(this.format.size)-N)/2}var G="";var A;var m;A=main.GetCurrentSlideNo();m=main.GetSlideCount();G=A.toString()+"/"+m.toString();var l=new f(K.x,K.y,K.width,K.height);l.setID("portion");l.divShape.style.zIndex=80000;var E=new e(-1,0,K.width,K.height);b.Text(l,G,E,this.format);main.Draw(l)}};return g});