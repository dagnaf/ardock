define(['./game', './ajax', 'common/login'], function(game, ajax) {
  $('[rel=tooltip]').tooltip();
  function init() {
    // game
    game.init();
    // chat.init();
    // page.init();
  }
  return {
    init: init
  };
});
