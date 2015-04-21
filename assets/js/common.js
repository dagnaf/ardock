requirejs.config({
  // baseUrl: 'assets/js',
  shim: {
    'lib/bootstrap.min': {
      deps: ['lib/jquery.min']
    }
  }
});

define([
  'lib/jquery.min',
  'lib/bootstrap.min'
  ], function () {
});
