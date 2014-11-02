define("CEBoardProgress",function(){function a(b){this.object=document.getElementById(b);this.object.me=this;this.objectText=document.getElementById(b+"Text");this.objectStick=document.getElementById(b+"Stick");this.callback=null;this.width=201;this.height=8;this.x=0;this.y=this.object.height/2-this.height/2;this.maximum=100;this.grade=1}a.prototype={init:function(c,b){this.addEventListener();this.callback=c;this.setPos(b)},addEventListener:function(){this.onclickCanvas.me=this;this.object.addEventListener("click",this.onclickCanvas)},onclickCanvas:function(c){var b=this.me.isValidClick(c);if(b==1){if(this.me.callback){var d=this.me.getPos(c);if(this.me.maximum<d){return}this.me.callback(d);this.me.setPos(d);if(this.me&&this.me.me&&this.me.me.eboardInfo&&this.me.me.eboardInfo.iPlayStatus==2){this.me.me.eboardInfo.UpdateTime()}}}},isValidClick:function(b){if(b.target.id==this.object.id||b.target.parentElement.id==this.object.id){return 1}return 0},setMaxTime:function(b){this.setMax(b/1000)},setMax:function(b){this.maximum=b;this.grade=200/this.maximum},setPosTime:function(b){this.setPos(b/1000);this.drawTime(b)},setPos:function(b){if(b&&b>0){b=b*this.grade;this.objectStick.style.width=b+"px"}},getPos:function(b){var c=(b.clientX-b.target.offsetLeft-this.findPosX(eBoardControlPanel)-1-1);c=c/this.grade;return c},findPosX:function(b){var c=0;if(b.offsetParent){while(b.offsetParent){c+=b.offsetLeft;b=b.offsetParent}}else{if(b.x){c+=b.x}}return c},drawTime:function(c){var b=this.ms2hhmmss(c/1000)+" / "+this.ms2hhmmss(this.maximum);this.drawMsg(b)},drawMsg:function(b){this.objectText.innerHTML=b},ms2hhmmss:function(c){var j;var g,b,f;var e="",i="",d="";g=parseInt(c/3600);b=parseInt((c%3600)/60);f=parseInt((c%3600)%60);if(!g){if(b<10){i="0"}i+=b.toString();if(f<10){d="0"}d+=f.toString();j=i+":"+d}else{if(g<10){e="0"}e+=g.toString();if(b<10){i="0"}i+=b.toString();if(f<10){d="0"}d+=f.toString();j=e+":"+i+":"+d}return j}};return a});