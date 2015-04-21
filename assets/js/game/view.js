define(['lib/three.min'], function() {

  var w = 640;
  var h = 480;
  var w_fs = window.screen.width;
  var h_fs = window.screen.height;
  // init full screen ratio
  if (w_fs/w < h_fs/h) {
    h_fs = h*w_fs/w;
  } else {
    w_fs = w*h_fs/h;
  }
  // var renderer = new THREE.WebGLRenderer3({ antialias: true, alpha: true });
  // var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
  var renderer = new THREE.WebGLRenderer({ antialias: true });
  renderer.setSize(w, h);
  renderer.autoClear = false;
  renderer.setClearColor( 0xf0f0f0);
  $('#v3d').append(renderer.domElement);

  return {
    renderer: renderer,
    render: function(obj) {
      renderer.render(obj.getScene(), obj.getCamera());
    },
    cancelFullScreen: function() {
      console.log("now not full");
      renderer.setSize(w, h);
      $('#debugCanvas').css({ width: w+'px', height: h+'px'})
    },
    requestFullScreen: function() {
      console.log("now full");
      renderer.setSize(w_fs, h_fs);
      $('#debugCanvas').css({ width: w_fs+'px', height: h_fs+'px'})
    }
  };
});
