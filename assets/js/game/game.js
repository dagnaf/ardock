define(['./ar', './background', './control', './view', 'lib/jquery.min', 'lib/stats.min'], function (ar, bg, ctrl, view) {
  var stats;
  var init = function() {
    // if (!Detector.webgl) {
    //   alert('webgl not supported!');
    //   return;
    // }
    stats = new Stats();
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.top = '0px';
    stats.domElement.style.zIndex = 100000;
    var container = document.getElementById('v3d');
    container.appendChild(stats.domElement);
    // document.body.appendChild(stats.domElement);

    bg.init(function() {
      animate();
      ctrl.init();
    });
  }
  var animate = function() {
    stats.update();
    if (ctrl.isPlaying()) {
      view.renderer.autoClear = false;
      ar.animate();
      view.render(ar.reality());
      view.render(ar.virtual());
    } else {
      view.renderer.autoClear = true;
      bg.animate();
      view.render(bg);
    }
    window.requestAnimationFrame(animate);
  }
  return {
    init: init
  }
});
