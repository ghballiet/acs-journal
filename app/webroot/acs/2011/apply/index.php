<?
   $_POST['page_title'] = 'Application';
   $_POST['extra_css'] = array('forms2.css');
   include_once('../template/before2.php');
   include_once('../includes/php/functions.php');
   init();
?>

<? mark_file('apply.txt'); ?>
<div id="error"></div>
<form method="post" action="apply.php" id="form_apply"
      enctype="multipart/form-data">

  <div class="group">
    <div class="half">
      <label for="fn">First Name</label>
      <input type="text" id="fn" name="first_name"
	     placeholder="First Name"/>
    </div>
    <div class="half">
      <label for="ln">Last Name</label>
      <input type="text" id="ln" name="last_name"
	     placeholder="Last Name"/>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="email">Electronic Mail</label>
      <input type="email" id="email" name="email"
	     placeholder="email@example.com" spellcheck="false"/>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="org">Department/Organization</label>
      <input type="text" id="org" name="organization"
	     placeholder="Department/Organization"/>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="address">Physical Address</label>
      <input type="text" id="address" name="address"
	     placeholder="Physical Address"/>
    </div>
  </div>

  <div class="group">
    <div class="half">
      <label for="city">City</label>
      <input type="text" id="city" name="city"
	     placeholder="City"/>
    </div>
    <div class="half">
      <label for="state">State/Province</label>
      <input type="text" id="state" name="state"
	     placeholder="State/Province"/>
    </div>
  </div>

  <div class="group">
    <div class="half">
      <label for="postal">Postal Code</label>
      <input type="text" id="postal" name="postal"
	     placeholder="Postal Code"/>
    </div>
    <div class="half">
      <label for="country">Country</label>
      <? country(); ?>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="summary">Research Summary</label>
      <textarea id="summary" name="summary"
		placeholder="Summary of Relevant Research"></textarea>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="paper">Related Paper <small>(Optional; PDF only; this
	  is NOT your submission to the Symposium)</small></label>
      <input type="file" id="paper" name="paper"/>
    </div>
  </div>

  <input type="button" id="subapp"
	 value="Submit Application"/>
</form>

<script type="text/javascript">
    function tchk(id, name) {
	var v = $('#' + id).val();
	if(v==''||v==null)
	    return '<li><strong>' + name + '</strong> is required.</li>';
	else
	    return '';
    }
   
    function validate() {
	var msg = '';
	msg += tchk('fn','First Name');
	msg += tchk('ln','Last Name');
	msg += tchk('email','Email');
	msg += tchk('org','Department/Organization');
	msg += tchk('address','Physical Address');
	msg += tchk('city','City');
	msg += tchk('state','State');
	msg += tchk('postal','Postal Code');
	msg += tchk('summary','Research Summary');

	return msg;
    }
    
    $(document).ready(function() {
	$('#ct237').attr('selected','selected');

	$('#subapp').click(function() {
	    var msg = validate();
	    if(msg!=''&&msg!=null) {
		$('#error').html('<p>Please correct the following:</p><ul>' + msg + '</ul>');
	    } else {
		$('#error').html('');
		$('#form_apply').submit();
	    }
	});
    });
</script>

<?
   cleanup();
   include_once('../template/after2.php');
?>
