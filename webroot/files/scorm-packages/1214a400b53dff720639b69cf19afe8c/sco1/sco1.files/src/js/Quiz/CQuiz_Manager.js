define("CQuiz_Manager",["CScript","BitmapAsset","Rectangle","CQuiz_Info"],function(a,e,c,b){function d(){this.arrayQuiz_Info=[]}d.prototype={arrayQuiz_Info:null,main:null,AddQuiz:function(h,k,i,j,f){var g=new b(h,k,i,j,f);this.arrayQuiz_Info.push(g);return g},FindQuiz_Info:function(h){for(var g=0;g<this.arrayQuiz_Info.length;g++){var f=this.arrayQuiz_Info[g];if(f.GetQuizNo()==h){return f}}return null},DeleteQuiz_Info:function(g){for(var f=0;f<this.arrayQuiz_Info.length;f++){if(this.arrayQuiz_Info[f].GetQuizNo()==g){this.arrayQuiz_Info.splice(0,1)}}},GetQuiz_Info:function(k,n,p,r){n=n||1;p=p||null;r=r||"";var l;var g;var o;var q;var v=Viewer.QuizTotalCount;var f=Viewer.QuizTotalPoint;var s=this.arrayQuiz_Info.length;var h=0;var m=0;var u=0;var t="";for(l=0;l<s;l++){o=this.arrayQuiz_Info[l];for(g=0;g<main.quizNumber.length;g++){if(main.quizNumber[g]==o.QuizNumber){switch(o.GetPassed()){case 1:main.quizResult[g]="1";break;case 0:main.quizResult[g]="0";break;case -1:main.quizResult[g]="-";break}break}}}for(l=0;l<main.quizResult.length;l++){o=this.arrayQuiz_Info[l];if(main.quizResult[l]!="-"){h++}if(main.quizResult[l]=="1"){m++;u+=main.quizPoint[l]}}switch(k){case 0:return String(v);case 1:return String(h);case 2:return String(v-h);case 3:return String(m);case 4:return String(v-m);case 5:return String(v>0?100*m/v:0);case 6:return String(f);case 7:return String(u);case 8:return String(f-u);case 9:return String(u.toString()+" / "+f.toString());case 10:case 11:case 12:q=((0<n)&&(n<=s))?this.arrayQuiz_Info[n-1]:null;if(q){if(k==10){return String(q.Point)}if(k==11){return q.GetPassed()==1?"1":"0"}return q.GetPassed()==1?"O":"X"}case 17:for(var l=0;l<main.quizResult.length;l++){switch(main.quizResult[l]){case"1":t+="1";break;case"0":t+="0";break;case"-":t+="-";break}}return t;case 18:for(var l=0;l<r.length;l++){if(l<main.quizResult.length){switch(r.charAt(l)){case"0":main.quizResult[l]="0";break;case"1":main.quizResult[l]="1";break;case"-":main.quizResult[l]="-";break}for(g=0;g<s;g++){o=this.arrayQuiz_Info[g];if(main.quizNumber[l]==o.QuizNumber){switch(r.charAt(l)){case"0":o.SetPassed(0);break;case"1":o.SetPassed(1);break;case"-":o.SetPassed(-1);break}break}}}}return""}return""}};return d});