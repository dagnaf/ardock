// define([], function(webcam) {
// define(['./webcam', './scene', './detector', './object', 'lib/dat.gui'], function(webcam, scene, detector, object) {
define(['./webcam', './scene', './detector', './object'], function(webcam, scene, detector, object) {
  webcam.setSource('webcam');

  var canvas, context, videoCanvas, debugCanvas, gui;
  window.DEBUG = false;
  // FIXME
  var threshold = 70;
  // var effectController = {
  //   threshold: 50,
  //   debug: false,
  //   src: 'webcam'
  // };
  (function() {
    canvas = document.createElement('canvas');
    canvas.width = 320;
    canvas.height = 240;
    canvas.width = 640;
    canvas.height = 480;
    context = canvas.getContext('2d');
    detector.init(canvas);

    debugCanvas = document.createElement('canvas');
    debugCanvas.id = 'debugCanvas';
    debugCanvas.width = 320;
    debugCanvas.height = 240;
    debugCanvas.width = 640;
    debugCanvas.height = 480;
    debugCanvas.style.position = 'relative';
    debugCanvas.style.top = '0';
    debugCanvas.style.margin = '0 auto';
    debugCanvas.style.display = 'none';
    // $div = $('div').css({
    //   position: 'absolute',
    //   width: '100%',
    //   top: 0
    // });
    // $div.append(debugCanvas)
    $v3d = document.getElementById('v3d');
    $div = $v3d.appendChild(document.createElement('div'));
    $div.style.position = 'absolute';
    $div.style.width = '100%';
    $div.style.top = '0';
    $div.appendChild(debugCanvas);
    // $('#v3d').append(debugCanvas);

    // gui = new dat.GUI({ autoPlace: false });
    // $.extend(gui.domElement.style, {
    //   position: 'absolute',
    //   top: '0',
    //   left: '80px',
    //   zIndex: 1000000
    // })
    // var element;
    // element = gui.add( effectController, "threshold", 0, 255);
    // element.name("Threshold");

    // element = gui.add( effectController, "debug").onChange(function() {
    //   DEBUG = effectController.debug;
    //   if (DEBUG) document.getElementById('debugCanvas').style.display = 'block';
    //   else document.getElementById('debugCanvas').style.display = 'none';
    // });
    // element.name("Debug");

    // element = gui.add( effectController, "src", [ 'webcam', 'video' ]).onChange(function() {
    //   webcam.setSource(effectController.src);
    // });
    // element.name("source");

    // $('#v3d').append(gui.domElement);
    // $('.dg.main .close-button').click();


    var webcamDimensions = webcam.getDimensions();
    videoCanvas = document.createElement('canvas');
    videoCanvas.width = webcamDimensions.width;
    videoCanvas.height = webcamDimensions.height;
    // context.drawImage(videoCanvas, 0, 0, 320, 240);
    scene.init(videoCanvas);
    scene.setCameraMatrix(detector.getCameraMatrix(0.1, 1000));
  })();

  var animate = function() {
    webcam.copyToContext(videoCanvas.getContext('2d'));
    // context.drawImage(img,sx,sy,swidth,sheight,dx,dy,dwidth,dheight);
    // img/canvas/video
    // s source d destination
    context.drawImage(videoCanvas, 0, 0, 640, 480, 0, 0, 640, 480);
    // texture needs change
    scene.update();
    canvas.changed = true;
    detector.detect(object.onMarkerCreated, object.onMarkerUpdated, object.onMarkerDestroyed, threshold);
  };
  var authorize = function(success, error, setting, isTutorial, no_init) {
    function init() { // AR init with success func
      // ... init done only once, create model every time
      // THREE.PlaneGeometry: Consider using THREE.PlaneBufferGeometry for lower memory footprint
      scene.init(canvas);
      detector.reset();
      scene.setCameraMatrix(detector.getCameraMatrix(0.1, 1000));
      object.init(setting, success);
    }
    if (isTutorial)
      webcam.noWaitForAuthorize(no_init ? success : init, error);
    else
      webcam.waitForAuthorize(no_init ? success : init, error);
  }
  return {
    animate: animate,
    authorize: authorize,
    reality: scene.reality,
    virtual: scene.virtual,
    setDebug: function (yes) {
      document.getElementById('debugCanvas').style.display = (yes ? 'block' : 'none');
      window.DEBUG = yes;
    },
    setThreshold: function (t) {
      threshold = t;
    }
  }
})
