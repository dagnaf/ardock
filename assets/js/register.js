require(['common'], function () {
  require(['common/form', 'common/login'], function(form) {
    // default sign text
    var wrongSign = '<span class="glyphicon glyphicon-remove"></span> ';
    var okSign = '<span class="glyphicon glyphicon-ok"></span> ';
    var good = ['GOOD', 'WELL DONE', 'GREAT', 'EXCELLENT', 'THAT\'S IT'];
    var ok = function() {
      return okSign+good[Math.floor(Math.random()*good.length)]+' ';
    }
    var frontEndCheck = function(name, init_msg, site, validate_rule) {
      // global var
      var $input = $(['#signup input[name=',name,']'].join(''));
      var $label = $(['#signup label[name=',name,']'].join(''));
      // var val;
      // helper func
      var showWrong = function(data) {
        $label.html(wrongSign+data);
        $label.parent().addClass('wrong');
      }
      var removeWrong = function(data) {
        $label.html(data);
        $label.parent().removeClass('wrong');
      }
      var showOK = function(data) {
        removeWrong(ok()+(data ? data : ''));
      }
      function change_callback() {
        if (name == 'agree') {
          if ($input.is(':checked')) {
            showOK();
          } else {
            showWrong('CHECK THIS BEFORE SUBMITTING');
          }
          return;
        }
        var val = $input.val();
        if (val == '') {
          removeWrong(init_msg);
          return 1;
        }
        if (validate_rule) {
          var data = form.validate(val, validate_rule);
          if (data != 1) {
            showWrong(data);
            return 1;
          }
        }
        // no need to ajax for password, but show strength
        if (site == null) { return 0; }
        var get_data = {}
        get_data[name] = val;
        $.get(site, get_data, function(data) {
          if (data == '1') {
            showOK();
          } else {
            showWrong(data);
          }
        });
      }
      // init
      removeWrong(init_msg);
      if (change_callback) {
        $input.change(change_callback);
      }
      if (name == 'password') {
        $input.keyup(function() {
          if (change_callback() == 1) return;
          ret = form.password_strength($input.val());
          if (ret == 'STRONG') {
            showOK('AND IT\'S STRONG', '100%');
          } else if (ret == 'OK') {
            showOK('<span title="TRY !@#$ ETC.">IT\'S OK</span>', '67%');
          } else {
            showOK('<span title="TRY a-z,A-Z,0-9 TOGETHER IN THE INPUT">BUT IT\'S WEAK</span>', '33%');
          }
        })
      }
      return {
        showWrong: showWrong,
        showOK: showOK,
        $input: $input,
        $label: $label
      }
    }
    var msg_username = '3-16 CHARS (<span title="ALPHABATE">"a-zA-Z"</span> | <span title="NUMBERS">"0-9"</span> | <span title="UNDERSCORE">"_"</span>)';
    var msg_password = '8-12 CHARS (EXCEPT FOR <span title="SPACE">" "</span>, <span title="BACKSLASH">"\\"</span> ETC.)';
    var msg_email = 'EFFECTIVE ADDRESS LIKE <span title="A@B.C IS OK">NAME@EXAMPLE.COM</span>';
    var msg_auth = 'NOT CLEAR? <span title="DO NOT OPEN THE SAME PAGE SIMULTANEOUSLY">TRY CLICKING IT</span>';
    var msg_agree = 'READ <span title="LISTED BELOW">TERMS OF USE</span>';

    var init = function() {
      var check_username = frontEndCheck('username', msg_username, 'check/username', {
        minlength: 3,
        maxlength: 12,
        regexp: /^\b\w{3,12}\b$/,
        ret: false
      })
      var check_password = frontEndCheck('password', msg_password, null, {
        minlength: 8,
        maxlength: 16,
        regexp: /[^\s]{8,16}/,
      })
      var check_email = frontEndCheck('email', msg_email, 'check/email', {
        maxlength: 50,
        regexp: /^(\w+)@(\w+)\.(\w+)$/,
      })
      var check_auth = frontEndCheck('auth', msg_auth, 'check/captcha')
      var check_agree = frontEndCheck('agree', msg_agree)
      var src = $('#captcha img').attr('src');
      var $auth = $('#signup input[name=auth]');
      $('#captcha > a').click(function(e) {
        e.preventDefault();
        $('#captcha img').attr('src', src + '?' + Math.random());
        $auth.val('');
        $auth.change();
      });
      $('#signup').submit(function(e) {
        if (!check_agree.$input.is(':checked')) {
          e.preventDefault();
          check_agree.showWrong('CHECK IT BEFORE SUBMITTING');
        }
        var $wrongs = $('#signup .wrong')
        if ($wrongs.length > 0) {
          e.preventDefault();
          $wrongs.fadeOut(200).fadeIn(200);
          return false;
        }
      })
    }
    // return {
    //   init: init
    // }
    init();
  })
});
