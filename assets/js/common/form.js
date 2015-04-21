// form.js
define([], function() {
  var validate = function(value, opt) {
    var val = value || '';
    var minlength = opt.minlength || 1;
    var maxlength = opt.maxlength || 16;
    var regexp = opt.regexp || /.*/;
    if (val.length < minlength) return ['TOO SHORT, ',minlength, ' AT LEAST'].join('');
    if (val.length > maxlength) return ['TOO LONG, ',maxlength, ' AT MOST '].join('');
    if (val.match(regexp)) return 1;
    else return 'INVALID INPUT';
  }
  var password_strength = function(val) {
    if (val.match(/[0-9]+/) == val ||
      val.match(/[a-z]+/) == val ||
      val.match(/[A-Z]+/) == val) {
      return 'WEAK';
    } else if (val.match(/[0-9a-z]+/) == val ||
      val.match(/[a-zA-Z]+/) == val ||
      val.match(/[A-Z0-9]+/) == val ||
      val.match(/[a-zA-Z0-9]+/) == val ||
      val.match(/[^a-zA-Z0-9]+/) == val) {
      return 'OK';
    } else {
      return 'STRONG';
    }
  }
  return {
    validate: validate,
    password_strength: password_strength
  }
})