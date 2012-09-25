$(document).ready(function() {
  $('fieldset select').live('change', function() {
    selectPaper($(this));
  });
});

function selectPaper(object) {
  var oldCat= object.parent().parent().parent().attr('id');
  var newCat = object.val().split('%')[0];
  var id = object.val().split('%')[1];
  var row = object.parent().parent();
  var newId = newCat.replace(/ /g, '_');
  
  oldCat = oldCat.replace('_', ' ');
  
  var data = {
    'old': oldCat,
    'new': newCat,
    'id': id
  };
  
  console.log(oldCat, newCat, id);
  
  row.fadeOut('fast', function() {
    var n = $('#' + newId);
    row.remove();
    $.post('../paper-category/save.php', { data: data }, function(d) {
      row.appendTo(n).fadeIn('fast');      
    });
  });  
}