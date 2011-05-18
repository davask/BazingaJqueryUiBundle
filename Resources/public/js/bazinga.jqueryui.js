(function($, undefined) {
  $(document).ready(function() {
    $('.ui-button').each(function() {
      $(this).hover(function() {
        $(this).addClass('ui-state-hover');
      }, function() {
        $(this).removeClass('ui-state-hover');
      });
      $(this).focus(function() {
        $(this).addClass('ui-state-focus');
      }, function() {
        $(this).removeClass('ui-state-focus');
      });
      $(this).mousedown(function() {
        $(this).addClass('ui-state-active');
      });
      $(this).mouseup(function() {
        $(this).removeClass('ui-state-active');
      });
      $(this).mouseleave(function() {
        $(this).removeClass('ui-state-active');
      });
    });

    if ($.uniform) {
      $('.uniformize').uniform();
    }
  });
})(jQuery);
