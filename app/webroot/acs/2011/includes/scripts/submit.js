$(document).ready(function() {
  var loc = null;
  
  $('#name').focus();
  
  $('#country').change(function() {
    var txt = $(this).find(':selected').text();
    $('#countryName').val(txt);
  });

  $('#paperNumCoauthors').change(function() {
    addCoauthors($(this).val());
  });

  $('form').submit(function() {
    return validateData();
  });
  $('input[type="button"]').click(function() {
    doFormSubmission();
  });
});

function addCoauthors(num) {
  // adds coauthors for this paper
  console.log('Adding ' + num + ' coauthors');
  var co = $('#coauthors');
  co.html('');

  var i = 1;
  for(i=1; i<=num; i++) {
    addCoauthor(i);
  }
}

function addCoauthor(num) {
  // adds a line for a single coauthor
  var co = $('#coauthors');
  
  var s = $('<section />').addClass('row');
  s.attr('id', 'coauthor' + num);

  var name = $('<section />').addClass('cell');
  name.append($('<label />').attr('for', 'caName' + num).text(
    'Co-author Name'));
  var iName = $('<input>').attr('type','text');
  iName.attr('id', 'caName' + num).attr('name', 'caName' + num);
  iName.attr('placeholder', 'Co-author Name');
  name.append(iName);
  s.append(name);

  var email = $('<section />').addClass('cell');
  email.append($('<label />').attr('for', 'caEmail' + num).text(
    'Co-author Electronic Mail'));
  var iEmail = $('<input>').attr('type','email');
  iEmail.attr('id', 'caEmail' + num).attr('name', 'caEmail' + num);
  iEmail.attr('placeholder', 'Co-author Electronic Mail');
  email.append(iEmail);
  s.append(email);

  var inst = $('<section />').addClass('cell');
  inst.append($('<label />').attr('for','caInstitution' + num).text(
    'Co-author Institution'));
  var iInst = $('<input>').attr('type','text');
  iInst.attr('id','caInstitution' + num).attr('name', 'caInstitution' + num);
  iInst.attr('placeholder', 'Co-author Institution');
  inst.append(iInst);
  s.append(inst);

  co.append(s);
}

function sampleData() {
  $('#name').val('Glen');
  $('#surname').val('Hunt');
  $('#email').val('glenrhunt@asu.edu');
  $('#emailConfirm').val('glenrhunt@asu.edu');
  $('#address1').val('Arizona State University');
  $('#address2').val('699 S Mill Ave');
  $('#city').val('Tempe');
  $('#state').val('Arizona');
  $('#postal').val('85281');
  $('#country').val('237 ').change();
  $('#phone1').val('+18063191774');
  $('#paperTitle').val('Test Paper for Submission');
  $('#paperAbstract').val('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec hendrerit tempor tellus. Donec pretium posuere tellus. Proin quam nisl, tincidunt et, mattis eget, convallis nec, purus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla posuere. Donec vitae dolor. Nullam tristique diam non turpis. Cras placerat accumsan nulla. Nullam rutrum. Nam vestibulum accumsan nisl.');
  $('#paperKeywords').val('test, default, cognitive architecture');
  $('#paperNumCoauthors').val('1').change();
  $('#caName1').val('Mahmoud Dinar');
  $('#caEmail1').val('glenrhunt@gmail.com');
  $('#caInstitution1').val('Arizona State University');
}

function doFormSubmission() {
  // validate form here
  if(validateData())
    $('form').submit();
}

function validateData() {
  // check all inputs to make sure they're not empty
  var invalid = [];
  $('.error').removeClass('error');
  
  $('input, textarea').each(function() {
    var val = $(this).val();    
    if((val == null || val == '') && $(this).attr('id')!='phone2'
      && $(this).attr('type')!='hidden') {
      var text = $(this).attr('placeholder');
      invalid.push('<strong>' + text + '</strong> is a required field.');
      $(this).addClass('error');
    }
  });
  
  // check select boxes
  $('select').each(function() {
    var val = $(this).val();
    if(val == null || val == '') {
      invalid.push('<strong>' + $(this).attr('id') + '</strong> is a required field.');
      $(this).addClass('error');
    }
  });
  
  $('.error').each(function() {
    $(this).change(function() {
      $(this).removeClass('error');
    });
  });
  
  if($('#email').val() != $('#emailConfirm').val())
    invalid.push('The email addresses you provided do not match.');
  
  showInvalidData(invalid);
  
  return invalid.length == 0;
}

function showInvalidData(data) {
  var sec = $('<section />').attr('id','error');
  sec.append($('<p />').text('Please correct the following:'));
  
  var list = $('<ul />');
  
  for(var i in data) {     
    list.append($('<li />').html(data[i]));
  }
  
  sec.append(list);
  
  $('#error').remove();
  
  $('form').before(sec);
}