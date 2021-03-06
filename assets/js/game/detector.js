define(['lib/JSARToolKit.min'], function() {
  var JSARRaster = null;
  var JSARParameters = null;
  var JSARDetector = null;
  var threshold = 70;

  var init = function(sourceCanvas) {
    JSARRaster = new NyARRgbRaster_Canvas2D(sourceCanvas);
    JSARParameters = new FLARParam(sourceCanvas.width, sourceCanvas.height);
    JSARDetector = new FLARMultiIdMarkerDetector(JSARParameters, 20); // unit of marker
    JSARDetector.setContinueMode(true);
  }

  var getMarkerNumber = function(idx) {
    var data = JSARDetector.getIdMarkerData(idx);
    if (data.packetLength > 4) {
      return -1;
    }

    var result=0;
    for (var i = 0; i < data.packetLength; i++ ) {
      result = (result << 8) | data.getPacketData(i);
    }

    return result;
  }

  var getTransformMatrix = function(idx) {
    var mat = new NyARTransMatResult();
    JSARDetector.getTransformMatrix(idx, mat);

    var cm = new Float32Array(16);
    cm[0] = mat.m00;
    cm[1] = -mat.m10;
    cm[2] = mat.m20;
    cm[3] = 0;
    cm[4] = mat.m01;
    cm[5] = -mat.m11;
    cm[6] = mat.m21;
    cm[7] = 0;
    cm[8] = -mat.m02;
    cm[9] = mat.m12;
    cm[10] = -mat.m22;
    cm[11] = 0;
    cm[12] = mat.m03;
    cm[13] = -mat.m13;
    cm[14] = mat.m23;
    cm[15] = 1;

    return cm;
  }

  var getCameraMatrix = function(zNear, zFar) {
    var result = new Float32Array(16);
    JSARParameters.copyCameraMatrix(result, zNear, zFar);
    return result;
  }

  var persistTime = 1;
  var newMarker = function(id, matrix) {
    return {
      id: id,
      matrix: matrix,
      age: persistTime,
    }
  }

  var markers = {};
  var detect = function( onCreate, onUpdate, onDestroy, threshold ) {
    var markerCount = JSARDetector.detectMarkerLite(JSARRaster, threshold);
    for( var index = 0; index < markerCount; index++ ) {
      var id = getMarkerNumber(index);
      var marker = markers[id];
      if( marker === undefined ) {
          marker = newMarker(id, getTransformMatrix(index));
          markers[id] = marker;
          onCreate( marker );
      }
      else {
          marker.matrix = getTransformMatrix(index);
          marker.age = persistTime;
          onUpdate( marker );
      }
    }

    for( var id in markers ) {
      var marker = markers[id];
      if( marker ) {
        if( marker.age-- == 0 ) {
          onDestroy( marker );
          delete markers[id];
        }
      }
    }
  }

  return {
    init: init,
    detect: detect,
    getCameraMatrix: getCameraMatrix,
    reset: function() {
      markers = {};
    },
    threshold: function(x) {
      if (x == undefined) return threshold;
      if (0 <= x && x <= 255) {
        threshold = x;
      } else {
        console.log('threshold out of range, reset to 70');
        threshold = 70;
      }
    }
  }
});
