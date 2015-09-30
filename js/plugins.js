;(function($) {
  jQuery(function($) {
    $('li > span', '.accordion').click(function() {
      var $this = $(this);
      $this.parent().toggleClass('open');
    });

    $('.module-button').click(function() {
      $(this).parents('.module').toggleClass('active');
    });

  });
}(jQuery));
