define("CEBoardActionElectronicBoardRectangle",["CEBoardActionElectronicBoard"],function(a){function b(f,c,d,h,g,e){a.call(this,f,c,d,h);this.rectType=g;this.rectangle=e}b.prototype=new a();b.prototype.Act=function(e,d){var c=null;switch(this.rectType){case ERectType.Ellipse:case ERectType.EllipseBright:c=CUIComponentFactory.FillEllipse(this.rectangle,0,this.uColor,this.rectType==ERectType.EllipseBright?0.5:1);break;case ERectType.Line:case ERectType.LineBright:c=CUIComponentFactory.DrawLine(this.rectangle,this.iLineWidth,this.uColor,this.rectType==ERectType.LineBright?0.5:1);break;case ERectType.Rect:case ERectType.RectBright:c=CUIComponentFactory.FillRectangle2(this.rectangle,0,this.uColor,this.rectType==ERectType.RectBright?0.5:1);break}if(c){c.divShape.className=(c.divShape.className==undefined)?"EBoardItem":c.divShape.className+" EBoardItem";main.DrawEBoardItem(c,d.sID)}CAssertUtil.Failed()};return b});