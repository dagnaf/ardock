define(['lib/jquery.min'], function() {
  $(document).ajaxSend(function(evt, jqxhr, settings) {
    // must hide in other scripts!!!
    if (settings.url.indexOf('.pdb') != -1) {
      $('#mask-wait').show();
    } else {
      // ...ajax with req like list-lig/rec, (pic is hard to impl.)
    }
  });
});
