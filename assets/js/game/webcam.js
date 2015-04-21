define([], function() {
  var img = document.createElement('img');
  // img.src = "assets/img/untitled.png";
  // document.body.appendChild(img);
  var webcamvideo;
  var tutorial;
  var drawhich;
  var localStream = undefined;
  (function() {
    webcamvideo = document.createElement('video');
    webcamvideo.width = 640; // general webcam resolution set for trouble in getting delayed src
    webcamvideo.height = 480;
    webcamvideo.autoplay = true;

    tutorial = document.createElement('video');
    tutorial.width = 640;
    tutorial.height = 480;
    tutorial.autoplay = true;
    tutorial.loop = true;
    tutorial.controls = true;

    drawhich = 'webcam';
  })();

  // compatible template
  var getUserMedia = function(t, onsuccess, onerror) {
    var result = undefined;
    if (navigator.getUserMedia) {
      result = navigator.getUserMedia(t, onsuccess, onerror);
    } else if (navigator.webkitGetUserMedia) {
      result = navigator.webkitGetUserMedia(t, onsuccess, onerror);
    } else if (navigator.mozGetUserMedia) {
      result = navigator.mozGetUserMedia(t, onsuccess, onerror);
    } else if (navigator.msGetUserMedia) {
      result = navigator.msGetUserMedia(t, onsuccess, onerror);
    } else {
      onerror(new Error("No getUserMedia implementation found."));
    }
    return result;
  };

  var waitForAuthorize = function(ctrl_success_with_init, ctrl_error) { // param callback function
    drawhich = 'webcam';
    getUserMedia({ video: true }, function (stream) { // local callback function
      window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
      webcamvideo.src = window.URL.createObjectURL(stream);
      localStream = stream;
      webcamvideo.play();

      // createModel / init / tick with ctrl success callback
      if (ctrl_success_with_init)
        ctrl_success_with_init();
    }, function(err) {
      console.log(err);
      if (ctrl_error)
        ctrl_error();
    });
  };
  var noWaitForAuthorize = function (ctrl_success_with_init, ctrl_error) {
      drawhich = 'tutorial';
      tutorial.src = 'assets/video/swap_loop.ogg';
      tutorial.play();
      if (ctrl_success_with_init)
        ctrl_success_with_init();
  }

  function _copyToContext(context) { // hard to expl. moz's err
    return function() { copyToContext(context); }
  }
  var copyToContext = function(context) {
    try {
      if (drawhich == 'webcam')
        context.drawImage(webcamvideo, 0, 0);
      else
        context.drawImage(tutorial, 0, 0);
      // context.drawImage(img, 0, 0);
    } catch(e) {
      if (e.name == "NS_ERROR_NOT_AVAILABLE") {
        setTimeout(_copyToContext(context), 0);
      } else {
        throw e;
      }
    }
  }
  var closeWebcam = function () {
    if (webcamvideo && webcamvideo.pause)
      webcamvideo.pause();
    if (localStream) localStream.stop();
    localStream = undefined;
  }
  var closeTutorial = function () {
    // tutorial.restart();
    if (tutorial && tutorial.pause)
      tutorial.pause();
  }
  var close = function(type) {
    if (type) {
      if (type === 'webcam')
        closeWebcam();
      else
        closeTutorial();
      return;
    }
    closeWebcam();
    closeTutorial();
  }
  return {
    waitForAuthorize: waitForAuthorize,
    noWaitForAuthorize: noWaitForAuthorize,
    copyToContext: copyToContext,
    close: close,
    getDimensions: function() {
      return { width: webcamvideo.width, height: webcamvideo.height };
    },
    setSource: function(src) {
      drawhich = src;
    },
    getSource: function() {
      return drawhich;
    }
  };
});
