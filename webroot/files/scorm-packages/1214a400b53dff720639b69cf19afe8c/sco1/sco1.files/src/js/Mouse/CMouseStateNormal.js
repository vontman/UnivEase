define("CMouseStateNormal",["EMouseState","CMouseEventUtil"],function(b,c){function a(){this.buttonInfoOver=null}a.prototype={buttonInfoOver:null,GetButtonInfoOver:function(){return this.buttonInfoOver},SetButtonInfoOver:function(f,d){if(this.buttonInfoOver==f){return}if(null!=this.buttonInfoOver){this.buttonInfoOver.DrawOut();this.buttonInfoOver._Action(2)}this.buttonInfoOver=f;var e=document.getElementById("EBoard");if(null!=this.buttonInfoOver){this.buttonInfoOver.DrawOver();this.buttonInfoOver._Action(0);if(e){e.style.cursor="pointer";e.style.cursor="hand"}}else{if(e){e.style.cursor=""}}},OnMouseMove:function(f,d){var e=this.FindButton(f,d);this.SetButtonInfoOver(e,main)},OnMouseDown:function(k,e){var i=this.FindButton(k,e);if(null==i){return null}if(k.target.tagName!="INPUT"){var h=k.target.className;var f=k.target.parentElement.className;var j=h.indexOf("Choiced")==-1||f.indexOf("Choiced")==-1;var g=h.indexOf("ChoiceBody")==-1&&h.indexOf("ChoiceSymbol")==-1;var d=f.indexOf("ChoiceBody")==-1&&f.indexOf("ChoiceSymbol")==-1;if(g&&d&&!j){i.DrawButton(2)}}return i.GetRectangle()},OnMouseUp:function(d,h){var e=this.FindButton(d,h);if(null==e){return null}if(e.DrawOver){if(d.target.tagName!="INPUT"){var f=d.target.tagName;var j=d.target.className;var i=d.target.parentElement.className;if(i.indexOf("ChoiceBody")==-1&&e.nQuizInfoIndex==-1){e.DrawOver()}var g=f=="DIV"&&j.indexOf("ChoiceSymbol")>-1;var l=i.indexOf("ChoiceBody")>-1;var k=null;if(g){k=window.buttons[d.target.getAttribute("iBitmapID")]}if(l){k=window.buttons[d.target.parentElement.getAttribute("iBitmapID")]}if(k){k.click()}}}return e.GetRectangle()},OnMouseClick:function(f,d){var e=this.FindButton(f,d);if(null!=e){e.Action();return}if(main.CanContinueWithMouse()){if(Viewer.isAndroid||Viewer.isIOS){if(main.bPaused){main.bPaused=false;main.Continue()}}else{main.Continue()}}},SlideStart:function(){this.buttonInfoOver=null},FindButton:function(d,k){if(d==undefined){return null}var p=c.GetPointLocal(d);var g;var n=null;if(d.target.className=="content"||(d.target.tagName=="INPUT")){var m=d.target.className;var l=d.target.parentElement.className;var o=m.indexOf("ChoiceBody")==-1&&m.indexOf("ChoiceSymbol")==-1;var e=l.indexOf("ChoiceBody")==-1&&l.indexOf("ChoiceSymbol")==-1;if(o||e){var j=d.target.parentElement;n=j.getAttribute("iButtonNo")||-1;var h=k.length-1;for(;h>=0;h--){var f=k[h];if(n&&f.iButtonNo==n){return f}if(f.Contains(p)){return f}}}}return null}};return a});