define(['lib/iview_new', 'lib/three.min'], function (iview_new) {
  var init = function(callback) {
    $.ajax({
      // url: 'assets/pdb/receptor/2Y01.pdb',
      url: 'assets/pdb/ligand/Y01.pdb',
      dataType: 'text',
    }).done(function(data) {
      loadMol(data);
      animate();
      callback();
      $('#mask-wait').hide();
    });
  };
  var bgIview;
  var animate = function() {
    bgIview.rot.rotation.y += 0.01;
  };
  var camera, scene;
  var loadMol = function(data) {
    // scene = new THREE.Scene();

    // camera = new THREE.PerspectiveCamera(20, 640 / 480, 1, 800);
    // camera.position.set(0,0,-150);
    // camera.lookAt(new THREE.Vector3(0, 0, 0));

    // var v = new iview();
    // v.loadPDB(data);
    // var v1 = new iview_new("iview");
    // v1.loadPDB(data, {ligands: 'stick', surface: 'nothing'});
    // scene.add(v.rot);
    // obj = v.rot;

    // var ambientLight = new THREE.AmbientLight(0x202020);
    // scene.add(ambientLight);

    // // var spotLight = new THREE.SpotLight(0xffffff);
    // // spotLight.position.set(0, 0, 9000);
    // // spotLight.lookAt(new THREE.Vector3(0,0,0));
    // // scene.add(spotLight);

    // var directionalLight = new THREE.DirectionalLight(0xFFFFFF, 1.2);
    // directionalLight.position.set(0.2, 0.2, -1).normalize();
    // scene.add(directionalLight);

    // // ...3d title and positioning
    // // ...
    // scene.add(new THREE.AxisHelper(5));

    // camera = v1.camera;
    // scene = v1.scene;
    bgIview = new iview_new();
    bgIview.loadPDB(data, {ligands: 'stick', surface: 'nothing', labels: 'yes'});
    // bgIview.loadPDB(data, {ligands: 'stick', surface: 'nothing' });
    camera = new THREE.Camera();
    scene = new THREE.Scene();
    camera = bgIview.camera;
    camera.position.z;
    scene = bgIview.scene;
    // camera = new THREE.PerspectiveCamera(20, 640/480, 1, 800);
    console.log(camera.position.z);
    camera.fov = 8;
    camera.updateProjectionMatrix();
    // camera.lookAt(new THREE.Vector3(0,0,0));
    // scene = new THREE.Scene();
    // scene.add(new THREE.AxisHelper(5));

    window.iview_x = bgIview;
  }

  return {
    init: init,
    animate: animate,
    getCamera: function() { return camera; },
    getScene: function() { return scene; },
  };
});
