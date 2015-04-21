require(['common'], function () {
  require(['common/login', 'lib/jquery.timeago'], function () {
    $('abbr.timeago').timeago();
    $('[rel=tooltip]').tooltip();
    // board
    $('#newPost').click(function() {
      if ($('span[ardock]').length)
        $('input[name=title]').focus();
      else $('#myModal').modal('show');
    })
    $('.reply-link').click(function () {
      if ($('span[ardock]').length) {
        $form = $(this).next();
        if ($form.css('display') == 'block')
          $form.hide();
        else {
          $('.media form').hide();
          $form.show();
          $form.find('textarea').focus();
        }
      }
      else $('#myModal').modal('show');
    })
    // enter to submit
    // $('textarea').keydown(function(e) {
    //   if (e.keyCode == 13) {
    //     e.preventDefault();
    //     if ($(this).val().length > 0)
    //       $(this.form).submit();
    //   }
    // })
    if (location.hash !== '' && parseInt(location.hash.slice(1)) !== NaN) {
      $(location.hash + ' .media-body').css('border','1px dashed');
    }
    // return {
    //   init: function() {
    //   }
    // }
  })
});
