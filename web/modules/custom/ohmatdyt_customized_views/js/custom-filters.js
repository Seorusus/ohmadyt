(function($) {
  $( document ).ready(function() {
    $('#edit-choose-selector').change(function() {
      switch($(this).val()) {
        case 'alphabet':
          window.location = "?field_parent_department_target_id=All&&choose_selector=alphabet";
          break;
        case 'department':
          window.location = "/personal?field_parent_department_target_id=All&&choose_selector=department";
          break;
        default:
          // default.
          window.location = "?field_parent_department_target_id=All&&choose_selector=alphabet";
      }
    });
  });
})(jQuery);