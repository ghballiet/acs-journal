$(document).ready(function() {
  getReviewers();
    
  var btnString = 'section.paper section.btn span';
  
  $(btnString).each(function() {
    $(this).css('width', $(this).width());
  });
  
  $(btnString).live('click', function() {
    assignReviewers($(this).parent());
  });
});

function handleScroll() {
  var $window = $(window);
  var review = $('#reviewers');
  var paper = $('#availablePapers');
  var offset = review.offset();
  var padding = review.css('padding-top').replace('px','');
  padding = parseInt(padding);
  var height = review.height() + (2*padding);
  
  $window.scroll(function() {
    var bottom = height + offset.top + 
      parseInt(review.css('margin-top').replace('px','')) + 
      padding;
    var pHeight = paper.height();
    var pBottom = paper.offset().top + pHeight;
    
    console.log(pBottom, bottom);

    if($window.scrollTop() > offset.top) {
      if(bottom < pBottom) {
        review.stop().animate({
          marginTop: $window.scrollTop() - offset.top + padding
        }, 500);
      }
    } else {
      review.stop().animate({
        marginTop: 0
      }, 500);
    }
  });
}

function getReviewers() {
  var url = '../assign/getJSON.php';
  var type = 'reviewers';
    
  $.getJSON(url + '?q=' + type, function(data) {
    var s = $('<section />').attr('id','reviewers');
    $('menu').append(s);
    for(var i in data)
      getReviewer(data[i]);
    handleScroll();
  });
}

function getReviewer(data) {
  var reviewer = data.reviewer;
  var assignments = data.assignments;
  var len = assignments.length;
  
  var item = $('<section />').attr('id', 'r' + reviewer.id);
  item.addClass('reviewer');
  
  var plus = 'ff0b';
  var minus = 'ff0d';
  
  var action = $('<span />').addClass('action').html('&#x' + plus + ';');
  
  var name = $('<span />').addClass('name').text(reviewer.name + 
    ' ' + reviewer.surname);
  var num = $('<span />').addClass('num').text(len);
  var papers = $('<span />').addClass('papers');
  
  var aStr = '';
  
  for(var i in assignments) {
    var p = $('<span />').addClass('paper').addClass('a' + assignments[i]);
    p.text(assignments[i]);
    papers.append(p);
    
    if(i>0)
      aStr += ',';
    aStr += assignments[i];
  }
    
  item.append(action);
  item.append(name);
  item.append(papers);
  item.append(num);
  $('#reviewers').append(item);
}

function assignReviewers(btn) {
  var parent = btn.parent();
  
  parent.toggleClass('focus');
  
  if(parent.hasClass('focus'))
    doAssignReviewers(parent);
  else
    stopAssignReviewers(parent);
}

function doAssignReviewers(item) {
  item.find('.btn span').text('Done');
  var id = item.attr('id').replace('p','');
  showActions(id);
  $('fieldset .paper').not('.focus').addClass('disabled').click(function(e) {
    e.preventDefault();
    return false;
  });
}

function stopAssignReviewers(item) {
  item.find('.btn span').text('Assign Reviewers');
  var id = item.attr('id').replace('p','');  
  hideActions(id);
  $('fieldset .paper').not('.focus').removeClass('disabled').unbind('click');
}

function showActions(id) {
  var plus = 'ff0b';
  var minus = 'ff0d';
  $('#reviewers .reviewer').each(function() {
    var rID = $(this).attr('id');
    var action = $('#' + rID + ' .action');
    var len = $('#' + rID + ' .a' + id).length;
    if(len == 1)
      action.html('&#x' + minus + ';').addClass('remove');
    else
      action.html('&#x' + plus + ';').removeClass('remove');
    action.addClass('visible');
    action.click(function() {
      assignReviewer(id, rID.replace('r',''));
    });
  });
}

function hideActions(id) {
  $('#reviewers .action').removeClass('visible').unbind('click');
}

function assignReviewer(paper, user) {
  var add = false;
  
  add = ($('#r' + user + ' .a' + paper).length != 1);
  
  var kind = add ? 'insert' : 'delete';
  
  var data = {
    paper: paper,
    user: user,
    kind: kind
  };
  
  message('Working...');
  
  $.post('saveChanges.php', {data: data}, function(d) {
    console.log(d);
    if(add)
      addReviewer(paper, user);
    else
      removeReviewer(paper, user);
    clearMessage();
  });
}

function addReviewer(paper, user) {
  var plus = '&#xff0b;';
  var minus = '&#xff0d;';
  $('#r' + user + ' .action').html(minus).addClass('remove');
  var papers = $('#r' + user + ' .papers');
  var p = $('<span />').addClass('paper').addClass('a' + paper);
  p.text(paper);
  papers.append(p);
  var num = $('#r' + user + ' .num').text();
  num = parseInt(num);
  num++;
  $('#r' + user + ' .num').text(num);
  
  var pNum = $('#p' + paper + ' .assigned span');
  var pInt = parseInt(pNum.text());
  pInt++;
  pNum.text(pInt);
}

function removeReviewer(paper, user) {
  var plus = '&#xff0b;';
  var minus = '&#xff0d;';
  $('#r' + user + ' .action').html(plus).removeClass('remove');
  var p = $('#r' + user + ' .a' + paper);
  p.hide().remove();
  var num = $('#r' + user + ' .num').text();
  num = parseInt(num);
  num--;
  $('#r' + user + ' .num').text(num);
  
  var pNum = $('#p' + paper + ' .assigned span');
  var pInt = parseInt(pNum.text());
  pInt--;
  pNum.text(pInt);
}