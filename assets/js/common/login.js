// login.js
define(['common'], function() {
  var $body = $('#myModal .modal-body');
  var $html = $body.html();
  var $loading = $('label[for=loading]');
  $('#myModal form').submit(function (e) {
    e.preventDefault();
    $loading.show();
    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      $loading.hide();
      console.log(data);
      if (data == '0') {
        if (window.location.href.toLowerCase().indexOf('register') != -1)
          window.location.href = '';
        if (window.location.href.toLowerCase().indexOf('game') == -1) {
          window.location.reload();
          return;
        }
        $body.append('<span ardock></span>');
        $('#myModal').modal('hide');
        $('.navbar-right').load('nav/logout', function() {
          $('#logoutButton').attr('href', 'logout?last_url='+encodeURIComponent(window.location.href));
        });
      } else {
        var username = $('#myModal [name=username]').val();
        $body.html(['<div class="alert alert-warning alert-dismissible" role="alert">', 
          '<button type="button" class="close" data-dismiss="alert">',
          '<span aria-hidden="true">&times;</span>',
          '<span class="sr-only">Close</span></button><span id="errSpan">',data,'</span></div>', $html].join('')
        );
        $('#myModal [name=username]').val(username);
      }
    })
  })
  return {};
});