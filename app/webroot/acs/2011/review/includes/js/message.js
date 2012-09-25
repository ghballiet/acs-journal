var msgTimeout = null;
var msgLength = 100;

function message(txt) {
  var msg = $('<section />').attr('id','message');
  msg.text(txt).hide();
  
  $('body').append(msg);
  
  msg.fadeIn('fast');
}

function clearMessage() {
  $('#message').fadeOut('fast', function() {
    $('#message').remove();
  });
}