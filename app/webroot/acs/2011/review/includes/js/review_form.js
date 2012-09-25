$(document).ready(function() {
  $('#btn').click(function() {
    submitReview();
  });
  
  loadQuestions();
});

function submitReview() {
  // submits the review
  console.log('Review was submitted...');

  var questions = {
    1: 'related',
    2: 'extension',
    3: 'claims',
    4: 'convincing',
    5: 'effective',
    6: 'comment',
    7: 'meeting',
    8: 'journal'
  };
  
  for(var i in questions)
    saveQuestion(questions[i]);
}

function saveQuestion(name) {
  // save response to a question
  console.log('  Saving ' + name + '...');
  
  var review = '';
  
  if($('input[name="' + name + '"]:checked').length > 0)
    review = $('input[name="' + name + '"]:checked').val();
  var comments = $('#' + name + 'Comments').val().trim();
  var user = $('input[name="user"]').val();
  var paper = $('input[name="paper"]').val();
    
  var data = {
    user: user,
    submission: paper,
    question: name,
    review: review,
    comments: comments
  };
  
  message('Saving...');
  $.post('saveQuestion.php', {data: data}, function(d) {
    console.log(d);
    clearMessage();
  });
}

function loadQuestions() {
  // load questions from the database
  var user = $('input[name="user"]').val();
  var paper = $('input[name="paper"]').val();
    
  $.post('getQuestions.php', {user: user, submission: paper}, function(d) {
    var data = $.parseJSON(d);
    for(var i in data)
      loadQuestion(data[i]);
  });
}

function loadQuestion(data) {
  // loads a question from the database
  var i = $('input[value="' + data.review + '"]');
  i.prop('checked', true);
  var txt = $('#' + data.question + 'Comments');
  txt.val(data.comments.replace(/\\'/ig, "'"));
}