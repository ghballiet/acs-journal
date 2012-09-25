$(document).ready(function() {
  $('a.show_abstract').live('click', function(e) {
    e.preventDefault();
    var title = $(this).parent().find('input.title').val();
    var abstract = $(this).parent().find('input.abstract').val();
    $('#modal h1').html(title);
    $('#modal p').html(abstract);
    $('#modal').reveal();
    return false;
  });
});