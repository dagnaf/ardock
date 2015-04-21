require(['common'], function () {
  require(['common/login'], function () {
    console.log('loaded');
    var arr = location.pathname.split('/');
    var l = arr.length;
    if (arr[l-2] === 'rank' && isNaN(parseInt(arr[l-1]))) {
      var name = arr[l-1];
      $('.media-body a').each(function () {
        if ($(this).attr('href').toLowerCase().split('/').reverse()[0] === name.toLowerCase()) {
          $(this).css('border-bottom', '1px dashed');
        }
      })
    }
  });
});
