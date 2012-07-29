$(document).ready(function() {
  $('.add-coauthor').click(function(e) {
    // add a new set of coauthor info
    e.preventDefault();
    var btn = $(this);
    var coauthor = $('.coauthor:last').clone().removeClass('base');

    coauthor.find('input').each(function() {
      $(this).val('');
      var name = $(this).attr('name');
      var id = $(this).attr('id');
      var curr = parseInt(name.match(/[0-9]+/)[0]);
      var next = curr + 1;
      name = name.replace(curr, next);
      id = id.replace(curr, next);
      $(this).attr({
        name: name,
        id: id
      });
    });

    var close = $('<a />').attr('href', '#');
    close.addClass('btn btn-mini btn-danger close-btn')
    close.html('Remove');
    coauthor.prepend(close);

    btn.before(coauthor);
    coauthor.find('input:eq(0)').focus();
  });

  $('.btn.close-btn').live('click', function(e) {
    e.preventDefault();
    $(this).parent().remove();
  });
});
