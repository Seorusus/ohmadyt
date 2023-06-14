(function($) {
  $( document ).ready(function() {
    $('#edit-choose-selector').change(function() {
      switch($(this).val()) {
        case 'alphabet':
          window.location = "/personal?choose_selector=alphabet";
          break;
        case 'department':
          window.location = "/personal?choose_selector=department";
          break;
        default:
          // default.
          window.location = "/personal?choose_selector=alphabet";
      }
    });
  });
})(jQuery);