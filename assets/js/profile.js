require(['common'], function () {
  require(['common/login', 'lib/jquery.timeago'], function () {
    $('abbr.timeago').timeago();
    $('[rel=tooltip]').tooltip();
  });
});
