define("CBitmapInfo",function(){function a(f,c,d,b,e){this.sID=b;this.iID=f;this.rectangle=c;this.bitmapData=d;this.sComandID=e||""}a.prototype={Rect:function(){return this.rectangle},GetCommandID:function(){return this.sComandID},GetID:function(){return this.iID},GetSID:function(){return this.sID},GetBitmapData:function(){return this.bitmapData}};return a});