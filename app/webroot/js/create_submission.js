$(document).ready(function() {
  $('.right a.btn').click(function(e) {
    // add a new set of coauthor info
    e.preventDefault();
    var btn = $(this);
    var coauthor = $('.right .coauthor:last').clone().removeClass('base');
    coauthor.find('input').each(function() {
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
    btn.before(coauthor);
  });
});
