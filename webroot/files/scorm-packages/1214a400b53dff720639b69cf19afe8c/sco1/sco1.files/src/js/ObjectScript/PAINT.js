define("PAINT",["CScript"],function(a){function b(j,h,e,f,k,g,i,c,d){this.x=j;this.y=h;this.PaintColor=e;this.BoundColor=f;this.PatternNum=k;this.BkColor=g;this.Rops=i||0;this.iInTime=c||-1;this.iOutTime=d||Number.MAX_VALUE}b.prototype=new a();b.prototype.Run=function(c){c=c||false};return b});