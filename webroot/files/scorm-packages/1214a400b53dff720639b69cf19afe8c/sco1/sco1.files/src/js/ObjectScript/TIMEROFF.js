define("TIMEROFF",["CScript"],function(a){function b(d,e,f,c){this.TimerNum=d||0;this.PauseStop=e||0;this.iInTime=f||-1;this.iOutTime=c||Number.MAX_VALUE;this.iSyncObject;this.iIndex;this.bRunSyncObject=false}b.prototype=new a();b.prototype.Run=function(c){c=c||false;this.iSyncObject=this.CheckSyncObject(c,"TIMEROFF","",this.iInTime,this.iOutTime);if(this.iScriptIndex>=0){this.iIndex=this.iScriptIndex}if(this.iSyncObject==-1){return}if(this.TimerNum<0||this.TimerNum>15){return}var d;d=main.timerArray[this.TimerNum];d.stop()};return b});