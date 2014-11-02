var bFinished = false;

function doInit()
{
  doInitialize();

  var total_time = doGetValue("cmi.total_time");

  setStartTime();

  var entry=doGetValue("cmi.entry");
  var learner_id = doGetValue("cmi.learner_id");
  if (entry == "ab-initio")
  {
    //doSetValue("cmi.location", 0);
  }

  var threshold = doGetValue("cmi.completion_threshold");
  var progress = doGetValue("cmi.progress_measure");
  var status = doGetValue("cmi.completion_status");

  if (status == "not attempted")
  {
    LMSSetValue( "cmi.completion_status", "incomplete" );
  }

  checkGotoBookMark()
}

function checkGotoBookMark()
{
  try
  {
    if (!!window.checkload)
      clearTimeout(window.checkload);
   document.LectureMaker.eval("");
   gotoBookMark();
  }
  catch(ex)
  {
    window.checkload = setTimeout(checkGotoBookMark, 100);
  }
}

function doQuit()
{
  if (bFinished)
    return;
  bFinished = true;

  setBookMark();
  sendScore();

  var studyTime = getStudyTime();
  doSetValue("cmi.session_time", studyTime);

  doSetValue("cmi.exit", "suspend");

  doCommit();
  doTerminate();
}

function sendScore()
{
  try
  {
    var TotalPage;
    var MaxPage;
    var VisitPage;
    var Progress;
    TotalPage = document.LectureMaker.eval("SlideInfo(3)");
    MaxPage = document.LectureMaker.eval("SlideInfo(4)");
    VisitPage = document.LectureMaker.eval("SlideInfo(10)");
    Progress = document.LectureMaker.eval("SlideInfo(14)"); // 0 ~ 1
    if (parseInt(TotalPage) > 0)
    {
      if (parseFloat(Progress) == 1)
        doSetValue("cmi.completion_status", "completed");
      doSetValue("cmi.progress_measure", Progress);

      var min = 0;
      var max = document.LectureMaker.eval("QuizInfo(6)");
      var raw = document.LectureMaker.eval("QuizInfo(7)");
      var scaled = 0;
      var status;

      if (parseInt(max) > 0)
      {
        scaled = parseInt(raw)/parseInt(max);
        doSetValue("cmi.score.min", min);
        doSetValue("cmi.score.max", max);
        doSetValue("cmi.score.raw", raw);
        doSetValue("cmi.score.scaled", scaled);
      }
      if (parseInt(max) == 0)
        status = "unknown";
      else
      if (scaled >= scaledPassingScore)
        status = "passed";
      else
        status = "failed";
      doSetValue("cmi.success_status", status);
    }
  }
  catch(ex)
  {
  }
}

function setBookMark()
{
  try
  {
    var LastPage;
    var TotalPage;
    var LastVideoTime;
    var MaxVideoTime;
    var VisitPage;
    var QuizResult;
    LastPage = document.LectureMaker.eval("SlideInfo(2)");
    TotalPage = document.LectureMaker.eval("SlideInfo(3)");
    LastVideoTime = document.LectureMaker.eval("VideoInfo(,13)");
    MaxVideoTime = document.LectureMaker.eval("VideoInfo(,8)");
    VisitPage = document.LectureMaker.eval("SlideInfo(12)"); // 10101...
    QuizResult = document.LectureMaker.eval("QuizInfo(17)"); // 10-...

    if (parseInt(TotalPage) > 0)
    {
      doSetValue("cmi.location", LastPage+"");
      doSetValue("cmi.suspend_data", LastVideoTime+","+MaxVideoTime+","+VisitPage+","+QuizResult);
    }
  }
  catch(ex)
  {
  }
}

function gotoBookMark()
{
  var page = doGetValue("cmi.location");
  if (parseInt(page) > 0)
  {
    var SuspendData = doGetValue("cmi.suspend_data");  // LastVideoTime, MaxVideoTime, VisitPage, QuizResult
    var index = SuspendData.indexOf(",");
    var LastVideoTime = SuspendData.substring(0, index);
    var index2 = SuspendData.indexOf(",",index+1);
    var MaxVideoTime = SuspendData.substring(index+1, index2);
    var index3 = SuspendData.indexOf(",",index2+1);
    var VisitPage = SuspendData.substring(index2+1, index3);
    var QuizResult = SuspendData.substring(index3+1, SuspendData.length);
    VisitPage = "\"" + VisitPage + "\"";
    QuizResult = "\"" + QuizResult + "\"";
    document.LectureMaker.eval("SlideInfo(13,"+VisitPage+")");
    document.LectureMaker.eval("QuizInfo(18,,,"+QuizResult+")");
    if (parseFloat(MaxVideoTime) > 0)
      document.LectureMaker.exec("VIDEO ,8,,,,,,,,"+MaxVideoTime);

    if (confirm("Do you wish to continue from where you have stopped?"))
    {
      if (parseFloat(LastVideoTime) > 0)
        document.LectureMaker.exec("VIDEO ,8,,,,,,"+LastVideoTime+",,"+MaxVideoTime);
      document.LectureMaker.exec("GOTO "+page+",6");
    }
  }
}

var startTime;

function setStartTime()
{
  startTime = new Date().getTime();
}

function getStudyTime()
{
  var currentTime = new Date().getTime();
  if (startTime == 0)
    startTime = currentTime;

  return sec2HMS(((currentTime - startTime)/1000));
}

function sec2HMS(sec)
{
  var h, m, s;
  h = Math.floor(sec/3600);
  m = Math.floor((sec%3600)/60);
  s = Math.floor((sec%3600)%60);

  return "PT" + h + "H" + m + "M" + s + "S";
}
