define("CQuiz_Info",["CScript","BitmapAsset","Rectangle"],function(a,d,c){function b(f,i,g,h,e){this.strID=f;this.QuizNo=i;this.Point=g||1;this.nPassed=-1;this.Retry=h||1;this.QuizNumber=e||-1}b.prototype={GetQuizNo:function(){return this.QuizNo},GetQuizNumber:function(){return this.QuizNumber},SetQuizNumber:function(e){this.QuizNumber=e},GetPoint:function(){return this.Point},GetPassed:function(){return this.nPassed},GetRetry:function(){return this.Retry},SetPassed:function(e){this.nPassed=e}};return b});