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

function Notifier() {
}

Notifier.prototype.pending = function(msg) {
  $('.notifications .text').html(msg);
  $('.notifications').slideDown('fast');
  $('.notifications > div').attr('class', 'alert');
}

Notifier.prototype.success = function(msg) {  
  if(msg == null)
    msg = 'Success!';
  $('.notifications .text').html(msg);
  $('.notifications > div').attr('class', 'alert alert-success');
  setTimeout(function() {
    $('.notifications').slideUp('fast');
  }, 1000);
}
