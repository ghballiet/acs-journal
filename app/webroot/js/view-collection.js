$(function() {
  $('.btn-add').live('click', function(e) {
    // add answer button is clicked
    e.preventDefault();
    var btn = $(this);
    var input = btn.siblings('.text');
    var id = input.data('id');
    var text = input.val();
    var url = $('.add-choice-url').val();
    
    var data = {
      'Choice': {
        'question_id': id,
        'text': text
      }
    };

    var notify = new Notifier();
    notify.pending('Saving...', true);
    $.post(url, data, function(response) {
      if(response.ok == true) {
        notify.success('Saved!');
        var choice = response.data.Choice;
        var choice_id = choice.id;
        var li = $('<li />').addClass('answer');
        var close = $('<a />').addClass('btn-delete-choice btn-delete close').html('&times;');
        close.attr({
          href: '#',
          'data-id': choice_id
        }).data('id', choice_id);
        var radio = $('<input />').attr({
          type: 'radio',
          disabled: 'disabled'
        }).addClass('radio');
        var span = $('<span />').html(text);
        li.append(close).append(radio).append(span);
        btn.parent().before(li);
        input.val('');
      }
    }, 'json');
  });

  $('.text').live('keyup', function(e) {
    e.preventDefault();
    if(e.keyCode == 13) {
      $(this).next('.btn-add').click();
    }
  });

  $('.btn-add-question').live('click', function(e) {
    // add question to the form
    e.preventDefault();
    var btn = $(this);
    var url = $('.add-question-url').val();
    var order = $('.new-order').val();
    var form_id = $('.review-form-id').val();
    var text = $('.new-question').val();

    var data = {
      'Question': {
        'review_form_id': form_id,
        'text': text,
        'position': order
      }
    };

    var notify = new Notifier();
    notify.pending('Saving...', true);

    $.post(url, data, function(response) {
      if(response.ok) {
        notify.success('Saved!');
        var question = response.data.Question;
        console.log(question);
        var id = question.id;
        var order = question.position;
        var text = question.text;
        var template = $('.question-template').clone();
        template.find('a.close, input.text').attr('data-id', id).data('id', id);
        template.find('div.order').html(order);
        template.find('p.text').html(text);
        template.removeClass('hidden question-template');
        $('.questions').append(template);
      }
    }, 'json');
  });

  $('.btn-delete-choice').live('click', function(e) {
    // delete choice
    e.preventDefault();
    var id = $(this).data('id');
    var element = $(this).parent();
    var url = $('.delete-choice-url').val();
    var data = { 'Choice': { 'id': id } };
    
    var notify = new Notifier();
    notify.pending('Deleting...');

    $.post(url, data, function(response) {
      if(response.ok) {
        notify.success('Deleted!');
        element.remove();
      }
    }, 'json');
  });

  $('.btn-delete-question').live('click', function(e) {
    // delete question
    e.preventDefault();
    var do_it = confirm('Are you sure you want to delete this question?\n' + 
                        'This cannot be undone.');
    if(!do_it)
      return false;
    
    var btn = $(this);
    var question = btn.parent();
    var id = btn.data('id');
    var url = $('.delete-question-url').val();
    var data = { 'Question': { 'id': id } };

    var notify = new Notifier();
    notify.pending('Deleting question...', true);

    $.post(url, data, function(response) {
      if(response.ok) {
        notify.success('Deleted!');
        question.remove();
      }
    }, 'json');
  });
});
