$(document).ready(function() {
  $('.right a.btn').click(function(e) {
    // add a new set of coauthor info
    e.preventDefault();
    var coauthor = $('.coauthor.base').clone().removeClass('base');
    var id = coauthor.attr('id');
    var name = coauthor.attr('name');
    
    var num = id.match(/.*[0-9]+.*/);
    console.log(num++);
  });
});
