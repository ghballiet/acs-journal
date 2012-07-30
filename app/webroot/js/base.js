$(document).ready(function() {
  $('span.help-inline.error').each(function() {
    $(this).parents('div.control-group').addClass('error');
  });

  $('ul.columns').each(function() {
    var list = $(this);
    var clone = list.clone();
    list.addClass('hidden-phone');
    clone.addClass('visible-phone').removeClass('columns');
    list.after(clone);
  });
});
