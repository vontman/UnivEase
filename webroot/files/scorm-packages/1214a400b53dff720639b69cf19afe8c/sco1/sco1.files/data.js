require(["CScript", "ARC", "ARROW", "BOARD", "BROWSER", "BUTTONDRAW", "BUTTONOFF", "BUTTONON", "BUTTONSET", "CALL", "CELLBOX", "CIRCLE", "CONTROLOFF", "CLS", "CURVE",
	"DBOX", "DSHAPE", "EBOARD", "EDIT", "ENDSUB", "EVENTFIRE", "EWINDOW", "FRAMEDRAW", "GET", "GOTO", "HEXAD", "LINE", "MENUBUTTON", "MESSAGEBOX", "NAVIBUTTON",
	"PAINT", "PAUSE", "POLYGON", "PUT", "QUIZ_OBJECTIVE", "QUIZ_SUBJECTIVE", "QUIZRESULT", "SLIDEEND", "SLIDENUMBER", "SLIDESTART", "SOUND", "SUB",
	"TIMERSET", "TIMEROFF", "VIDEO", "VIDEOOPEN", "WINDOW", "XEDIT", "XVIEWER",
	"CMasterInfo", "BitmapAsset", "SoundAsset", "VideoAsset", "Point", "Rectangle", "CEBoardActionElectronicBoardClearScreen",
	"CEBoardActionElectronicBoardPoly", "CEBoardActionElectronicBoardRectangle", "CEBoardActionElectronicBoardText", "EPolyType", "ERectType"],
function (CScript, ARC, ARROW, BOARD, BROWSER, BUTTONDRAW, BUTTONOFF, BUTTONON, BUTTONSET, CALL, CELLBOX, CIRCLE, CONTROLOFF, CLS, CURVE,
	DBOX, DSHAPE, EBOARD, EDIT, ENDSUB, EVENTFIRE, EWINDOW, FRAMEDRAW, GET, GOTO, HEXAD, LINE, MENUBUTTON, MESSAGEBOX, NAVIBUTTON,
	PAINT, PAUSE, POLYGON, PUT, QUIZ_OBJECTIVE, QUIZ_SUBJECTIVE, QUIZRESULT, SLIDEEND, SLIDENUMBER, SLIDESTART, SOUND, SUB,
	TIMERSET, TIMEROFF, VIDEO, VIDEOOPEN, WINDOW, XEDIT, XVIEWER,
	CMasterInfo, BitmapAsset, SoundAsset, VideoAsset, Point, Rectangle, CEBoardActionElectronicBoardClearScreen,
	CEBoardActionElectronicBoardPoly, CEBoardActionElectronicBoardRectangle, CEBoardActionElectronicBoardText, EPolyType, ERectType) {

	// Language
	Viewer.LangID = 1;

	// Global Variables
	Viewer.SlideWidth = 990;
	Viewer.SlideHeight = 660;
	Viewer.bRTL = false;
	Viewer.QuizTotalCount = 0;
	Viewer.QuizTotalPoint = 0;
	Viewer.arrayDomains = [/* AllowDomain */];
	Viewer.bWaterMark = true;

	// Resources
	Viewer.res1 = new VideoAsset("Resources/Final!20Video!201!20(2)wmv.mp4");


	// Basic Resources
	Viewer._CheckBlue_ = new BitmapAsset("Resources/base/_CheckBlue_.png");
	Viewer._CheckRed_ = new BitmapAsset("Resources/base/_CheckRed_.png");
	Viewer._SoundOn_ = new BitmapAsset("Resources/base/_soundon_.png");
	Viewer._SoundOff_ = new BitmapAsset("Resources/base/_soundoff_.png");
	Viewer._WaterMark_ = new BitmapAsset("Resources/base/_watermark_.png");
	Viewer._Pen_ = new BitmapAsset("Resources/base/_Pen_.png");
	Viewer._EBoardPlay_ = new BitmapAsset("Resources/base/_Play_.png");
	Viewer._EBoardStop_ = new BitmapAsset("Resources/base/_Stop_.png");
	Viewer._EBoardPause_ = new BitmapAsset("Resources/base/_Pause_.png");



	// Subroutine Script
	function sub1() { }
	sub1.prototype = new CScript();
	sub1.prototype.Run = function () {
		this.arrayScripts = [
		];
	};

	function sub2() { }
	sub2.prototype = new CScript();
	sub2.prototype.Run = function () {
		this.arrayScripts = [
		];
	};



	// Slide Script
	Viewer.arrayScripts = [
new  MESSAGEBOX("Lecture Authoring Tool LectureMAKER\r\n\r\nMade by LectureMAKER Trial Version.\r\n\r\nDaulSoft Co., Ltd. (C)2005-2013.\r\n\r\nhttp://www.daulsoft.com"),
		new SLIDESTART("Slide1",0xffffff,null,"",-1,0,-1,-1,30,20,"",null,0,"sub1"),
		new  VIDEOOPEN("1",Viewer.res1,184,96,658,404,0,2,2),
		new SLIDEEND(),
	];

	// Master Array
	Viewer.arrayMasters = [
		new CMasterInfo("sub1", new sub1()),
		new CMasterInfo("sub2", new sub2()),
	];
});
