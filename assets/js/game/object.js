define(['./scene', 'lib/iview_new', 'lib/d3.min', 'lib/jquery.min'], function(scene, iview_new, d3) {
  var mol = {
    lig: { type: 'lig', name: undefined, obj: undefined, visible: false },
    rec: { type: 'rec', name: undefined, obj: undefined, visible: false }
  };
  var cache = {};
  var cacheable = true;
  var $load_chunk = $('#load-chunk');

  window.mymol = mol;
  var last_dn = 0;
  var best_data = undefined;
  var best_matrix = undefined;
  var mode = undefined;
  THREE.Matrix4.prototype.setFromArray = function(m) {
    return this.set(
      m[0], m[4], m[8], m[12],
      m[1], m[5], m[9], m[13],
      m[2], m[6], m[10], m[14],
      m[3], m[7], m[11], m[15]
    );
  };

  function scoreMap(score) {
    var per = score/10000000;
    if (per > 100) per = 100;
    return Math.round(100-per);
    // 0         100    100   400    550 700   700 1000
    // 10 9 8 7    6       5    4       3 2       1  0
    // var score = parseFloat(scoreStr);
    // var mark = 0;
    // if (score === NaN) score = 0;
    // if (score < 0) mark = d3.scale.linear().domain([0,-20]).range([1000, 9999])(score);
    // else if (score < 100) mark = d3.scale.linear().domain([100, 0]).range([100, 1000])(score);
    // else if (score < 100000) mark = d3.scale.linear().domain([100000,10]).range([0, 100])(score);
    // return Math.floor(mark);
  }
  THREE.Object3D.prototype.transformFromArray = function(m) {
    this.matrix.setFromArray(m);
    this.matrixWorldNeedsUpdate = true;
  };
  // ajax when both mols visible otherwise return
  // note matrix store in obj.matrix is column-major, need to transpose before submit
  // also need to multiply the inverse of receptor's matrix
  function highlightHud() {
    $('#new-record').addClass('fall-down');
    setTimeout(function () {
      $('#new-record').removeClass('fall-down')
    }, 1000);
  }
  function ajaxScore() {
    // FIXME
    if ($load_chunk.hasClass('fall-down')) return;
    if (mol['lig'].visible && mol['rec'].visible && Date.now() - last_dn > 500) {
      last_dn = Date.now();
      //alert('visible');
      var matrix0 = new THREE.Matrix4();
      var array0 = new Array();
      matrix0.getInverse(mol['rec'].obj.model.matrix).multiply(mol['lig'].obj.model.matrix);
      var matrix_send = matrix0.transpose().flattenToArrayOffset(array0, 0).toString();
      $.ajax({
        url: 'test',
        type: 'post',
        data: { body: matrix_send },
        dataType: 'text',
        success: function(data_received) {
          data = parseFloat(data_received);
          // FIXME
          if (isNaN(data)) {
            console.log('cannot parse data to float: ' + data_received);
            return;
          }
          // best_data is the unmodified data
          // best_matrix is the unmodified matrix
          if (best_data === undefined || data < best_data) {
            best_data = data;
            best_matrix = matrix_send;
            highlightHud();
          }
          $('#best-data-hidden').text(best_data);
          $('#best-matrix-hidden').text(best_matrix);
          var best_data_to_show = best_data < 0 ? 0 : best_data;
          var data_to_show = data < 0 ? 0 : data;
          $('#best-score-hud').val(scoreMap(best_data_to_show));
          $('#current-score-hud').val(scoreMap(data_to_show));
        }
      });
    }
  }
  var createMarkerObject = function(modelContainer) {
    modelContainer.matrixAutoUpdate = false;
    return {
      transform: function(matrix) {
        modelContainer.transformFromArray( matrix );
      },
      model: modelContainer
    }
  }
  var selectObject = function(id) { // id -> model
    if (mode == undefined) return undefined;
    if (id == undefined) return undefined;
    if (mode === 0) { // double: 0 for rec any others for lig
      return id == 0 ? 'rec' : 'lig';
    } else { // single all lig
      return 'lig';
    }
  }
  var onMarkerCreated = function(marker) {
    var type = selectObject(marker.id);
    if (type == undefined) return;
    var object = mol[type].obj;
    // var object = markerObjects[marker.id];
    object.transform(marker.matrix);
    // console.log(marker.matrix);
    mol[type].visible = true;
    ajaxScore();
    scene.add(object);
  };
  var onMarkerUpdated = function(marker) {
    var type = selectObject(marker.id);
    if (type == undefined) return;
    var object = mol[type].obj;
    // var object = markerObjects[marker.id];
    object.transform(marker.matrix);
    mol[type].visible = true;
    ajaxScore();
    // console.log(marker.matrix);
  };
  var onMarkerDestroyed = function(marker) {
    var type = selectObject(marker.id);
    if (type == undefined) return;
    var object = mol[type].obj;
    // var object = markerObjects[marker.id];
    mol[type].visible = false;
    scene.remove(object);
  };
  // FIXME
  var rec_mat = [0.9984073042869568, -0.036981869488954544, -0.04260563105344772, 0, 0.05227585509419441, 0.8904197812080383, 0.45212817192077637, 0, 0.02121634967625141, -0.4536353051662445, 0.8909348249435425, 0, 4.802630424499512, -17.175390243530273, 197.8627471923828, 1];


  function putRec() {
    mol.rec.obj.transform(rec_mat);
    mol.rec.visible = true;
    if (mol.rec.obj !== undefined)
      scene.add(mol.rec.obj);
  }

  var init = function(setting, callback) {
    if (scene) {
      if (mol.lig.obj)
        scene.remove(mol.lig.obj);
      if (mol.rec.obj)
        scene.remove(mol.rec.obj);
    }
    mol.lig.name = undefined;
    mol.rec.name = undefined;
    mode = setting.mode;

    function same() {
      return (setting.rec == mol.rec.name && setting.lig == mol.lig.name);
    }

    // if (same()) {
    //   if (!mode) putRec();
    //   callback();
    //   return;
    // }

    function doneFn() {
      if (same()) {
        if (mode === 1) putRec();
        if (callback) callback();
      }
    }

    var abbr = { lig: 'ligand', rec: 'receptor' };
    function create(m) {
      var type = abbr[m.type];
      var name = setting[m.type];
      if (name != m.name) {
        // cacheable and found
        if (cacheable && cache[name] !== undefined) {
          m.name = name;
          m.obj = cache[name];
          doneFn();
          return;
        }
        // not cache found
        var v = new iview_new();
        var opt = {}
        if (type == 'ligand') {
          opt = {
            ligands: 'stick',
            surface: 'nothing',
          }
        } else {
          opt = {
            // opacity: 0.4
          }
        }
        $.ajax({
          url: 'assets/pdb/'+ type + '/' + name + '.pdb',
          dataType: 'text'
        }).done(function(data) {
          m.name = name;
          v.loadPDB(data, opt);
          m.obj = createMarkerObject(v.rot);
          if (cacheable) {
            cache[name] = m.obj;
          }
          // v.rot.add(new THREE.AxisHelper(10));
          // m.obj = createMarkerObject(new THREE.AxisHelper(10));
          // if (same()) {
          //   // $('#mask-wait').hide();
          //   if (mode === 1) putRec();
          //   if (callback) callback();
          // }
          doneFn();
        });
      }
    }
    create(mol.lig); // sync load
    create(mol.rec);

    // var obj3d = new THREE.Object3D();
    // var material = new THREE.MeshLambertMaterial({ color: new THREE.Color(0x54B5B5), side: THREE.DoubleSide});
    // var geometry = new THREE.CubeGeometry(10, 10, 10);
    // var cube = new THREE.Mesh(geometry, material);
    // obj3d.add(cube);

    // var test = createMarkerObject(obj3d);
    // var testm = [
    //   0.9998531937599182, -0.0002728062099777162, 0.01713312789797783, 0,
    //   0.0003042330499738455, 0.9999982714653015, -0.001831693109124899, 0,
    //   -0.017132598906755447, 0.0018366365693509579, 0.9998515248298645, 0,
    //   -7.763726234436035, -3.1670336723327637, 121.00984191894531, 1
    // ];

    // scene.add(test);
    // var testf = function() {
    //   test.transform(testm);
    //   window.requestAnimationFrame(testf);
    // }
    // testf();
  };
  function setMode (i) {
    prev_mode = mode;
    mode = i;
    if (prev_mode !== i) {
      if (i === 0) {
        mol.rec.visible = false;
        if (mol.rec.obj !== undefined)
          scene.remove(mol.rec.obj);
      } else {
          putRec();
      }
    }
  };
  return {
    init: init,
    onMarkerCreated: onMarkerCreated,
    onMarkerUpdated: onMarkerUpdated,
    onMarkerDestroyed: onMarkerDestroyed,
    setMode: setMode,
    setCache: function (yes) {
      cacheable = yes;
      if (!cacheable) {
        cache = [];
      }
    }
  }
});
