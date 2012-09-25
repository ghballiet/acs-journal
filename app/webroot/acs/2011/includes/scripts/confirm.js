$(document).ready(function() {
  var data = $('#data').text();
  data = $.parseJSON(data);
  
  $('#edit').click(function() {
    history.go(-1);
  });
  
  $('#submit').click(function() {
    submitPaper(data);
  });
});

function submitPaper(data) {
  $.post('../submit/submit.php', data, function(d) {
    $('#content .wrapper').fadeOut('fast', function() {
      $('#content .wrapper').html(d).fadeIn('fast');
    });
  });
}