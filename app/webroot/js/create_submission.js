$(document).ready(function() {
  $('.right a.btn').click(function(e) {
    // add a new set of coauthor info
    e.preventDefault();
    var btn = $(this);
    var coauthor = $('.coauthor:last').clone().removeClass('base');
    coauthor.find('input').each(function() {
      var id = $(this).attr('id');
      var name = $(this).attr('name');
      var num = parseInt(id.match(/.*[0-9]+.*/));
      console.log(num, num++);
    });
  });
});
