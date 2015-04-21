require(['common'], function () {
  require(['common/login', 'game/webcam'], function (login, webcam) {
    webcam.setSource('webcam');
    var $btn_take = $('button[for=btn-take]');
    var $btn_ok = $('button[for=btn-ok]');
    var $btn_retake = $('button[for=btn-retake]');
    var $btn_notake = $('button[for=btn-notake]');
    var $myModal2 = $('#myModal2');
    var $img_preview = $('.img-preview');
    var $edit_form = $('.edit-form');
    var $avatar_src = $('input[name=src]');
    var ori_src = $img_preview.attr('src');

    var canvas;
    var context;
    var stop;
    var src;

    var init = function () {
      $btn_take.hide();
      $btn_ok.hide();
      $btn_retake.hide();
      $btn_notake.show();
      canvas = undefined;
      context = undefined;
      stop = undefined;
      src = undefined;
    }
    init();


    var animate = function () {
      webcam.copyToContext(context);
      canvas.changed = true;
      stop = window.requestAnimationFrame(animate);
    }

    var pause = function () {
      if (stop) {
        window.cancelAnimationFrame(stop);
        stop = undefined;
      }
    }

    var imgLoaded = function (e) {
      if (this.width > this.height) {
        this.width *= 140 / this.height;
        this.height = 140;
      } else {
        this.height *= 140 / this.width;
        this.width = 140;
      }
      var x = (this.width-this.height)/2;
      $img_preview.css({
        'width' : this.width + 'px',
        'height' : this.height + 'px',
        'margin-left': (x > 0 ? -x : 0) + 'px',
        'margin-top': (x < 0 ? x : 0) + 'px'
      }).attr('src', this.src);
      $avatar_src.attr('value', this.src);
    }

    $btn_take.click(function (e) {
      if (stop == undefined) return;
      pause();
      src = canvas.toDataURL();
      $(this).hide();
      $btn_ok.show();
      $btn_retake.show();
    });
    $btn_retake.click(function (e) {
      animate();
      $(this).hide();
      $btn_ok.hide();
      $btn_take.show();
    })
    $btn_ok.click(function (e) {
      var image = new Image();
      image.src = src;
      image.onload = imgLoaded;
      $myModal2.modal('hide');
    });
    $btn_notake.click(function (e) {
      $myModal2.modal('hide');
    })
    $('.btn-upload').click(function (e) {
      e.preventDefault();
      $('input[type=file]').trigger('click');
    });
    $myModal2.on('hide.bs.modal', function (e) {
      webcam.close();
      pause();
    });
    $myModal2.on('show.bs.modal', function (e) {
      init();
      $('.photo-container').append($('<div class="alert alert-info">AUTHORIZING ... </div>'));
      webcam.waitForAuthorize(function () {
        canvas = document.createElement('canvas');
        var webcamDimensions = webcam.getDimensions();
        canvas.width = webcamDimensions.width;
        canvas.height = webcamDimensions.height;

        context = canvas.getContext('2d');
        context.translate(canvas.width, 0);
        context.scale(-1, 1);

        animate();
        $('.photo-container').html('').append($(canvas));
        $btn_notake.hide();
        $btn_take.show();
      }, function () {
        $('.photo-container').html('').append($('<div class="alert alert-warning">REAUTHORIZE BEFORE TAKING A PHOTO</div>'));
      });
    });
    $('.btn-photo').click(function (e) {
      e.preventDefault();
      $('.photo-container').html('');
      $myModal2.modal('show');
    })
    $('input[type=file]').change(function (e) {
      var input = $(this);
      if (input[0].files && input[0].files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          var image = new Image();
          image.src = e.target.result;
          image.onload = imgLoaded;
        };
        reader.readAsDataURL(input[0].files[0]);
      }
    });
    $('.btn-reset').click(function (e) {
      $img_preview.attr('src', ori_src);
      $edit_form[0].reset();
    })
    // return {
    //   init: function() {}
    // }
  })
});
