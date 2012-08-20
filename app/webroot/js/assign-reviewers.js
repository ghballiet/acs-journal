const MODE_DEFAULT = 0;
const MODE_ASSIGN_USERS = 1;
const MODE_ASSIGN_PAPERS = 2;

var mode = MODE_DEFAULT;
var review_form_id = null;

$(function() {
  main();

  function main() {
    // entry point
    review_form_id = parseInt($('.review-form-id').val());
    handlers();
  }

  function handlers() {
    // click event handlers and so on

    $('#assign-reviewers .user-badge').click(function(e) {
      // click event handler for user badges
      e.preventDefault();

      // act differently depending on the mode
      if(mode == MODE_DEFAULT) {
        // nothing was selected, so we should just change the mode and
        // get ready to assign papers to this user.
        $(this).assignPapers();
      } else if(mode == MODE_ASSIGN_USERS) {
        // we're assigning users to a particular paper already - we
        // should either assign or unassign this user from the paper
        // depending on the current state.
        $(this).toggleUser();
      } else if(mode == MODE_ASSIGN_PAPERS) {
        // we're assigning papers to a user and this badge was
        // clicked. if we're currently working with this badge, go
        // back to the default mode. otherwise, start assigning papers
        // to this user.
        if($(this).hasClass('active')) {
          resetSelections();
          mode = MODE_DEFAULT;
        } else {          
          $(this).switchUsers();
        }         
      }
    });

    $('#assign-reviewers .submission-badge').click(function(e) {
      // click event handler for submission badges
      e.preventDefault();

      // act differently depending on the mode
      if(mode == MODE_DEFAULT) {
        // nothing was selected, so we should just change the mode and
        // get ready to assign users to this paper
        $(this).assignUsers();
      } else if(mode == MODE_ASSIGN_USERS) {
        // we're assigning users to a particular paper already and
        // this paper was clicked. if we're currently working with
        // this paper, go back to the default mode. otherwise, start
        // assigning users to this paper.
        if($(this).hasClass('active')) {
          resetSelections();
          mode = MODE_DEFAULT;
        } else {
          $(this).switchPapers();
        }
      } else if(mode == MODE_ASSIGN_PAPERS) {
        // we're assigning papers to a user and this paper was
        // selected. we should either assign or unassign this paper
        // from the active user
        $(this).togglePaper();
      }
    });
  }
});

function resetSelections() {
  // reset all selections
  $('.user-badge, .submission-badge').reset();
}

/* ==== global functions ==== */

jQuery.fn.deactivate = function() {
  $(this).removeClass('active selected').addClass('inactive');
}

jQuery.fn.activate = function() {
  $(this).removeClass('inactive selected').addClass('active');
}

jQuery.fn.select = function() {
  $(this).addClass('selected');
}

jQuery.fn.toggleSelected = function() {
  if($(this).hasClass('selected'))
    $(this).deactivate();
  else
    $(this).select();    
}

jQuery.fn.reset = function() {
  $(this).removeClass('active inactive selected');
}

function assign(user_id, submission_id) {
  // actually do the assignment here
  var url = $('.assign-url').val();
  var data = {
    'Review': {
      'user_id': user_id,
      'submission_id': submission_id,
      'review_form_id': review_form_id
    }
  };
  $.post(url, data, function(response) {
    if(response.ok) {
      var review = response.data.Review;

      // update the user badge
      var user_badge = $('.user-badge[data-id="' + user_id + '"]');
      var tag = parseInt(user_badge.data('tag')) + 1;
      user_badge.data('tag', tag);
      user_badge.find('.user-tag span').html(tag);

      // update the submission badge
      var sub_badge = $('.submission-badge[data-id="' + submission_id + '"]');
      var num = parseInt(sub_badge.data('reviews')) + 1;
      sub_badge.data('reviews', num);
      sub_badge.find('.num-reviews span').html(num);

      // add to the review arrays
      user_reviews[user_id][review.id] = submission_id;
      submission_reviews[submission_id][review.id] = user_id;
    }
  }, 'json');
}

function unassign(user_id, submission_id) {
  // delete the assignment
  var url = $('.unassign-url').val();
  var data = {
    'Review': {
      'user_id': user_id,
      'submission_id': submission_id,
      'review_form_id': review_form_id
    }
  };
  $.post(url, data, function(response) {
    // update the user badge
    var user_badge = $('.user-badge[data-id="' + user_id + '"]');
    var tag = parseInt(user_badge.data('tag')) - 1;
    user_badge.data('tag', tag);
    user_badge.find('.user-tag span').html(tag);

    // update the submission badge
    var sub_badge = $('.submission-badge[data-id="' + submission_id + '"]');
    var num = parseInt(sub_badge.data('reviews')) - 1;
    sub_badge.data('reviews', num);
    sub_badge.find('.num-reviews span').html(num);

    // delete from the review arrays
    for(var i in user_reviews[user_id]) {
      if(user_reviews[user_id][i] == submission_id)
        delete user_reviews[user_id][i];
    }      
    for(var i in submission_reviews[submission_id]) {
      if(subission_reviews[submission_id][i] == user_id)
        delete submission_reviews[submission_id][i];
    }
  }, 'json');
}

/* ==== user badge functions ==== */

jQuery.fn.assignPapers = function() {
  // assign papers mode  
  mode = MODE_ASSIGN_PAPERS;
  $(this).switchUsers();
}

jQuery.fn.switchUsers = function() {
  // switch between users
  $(this).siblings().deactivate();
  $(this).activate();
  $('#assign-reviewers .submission-badge').deactivate();
  var id = $(this).data('id');
  var reviews = user_reviews[id];
  for(var i in reviews) {
    $('.submission-badge[data-id="' + reviews[i] + '"]').select();
  }
}

jQuery.fn.toggleUser = function() {
  // assign this user to a paper
  $(this).toggleSelected();
  var user_id = $(this).data('id');
  var submission_id = $('.submission-badge.active').data('id');
  if($(this).hasClass('selected'))
    assign(user_id, submission_id);
  else
    unassign(user_id, submission_id);
}

/* ==== submission badge functions ==== */

jQuery.fn.assignUsers = function() {
  // assign users mode
  mode = MODE_ASSIGN_USERS;
  $(this).switchPapers();
}

jQuery.fn.switchPapers = function() {
  // switch between papers
  $(this).siblings().deactivate();
  $(this).activate();
  $('#assign-reviewers .user-badge').deactivate();
  var id = $(this).data('id');
  var reviews = submission_reviews[id];
  for(var i in reviews) {
    $('.user-badge[data-id="' + reviews[i] + '"]').select();
  }
}

jQuery.fn.togglePaper = function() {
  // assign this paper to a user
  $(this).toggleSelected();
  var submission_id = $(this).data('id');
  var user_id = $('.user-badge.active').data('id');
  if($(this).hasClass('selected'))
    assign(user_id, submission_id);
  else
    unassign(user_id, submission_id);
}
