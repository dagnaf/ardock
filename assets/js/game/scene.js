define(['lib/three.min'], function() {

  var reality, virtual;
  var Reality = function(sourceCanvas){
    // Create a default camera and scene.
    var camera = new THREE.Camera();
    var scene = new THREE.Scene();
    // Create a plane geometry to hold the sourceCanvas texture
    var geometry = new THREE.PlaneGeometry(2, 2, 0);
    // Create a material textured with the contents of sourceCanvas.
    var texture = new THREE.Texture(sourceCanvas);
    var material = new THREE.MeshBasicMaterial({
      map: texture,
      depthTest: false,
      depthWrite: false
    });
    // Build a mesh and add it to the scene.
    var mesh = new THREE.Mesh( geometry, material );
    scene.add(mesh);
    // We need to notify ThreeJS when the texture has changed.
    function update() {
      texture.needsUpdate = true;
    }
    return {
      camera: camera,
      scene: scene,
      update: update,
      getScene: function() { return scene; },
      getCamera: function() { return camera; }
    }
  }
  var Virtual = function() {
    var scene = new THREE.Scene();
    var camera = new THREE.Camera();
    function add(object) {
      scene.add(object);
    }
    function remove(object) {
      scene.remove(object);
    }
    function setProjectionMatrix(matrix) {
      camera.projectionMatrix.setFromArray( matrix );
    }
    return {
      scene: scene,
      camera: camera,
      add: add,
      remove: remove,
      setProjectionMatrix: setProjectionMatrix,
      getScene: function() { return scene; },
      getCamera: function() { return camera; }
    }
  }

  // Create a reality scene
  var init = function(sourceCanvas) {
    reality = new Reality(sourceCanvas);
    // var reality = new Reality(sourceCanvas);
    virtual = new Virtual();

    var ambientLight = new THREE.AmbientLight(0x202020);
    virtual.scene.add(ambientLight);
    var directionalLight = new THREE.DirectionalLight(0xFFFFFF, 1.2);
    directionalLight.position.set(0, 0, 1);
    virtual.scene.add(directionalLight);
  }
  function update() {
    // Notify the reality scene to update it's texture
    reality.update();
  }
  function setCameraMatrix( matrix ) {
    virtual.setProjectionMatrix( matrix );
  }
  function add( object ) {
    virtual.add( object.model );
  }
  function remove( object ) {
    virtual.remove( object.model );
  }
  return {
    init: init,
    add: add,
    remove: remove,
    update: update,
    setCameraMatrix: setCameraMatrix,
    reality: function() { return reality; },
    virtual: function() { return virtual; }
  }
});
