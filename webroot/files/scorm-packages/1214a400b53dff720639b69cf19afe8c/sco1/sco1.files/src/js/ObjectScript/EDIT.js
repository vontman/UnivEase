define("EDIT",["CScript","CTextFormatUtil","Rectangle","CStopTypeAfterNSec","CEffectMacro","AnimationPackage","Shape","Capabilities"],function(CScript,CTextFormatUtil,Rectangle,CStopTypeAfterNSec,CEffectMacro,AnimationPackage,Shape,Capabilities){function EDIT(x1,y1,x2,y2,EditType,sText,MultiLine,sFontMacro,sEffectMacro,NoUse1,NoUse2,NoUse3,NoUse4,sHyperLink,sHyperLinkToolTip,disappear,disappearGroupID,sID,iInTime,iOutTime){this.x1=x1||0;this.y1=y1||0;this.x2=x2||-1;this.y2=y2||-1;this.EditType=EditType||0;this.sText=sText||"";this.MultiLine=MultiLine||1;this.sFontMacro=sFontMacro||"";this.sEffectMacro=sEffectMacro||"";this.NoUse1=NoUse1||0;this.NoUse2=NoUse2||"";this.NoUse3=NoUse3||0;this.NoUse4=NoUse4||"";this.sHyperLink=sHyperLink||"";this.sHyperLinkToolTip=sHyperLinkToolTip||"";this.rect=new Rectangle(x1,y1,x2-x1,y2-y1);this.format=CTextFormatUtil.parseFontMacro(this.sFontMacro);this.edgeFormat=CTextFormatUtil.parseEdgeMacro(this.sFontMacro);this.disappear=disappear||0;this.disappearGroupID=disappearGroupID||-1;this.sID=sID||"";this.iInTime=iInTime||-1;this.iOutTime=iOutTime||Number.MAX_VALUE;this.iSyncObject=0;this.iIndex=0;this.EM=new CEffectMacro();this.EM.parseEffectMacro(this.sEffectMacro)}EDIT.prototype=new CScript();EDIT.prototype.StopType=function(){if(this.EM.IsAnimation()){return new CStopTypeAfterNSec(0)}return null};EDIT.prototype.Run=function(bRunSyncObject){bRunSyncObject=bRunSyncObject||false;this.iSyncObject=this.CheckSyncObject(bRunSyncObject,"EDIT",this.sID,this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}var sText=this.sText;if(this.EditType==4){var date=new Date();var iSlideNo;var iTotalNo;switch(this.sText){case"SlideInfo(10)":sText=main.GetSlideViewCount();break;case"SlideInfo(12)":sText=main.GetSlideViewStatus();break;case"SlideInfo(14)":sText=main.GetSlideProgressRate().toString();break;case"SlideInfo(8)":iSlideNo=main.GetCurrentSlideNo();iTotalNo=main.GetSlideCount();sText=iSlideNo.toString()+"/"+iTotalNo.toString();break;case"SlideInfo(9)":iSlideNo=main.GetCurrentSlideNo();iTotalNo=main.GetSlideCount();sText=iSlideNo.toString()+" of "+iTotalNo.toString();break;case"Date(0)":sText=date.getFullYear()+"-"+(date.getMonth()+1).padLeft(2,"0")+"-"+date.getDate().padLeft(2,"0");break;case"Date(2)":var message=Capabilities.Message(Capabilities.Langueges.Weekend);var sText=message[date.getDay()];break;case"Date(1)":sText=date.toTimeString().substr(0,8);break;case"QuizInfo(0)":sText=main.quiz_Manager.GetQuiz_Info(0).toString();break;case"QuizInfo(1)":sText=main.quiz_Manager.GetQuiz_Info(1).toString();break;case"QuizInfo(2)":sText=main.quiz_Manager.GetQuiz_Info(2).toString();break;case"QuizInfo(3)":sText=main.quiz_Manager.GetQuiz_Info(3).toString();break;case"QuizInfo(4)":sText=main.quiz_Manager.GetQuiz_Info(4).toString();break;case"QuizInfo(5)":sText=main.quiz_Manager.GetQuiz_Info(5).toString();break;case"QuizInfo(6)":sText=main.quiz_Manager.GetQuiz_Info(6).toString();break;case"QuizInfo(7)":sText=main.quiz_Manager.GetQuiz_Info(7).toString();break;case"QuizInfo(8)":sText=main.quiz_Manager.GetQuiz_Info(8).toString();break;case"QuizInfo(9)":sText=main.quiz_Manager.GetQuiz_Info(9).toString();break;case"QuizInfo(12,1)":sText=main.quiz_Manager.GetQuiz_Info(12,1).toString();break;default:var iIndex,iIndex2;var str;iIndex=this.sText.indexOf("Timer(");if(iIndex>=0){var Type;var nTimerNo,nCountDown=3600;var nStartTime=0;str=this.sText.substring(iIndex+6);Type=parseInt(str);iIndex=this.sText.indexOf(",");str=this.sText.substring(iIndex+1);nTimerNo=parseInt(str);iIndex=this.sText.indexOf(",",iIndex+1);if(iIndex>=0){str=this.sText.substring(iIndex+1);nCountDown=parseInt(str)}if(nTimerNo>=0&&nTimerNo<=15){nStartTime=main.timerStart[nTimerNo]}var elapseTime,leftTime;elapseTime=parseInt((main.getTimer()-nStartTime)/1000);leftTime=parseInt(nCountDown-(main.getTimer()-nStartTime)/1000);switch(Type){case 7:sText=elapseTime.toString();break;case 8:sText=CCommonUtil.ms2hhmmss(elapseTime*1000);break;case 9:sText=leftTime.toString();break;case 10:sText=CCommonUtil.ms2hhmmss(leftTime*1000);break}break}iIndex=this.sText.indexOf("QuizInfo(1");if(iIndex>=0){var iInfo;var iQuizNo=1;str=this.sText.substring(iIndex+9);iInfo=parseInt(str);iIndex=this.sText.indexOf(",");if(iIndex>=0){str=this.sText.substring(iIndex+1);iQuizNo=parseInt(str)}sText=main.quiz_Manager.GetQuiz_Info(iInfo,iQuizNo).toString();break}iIndex=this.sText.indexOf("GetParam('");if(iIndex>=0){sText="";iIndex2=this.sText.indexOf("'",iIndex+10);if(iIndex2>=0){var sParam=this.sText.substring(iIndex+10,iIndex2);for(var keyStr in paramObj){if(keyStr==sParam){sText=String(paramObj[keyStr]);break}}}break}var Pattern;var sText2;var sSlideNo;var sTotalNo;var bFound=false;iIndex=sText.indexOf("SlideInfo(2)");if(iIndex>=0){sSlideNo=main.GetCurrentSlideNo().toString();sText2=sText.replace("SlideInfo(2)",sSlideNo);sText=sText2;bFound=true}iIndex=sText.indexOf("SlideInfo(3)");if(iIndex>=0){sTotalNo=main.GetSlideCount().toString();sText2=sText.replace("SlideInfo(3)",sTotalNo);sText=sText2;bFound=true}if(bFound){try{sText=eval(sText.replace(/Str/gi,"")).toString()}catch(e){}if(sText==null){iSlideNo=main.GetCurrentSlideNo();iTotalNo=main.GetSlideCount();sText=iSlideNo.toString()+" / "+iTotalNo.toString()}}break}}var iWidth=Number(this.edgeFormat.size);var iInnerSize=Number(this.edgeFormat.indent);var backColor=Number(this.format.rightMargin);var rect=this.rect.clone();shape=new Shape(rect.x,rect.y,rect.width,rect.height);if(backColor!=-1){CUIComponentFactory.fillRectangle(shape,0,0,rect.width,rect.height,backColor)}var rc=new Rectangle(0,0,rect.width,rect.height);rc.inflate(-iInnerSize,-iInnerSize);CUIComponentFactory.Text(shape,sText,rc,this.format);if(this.edgeFormat.size){if(this.edgeFormat.blockIndent==0){var nWidth=iWidth/2;rect.inflate(-nWidth,-nWidth);rect.offset(-iWidth,-iWidth);var xShape=new Shape(rect.x,rect.y,rect.width,rect.height);xShape.graphics.drawImage(shape.divCanvas,0,0);CUIComponentFactory.DrawRectangle3(xShape,this.edgeFormat.size,this.edgeFormat.color);shape=xShape}else{if(Viewer.isIE){CUIComponentFactory.DrawRectangle3(shape,1,this.edgeFormat.color,"dashed")}else{CUIComponentFactory.DrawRectangle4(shape,1,this.edgeFormat.color,this.edgeFormat.blockIndent)}}}main.Draw(shape);if(this.sID){shape.setID(this.sID)}if(this.disappear==1){var iButtonNo=main.GetFreeButtonNo(10000);main.AddBitmapCloseButton(shape,this.sID,iButtonNo,this.disappearGroupID);shape.addStyle("cursor","pointer");shape.addStyle("cursor","cursor");shape.addEvent("onclick","main.RemoveBitmapClose(this, "+iButtonNo+", "+this.disappearGroupID+")")}if(this.sHyperLink.length>0){shape.addHyperLink(this.sHyperLink,this.sHyperLinkToolTip)}if(this.sEffectMacro.length>0){if(this.EM.IsAnimation()){if(!this.sID){shape.setID("E"+shape.zIndex)}var aniPack=new AnimationPackage(shape.divShape);aniPack.setmacro(this.sEffectMacro.split(","));aniPack.setcontainer();aniPack.start()}}};return EDIT});