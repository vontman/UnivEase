define("Graphics",function(){function a(b){this.divCtx2d=b}a.prototype={divCtx2d:null,bFill:false,globalAlpha:function(b){this.divCtx2d.globalAlpha=b},padLeft:function(b,e,d){while(b.length<e){b=d+b}return b},toStyle:function(b){if(b==NaN){return b}return"#"+this.padLeft(b.toString(16),6,"0")},setLineDash:function(b){if(typeof this.divCtx2d.setLineDash!="undefined"){this.divCtx2d.setLineDash(b)}if(typeof this.divCtx2d.mozDash!="undefined"){this.divCtx2d.mozDash=b}if(typeof this.divCtx2d.webkitLineDash!="undefined"){this.divCtx2d.webkitLineDash=b}},lineStyle:function(b,d,c){this.divCtx2d.lineCap="round";this.divCtx2d.lineJoin="round";if(c==1){this.divCtx2d.lineCap="butt";this.divCtx2d.lineJoin="miter"}this.divCtx2d.lineWidth=b==0?0.001:b;this.divCtx2d.strokeStyle=this.toStyle(d)},beginFill:function(b){this.divCtx2d.fillStyle=this.toStyle(b);this.bFill=true},beginGradientFill:function(){},drawImage:function(e,c,f,d,b){if(d==undefined){d=e.width}if(b==undefined){b=e.height}if(e.width||e.naturalWidth){this.divCtx2d.drawImage(e,c,f,d,b)}},drawRotateImage:function(f,c,g,d,b,e){if(d==undefined){d=f.width}if(b==undefined){b=f.height}this.divCtx2d.save();this.divCtx2d.translate(this.divCtx2d.canvas.width/2,this.divCtx2d.canvas.height/2);this.divCtx2d.save();this.divCtx2d.rotate(e);this.divCtx2d.drawImage(f,-d/2,-b/2,d,b)},drawRect:function(c,e,d,b){this.divCtx2d.strokeRect(c,e,d,b)},fillRect:function(c,e,d,b){this.divCtx2d.fillRect(c,e,d,b)},drawRoundRect:function(b,f,c,d,e){e=e/2;this.divCtx2d.beginPath();this.divCtx2d.moveTo(b+e,f);this.divCtx2d.lineTo(b+c-e,f);this.divCtx2d.quadraticCurveTo(b+c,f,b+c,f+e);this.divCtx2d.lineTo(b+c,f+d-e);this.divCtx2d.quadraticCurveTo(b+c,f+d,b+c-e,f+d);this.divCtx2d.lineTo(b+e,f+d);this.divCtx2d.quadraticCurveTo(b,f+d,b,f+d-e);this.divCtx2d.lineTo(b,f+e);this.divCtx2d.quadraticCurveTo(b,f,b+e,f);this.divCtx2d.closePath();if(this.bFill){this.divCtx2d.fill()}this.divCtx2d.stroke();this.bFill=false},drawEllipse:function(k,j,l,e){var i=0.5522848;var d=(l/2)*i;var b=(e/2)*i;var m=k+l;var g=j+e;var f=k+(l/2);var c=j+(e/2);this.divCtx2d.beginPath();this.divCtx2d.moveTo(k,c);this.divCtx2d.bezierCurveTo(k,c-b,f-d,j,f,j);this.divCtx2d.bezierCurveTo(f+d,j,m,c-b,m,c);this.divCtx2d.bezierCurveTo(m,c+b,f+d,g,f,g);this.divCtx2d.bezierCurveTo(f-d,g,k,c+b,k,c);this.divCtx2d.closePath();if(this.bFill){this.divCtx2d.fill()}this.divCtx2d.stroke()},endFill:function(){this.divCtx2d.fill()},lineTo:function(b,c){this.divCtx2d.lineTo(b,c)},dashedLineTo:function(c,f,b,e,d){this.divCtx2d.dashedLineTo(c,f,b,e,d)},moveTo:function(b,c){this.divCtx2d.moveTo(b,c)},curveTo:function(d,c,b,e){this.divCtx2d.quadraticCurveTo(d,c,b,e)},closePath:function(){this.divCtx2d.closePath()},beginPath:function(){this.divCtx2d.beginPath()},stroke:function(){this.divCtx2d.stroke()},draw:function(){if(this.bFill){this.divCtx2d.fill()}this.divCtx2d.stroke()},drawText:function(g,p){var n="";if(g.italic){n+="italic "}if(g.bold){n+="bold "}this.divCtx2d.strokeStyle=this.toStyle(g.color);this.divCtx2d.fillStyle=this.toStyle(g.color);this.divCtx2d.font=n+g.size+"px "+g.font;this.divCtx2d.textBaseline="top";this.divCtx2d.textAlign=g.align;var q,m;var o=g.textHeight;var e=g.leading||0;var r=this.getTextLines(g.text,p.GetWidth());if(g.wordWrap==false&&(r.length>1)){if(p.height<(o*r.length)){for(var h=r.length-1;h>=0;h--){if(p.height<(o*r.length)){if(r[h]==""){r.splice(h,1)}}}}}switch(g.align){default:case"left":q=0;break;case"right":q=p.GetWidth();break;case"center":q=p.GetWidth()/2;break}var l=parseInt(o/8);var k=0;for(var h=0;h<r.length-1;h++){k=r[h]==""?k+l:!this.IsBreakWord(r[h])?k+l:!this.IsZenkakuWord(r[h])?k+l:k;if(h in r.newLine){k+=2}}switch(g.target){default:case"top":m=0;break;case"bottom":m=p.GetHeight()-o*(r.length)-e*r.length-k;break;case"center":if(r.length==1){m=p.GetHeight()/2-o/2}else{if(r.length>1){m=p.GetHeight()/2-((o+e)*(r.length)+k)/2}}break}if(Viewer.isIE||Viewer.isIOS){m+=1}for(var h=0;h<r.length;h++){var j=0;var f=r[h]==""?l:!this.IsBreakWord(r[h])?l:!this.IsZenkakuWord(r[h])?l:0;if(h in r.newLine){f+=2}var b=h==0?m+e/2:b+e+f+o;if(g.bullet>0){this.divCtx2d.strokeText(r[h],q,b)}else{this.divCtx2d.fillText(r[h],q,b)}if(g.underline){var d=q;var c=b+(o);if(g.align=="center"){d=d-this.divCtx2d.measureText(r[h]).width/2}else{if(g.align=="right"){d=d-this.divCtx2d.measureText(r[h]).width}}this.divCtx2d.lineWidth=g.size/16;this.divCtx2d.moveTo(d,Math.ceil(c+this.divCtx2d.lineWidth)+0.5);this.divCtx2d.lineTo(d+this.divCtx2d.measureText(r[h]).width,Math.ceil(c+this.divCtx2d.lineWidth)+0.5);this.divCtx2d.stroke()}}},getTextLines:function(h,p,n){h=h||"";var b=new Array();b.newLine=new Array();var d=h.split(/\r\n|\r|\n/);for(var t=0;t<d.length;t++){var l=d[t];if(this.divCtx2d.measureText(l).width>p){var e="";var v="";var x=l.split(/\s/);var w="";var u="";for(var s=0;s<x.length;s++){if(this.IsBreakWord(x[s])){for(var r=0;r<x[s].length;r++){var z=s!=0&&r==0?" "+x[s].charAt(r):x[s].charAt(r);if(this.divCtx2d.measureText(u+e+v+z).width<=p){if(this.IsBreakCharactor(x[s].charAt(r))||this.IsZenkakuCharactor(x[s].charCodeAt(r))){if(v){e+=v}v="";e=(s!=0&&r==0)?e+" "+x[s].charAt(r):e+x[s].charAt(r)}else{v=(s!=0&&r==0)?v+" "+x[s].charAt(r):v+x[s].charAt(r)}}else{if(v){if(this.IsBreakCharactor(x[s].charAt(r))==false){b.push(e);v=v.ltrim();e=v+x[s].charAt(r)}else{b.push(e+v);e=x[s].charAt(r)}v=""}else{if(this.IsNoStartCharactor(x[s].charAt(r))){var f=e.charAt(e.length-1);b.push(e.substring(0,e.length-1));e=f+x[s].charAt(r)}else{b.push(e);e=x[s].charAt(r)}}if(Viewer.isChrome){u=z.match(/\s/g)?" ":""}}}if(v){e+=v}v=""}else{var o=s==0?x[s]:" "+x[s];var y=this.IsConnectWord(o);if(y){var g=o.split(y);for(var q=0;q<g.length;q++){var c=(q<g.length-1)?g[q]+y:g[q];if(this.divCtx2d.measureText(w+e+c).width<=p){e=(t==0&&s==0)?e+c:s==0?c.ltrim():e+c}else{b.push(e);e=c.ltrim();if(Viewer.isChrome){w=c.match(/\s/g)?" ":""}}}}else{if(this.divCtx2d.measureText(w+e+o).width<=p){e=s==0?x[s]:e+" "+x[s]}else{b.push(e);e=x[s];if(Viewer.isChrome){w=o.match(/\s/g)?" ":""}}}}}if(v){e+=v}v="";b.push(e)}else{b.push(l)}if(t<d.length-1){b.newLine.push(b.length-1)}}return b},IsZenkakuWord:function(c){for(var b=0;b<c.length;b++){if(c.charAt(b)&&!this.IsZenkakuCharactor(c.charAt(b))){return false}}return true},IsZenkakuCharactor:function(b){return !(b<256||(b>=65377&&b<=65439))},IsBreakWord:function(c){for(var b=0;b<c.length;b++){if(this.IsBreakCharactor(c.charAt(b))){return true}}return false},IsBreakCharactor:function(j){var g=j.match(/[\u1100-\u11ff\u3130-\u318f\uac00-\ud7af]/g);if(g){return true}var f=j.match(/[\u2e80-\u2eff\u31c0-\u31ef\u3200-\u3eff\u3400-\u4dbf\u4e00-\u9fbf\uf900-\ufaff]/g);if(f){return true}var k=j.match(/[\u3040-\u30ff\u31f0-\u31ff]/g);if(k){return true}var i=j.match(/[\u3000-\u303f]/g);if(i){return true}var h=j.match(/[\u25a0-\u25ff]/g);if(h){return true}return false},IsConnectWord:function(c){for(var b=0;b<c.length;b++){if(this.IsConnectCharactor(c.charAt(b))){return this.IsConnectCharactor(c.charAt(b))}}return null},IsConnectCharactor:function(b){return b.match(/[\u002d]/g)},IsNoStartCharactor:function(b){return b.match(/[\u3001\u3002\u3009\u300b\u300d\u300f\u3011\u3015\u3017\u3019\u301b\u301e]/g)},IsNoEndCharactor:function(b){return b.match(/[\u3008\u300a\u300c\u300e\u3010\u3014\u3016\u3018\u301a\u301d]/g)},clearRect:function(c,e,d,b){if(Viewer.isAnApp){this.divCtx2d.canvas.width=0;this.divCtx2d.canvas.width=d}else{this.divCtx2d.clearRect(c,e,d,b)}}};return a});