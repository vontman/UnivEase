define("WINDOW",["CScript"],function(a){function b(f,h,e,g,d,i,c){this.iX1=f;this.iY1=h;this.iX2=e;this.iY2=g;this.iWindowStyle=d||0;this.iInTime=i||-1;this.iOutTime=c||Number.MAX_VALUE}b.prototype=new a();b.prototype.Run=function(c){c=c||false};return b});