define("EMouseState",["CAssertUtil"],function(a){EMouseState={Normal:1,Drawing:2,NextState:function(b){switch(b){case this.Normal:return this.Drawing;case this.Drawing:return this.Normal}a.Failed();return this.Normal}};return EMouseState});