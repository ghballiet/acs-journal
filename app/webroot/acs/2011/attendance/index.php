<?
$_POST['page_title'] = 'Tentative Submission Information';
$_POST['extra_css'] = array('forms2.css');
include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();
?>

<? mark_file('paper-title.txt'); ?>

<form id="paper" action="acceptance.php" method="post">
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
      <label>Attendance</label>
      <div>
	<input type="radio" name="attend" value="yes" id="a1">
	<label for="a1">There is at least an 80% chance I will attend.</label>
      </div>
      <div>
	<input type="radio" name="attend" value="no" id="a2">
	<label for="a2">There is a less than 80% chance I will attend.</label>
      </div>
      <div>
	<input type="radio" name="attend" value="na" id="a3">
	<label for="a3">I do not plan to submit a paper for which I will be
	first author.</label>
      </div>
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="num_papers">Number of Submissions</label>
      <input type="number" min="0" max="20" step="1" value="0"
	     id="num_papers" name="num_papers">
    </div>
  </div>

  <div class="group">
    <div class="stretch">
      <label for="titles">Submission Titles</label>

      <p>
	Type the title of each submission on a separate
	line. <strong>Please consult with joint authors to ensure you
	do not list the same submission twice.</strong>
      </p>

      <textarea id="titles" name="titles"></textarea>
    </div>
  </div>

  <input type="button" id="subapp" value="Submit Information"/>
  
  <script>
    $(document).ready(function() {
      $('#subapp').click(function() {
        $('#paper').submit();
      });
    });
  </script>

</form>

<?
include_once('../template/after2.php');
?>
