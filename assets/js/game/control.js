define(['./view', './ar', './webcam', './object','lib/jquery.min', 'lib/bootstrap-slider'], function(view, ar, webcam, object) {
  // true when authorize succes, flase when return to previous frame
  var playing = false;
  var frames = [], frame = 0;
  // FIXME
  var lig = 'RANDOM', rec = 'RANDOM';
  var nligs = $('#list-lig a').length - 1;
  var nrecs = $('#list-rec a').length - 1;
  var Settings = function () {};
  Settings.prototype.saveAll = function () {
    this.setThreshold();
    this.setDebug();
    this.setMode();
    this.setVideoSrc();
    this.setCache();
    return this;
  }
  Settings.prototype.setThreshold = function (i) {
    if (i !== undefined) {
      this.threshold = i;
      $('#ex1').slider('setValue', this.threshold);
    } else
      this.threshold = $('#ex1').slider('getValue');
  }
  Settings.prototype.setDebug = function (i) {
    if (i !== undefined) {
      this.debug = i;
      $('#debugcheck').prop('checked', settings.debug);
    } else
      this.debug = $('#debugcheck').prop('checked');
  }
  Settings.prototype.setCache = function (i) {
    if (i !== undefined) {
      this.cache = i;
      $('#cachecheck').prop('checked', settings.cache);
    } else
      this.cache = $('#cachecheck').prop('checked');
  }
  Settings.prototype.setMode = function (i) {
    if (i !== undefined) {
      this.mode = i;
      if (settings.mode === 1)
        $('#radio-single').prop('checked', true);
      else
        $('#radio-double').prop('checked', true);
    } else
      this.mode = $('#radio-single').prop('checked') ? 1 : 0;

  }
  Settings.prototype.setVideoSrc = function (i) {
    if (i !== undefined) {
      this.videosrc = i;
      if (settings.videosrc === 'webcam')
        $('#radio-webcam').prop('checked', true);
      else
        $('#radio-tutorial').prop('checked', true);
    } else
      this.videosrc = $('#radio-webcam').prop('checked') ? 'webcam' : 'tutorial';
  }
  Settings.prototype.force = function () {
    this.setThreshold(this.threshold);
    this.setMode(this.mode);
    this.setVideoSrc(this.videosrc);
    this.setDebug(this.debug);
    this.setCache(this.cache);
  }

  // slider init
  $('#ex1').slider({
    formatter: function(value) {
      ar.setThreshold(value);
      return value;
    }
  });
  $('#debugcheck').change(function () {
    ar.setDebug($(this).prop('checked'))
  })

  var settings = new Settings();
  settings.setThreshold(70);
  settings.setDebug(false);
  settings.setMode(1);
  settings.setVideoSrc('webcam');
  settings.setCache(true);

  $('#general-buttons').addClass('slide-left');


  // modal init
  $('#settingsModal').on('show.bs.modal', function () {
    $('#settings-backdrop').fadeIn(500);
    settings.force();
  });
  $('#settingsModal').on('hidden.bs.modal', function () {
    $('#settings-backdrop').fadeOut(500);
    ar.setDebug(settings.debug);
    ar.setThreshold(settings.threshold);
  });
  $('#settingsModal').click(function (e) {
    if (this === e.target) {
      $(this).modal('hide');
    }
  })
  // fullscreen init
  $('#btn-fullscreen').click(function() {
    var el = $('#game')[0];
    if (el.webkitRequestFullScreen) {
      if (document.webkitFullscreenElement) {
          document.webkitCancelFullScreen();
      } else {
          el.webkitRequestFullScreen();
      };
    } else if (el.mozRequestFullScreen) {
      if (document.mozFullScreenElement) {
          document.mozCancelFullScreen();
      } else {
          el.mozRequestFullScreen();
      };
    } else {
      console.log('moz webkit fullscreen not supported');
    }
  });
  function fullsize() {
    var isFS = undefined;
    if (isFS === undefined) isFS = document.webkitIsFullScreen;
    if (isFS === undefined) isFS = document.mozFullScreen;
    if (isFS === undefined) {
      console.log('moz webkit fullscreen not supported');
    } else {
      if (isFS) {
        view.requestFullScreen();
      } else {
        view.cancelFullScreen();
      }
    }
  }
  document.addEventListener('webkitfullscreenchange', fullsize);
  document.addEventListener('mozfullscreenchange', fullsize);

  // tutorial init()
  $('#btn-tutorial').click(function() {
    $.ajax({
      url: 'content/tutorial',
      dataType: 'text'
    }).done(function(html) {
      $('#info-content').html(html);
    });
  });
  $('#btn-tutorial').click();

  // qrcode init
  $('#btn-qrcode').click(function() {
    $.ajax({
      url: 'content/qrcode',
      dataType: 'text',
    }).done(function (html) {
      $('#info-content').html(html);
    })
  });

  function showthenhide ($el, cb) {
    $el.addClass('fall-down');
    setTimeout(function () {
      $el.removeClass('fall-down');
      if (cb) cb();
    }, 3000);
  }
  // ok setting
  // settings should be apply
  // 1. OK btn on click when playing; or,
  // 2. GO/START btn in ligFrame on click
  $("#btn-settings-ok").click(function () {
    // not playing, then just save debug manually
    // other property/settings saved when click events fired
    // see above click handlers
    if (!playing) {
      settings.saveAll();
      $('#settingsModal').modal('hide');
      return;
    }
    var currentSettings = new Settings().saveAll();
    // is playing
    // change mode
    if (settings.mode !== currentSettings.mode) {
      object.setMode(currentSettings.mode);
      settings.setMode();
      showthenhide($('#change-mode-success'));
    }
    // change videosrc
    if (settings.videosrc !== currentSettings.videosrc) {
      // FIXME
      if (currentSettings.videosrc === 'webcam') {

        $('#mask-auth').show();
        $('#auth-info').addClass('fall-down');
        ar.authorize(function () {
          // success change to webcam
          webcam.setSource(currentSettings.videosrc);
          settings.setVideoSrc(currentSettings.videosrc);
          $('#auth-info').removeClass('fall-down');
          $('#mask-auth').hide();
          showthenhide($('#auth-succeed'));
          $('#game canvas').addClass('mirror');
        }, function () {
          // fail to change to webcam
          webcam.setSource(settings.videosrc);
          settings.setVideoSrc(settings.videosrc)
          $('#auth-info').removeClass('fall-down');
          $('#mask-auth').hide();
          showthenhide($('#auth-fail'));
          $('#game canvas').removeClass('mirror');
        }, {}, false, true);

      } else {

        ar.authorize(function () {
          // success change to tutorial
          webcam.setSource(currentSettings.videosrc);
          settings.setVideoSrc(currentSettings.videosrc);
          webcam.close('webcam');
          $('#game canvas').removeClass('mirror');
        }, function () {
          // fail to change to tutorial
          webcam.setSource(settings.videosrc);
          settings.setVideoSrc(settings.videosrc)
          $('#game canvas').addClass('mirror');
        }, {}, true, true);

      }
    }
    // change debug & threshold
    ar.setThreshold(currentSettings.threshold);
    ar.setDebug(currentSettings.debug);
    object.setCache(currentSettings.cache);
    settings.setThreshold();
    settings.setDebug();
    settings.setCache();
    $('#settingsModal').modal('hide');
  })


  // in this frame, set lig/rec,
  // initial is random
  // go/start btn to play
  var initFrameLig = function() {
    $('#submit-buttons').removeClass('rise-up');
    $('#molecule-buttons').addClass('rise-up');
    if (!frames[0]) {
      frames.push($('#molecule-buttons'));
      $('#list-lig a').click(function() {
        lig = $(this).text();
        if (lig == 'RANDOM') {
          var x = Math.floor(Math.random()*nligs);
          $('#list-lig a:nth('+x+')').click();
          return;
        }
        $('#list-lig a.selected').removeClass('selected');
        $(this).addClass('selected');
      });
      $('#list-rec a').click(function() {
        rec = $(this).text();
        if (rec == 'RANDOM') {
          var x = Math.floor(Math.random()*nrecs);
          $('#list-rec a:nth('+x+')').click();
          return;
        }
        $('#list-rec a.selected').removeClass('selected');
        $(this).addClass('selected');
        $.ajax({
          url: 'content/receptor',
          dataType: 'text',
          data: { recname: rec },
          method: 'get'
        }).done(function (html) {
          $('#info-content').html(html);
        })
      });
      $('#btn-go').click(function() {
        if (lig=='RANDOM') {
          $('#random-lig-a').click();
        }
        if (rec=='RANDOM') {
          $('#random-rec-a').click();
        }
        if (frame != 0) {
          return;
        }
        // set frame + 1 to next, next frame will load playing
        setFrame(frame+1);
      })
    }
  };

  var initFrameScore = function() {
    $('#molecule-buttons').removeClass('rise-up');
    $('#submit-buttons').addClass('rise-up');
    $('#best-score-hud').val(0);
    $('#current-score-hud').val(0);

    if (!frames[1]) {
      frames.push($('#submit-buttons'));
      $('#btn-submit').click(function() {
        // FIXME
        if (!$('span[ardock]').length) {
            $('#myModal').modal('show');
          return;
        }
        $.ajax({
          url: 'submit/score',
          dataType: 'text',
          data: {
            lig: lig,
            rec: rec,
            result: $('#best-data-hidden').text(),
            matrix: $('#best-matrix-hidden').text(),
            mark: $('#best-score-hud').val()
          },
          method: 'post'
        }).done(function(data) {
          // FIXME
          $('#mask-wait').hide();
          showthenhide($('#submit-succeed'))
        });
      });
      $('#btn-back').click(function(e) {
        if (frame == 1) {
          webcam.close();
          $('#game canvas').removeClass('mirror');
          playing = false;
        }
        setFrame(frame-1);
        e.preventDefault();
      });
    }
    if (settings.videosrc === 'webcam') {
      $('#mask-auth').show();
      $('#auth-info').addClass('fall-down');
      ar.authorize(function() {
        $('#auth-info').removeClass('fall-down');
        $('#mask-auth').hide();
        // FIXME
        $('#game canvas').addClass('mirror');
        playing = true;
        showthenhide($('#auth-succeed'), function (cached) {
          // if (cached === true) return
          // $('#load-chunk').addClass('fall-down');
        });

      }, function() {
        $('#mask-auth').hide();
        $('#auth-info').removeClass('fall-down');
        // FIXME
        showthenhide($('#auth-fail'))
        setFrame(frame-1);
      }, {
        mode: settings.mode,
        lig: lig,
        rec: rec
      });
    } else {
      //FIXME
      ar.authorize(undefined, undefined, {
        mode: settings.mode,
        lig: lig,
        rec: rec
      }, true);
      playing = true;
    }
    // callback aftermaths
    if (frame != 1) { return; }
  }

  var setFrame = function(new_frame) {
    if (new_frame < 0 || new_frame > 1) return;
    // $(frames[frame]).hide();
    frame = new_frame;

    if (frame == 0) {
      $('#game').addClass('pre-game')
      initFrameLig();
    } else {
      $('#game').removeClass('pre-game')
      initFrameScore();
    }
    // frames[frame].show();
    // load(frame);
    // ...init/clear some frame property
  }
  initFrameLig();
  return {
    isPlaying: function() { return playing; },
    init: function() {
      initFrameLig();
      setFrame(0);
    }
  };
});
