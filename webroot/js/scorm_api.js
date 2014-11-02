function iliasApi() {
/* Copyright (c) 1998-2010 ILIAS open source, Extended GPL, see docs/LICENSE */
/**
* @author  Uwe Kohnle <kohnle@internetlehrer-gmbh.de>
* @version $Id$
*/

var iv={},
    ir=[],
    data={},
    a_toStore=[],
    Initialized=false,
    b_launched=true,
    APIcallStartTimeMS,
    as_APIcalls=[];


/* XMLHHTP functions */
function sendRequest (url, data, callback, user, password, headers) {       

    function sendAndLoad(url, data, callback, user, password, headers) {
        function createHttpRequest() {
            try 
            {
                return window.XMLHttpRequest 
                    ? new window.XMLHttpRequest()
                    : new window.ActiveXObject('MSXML2.XMLHTTP');
            } 
            catch (e) 
            {
                throw new Error('cannot create XMLHttpRequest');
            }
        }
        function HttpResponse(xhttp) 
        {
            this.status = Number(xhttp.status);
            this.content = String(xhttp.responseText);
            this.type = String(xhttp.getResponseHeader('Content-Type'));
        }
        function onStateChange() 
        {
            if (xhttp.readyState === 4) { // COMPLETED
                if (typeof callback === 'function') {
                    callback(new HttpResponse(xhttp));
                } else {
                    return new HttpResponse(xhttp);
                } 
            }
        }       
        var xhttp = createHttpRequest();
        var async = !!callback;
        var post = !!data; 
        xhttp.open(post ? 'POST' : 'GET', url, async, user, password);
        if (typeof headers !== 'object') 
        {
            headers = new Object();
        }
        if (post) 
        {
            headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        if (headers && headers instanceof Object) 
        {
            for (var k in headers) {
                xhttp.setRequestHeader(k, headers[k]);
            }
        }
        if (async) 
        {
            xhttp.onreadystatechange = onStateChange;
//              xhttp.send(data ? String(data) : '');               
            xhttp.send(data);               
        } else 
        {
            xhttp.send(data ? String(data) : '');               
            return onStateChange();
        }
    }

    if (typeof headers !== "object") {headers = {};}
    headers['Accept'] = 'text/javascript';
    headers['Accept-Charset'] = 'UTF-8';
    var r = sendAndLoad(url, data, callback, user, password, headers);
    
    if (r.content) {
        if (r.content.indexOf("login.php")>-1) {
            window.location.href = "./Modules/Scorm2004/templates/default/session_timeout.html";
        }
    }
    
    if ((r.status===200 && (/^text\/javascript;?.*/i).test(r.type)) || r.status===0)
    {
        return r.content;
    }
    else
    {
        return r.content;
    }
}

// Debugger
function showCalls(APIcall,callResult,err,dia){
    if (iv.b_debug){
        if (err==null) err="";
        if (dia==null) dia="";
        if (err!=0 && err!="") dia=getErrorStringIntern(err)+'; '+dia; //only function not in basisAPI
        var APIcallNowMS=new Date().getTime(),
            APIms,
            APIs_out='<table cellpadding=0><tr class="d"><td class="r">ms</td><td>sent to API</td><td>returns</td><td class="c">error</td><td>error string; diagnostic</td></tr>';
        APIms=""+(APIcallNowMS-APIcallStartTimeMS);
        if(callResult!="") callResult='"'+callResult+'"';
        as_APIcalls.push('<tr><td class="r">'+APIms+'</td><td><div>'+APIcall+'</div></td><td><div>'+callResult+'</div></td><td class="c">'+err+'</td><td><div>'+dia+'</div></td></tr>');
        for(var i=as_APIcalls.length-1;i>=0;i--) APIs_out+=as_APIcalls[i];
        frames.logframe.document.getElementById("APIcalls").innerHTML=APIs_out+"</table>";
    }
}

function initDebug(){
    if (iv.b_debug==true){
        var href="";
        for(var i=0; i<ir.length; i++){
            if(ir[i][1]==iv.launchId) href=ir[i][3];
        }
        as_APIcalls.push('<tr class="d"><td colspan=5>SCO: '+decodeURIComponent(iv.dataDirectory+href)+' (Id: '+iv.launchId+')</td></tr>');
        APIcallStartTimeMS=new Date().getTime();
    }
}

// send to logfile
function message(s_send){
    s_send = 'lm_'+iv.objId+': '+s_send;
    if (iv.b_messageLog) sendRequest ('./ilias.php?baseClass=ilSAHSPresentationGUI&ref_id='+iv.refId+'&cmd=logMessage', s_send);
}

function warning(s_send){
    s_send = 'lm_'+iv.objId+': '+s_send;
    sendRequest ('./ilias.php?baseClass=ilSAHSPresentationGUI&ref_id='+iv.refId+'&cmd=logWarning', s_send);
}

// avoid sessionTimeOut
function SchedulePing() {
    var r = sendRequest('./ilias.php?baseClass=ilSAHSPresentationGUI&cmd=pingSession&ref_id='+iv.refId);
    setTimeout("API.SchedulePing()", iv.pingSession*1000);
}

// launch functions
function IliasLaunch(i_l){
    if (isNaN(i_l)) return false;
    var href="",asset=0;
    for (var i=0;i<ir.length;i++){
        if (ir[i][1]==iv.launchId){
            asset=ir[i][2];
        }
        if (ir[i][1]==i_l){
            iv.launchNr=ir[i][0];
            href=ir[i][3];
        }
    }
    if (href=="") return false;

    if (asset==1 || Initialized==false){
        if (asset==1) status4tree(iv.launchId,'asset');
        else status4tree(iv.launchId,getValueIntern(iv.launchId,'cmi.core.lesson_status'),getValueIntern(iv.launchId,'cmi.core.total_time'));
        b_launched=true;
        iv.launchId=i_l;
        if (href.substring(0,4)!="http") href=iv.dataDirectory+href;
        frames.sahs_content.document.location.replace(decodeURIComponent(href));
    }
    else {
        status4tree(iv.launchId,getValueIntern(iv.launchId,'cmi.core.lesson_status'),getValueIntern(iv.launchId,'cmi.core.total_time'));
        b_launched=false;
        setTimeout("API.IliasAbortSco("+iv.launchId+")",5000);
        iv.launchId=i_l;
        frames.sahs_content.document.location.replace('./Modules/ScormAicc/templates/default/dummy.html');
    }
    status4tree(iv.launchId,'running');
}

function launchNext(){
    if (iv.b_autoContinue == true){
        var i_l=0;
        for (var i=0;i<ir.length;i++){
            if (ir[i][0]==iv.launchNr && i<(ir.length-1)){
                i_l=ir[i+1][1];
            }
        }
        if (i_l>0) setTimeout("API.IliasLaunch("+i_l+")",500);
    }
}

function IliasWaitLaunch(i_l){
    if (typeof frames.sahs_content == "undefined") setTimeout("API.IliasWaitLaunch("+i_l+")",100);
    else {
        API.IliasLaunch(i_l);
        API.IliasWaitTree(i_l,0);
    }
}

function IliasWaitTree(i_l,i_counter) {
    if (i_counter<20){
        if (typeof frames.tree == "undefined" || typeof frames.tree.document.getElementsByName('scoIcon'+i_l)[0] == "undefined") 
            setTimeout("API.IliasWaitTree("+i_l+","+(i_counter+1)+")",100);
        else status4tree(i_l,'running');
    }
}

function IliasLaunchAfterFinish(i_la){
    status4tree(i_la,getValueIntern(i_la,'cmi.core.lesson_status'),getValueIntern(i_la,'cmi.core.total_time'));
    if(b_launched==false) setTimeout("API.IliasLaunch("+iv.launchId+")",1);
    else launchNext();
}

function IliasAbortSco(i_l){
    if (b_launched==true) return;
    warning('SCO '+i_l+' has not sent LMSFinish or Terminate');
    //a_toStore=[];
    Initialized=false;
    IliasLaunch(iv.launchId);
}

// status for navigation-tree
function status4tree(i_sco,s_status,s_time){
    if (typeof(frames.tree)!="undefined"){
        var ico=frames.tree.document.getElementsByName('scoIcon'+i_sco)[0];
        if(typeof(ico)!="undefined"){
            if(s_status==null || s_status=="not attempted") s_status="not_attempted";
            ico.src=decodeURIComponent(iv.img[s_status]);
            if (s_status!='asset'){
                var icotitle = iv.statusTxt.status+': '+iv.statusTxt[s_status];
                if (s_time!=null) icotitle+=' ('+s_time+')';
                ico.title = decodeURIComponent(icotitle);
            }
        }
    }
}

// store data
function IliasCommit() {
    if (a_toStore.length==0){
        message("Nothing to do.");
        return true;
    }
    var s_s="",a_tmp,s_v;
    for (var i=0; i<a_toStore.length; i++){
        a_tmp=a_toStore[i].split(';');
        s_v=getValueIntern(a_tmp[0],a_tmp[1],true); 
        if (s_v != null){
            s_s+="&S["+i+"]="+a_tmp[0]+"&L["+i+"]="+a_tmp[1]+"&R["+i+"]="+s_v;
        }
    }
    a_toStore=[];
    try {
        var ret=sendRequest ("./Modules/ScormAicc/sahs_server.php?cmd=storeJsApi&ref_id="+iv.refId, s_s);
        if (ret!="ok") return false;
        return true;
    } catch (e) {
        warning("Ilias cmi storage failed.");
    }
    return false;
}

// get data
function getValueIntern(i_sco,s_el,b_noDecode){
    var s_sco=""+i_sco,
        a_el=s_el.split('.');
    if (typeof data[s_sco] == "undefined") return null;
    var o_el=data[s_sco];
    for (var i=0;i<a_el.length;i++){
        o_el=o_el[""+a_el[i]];
        if (typeof o_el == "undefined") return null;
    }
    if(b_noDecode!=true) return decodeURIComponent(""+o_el);
    return ""+o_el;
}

// set data
function setValueIntern(i_sco,s_el,s_value,b_store,b_noEncode){
    //create data-elements
    var s_sco=""+i_sco,
        a_el = s_el.split('.');
    if (typeof data[s_sco] == "undefined") data[s_sco]=new Object();
    var o_el=data[s_sco];
    for (var i=0;i<a_el.length-1;i++){
        if (typeof o_el[a_el[i]] == "undefined") o_el[a_el[i]]=new Object();
        o_el=o_el[a_el[i]];
        if(!isNaN(a_el[i+1])) { //set check counter 
            if (typeof o_el['_count'] == "undefined") {
                o_el['_count']=new Number();
                o_el['_count']=0;
            }
            if(b_store){
                if (a_el[i+1] == o_el['_count']) o_el['_count']++;
                if (a_el[i+1] > o_el['_count']) return false;
            } else {
                if (a_el[i+1] >= o_el['_count']) o_el['_count']=a_el[i+1]+1;
            }
        }
    }
    var s2s=a_el[a_el.length-1];
    //store
    if (typeof o_el[s2s] == "undefined") o_el[s2s] = new String();
    if (b_noEncode!=true) s_value=encodeURIComponent(s_value);
    o_el[s2s]=s_value;
    if (b_store){
        for (var i=0;i<a_toStore.length;i++){
            if (a_toStore[i] == s_sco+';'+s_el) b_store=false;
        }
        if (b_store) a_toStore.push(s_sco+';'+s_el);
    }
    return true;
}

// done at start
function basisInit() {
    iv=IliasScormVars;
    ir=IliasScormResources;
    var s_w="";
    for (var i=0; i<IliasScormData.length; i++) {
        if (setValueIntern(IliasScormData[i][0],IliasScormData[i][1],IliasScormData[i][2],false,true) == false)
            s_w+='; sco_id:'+IliasScormData[i][0]+', element:'+IliasScormData[i][1];
    }
    if (s_w != "") warning('Failure read previous data:'+s_w.substr(1));
    
    try{
        delete IliasScormVars;
        delete IliasScormData;
        delete IliasScormResources;
    } catch (e) {
        IliasScormVars={};
        IliasScormData=[];
        IliasScormResources=[];
    }

    if (iv.pingSession>0) SchedulePing();
    if (iv.launchId!=0) IliasWaitLaunch(iv.launchId);
}

//done at end
function onWindowUnload () {
    var s_unload="";
    if (iv.b_autoLastVisited==true) s_unload="last_visited="+iv.launchId;
    sendRequest ("./Modules/ScormAicc/sahs_server.php?cmd=scorm12PlayerUnload&ref_id="+iv.refId, s_unload);
}

this.IliasLaunch=IliasLaunch;
this.IliasAbortSco=IliasAbortSco;
this.IliasWaitLaunch=IliasWaitLaunch;
this.IliasWaitTree=IliasWaitTree;
this.SchedulePing=SchedulePing;
basisInit();

if(window.addEventListener) window.addEventListener('unload',onWindowUnload);
else if(window.attachEvent) window.attachEvent('onunload',onWindowUnload);//IE<9
else window['onunload']=onWindowUnload;/* Copyright (c) 1998-2010 ILIAS open source, Extended GPL, see docs/LICENSE */
/**
* @author  Uwe Kohnle <kohnle@internetlehrer-gmbh.de>
* @version $Id$
*/

var errorCode=0,
    sco_id=0,
    diag='',
    entryAtInitialize='',
    totalTimeAtInitialize='',
    b_scoCredit=true;

// DataModel
// rx = regular Expression; ac = accessibility; dv = default value
var rx={
    CMIString255:   '^[\\u0000-\\uffff]{0,255}$',
    CMIString4096:  '^[\\u0000-\\uffff]{0,4096}$',
    CMIIdentifier:  '^[\\u0021-\\u007E]{0,255}$',
    CMIDecimal:     '^100(\\.0+)?$|^\\d?\\d(\\.\\d+)?$', //definition only for mastery_score and weighting
    DecimalOrBlank: '^100(\\.0+)?$|^\\d?\\d(\\.\\d+)?$|^$',
    CMITimespan:    '^([0-9]{2,4}):([0-9]{2}):([0-9]{2})(\.[0-9]{1,2})?$',
    CMITime:        '^([0-2]{1}[0-9]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})(\.[0-9]{1,2})?$'
    };

var model = {
        cmi:{
            _children:{
                ac: 'r',
                dv: 'core,suspend_data,launch_data,comments,objectives,student_data,student_preference,interactions'
            },
            core:{
                _children:{
                    ac: 'r',
                    dv: 'student_id,student_name,lesson_location,credit,lesson_status,entry,score,total_time,lesson_mode,exit,session_time'
                },
                credit:{
                    rx: '^(no-)?credit$',
                    ac: 'r', 
                    dv: 'no-credit'
                },
                entry:{
                    rx: '^ab-initio$|^resume$',
                    ac: 'r',
                    dv: 'ab-initio'
                },
                exit:{
                    rx: '^time-out$|^suspend$|^logout$|^$',
                    ac: 'w'
                },
                lesson_location:{
                    rx: rx.CMIString255,
                    ac: 'rw',
                    dv: ''
                },
                lesson_mode:{
                    rx: '^browse$|^normal$|^review$',// specs 3-31: "Right now there is no SCORM defined way to signify that learning content can be taken in dfferent modes. Implementation will therfore be LMS specific."
                    ac: 'r',
                    dv: 'browse'
                },
                lesson_status:{
                    rx: '^passed$|^failed$|^completed$|^incomplete$|^browsed$',
                    ac: 'rw',
                    dv: 'not attempted'
                },
                score:{
                    _children:{
                        ac: 'r',
                        dv: 'raw,min,max'
                    },
                    raw:{
                        rx: rx.DecimalOrBlank,
                        ac: 'rw',
                        dv: ''
                    },
                    min:{
                        rx: rx.DecimalOrBlank,
                        ac: 'rw',
                        dv: ''
                    },
                    max:{
                        rx: rx.DecimalOrBlank,
                        ac: 'rw',
                        dv: ''
                    }
                },
                session_time:{
                    rx: rx.CMITimespan,
                    ac: 'w'
                },
                student_id:{
                    type: rx.CMIIdentifier,
                    ac: 'r',
                    dv: ''
                },
                student_name:{
                    rx: rx.CMIString255,
                    ac: 'r',
                    dv: ''
                },
                student_login:{ //ILIAS specific
                    ac: 'r',
                    dv: ''
                },
                student_ou:{ //ILIAS specific
                    ac: 'r',
                    dv: ''
                },
                total_time:{
                    rx: rx.CMITimespan,
                    ac: 'r',
                    dv: "00:00:00"
                }
            },
            comments:{
                rx: rx.CMIString4096,
                ac: 'rw',
                dv: ''
            },
            comments_from_lms:{
                rx: rx.CMIString4096, 
                ac: 'r',
                dv: ''
            },
            interactions:{
                _children:{
                    ac: 'r',
                    dv: 'id,correct_responses,latency,student_response,objectives,result,time,type,weighting'
                },
                _count:{
                    ac: 'r',
                    dv: '0'
                },
                n:{
                    id:{
                        rx: rx.CMIIdentifier,
                        ac: 'w'
                    },
                    correct_responses:{
                        _count:{
                            ac: 'r',
                            dv: '0'
                        },
                        n:{
                            pattern:{
                                rx: rx.CMIString255,//could be done if interaction_type is set before 
                                ac: 'w'
                            }
                        }
                    },
                    latency:{
                        rx: rx.CMITimespan,
                        ac: 'w'
                    },
                    student_response:{
                        rx: rx.CMIString255,//no exact check possible if interaction_type is not set
                        ac: 'w'
                    },
                    objectives:{
                        _count:{
                            ac: 'r',
                            dv: '0'
                        },
                        n:{
                            id:{
                                rx: rx.CMIIdentifier,
                                ac: 'w'
                            }
                        }
                    },
                    result:{
                        rx: '^correct$|^wrong$|^unanticipated$|^neutral$|^-?\\d+(\\.\\d+)?$',//'^correct$|^wrong$|^unanticipated$|^neutral$|^([0-9]{0,3})?(\.[0-9]{1,2})?$',
                        ac: 'w'
                    },
                    time:{
                        rx: rx.CMITime,
                        ac: 'w'
                    },
                    type:{
                        rx: '^true-false$|^choice$|^fill-in$|^matching$|^performance$|^sequencing$|^likert$|^numeric$',
                        ac: 'w'
                    },
                    weighting:{
                        rx: rx.CMIDecimal,
                        ac: 'w'
                    }
                }
            },
            launch_data:{
                rx: rx.CMIString4096,
                ac: 'r',
                dv: ''
            },
            objectives:{
                _children:{
                    ac: 'r',
                    dv: 'id,score,status'
                },
                _count:{
                    ac: 'r',
                    dv: '0'
                },
                n:{
                    id:{
                        rx: rx.CMIIdentifier,
                        ac: 'rw'
                    },
                    score:{
                        _children:{
                            ac: 'r',
                            dv: 'raw,min,max'
                        },
                        raw:{
                            rx: rx.DecimalOrBlank,
                            ac: 'rw',
                            dv: ''
                        },
                        min:{
                            rx: rx.DecimalOrBlank,
                            ac: 'rw',
                            dv: ''
                        },
                        max:{
                            rx: rx.DecimalOrBlank,
                            ac: 'rw',
                            dv: ''
                        }
                    },
                    status:{
                        rx: '^passed$|^completed$|^failed$|^incomplete$|^browsed$|^not attempted$',
                        ac: 'rw',
                        dv: 'not attempted'
                    }
                }
            },
            student_data:{
                _children:{
                    ac: 'r',
                    dv: 'mastery_score,max_time_allowed,time_limit_action'
                },
                mastery_score:{
                    rx: rx.CMIDecimal,
                    ac: 'r',
                    dv: ''
                },
                max_time_allowed:{
                    rx: rx.CMITimespan,
                    ac: 'r',
                    dv: ''
                },
                time_limit_action:{
                    rx: '^exit,message$|^exit,no message$|^continue,message$|^continue,no message$',
                    ac: 'r',
                    dv: 'continue,no message'
                }
            },
            student_preference:{
                _children:{
                    ac: 'r',
                    dv: 'audio,language,speed,text'
                },
                audio:{
                    rx: '^-1$|^100$|^\\d?\\d$',
                    ac: 'rw',
                    dv: '0'
                },
                language:{
                    rx: rx.CMIString255,
                    ac: 'rw',
                    dv: ''
                },
                speed:{
                    rx: '^-?(100|\\d?\\d)$',
                    ac: 'rw',
                    dv: '0'
                },
                text:{
                    rx: '^-1$|^0$|^1$',
                    ac: 'rw',
                    dv: '0'
                }
            },
            suspend_data:{
                rx: rx.CMIString4096,
                ac: 'rw',
                dv: ''
            }
        }
    };

function getElementModel(s_el){
    var a_elmod=s_el.split('.');
    var o_elmod=model[a_elmod[0]];
    if (typeof o_elmod == "undefined") return null;
    for (var i=1;i<a_elmod.length;i++){
        if (isNaN(a_elmod[i])) o_elmod=o_elmod[a_elmod[i]];
        else o_elmod=o_elmod['n'];
        if (typeof o_elmod == "undefined") return null;
    }
    if (typeof o_elmod['ac'] == "undefined") return null;
    return o_elmod;
}

function addTime(s_a,s_b) {
    function timestr2hsec(st) {
        var a1=st.split(":");
        var a2=a1[2].split(".");
        var it=360000*parseInt(a1[0],10) + 6000*parseInt(a1[1],10) + 100*parseInt(a2[0],10);
        if (a2.length>1) {
            if(a2[1].length==1) it+=10*parseInt(a2[1],10);
            else it+=parseInt(a2[1],10);
        }
        return it;
    }
    function hsec2timestr(ts){
        function fmt(ix){
            var sx=Math.floor(ix).toString();
            if(ix<10) sx="0"+sx;
            return sx;
        }
        var ic=ts%100;
        var is=(ts%6000)/100;
        var im=(ts%360000)/6000;
        var ih=ts/360000;
        if(ih>9999) ih=9999;
        if(ic == 0) return fmt(ih)+":"+fmt(im)+":"+fmt(is);
        return fmt(ih)+":"+fmt(im)+":"+fmt(is)+"."+fmt(ic);
    }
    var i_hs=timestr2hsec(s_a)+timestr2hsec(s_b);
    return hsec2timestr(i_hs);
}   

function LMSInitialize(param){
    function setreturn(thisErrorCode,thisDiag){
        errorCode=thisErrorCode;
        diag=thisDiag;
        var s_return="false";
        if(errorCode==0) s_return="true";
        showCalls('LMSInitialize("'+param+'")',s_return,errorCode,diag);
        return s_return;
    }
    if (param!=="") return setreturn(201,"param must be empty string");
    if (Initialized) return setreturn(101,"already initialized");
    Initialized=true;
    errorCode=0;
    diag='';
    sco_id=iv.launchId;
    //to avoid additional commits at LMSFinish, values for elements entry and total_time are stored separatly
    totalTimeAtInitialize=getValueIntern(sco_id,'cmi.core.total_time');
    if (totalTimeAtInitialize==null) totalTimeAtInitialize=model.cmi.core.total_time.dv;

    entryAtInitialize="";
    if (getValueIntern(sco_id,'cmi.core.entry') == null && getValueIntern(sco_id,'cmi.core.exit') == null) {
        entryAtInitialize=model.cmi.core.entry.dv;
        setValueIntern(sco_id,'cmi.core.entry',"",true);
    }
    if (getValueIntern(sco_id,'cmi.core.exit') == 'suspend'){
        entryAtInitialize='resume';
        setValueIntern(sco_id,'cmi.core.entry','resume',true);
//  } else { //some other than 1.2
//      save total_time ...
//      data[sco_id]=new Object();
    }

    var mode=iv.lesson_mode;
    if (iv.b_autoReview==true) {
        var st=getValueIntern(sco_id,'cmi.core.lesson_status');
        if (st=="completed" || st=="passed" || st=="failed") {
            mode='review';
            entryAtInitialize=""; //specs 3-26
            setValueIntern(sco_id,'cmi.core.entry',"",true);
        }
    }
    setValueIntern(sco_id,'cmi.core.lesson_mode',mode,true);

    b_scoCredit=false;
    if (mode == 'normal') {
        setValueIntern(sco_id,'cmi.core.credit',iv.credit,true);
        if (iv.credit == 'credit') b_scoCredit=true;
    } else {
        setValueIntern(sco_id,'cmi.core.credit','no-credit',true);
    }
    
    if(iv.b_readInteractions==false) {
        var o_i=data[""+sco_id];
        o_i=o_i["cmi"];
        o_i["interactions"]=new Object();
    }

    initDebug();

    return setreturn(0,"");
}

function LMSCommit(param) {
    function setreturn(thisErrorCode,thisDiag){
        errorCode=thisErrorCode;
        diag=thisDiag;
        var s_return="false";
        if(errorCode==0) s_return="true";
        showCalls('LMSCommit("'+param+'")',s_return,errorCode,diag);
        return s_return;
    }
    if (param!=="") return setreturn(201,"param must be empty string");
    if (!Initialized) return setreturn(301,"");
    if (IliasCommit()==false) return setreturn(101,"LMSCommit was not successful");
    else return setreturn(0,"");
}

function LMSFinish(param){
    function setreturn(thisErrorCode,thisDiag){
        errorCode=thisErrorCode;
        diag=thisDiag;
        var s_return="false";
        if(errorCode==0) s_return="true";
        showCalls('LMSFinish("'+param+'")',s_return,errorCode,diag);
        return s_return;
    }
    if (param!=="") return setreturn(201, "param must be empty string");
    if (!Initialized) return setreturn(301,"");
//  if (getValueIntern(sco_id,'cmi.core.exit') == null && getValueIntern(sco_id,'cmi.core.entry') != 'resume') {
//      setValueIntern(sco_id,'cmi.core.entry',"",true);
//  }
    if (IliasCommit()==false) return setreturn(101,"LMSFinish was not successful because of failure with implicit LMSCommit");
    Initialized=false;
    IliasLaunchAfterFinish(sco_id);
    return setreturn(0,"");
}

function LMSGetLastError() {
    showCalls('LMSGetLastError()',""+errorCode);
    return ""+errorCode;
}

function getErrorStringIntern(ec){
    var s_error="";
    ec=""+ec;
    if (ec!=""){
        s_error='error';
        switch(ec){
            case "0"    : s_error = 'No Error';break;
            case "101"  : s_error = 'General Exception';break;
            case "201"  : s_error = 'Invalid argument error';break;
            case "202"  : s_error = 'Element cannot have children';break;
            case "203"  : s_error = 'Element not an array - Cannot have count';break;
            case "301"  : s_error = 'Not initialized';break;
            case "401"  : s_error = 'Not implemented error';break;
            case "402"  : s_error = 'Invalid set value, element is a keyword';break;
            case "403"  : s_error = 'Element is read only';break;
            case "404"  : s_error = 'Element is write only';break;
            case "405"  : s_error = 'Incorrect Data Type';break;
        }
    }
    return s_error;
}
function LMSGetErrorString(ec){
    s_err=getErrorStringIntern(ec);
    showCalls('LMSGetErrorString("'+ec+'")',s_err);
    return s_err;
}

function LMSGetDiagnostic(param){
    var s_return="";
    if (param==""){
        if (diag=="") s_return='no additional info for last error with error code '+errorCode;
        else s_return='additional info for last error with error code '+errorCode+': '+diag;
    } else {
        s_return='no additional info for error code '+param;
    }
    showCalls('LMSGetDiagnostic("'+param+'")',s_return);
    return s_return;
}

function LMSGetValue(s_el){
    function setreturn(thisErrorCode,thisDiag,value){
        errorCode=thisErrorCode;
        diag=thisDiag;
        var s_return="";
        if(errorCode==0) s_return=value;
        showCalls('LMSGetValue("'+s_el+'")',s_return,errorCode,diag);
        return s_return;
    }
    var value="";
    s_el=""+s_el;
    if (!Initialized) return setreturn(301,"");
    if (s_el=="" || s_el==null) return setreturn(201,"");
    //check if model exists
    var o_elmod=getElementModel(s_el);
    if (o_elmod==null){
        var a_el=s_el.split('.');
        if (a_el[a_el.length-1]=="_children") return setreturn(202,"");
        if (a_el[a_el.length-1]=="_count") return setreturn(203,"");
        return setreturn(201,"element not exists");
    }
    //check if writeable
    if (o_elmod['ac'] == "w") return setreturn(404,"");
    if (s_el=='cmi.core.total_time') value=totalTimeAtInitialize;
    else if (s_el=='cmi.core.entry') value=entryAtInitialize;
    else value=getValueIntern(sco_id,s_el);
    if (value != null) return setreturn(0,"",value);
    if (typeof o_elmod['dv'] == "undefined" || o_elmod['dv'] == null) return setreturn(0,"not set","");
    else return setreturn(0,"",decodeURIComponent(o_elmod['dv']));
    return setreturn(101,"");
}

function LMSSetValue(s_el,value){
    function setreturn(thisErrorCode,thisDiag){
        errorCode=thisErrorCode;
        diag=thisDiag;
        var s_return="false",s_v='"';
        if(errorCode==0) s_return="true";
        if(errorCode==405) s_v='';
        showCalls('LMSSetValue("'+s_el+'",'+s_v+value+s_v+')',s_return,errorCode,diag);
        return s_return;
    }
    //check value
    if (typeof value == "undefined") return setreturn(405,"Value cannot be type undefined");
    else if (value==null) return setreturn(405,"Value cannot be null");
    else if (typeof value == "object") return setreturn(405,"Value cannot be an object");
    else if (typeof value == "function") return setreturn(405,"Value cannot be a function");
    else if (typeof value == "number") value = value.toString(10);
    value=""+value;
    //check state
    if (!Initialized) return setreturn(301,"");
    //check element
    if (s_el=="" || s_el==null) return setreturn(201,"LMSSetValue without element");
    if (typeof s_el != "string") return setreturn(201,"element of LMSSetValue must be type string");
    //check if keyword
    if (s_el.indexOf('_children')>-1 || s_el.indexOf('_count')>-1) return setreturn(402,"");
    //check if model exists
    var o_elmod=getElementModel(s_el);
    if (o_elmod==null) return setreturn(201,"");
    //check if writeable
    if (o_elmod['ac'] == "r") return setreturn(403,"");
    //Format-/Range-Checker
    if(iv.b_checkSetValues){
        var trx = new RegExp(o_elmod['rx']);
        if (value.match(trx) == null) return setreturn(405,"");
    }
    //store
    var b_storeDB=true;
    if (iv.b_storeInteractions==false && s_el.indexOf("cmi.interactions")>-1) b_storeDB=false;
    else if (iv.b_storeObjectives==false && s_el.indexOf("cmi.objectives")>-1) b_storeDB=false;
    if (b_scoCredit==false && (s_el.indexOf("score")>-1 || s_el.indexOf("status")>-1)) b_storeDB=false;

    var b_result=setValueIntern(sco_id,s_el,value,b_storeDB);
    if (b_result==false) return setreturn(201,"out of order");
    if (s_el=='cmi.core.session_time'){
        var ttime = addTime(totalTimeAtInitialize, value);
        b_result=setValueIntern(sco_id,'cmi.core.total_time',ttime,true);
    }
    if (s_el=='cmi.core.exit'){
        if (value=='suspend') b_result=setValueIntern(sco_id,'cmi.core.entry',"resume",true);
        else b_result=setValueIntern(sco_id,'cmi.core.entry',"",true);
    }
    return setreturn(0,"");
}

function init(){
    model.cmi.core.student_id.dv=""+iv.studentId;
    model.cmi.core.student_name.dv=iv.studentName;
    model.cmi.core.student_login.dv=iv.studentLogin;
    model.cmi.core.student_ou.dv=iv.studentOu;
    model.cmi.core.credit.dv=iv.credit;
}

this.LMSInitialize=LMSInitialize;
this.LMSFinish=LMSFinish;
this.LMSGetValue=LMSGetValue;
this.LMSSetValue=LMSSetValue;
this.LMSCommit=LMSCommit;
this.LMSGetLastError=LMSGetLastError;
this.LMSGetErrorString=LMSGetErrorString;
this.LMSGetDiagnostic=LMSGetDiagnostic;
init();
}
IliasScormVars={refId:3086,objId:7763,launchId:0,launchNr:0,pingSession:0,studentId:176,studentName:"Wilson%2C%20Gwyneth",studentLogin:"gwyneth",studentOu:"",credit:"credit",lesson_mode:"normal",b_autoReview:false,b_messageLog:false,b_checkSetValues:true,b_storeObjectives:true,b_storeInteractions:true,b_readInteractions:false,c_storeSessionTime:"s",b_autoContinue:false,b_autoLastVisited:true,i_lessonScoreMax:-1,i_lessonMasteryScore:-1,b_debug:false,dataDirectory:".%2Fdata%2Fdemo%2Flm_data%2Flm_7763%2F",img:{asset:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fasset.png",browsed:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fbrowsed.png",completed:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fcompleted.png",failed:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Ffailed.png",incomplete:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fincomplete.png",not_attempted:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fnot_attempted.png",passed:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Fpassed.png",running:".%2Ftemplates%2Fdefault%2Fimages%2Fscorm%2Frunning.png"},statusTxt:{wait:"Please%20wait...",status:"Status",browsed:"Browsed",completed:"Completed",failed:"Failed",incomplete:"Incomplete",not_attempted:"Not%20attempted",passed:"Passed",running:"Running"}};
IliasScormData=[];
IliasScormResources=[[4,1264,0,"AssetLaunchTest.htm"],[6,1265,0,"APIRTETest1.htm"],[8,1266,0,"APIRTETest2.htm"]];
var API=new iliasApi();