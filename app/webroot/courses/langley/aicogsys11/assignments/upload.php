<?php
$t = $_GET['title'];
$ex = $_GET['ex'];
$num_files = $_GET['files'];
$notes = $_GET['notes'];
$msg = $_GET['msg'];

if($num_files == NULL) $num_files = 1;
$_POST['page_title'] = $t;
include_once('../template/before.php');?>

<h1>Exercise <? echo $ex; ?></h1>
<div id="msg" class="error"></div>
<? if(isset($notes)) echo Markdown($notes); ?>
<!-- <p>You may submit up to <? echo $num_files; ?> file(s) for this exercise.</p>-->
<form action="upload_file.php" method="post" enctype="multipart/form-data" id="upload">
    <input type="hidden" name="exercise" value="<?echo $ex;?>" />
    <input type="hidden" name="timestamp" value="<?echo date('U');?>" />
    <input type="hidden" name="remote_addr" value="<? echo $_SERVER['REMOTE_ADDR'];?>" />
    <input type="hidden" name="remote_host" value="<? echo gethostbyaddr($_SERVER['REMOTE_ADDR']);?>" />
    <input type="hidden" name="remote_port" value="<? echo $_SERVER['REMOTE_PORT'];?>" />
    <input type="hidden" name="user_agent" value="<? echo $_SERVER['HTTP_USER_AGENT'];?>" />
    <p><label for="name">Name</label><input type="text" name="name" id="name"/></p>
    <p><label for="course">Course</label><input type="radio" name="course" id="course_cse471" value="cse471"/><label for="course_cse471">CSE 471</label></p>
    <p><label></label><input type="radio" name="course" id="course_cse598" value="cse598"/><label for="course_cse598">CSE 598</label></p>
    <p><label for="asurite">ASURITE</label><input type="text" name="asurite" id="asurite"/>
       <span style="font-size:.85em;margin-left:1em">Note: this should be the login you use for MyASU, <strong>not</strong> your ASU ID number.</span>
    </p>
    <p><label for="email">Email</label><input type="text" name="email" id="email"/></p>
<?
  for($i=1; $i <= $num_files; $i++) {?>
    <p><label for="file<?echo $i;?>">File <?echo $i;?></label><input type="file" name="file<?echo $i;?>" id="file<?echo $i;?>"/></p>
<?}
?>
    <p><input type="button" value="Upload Files" id="do_upload"/></p>
</form>
<?
include_once('../template/after.php');
?>
<script type="text/javascript" src="verify_input.jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#name').focus();

    $('#do_upload').click(function() {
	var msg = "";
	var course_selected = false;

	msg += check_field("#name");

	msg += check_radio('course');

	msg += check_field("#asurite");
	msg += check_field("#email");
	
	$('input[type="file"]').each(function() {
	    msg += check_field('#' + $(this).attr('id'));
	});

	if(msg != "" && msg != null) {
	  $('#msg').html('<p>Please correct the following errors and resubmit.</p><ul>' + msg + '</ul>');
	} else {
	  $('#msg').html('');
	  $('#upload').submit();
	}
    });
});
</script>
