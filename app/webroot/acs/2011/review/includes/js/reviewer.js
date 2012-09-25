$(document).ready(function() {
  getPapers();
});

function getPapers() {
  // gets papers from the database
  console.log('Retrieving papers...');
  message('Retrieving papers...');
  
  $.getJSON('getPapers.php', function(data) {
    clearMessage();
    for(var i in data)
      showPaper(data[i]);
  });
}

function showPaper(data) {
  // adds paper info to the page
  var s = $('<section />').attr('id', 'p' + data.paperID);
  s.addClass('paper');
  
  var title = $('<section />').addClass('title');
  var link = $('<a />').attr('href', '../paper/?id=' + data.secretID);
  link.text(data.title);
  title.append(link);
  s.append(title);
  
  var author = $('<section />').addClass('author');
  author.text(data.name + ' ' + data.surname);
  s.append(author);
  
  $('#papers').append(s);
}