$(function() {
      var gain = $('#gain')[0];
      var silenceLevel = $('#silenceLevel')[0];
      for(var i=0; i<=100; i++) {
        gain.options[gain.options.length] = new Option(100-i);
        silenceLevel.options[silenceLevel.options.length] = new Option(i);
      }
    
      var appWidth = 24;
      var appHeight = 24;
      var flashvars = {'event_handler': 'microphone_recorder_events', 'upload_image': '../../../img/images/upload.png'};
      var params = {};
      var attributes = {'id': "recorderApp", 'name':  "recorderApp"};	  
      swfobject.embedSWF("../../../js/js/recorder.swf", "flashcontent", appWidth, appHeight, "11.0.0", "", flashvars, params, attributes);
    });


function configureMicrophone() {
      if(! FWRecorder.isReady) {
        return;
      }

      FWRecorder.configure($('#rate').val(), $('#gain').val(), $('#silenceLevel').val(), $('#silenceTimeout').val());
      FWRecorder.setUseEchoSuppression($('#useEchoSuppression').is(":checked"));
      FWRecorder.setLoopBack($('#loopBack').is(":checked"));
    }